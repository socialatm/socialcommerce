<?php
	/**
	 * Elgg module - actions
	 * 
	 * @package Elgg products
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
function register_socialcommerce_settings(){

	define("CHECKOUT_PATH", elgg_get_config('pluginspath').'socialcommerce/modules/checkout/');
	define("SHIPPING_PATH", elgg_get_config('pluginspath').'socialcommerce/modules/shipping/');
	define("CURRENCY_PATH", elgg_get_config('pluginspath').'socialcommerce/modules/currency/');
	
	load_module_languages();
	SetGeneralValuesInConfig();
	genarateCartFromSession();
}

function SetGeneralValuesInConfig() {

	if(elgg_is_logged_in()){
		$carts = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'cart',
		'owner_guid' => elgg_get_logged_in_user_guid(),
		));
		
		if($carts){
			$items = 0;
			$cart = $carts[0];
			$cart_items = elgg_get_entities_from_relationship(array(
				'relationship' => 'cart_item',
				'relationship_guid' => $cart->guid, 
				));  
			if($cart_items){
				foreach ($cart_items as $cart_item){
					$items += $cart_item->quantity;
				}
			}
			if($items)
				elgg_set_config('cart_item_count', $items);
		}
	}
		
	$wishlist_count = elgg_get_entities_from_relationship(array(
			'relationship' => 'wishlist',
			'relationship_guid' => elgg_get_logged_in_user_guid(), 
			'inverse_relationship' => false,
			'count' => true, 	
			));  
	
	if($wishlist_count){
		elgg_set_config('wishlist_item_count' , $wishlist_count);
	}
	
	$default_currency = elgg_get_entities_from_metadata(array(
		'metadata_name' => 'set_default',
		'metadata_value' => 1,
		'type' => 'object',
		'subtype' => 's_currency',
		'owner_guid' => 0, 
		'limit' =>'1'
		));
		
	if($default_currency){
		$default_currency = $default_currency[0];
		$currency_code = $default_currency->currency_code;
		elgg_set_config('currency_code', $currency_code);
	}else{
		elgg_set_config('currency_code', 'USD');
	}
	
	elgg_set_config('default_weight_unit', 'LBS');
	load_module_configs();
}

function sc_get_product_type_from_value($value) {
	$default_product_types = elgg_get_config('product_type_default');
	if (is_array($default_product_types) && sizeof($default_product_types) > 0 && $value) { 
		foreach ($default_product_types as $default_product_type){
			if($default_product_type->value == $value){
				return $default_product_type; 
			}
		}
	}	
}

function sc_register_subtypes(){
	$subtypes = array('stores','cart','cart_item','address','order','order_item','transaction', 's_checkout', 's_withdraw','s_currency', 'sc_category');
	foreach ($subtypes as $subtype){
		add_subtype('object',$subtype);
	}
}

function genarateCartFromSession(){
	
	if (elgg_is_logged_in() && isset($_SESSION['GUST_CART']) && !empty($_SESSION['GUST_CART'])) {
		$session_cart_items = $_SESSION['GUST_CART'];
		$ownered_products = array();
		$less_quantity_products = array();
		$carts = elgg_get_entities(array( 	
			'type' => 'object',
			'subtype' => 'cart',
			'owner_guid' => $_SESSION['user']->getGUID(),
			)); 			
				
		if($carts && $session_cart_items){
			$cart = $carts[0];
			$cart_guid = $cart->guid;
			foreach ($session_cart_items as $session_cart_item){
				$product = get_entity($session_cart_item['product_id']);
				if($_SESSION['user']->guid == $product->owner_guid){
					$ownered_products[] = array('guid'=>$product->guid,'title'=>$product->title,'quantity'=>$session_cart_item['quantity']);
				}else{
					$cart_item = get_stores_from_relationship('cart_item',$cart_guid,'product_id',$product->guid,'object','cart_item',$_SESSION['user']->getGUID());
					if($cart_item){
						if($product->product_type_id == 1){
							$cart_item = get_entity($cart_item[0]->guid);
							if($product->quantity >= ($session_cart_item['quantity'] + $cart_item->quantity)){
								$quantity = $cart_item->quantity + $session_cart_item['quantity'];
							}else{
								$quantity = $product->quantity;
								$less_quantity_products[] = array('guid'=>$product->guid,'title'=>$product->title,'quantity'=>$product->quantity);
							}
							$cart_item->quantity = $quantity;
							$result = $cart_item->save();
						}
					}else{
						if($session_cart_item['quantity'] > $product->quantity && $product->product_type_id == 1){
							$quantity = $product->quantity;
							$less_quantity_products[] = array('guid'=>$product->guid,'title'=>$product->title,'quantity'=>$product->quantity);
						}else {
							$quantity = $session_cart_item['quantity'];
						}
						
						$cart_item = new ElggObject();
						$cart_item->access_id = 2;
						$cart_item->subtype = "cart_item";
						$cart_item->title = $product->title;
						$cart_item->quantity = $quantity;
						$cart_item->product_id = $product->guid;
						$cart_item->amount = $product->price;
						$cart_item->container_guid = $_SESSION['user']->getGUID();
						$cart_item_guid = $cart_item->save();
						
						if($cart_item_guid){
							$result = add_entity_relationship($cart_guid,'cart_item',$cart_item_guid);
							if(in_array('cart_add', unserialize(elgg_get_plugin_setting('river_settings', 'socialcommerce')) ))
								elgg_create_river_item( array(
									'view' => 'river/object/cart/create',
									'action_type' => 'cartadd',
									'subject_guid' => $_SESSION['user']->guid,
									'object_guid' => $stores->guid
									)
								);	
						}
					}
				}
			}
		}else {
			$cart = new ElggObject();
			$cart->access_id = 2;
			$cart->subtype = "cart";
			$cart->container_guid = $_SESSION['user']->getGUID();
			
			$cart_guid = $cart->save();
			if($cart_guid && $session_cart_items){
				foreach ($session_cart_items as $session_cart_item){
					$product = get_entity($session_cart_item['product_id']);
					if($_SESSION['user']->guid == $product->owner_guid){
						$ownered_products[] = array('guid'=>$product->guid,'title'=>$product->title,'quantity'=>$session_cart_item['quantity']);
					}else{
						if($session_cart_item['quantity'] > $product->quantity && $product->product_type_id != 2){
							$quantity = $product->quantity;
							$less_quantity_products[] = array('guid'=>$product->guid,'title'=>$product->title,'quantity'=>$product->quantity);
						}else {
							$quantity = $session_cart_item['quantity'];
						}
						$cart_item = new ElggObject();
						$cart_item->access_id = 2;
						$cart_item->subtype = "cart_item";
						$cart_item->title = $product->title;
						$cart_item->quantity = $quantity;
						$cart_item->product_id = $product->guid;
						$cart_item->amount = $product->price;
						$cart_item->container_guid = $_SESSION['user']->getGUID();
						$cart_item_guid = $cart_item->save();
						
						if($cart_item_guid){
							$result = add_entity_relationship($cart_guid,'cart_item',$cart_item_guid);
							if(in_array('product_checkout', unserialize(elgg_get_plugin_setting('river_settings', 'socialcommerce'))))	//	@todo - maybe move this and add a 'cart_add' setting??
								elgg_create_river_item( array(
									'view' => 'river/object/cart/create',
									'action_type' => 'cartadd',
									'subject_guid' => $_SESSION['user']->guid,
									'object_guid' => $product->guid
									)
								);	
						}
					}
				}
			}
		}
		$cart_messages = "";
		if(count($ownered_products) > 0){
			$cart_message = '';
			foreach ($ownered_products as $ownered_product){
				$cart_message .= sprintf(elgg_echo('cart:ownered:product'),$ownered_product['title'],$ownered_product['quantity']);
			}
			if($cart_message != ""){
				$cart_messages = sprintf(elgg_echo('cart:ownered:products'),$cart_message);
			}
		}
		if(count($less_quantity_products) > 0){
			$cart_message = '';
			foreach ($less_quantity_products as $less_quantity_product){
				$cart_message .= sprintf(elgg_echo('cart:less:quantity:product'),$less_quantity_product['title'],$less_quantity_product['quantity']);
			}
			if($cart_message != ""){
				$cart_messages .= sprintf(elgg_echo('cart:less:quantity:products'),$cart_message);
			}
		}
		if($cart_messages != ""){
			system_message($cart_messages);
		}
		unset($_SESSION['GUST_CART']);
	}
}

/*********************************************************************
	Load config files from checkout, shipping and currency methods.
	@todo - add taxes at some point....
 *********************************************************************/
function load_module_configs(){
	//---- load config from checkout methods -----//
	$checkout_lists = get_checkout_list();
	if($checkout_lists){
		load_checkout_actions();
		foreach ($checkout_lists as $checkout_list){
			$function = 'set_config_'.$checkout_list;
			if(function_exists($function)){
				$function();
			}
		}
	}
	//---- load config from shipping methods -----//
	$shipping_lists = get_shipping_list();
	if($shipping_lists){
		load_shipping_actions();
		foreach ($shipping_lists as $shipping_list){
			$function = 'set_config_'.$shipping_list;
			if(function_exists($function)){
				$function();
			}
		}
	}
	//---- load config from currency methods -----//
	$currency_lists = get_currency_list();
	if($currency_lists){
		load_currency_actions();
		foreach ($currency_lists as $currency_list){
			$function = 'set_config_'.$currency_list;
			if(function_exists($function)){
				$function();
			}
		}
	}
}

/*********************************************************************
	Load language files from checkout, shipping and currency methods.
**********************************************************************/

function load_module_languages(){
	//---- load languages from checkout methods -----//
	$checkout_lists = get_checkout_list();
	if($checkout_lists){
		foreach ($checkout_lists as $checkout_list){
			register_translations(CHECKOUT_PATH.$checkout_list.'/languages/');
		}
	}
	
	//---- load languages from shipping methods -----//
	$shipping_lists = get_shipping_list();
	if($shipping_lists){
		foreach ($shipping_lists as $shipping_list){
			register_translations(SHIPPING_PATH.$shipping_list.'/languages/');
		}
	}

	//---- load languages from currency methods -----//
	$currency_lists = get_currency_list();
	if($currency_lists){
		foreach ($currency_lists as $currency_list){
			register_translations(CURRENCY_PATH.$currency_list.'/languages/');
		}
	}
}

/***************************************************************************************	
	CHECKOUT
	Read the check out plugins and get checkout methods. Return them as an array.
	@todo - these should be named 'payment' not 'checkout'
****************************************************************************************/

function sc_get_checkout_methods(){
	$checkout_lists = get_checkout_list();
	if ($checkout_lists) {
		$checkout_methods = array();
		foreach ($checkout_lists as $checkout_list){
			if (file_exists(CHECKOUT_PATH.$checkout_list.'/method.xml')) {
				$xml = new ElggXMLElement(file_get_contents(CHECKOUT_PATH.$checkout_list.'/method.xml'));
				
				if ($xml){
					$elements = array();
					if($xml->children){
						foreach ($xml->children as $element){
							$key = $element->attributes['key'];
							$value = $element->attributes['value'];
							$elements[$key] = $value;
						}
					}
					if($elements)
						$checkout_methods[$checkout_list] = (object)$elements;
				}
			}
		}
		return $checkout_methods;
	}
	return false;
}

/*****	Get checkout plugins list. returns an array.	*****/

function get_checkout_list(){
	$checkouts = array();
	$checkouts = array_diff(scandir(CHECKOUT_PATH), array('..', '.'));
	$checkouts = (count($checkouts) > 0) ? $checkouts : false ;
	return $checkouts;
}

function load_checkout_actions(){
	$checkout_lists = get_checkout_list();
	if ($checkout_lists) {
		$checkout_methods = array();
		foreach ($checkout_lists as $checkout_list){
			if (file_exists(CHECKOUT_PATH.$checkout_list.'/action.php')) {
				require_once(CHECKOUT_PATH.$checkout_list."/action.php");
			}else{
				throw new PluginException(sprintf(elgg_echo('misconfigured:checkout:method'), $checkout_list));
			}
		}
	}
}

function check_checkout_form(){



	if(is_dir(CHECKOUT_PATH.$_SESSION['CHECKOUT']['checkout_method'])){
		if (file_exists(CHECKOUT_PATH.$_SESSION['CHECKOUT']['checkout_method'].'/action.php')) {
			require_once(CHECKOUT_PATH.$_SESSION['CHECKOUT']['checkout_method']."/action.php");
			$function = 'checkout_payment_settings_'.$_SESSION['CHECKOUT']['checkout_method'];
			if(function_exists($function)){
				return $function();
			}else {
				throw new PluginException(sprintf(elgg_echo('misconfigured:checkout:function'), $function));
			}
		}else{
			throw new PluginException(sprintf(elgg_echo('misconfigured:checkout:method'), $_SESSION['CHECKOUT']['checkout_method']));
		}
	}else{
		return false;	
	}
}

/*******************************************************
	Shipping
********************************************************/

function sc_get_shipping_methods(){
	$shipping_lists = get_shipping_list();
	if ($shipping_lists) {
		$shipping_methods = array();
		foreach ($shipping_lists as $shipping_list){
			if (file_exists(SHIPPING_PATH.$shipping_list.'/method.xml')) {
				$xml = new ElggXMLElement(file_get_contents(SHIPPING_PATH.$shipping_list.'/method.xml'));
								
				if ($xml){
					$elements = array();
					if($xml->children){
						foreach ($xml->children as $element){
							$key = $element->attributes['key'];
							$value = $element->attributes['value'];
							$elements[$key] = $value;
						}
					}
					if($elements)
						$shipping_methods[$shipping_list] = (object)$elements;
				}
			}
		}
		return $shipping_methods;
	}
	return false;
}

/*****	Get shipping plugins list. returns an array.	*****/

function get_shipping_list(){
	$shippings = array();
	$shippings = array_diff(scandir(SHIPPING_PATH), array('..', '.'));
	$shippings = count($shippings) > 0 ? $shippings : false ;
	return $shippings;
}

function load_shipping_actions(){
	$shipping_lists = get_shipping_list();
	if ($shipping_lists) {
		$shipping_methods = array();
		foreach ($shipping_lists as $shipping_list){
			if (file_exists(SHIPPING_PATH.$shipping_list.'/action.php')) {
				require_once(SHIPPING_PATH.$shipping_list."/action.php");
			}else{
				throw new PluginException(sprintf(elgg_echo('misconfigured:shipping:method'), $shipping_list));
			}
		}
	}
}

function check_shipping_form(){

echo __FILE__ .' at '.__LINE__; die();	//	@todo - need to error check this function

	if(is_dir(SHIPPING_PATH.$_SESSION['SHIPPING']['shipping_method'])){
		if (file_exists(SHIPPING_PATH.$_SESSION['SHIPPING']['shipping_method'].'/action.php')) {
			require_once(SHIPPING_PATH.$_SESSION['SHIPPING']['shipping_method']."/action.php");
			$function = 'verify_shipping_settings_'.$_SESSION['SHIPPING']['shipping_method'];
			if(function_exists($function)){
				return $function();
			}else {
				throw new PluginException(sprintf(elgg_echo('misconfigured:shipping:function'), $function));
			}
		}else{
			throw new PluginException(sprintf(elgg_echo('misconfigured:shipping:method'), $_SESSION['SHIPPING']['shipping_method']));
		}
	}else{
		return false;	
	}
}

/*****	end shipping	*****/

function html_escape($text){
	return htmlspecialchars($text, ENT_QUOTES);
}

/**
 *	Display or redirect to payment gateway
 * 	@param string The URL to redirect to.
 * 	@param array An array of form fields to POST, if any.
 * 	
 */
 
function redirect_to_form( $url, $fields ){

	echo __FILE__ .' at '.__LINE__; 

	$formFields = '';
	
	if(is_array($fields)){
		foreach($fields as $name => $value) {
			$formFields .= "<input type=\"hidden\" name=\"".html_escape($name)."\" value=\"".html_escape($value)."\" />\n";
		}
	}

//	return json_encode($formFields);
	
		$detailed_view = elgg_echo('processing').'...';
		$url = elgg_get_config('url');
		$auto_redirect_script = <<<EOF
			<div id="load_action"></div>
			<div id='load_action_div'>
				<img src="{$url}mod/socialcommerce/views/default/modules/checkout/paypal/images/loading.gif" alt="" />
				<div style="color:#FFFFFF;font-weight:bold;font-size:14px;margin:10px;">Loading...</div>
			</div>
			<script type="text/javascript">
				window.onload = function() {
					var window_width = $(document).width();
					var window_height = $(document).height();
					var scroll_pos = (document.all)?document.body.scrollTop:window.pageYOffset;
					scroll_pos = scroll_pos  + 300;
					$("#load_action").show();
					$("#load_action").css({'width':window_width+'px','height':window_height+'px'});
					$("#load_action_div").css("top",scroll_pos+"px");
					$("#load_action_div").css({'width':window_width+'px'});
					$("#load_action_div").show();
					$("#payment_redirect_form").submit();
				}
			</script>
EOF;
	$form = 
	   '<div>
			<form id="payment_redirect_form" action="'.$url.'" method="post">'
				.$detailed_view
				.$formFields
			.'</form>'
			.$auto_redirect_script
	  .'</div>';

	return $form;
	exit;
}

/*****************************************************	
	the Create Order function
******************************************************/

function create_order( $buyer_guid, $CheckoutMethod, $posted_values, $BillingDetails, $ShippingDetails, $ShippingMethod ){
	
	$used_coupons = array();
	elgg_set_context('add_order');
	$buyer = get_entity($buyer_guid);
	$container_guid = $buyer_guid;
	$socialcommerce = elgg_get_plugin_from_id('socialcommerce');
	$seller = elgg_get_admins();
	$seller = get_entity( $seller[0]->guid);
	
	$carts = elgg_get_entities(array( 	
		'type' => 'object',
		'subtype' => 'cart',
		'owner_guid' => $buyer_guid,
		'limit' => 1,
		)); 
	$carts = $carts[0];
	if(!$carts){echo 'cart not found at '.__FILE__ .' at '.__LINE__; die(); } //	@todo - fix this. it's a bit of a hack...
		
	if($carts){
		$payment_fee = (float)$posted_values['fee'];
		$payment_gross = (float)$posted_values['total'];
		$payment_fee_percentage = ($payment_fee * 100)/$payment_gross;
		$payment_net = $payment_gross - $payment_fee;
						
		$order = new ElggObject();
		$order->access_id = 2;
		$order->owner_guid = $buyer_guid;
		$order->subtype = 'order';
		$order->payment_fee = $payment_fee;
		$order->total = $payment_gross;
		$order->percentage = $payment_fee_percentage;
		$order->amount = $payment_net;
		$order->payer_email = $posted_values['email'];
		$order->transaction_status = $posted_values['status'];
		$order->transaction_id = $posted_values['txn_id'];
		$order->checkout_method = $CheckoutMethod;
			
		if($ShippingMethod != 0 ) {
			$order->shipping_method=$ShippingMethod;
		}
			
		$BillingAddress = get_entity( $BillingDetails );
		$order->b_first_name = $BillingAddress->first_name;
		$order->b_last_name = $BillingAddress->last_name;
		$order->b_address_line_1 = $BillingAddress->address_line_1;
		$order->b_address_line_2 = $BillingAddress->address_line_2;
		$order->b_city = $BillingAddress->city;
		$order->b_state = $BillingAddress->state;
		$order->b_country = $BillingAddress->country;
		$order->b_pincode = $BillingAddress->pincode;
		
		if($BillingAddress->mobileno) { $order->b_mobileno = $BillingAddress->mobileno; }
		if($BillingAddress->phoneno) { $order->b_phoneno = $BillingAddress->phoneno; }
		
		$order->container_guid = $container_guid;
		$order_guid = $order->save();		
		
		if($order_guid){
			$cart_guid = $carts->guid;
			$tot = $tax_total_price = 0;		//	@todo - is this even used
			$item_details_for_store_owner = array();
			//-------- Site admin ----------------//
			$admin_user = elgg_get_admins(array('limit' => 1));
			//-------- Site entity ----------------//
			$site = get_entity(elgg_get_config('site_guid'));
				
			$cart_items = elgg_get_entities_from_relationship(array(
				'relationship' => 'cart_item',
				'relationship_guid' => $cart->guid, 
				));

			if($cart_items){
				if($ShippingMethod){						//	@todo -  will need to test this function
					foreach ($cart_items as $cart_item){
						$product = get_entity($cart_item->product_id);
						$products[$product->guid] = (object)array('quantity'=>$cart_item->quantity, 'price'=>$cart_item->amount, 'type'=>$product->product_type_id );
					}
					$function = "price_calc_".$ShippingMethod;
					if(function_exists($function)){
						$s_prince = $function($products);
					}
				}

				foreach ($cart_items as $cart_item){
					$price = 0;
					$product_id = $cart_item->product_id;
					$product = get_entity($product_id);
					$country_code = $product->countrycode;
					$item_payment_fee = ($product->price * $payment_fee_percentage)/100;
					$order_item = "";
					$order_item = new ElggObject();
					$order_item->access_id = 2;
					$order_item->owner_guid = $buyer_guid;
					$order_item->subtype="order_item";
					$order_item->product_id=$product_id;
					$order_item->product_owner_guid=$product->owner_guid;
					$order_item->title = $product->title;
					$order_item->description = $product->description;
					$order_item->quantity = $cart_item->quantity;
					$order_item->price = $product->price;
					$order_item->countrycode = $country_code;
					$order_item->payment_fee_per_item = $item_payment_fee;
					$order_item->status = 0;
					$order_item->save();
					if($s_prince[$product_id]){
						$order_item->shipping_price = $s_prince[$product_id];
						$shipping_total += $s_prince[$product_id];
					}
					if ($container_guid){
						$order_item->container_guid = $container_guid;
					}
					$coupon_discount = 0;
			
					$order_item_id = $order_item->save();
										
					if($order_item_id){
						if(in_array('product_checkout', unserialize(elgg_get_plugin_setting('river_settings', 'socialcommerce')))) {
							elgg_create_river_item( array(
								'view' => 'river/object/stores/purchase',
								'action_type' => 'purchase',
								'subject_guid' => $buyer_guid,
								'object_guid' => $product_id
								)
							);	
						}
												
						//-------- Buyer Price ----------------//
						$buyer_price = ( $product->price * $cart_item->quantity );
						
						$admin_transaction = new ElggObject();
						$admin_transaction->access_id = 2;
						$admin_transaction->owner_guid = $admin_user->guid;
						$admin_transaction->container_guid = $admin_user->guid;
						$admin_transaction->subtype = 'transaction';
						$admin_transaction->trans_type = "credit";
						$admin_transaction->title = 'site_commission';
						$admin_transaction->trans_category = 'site_commission';
						$admin_transaction->order_guid = $order_guid;
						$admin_transaction->order_item_guid = $order_item_id;
						$admin_transaction->amount = 0;
						$admin_transaction->payment_fee = $item_payment_fee * $cart_item->quantity;
						$admin_transaction->save();
												
						$buyer_transaction = new ElggObject();
						$buyer_transaction->access_id = 2;
						$buyer_transaction->owner_guid = $product->owner_guid;
						$buyer_transaction->container_guid = $product->owner_guid;
						$buyer_transaction->subtype = 'transaction';
						$buyer_transaction->total_amount = $product->price * $cart_item->quantity;
						$buyer_transaction->trans_type = "credit";
						$buyer_transaction->title = 'sold_product';
						$buyer_transaction->trans_category = 'sold_product';
						$buyer_transaction->order_guid = $order_guid;
						$buyer_transaction->order_item_guid = $order_item_id;
						$buyer_transaction->amount = $buyer_price;
						$buyer_transaction->save();
						
						$result = add_entity_relationship($order_guid, 'order_item', $order_item_id );
						if($product->product_type_id == 1){
							$product->quantity = $product->quantity - $cart_item->quantity;
							$product_update_guid = $product->save();
							if(!$product_update_guid > 0){
							
								//	get the inventory quantity for this product and subtract the amount that were sold in this order and then save new inventory amount.... re-write this
			echo '<b>'.__FILE__ .' at '.__LINE__; die();
			$dbprefix = elgg_get_config('dbprefix');
			
	$existing = get_data_row("SELECT * from {$dbprefix}metadata WHERE entity_guid = $product->guid and name_id=" .elgg_get_metastring_id('quantity') . " limit 1");
								if($existing){
									$id = $existing->id;
									$value = $product->quantity - $cart_item->quantity;
									$metadat_update = update_metadata($id, 'quantity', $value, $existing->value_type, $existing->owner_guid, $existing->access_id);	
								}
							}
						}
						if($result){
							$image = "";
							$desc = nl2br($product->description);
							$discount_price = $product->price;
							
							$sub_total = $discount_price * $cart_item->quantity;
							$original_price = $product->price * $cart_item->quantity;
							$total_price += $sub_total;

							$display_price = get_price_with_currency($original_price);

							$product_url = $product->getURL();
							
							$product_image_guid = sc_product_image_guid($product->guid);
							$image = '<img src ="'.elgg_get_config('url').'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/image/'.$product_image_guid.'/'.'medium'.'"/>'; 
							
							
							
							$display_sub_total = get_price_with_currency($sub_total);
							
	if($product->mimetype && $product->product_type_id == 2){
		$icon = '<div title="Download" class="order_icon_class"><a href="'.elgg_get_config('url')."action/socialcommerce/download?product_guid={$order_item->guid}\">".elgg_view("socialcommerce/icon", array("mimetype" => $product->mimetype, 'thumbnail' => $product->thumbnail, 'stores_guid' => $product->guid, 'size' => 'small')) . "</a></div><div class='clear'></div>";
	}else{
		$icon = "";
	}
							
							$item_details .= <<<EOF
								<tr>
									<td style="width: 400px;">
										<div style="float:left;">{$product->title}</div>{$icon}
										<div style="clear:both;"></div>
									</td>
									<td style="text-align:center;">{$cart_item->quantity}</td>
									<td style="text-align:right;">
										{$display_price}
									</td>
									<td style="text-align:right;">
										{$display_sub_total}
									</td>
								</tr>
EOF;
							$item_details_for_store_owner[$product->owner_guid]['content'] .= <<<EOF
								<tr>
									<td style="width: 350px;"><div style="float:left;">
										<a href="{$product->getUrl()}">{$product->title}</a></div>
										<div style="clear:both;"></div>
									</td>
									<td style="text-align:center;">{$cart_item->quantity}</td>
									<td style="text-align:right;">
										{$display_price}
									</td>
									<td style="text-align:right;">
										{$display_sub_total}
									</td>
								</tr>
EOF;
						}
						$item_details_for_store_owner[$product->owner_guid]['total'] += $sub_total;
					}
					$cart_item = get_entity($cart_item->guid);
					$cart_item->delete();				
				}
				if($result){
					$buyer_email = $buyer->email;
					$site_email = $site->email;
					
					$order_date = date("dS M Y");
					$order_recipient = $order->b_first_name." ".$order->b_last_name;
					$order_total = $order->s_first_name." ".$order->s_last_name;
					$billing_details = elgg_view("socialcommerce/order_display_address", array('entity'=>$order,'type'=>'b'));
					$adderss_details = <<<EOF
						<div style="float:left;width:300px;">
							<h3 style="font-size:16px;">Billing Details</h3>
							{$billing_details}
						</div>		
EOF;
					if($ShippingMethod){
						$shipping_details = elgg_view("socialcommerce/order_display_address", array('entity'=>$order,'type'=>'s'));
						$adderss_details .= <<<EOF
							<div style="float:left;width:300px;">
								<h3 style="font-size:16px;">shipping Details</h3>
								{$shipping_details}
							</div>		
EOF;
					}
					if($shipping_total > 0){
						$display_shipping_price = get_price_with_currency($shipping_total);
						$shipping_price = <<<EOF
							<tr>
								<td style="border-top:1px solid #4690D6;" colspan="4">
									<div style="width:100px;float:right;text-align:right;"><B>{$display_shipping_price}</B></div>
									<div style="text-align:right;"><B>Shipping:</B> </div> 
								</td>
							</tr>
EOF;
					}
					$grand_total_price = $total_price + $shipping_total;
					$display_grand_total = get_price_with_currency($grand_total_price);
					$grand_total = <<<EOF
						<tr>
							<td style="border-top:1px solid #4690D6;" colspan="4">
								<div style="width:100px;float:right;text-align:right;"><B>{$display_grand_total}</B></div>
								<div style="text-align:right;"><B>Total Cost:</B> </div> 
							</td>
						</tr>
EOF;
					$order_page = elgg_get_config('url').'socialcommerce/'.$buyer->username.'/order/';
					if($product->mimetype && $product->product_type_id == 2){
						$download_condition = <<<EOF
							<div>
								<div><b>How to download</b></div>
								if you want to download please follow the bellow steps.
								<ul>
									<li>Please click to the product type icon on the above order details.</li>
								</ul>
								<div style="margin-left:40px;"><b>OR</b></div>
								<ul>
									<li>Please go to <a target="_blank" href="{$order_page}">My Order</a></li>
									<li>Then click on View Details button.</li>
									<li>Click to the product type icon on order details.</li>
								</ul>
							</div>				
EOF;
					}else{
						$download_condition = "";
					}
						$ShippingMethod = 'None';
					$order_link = elgg_get_config('url').'socialcommerce/'.$buyer->username.'/order_products/'.$order_guid;
					$view_total_price = get_price_with_currency($grand_total_price);
					$mail_body = sprintf(elgg_echo('order:mail'),
										 $buyer->name,
										 $order_guid,
										 $order_link,
										 $order_link,
										 $order_guid,
										 $order_date,
										 $order_recipient,
										 $view_total_price,
										 $adderss_details,
										 $order_guid,
										 $item_details,
										 $tax_display,
										 $shipping_price,
										 $grand_total,
										 $download_condition
					);
					$subject = "New {$site->name} Purchase completed";
					stores_send_mail(	 $site, 					// From entity
										 $buyer, 					// To entity
										 $subject,					// The subject
										 $mail_body					// Message
								);
					
					if($admin_user){
						$mail_body = sprintf(elgg_echo('order:mail:to:admin'),
										 $admin_user->name,
										 $site->name,
										 $order_link,
										 $order_guid,
										 $order_date,
										 $order_recipient,
										 $view_total_price,
										 $adderss_details,
										 $order_guid,
										 $item_details,
										 $tax_display,
										 $shipping_price,
										 $grand_total
						);
						$subject = "New order created on {$site->name}";
						stores_send_mail($site, 					// From entity
										 $admin_user, 				// To entity
										 $subject,					// The subject
										 $mail_body					// Message
								);
					}
					
					if(count($item_details_for_store_owner) > 0){
						foreach($item_details_for_store_owner as $product_owner_guid=>$item_detaile){
							$product_owner = get_entity($product_owner_guid);
							$display_grand_total = get_price_with_currency($item_detaile['total']);
							$grand_total = <<<EOF
								<tr>
									<td style="border-top:1px solid #4690D6;" colspan="4">
										<div style="width:100px;float:right;text-align:right;"><B>{$display_grand_total}</B></div>
										<div style="text-align:right;"><B>Total Cost:</B> </div> 
									</td>
								</tr>
EOF;
							$mail_body = sprintf(elgg_echo('order:mail:for:store:owner'),
										 $product_owner->name,
										 $site->name,
										 $order_guid,
										 $order_date,
										 $order_recipient,
										 $adderss_details,
										 $order_guid,
										 $item_detaile['content'],
										 $grand_total
								);
							$subject = "Sold product(s) from {$site->name}";
							stores_send_mail($site, 				// From entity
										 $product_owner, 			// To entity
										 $subject,					// The subject
										 $mail_body					// Message
								);
						}
					}
				}
			}
			if(count($used_coupons) > 0 && $used_coupons){
				foreach($used_coupons as $coupon_guid=>$coupon_code){
					add_entity_relationship($coupon_guid, 'coupon_uses', $order_guid);
				}
			}
		}
		$cart->delete();		//	not until we're finished...
	}
	return $order_guid;
}

/***************************************
	End create order function
****************************************/




function view_success_page(){
	$view = 'modules/checkout/'.$_SESSION['CHECKOUT']['checkout_method'].'/cart_success';
	if(elgg_view_exists($view)){
		$body = elgg_view($view);
		$content = $title.$body;
		$sidebar .= elgg_view("socialcommerce/sidebar");
		$params = array(
			'title' => $title,
			'content' => $content,
			'sidebar' => $sidebar,
			);
		$body = elgg_view_layout('one_sidebar', $params);
		echo elgg_view_page($title1, $body);
	}else{
		forward(elgg_get_config('url')."socialcommerce/{$_SESSION['user']->username}/all");
	}
}

function sc_view_cancel_page(){
	$view = 'modules/checkout/'.$_SESSION['CHECKOUT']['checkout_method'].'/cart_cancel';
	if(elgg_view_exists($view)){
		$body = elgg_view($view);
		$title = elgg_view_title(elgg_echo('cart:cancel'));
		elgg_set_context('socialcommerce');
		$content = $body;
		$sidebar .= elgg_view("socialcommerce/sidebar");
		$params = array(
			'title' => $title,
			'content' => $content,
			'sidebar' => $sidebar,
			);
		$body = elgg_view_layout('one_sidebar', $params);
		echo elgg_view_page(elgg_echo('cart:cancel'), $body);
	}else{
		forward(elgg_get_config('url')."socialcommerce/{$_SESSION['user']->username}/all");
	}
}

function view_checkout_error_page(){
	$view = 'modules/checkout/'.$_SESSION['CHECKOUT']['checkout_method'].'/checkout_error';
	if(elgg_view_exists($view)){
		$body = elgg_view($view);
		return $body;
	}else{
		forward(elgg_get_config('url')."socialcommerce/{$_SESSION['user']->username}/all");
	}
}

/***********************************************************************
 * Read withdraw plugins and withdraw methods. It return as an array.
 ***********************************************************************/


function create_withdraw_transaction($amount,$receiver_email){
	$withdraw_transaction = new ElggObject();
	$withdraw_transaction->access_id = 2;
	$withdraw_transaction->owner_guid=$_SESSION['user']->guid;
	$withdraw_transaction->container_guid=$_SESSION['user']->guid;
	$withdraw_transaction->subtype='transaction';
	$withdraw_transaction->amount=$amount;
	$withdraw_transaction->trans_type="debit";
	$withdraw_transaction->title='withdraw_fund';
	$withdraw_transaction->trans_category='withdraw_fund';
	$withdraw_transaction->receiver_email=$receiver_email;
	
	$result = $withdraw_transaction->save();
	
	return $result;
}

/*****	currency	*****/

function get_currency_list(){
	$currencies = array_diff(scandir(CURRENCY_PATH), array('..', '.'));
	if($currencies){
		return $currencies;
	}else{
		return false;
	}
}

function load_currency_actions() {
	$currency_lists = get_currency_list();
	if ($currency_lists) {
		foreach ($currency_lists as $currency_list){
			if(!require_once(CURRENCY_PATH.$currency_list.'/action.php')){
				throw new PluginException(sprintf(elgg_echo('misconfigured:currency:method'), $currency_list));
			}
		}
	}
}

function get_price_with_currency( $price ){		

	$fmt = numfmt_create( 'en_US', NumberFormatter::CURRENCY );
	return numfmt_format_currency($fmt, $price, "USD");
	die();

	if(!$default_currency = elgg_get_plugin_from_id('socialcommerce')) {
		register_error(elgg_echo("default:currency:fail"));						
		FORWARD();																//	@todo - forward to where? by default it's the website homepage...
	}
	
	$currency_token = htmlentities($default_currency->currency_token, ENT_QUOTES, "UTF-8");
	$token_location = $default_currency->token_location;
	$decimal_token =  $default_currency->decimal_token;
	$price = number_format(round($price, $decimal_token), $decimal_token,'.','');
	$return = ($token_location == 'left') ? $currency_token.' '.$price : $price.' '.$currency_token;
		
	return $return;
}

function get_currency_name(){
	
	if(!$default_currency = elgg_get_plugin_from_id('socialcommerce')) {
		register_error(elgg_echo("default:currency:fail"));						
		FORWARD();																//	@todo - forward to where? by default it's the website homepage...
	}

	return $default_currency->currency_name;
}

function validate_currency( $c_code = "", $amount = 0, $method = "" ){
	load_currency_actions();
		
	if($method){
		if(!is_array($valid_amount))
			$valid_amount = array();
		switch ($method){
			case "paypal":
				$valid_currencies = array('AUD','CAD','EUR','GBP','JPY','USD','NZD','CHF','HKD','SGD','SEK','DKK','PLN','NOK','HUF','CZK','ILS','MXN');
				if(in_array($c_code,$valid_currencies)){
					$valid_amount['currency_code'] = $c_code;
					$valid_amount['amount'] = number_format($amount,2,'.','');
				}else {
					$exchange_rate = get_exchange_rate($c_code, 'USD');
					$valid_amount['currency_code'] = 'USD';
					$valid_amount['amount'] = number_format(($exchange_rate * $amount),2,'.','');
				}
				break;
			default:
				if($c_code == 'USD'){
					$valid_amount['currency_code'] = $c_code;
					$valid_amount['amount'] = number_format($amount,2,'.','');
				}else{
					$exchange_rate = get_exchange_rate($c_code, 'USD');
					$valid_amount['currency_code'] = 'USD';
					$valid_amount['amount'] = number_format(($exchange_rate * $amount),2,'.','');
				}
				break;
		}
		return $valid_amount;
	}
}

function convert_currency($convert_from="", $convert_to="", $amount=0){
	load_currency_actions();
	if($convert_from && $convert_to && $amount > 0){
		$con_rate = get_exchange_rate($convert_from, $convert_to);
		$con_rate = number_format($con_rate * $amount,2,'.','');
		return $con_rate;
	}
}

/******************************************/
/*           COUNTRY & STATE              */
/******************************************/

function register_country_state(){
	if ( file_exists(elgg_get_config('pluginspath').'/socialcommerce/xml/country_state.xml')) {
		$xml = new ElggXMLElement(file_get_contents(elgg_get_config('pluginspath').'/socialcommerce/xml/country_state.xml'));
				
		if ($xml && is_object($xml)){
			$country = array();
			foreach ($xml->children as $countries_array){
				$country_id = $countries_array->attributes['id'];
				if(!is_array($countries_array->children))
					$countries_array->children = array();
				foreach ($countries_array->children as $country_array){
					switch ($country_array->name){
						case 'name': 
							$country_name = $country_array->content;
							break;
						case 'iso2': 
							$iso2 = $country_array->content;
							break;
						case 'iso3': 
							$iso3 = $country_array->content;
							break;
						case 'states': 
							$state = array();
							if(!is_array($country_array->children))
								$country_array->children = array();
							foreach ($country_array->children as $state_array){
								$state_name = $state_array->content;
								$state_abbrv = $state_array->attributes['abbrv'];
								if(!empty($state_name) || !empty($state_abbrv)){
									$state_object = new stdClass();
									$state_object->name = $state_name;
									$state_object->abbrv = $state_abbrv;
									
									array_push($state,$state_object);
								}
							}
							break;
					}
				}
				
				$country[$country_name]['name'] = $country_name;
				$country[$country_name]['id'] = $country_id;
				$country[$country_name]['iso2'] = $iso2;
				$country[$country_name]['iso3'] = $iso3;
				if(count($state) > 0){
					$country[$country_name]['state'] = $state;
				}
			}
			elgg_set_config('country', $country);
		}
	}
}

function get_state_by_countryname($name=""){
	$country = elgg_get_config('country');
	if(!empty($name) && count($country[$name]['state']) > 0){
		$country_state = $country[$name]['state'];
		return $country_state;
	}else{
		return false;
	}
}

function get_state_by_fields($field="",$value=""){
	$countries = elgg_get_config('country');
	if(!empty($field) && !empty($value) && count($countries) > 0){
		if($field == 'iso2' || $field == 'iso3'){
			$value = strtoupper($value);
		}
		foreach ($countries as $country){
			if($country[$field] == $value){
				if(count($country['state']) > 0)
					$state = $country['state'];
				break;
			}
		}
		if(count($state) > 0){
			return $state;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function get_iso2_by_fields($field="",$value=""){
	$countries = elgg_get_config('country');
	if(!empty($field) && !empty($value) && count($countries) > 0){
		if($field == 'iso3'){
			$value = strtoupper($value);
		}
		foreach ($countries as $country){
			if($country[$field] == $value){
				if(count($country['iso2']) > 0)
					$iso2 = $country['iso2'];
				break;
			}
		}
		if(!empty($iso2)){
			return $iso2;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function get_iso3_by_fields($field="",$value=""){
	$countries = elgg_get_config('country');
	if(!empty($field) && !empty($value) && count($countries) > 0){
		if($field == 'iso2'){
			$value = strtoupper($value);
		}
		foreach ($countries as $country){
			if($country[$field] == $value){
				if(count($country['iso3']) > 0)
					$iso3 = $country['iso3'];
				break;
			}
		}
		if(!empty($iso3)){
			return $iso3;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function get_name_by_fields($field="",$value=""){
	$countries = elgg_get_config('country');
	if(!empty($field) && !empty($value) && count($countries) > 0){
		if($field == 'iso2'){
			$value = strtoupper($value);
		}
		foreach ($countries as $country){
			if($country[$field] == $value){
				if(count($country['name']) > 0)
					$name = $country['name'];
				break;
			}
		}
		if(!empty($name)){
			return $name;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

/*****	Function to convert a weight between the specified units.	*****/

function convert_weight($weight, $to_unit, $from_unit = null){
		
	if(is_null($from_unit)) {
		$from_unit = elgg_get_config('default_weight_unit');
	}
	$from_unit = strtolower($from_unit);
	$to_unit = strtolower($to_unit);

	$units = array(
			'pounds' => array('lb', 'pound', 'lbs', 'pounds'),
			'kg' => array('kg', 'kgs', 'kilos', 'kilograms'),
			'gram' => array('g', 'grams')
	);

	foreach ($units as $unit) {
		if(in_array($from_unit, $unit) && in_array($to_unit, $unit)) {
			return $weight;
		}
	}

	// First, let's convert back to a standardized measurement. We'll use grams.
	switch(strtolower($from_unit)) {
		case 'lbs':
		case 'pounds':
		case 'pound':
		case 'lb':
			$weight *= 453.59237;
			break;
		case 'ounces':
			$weight *= 28.3495231;
			break;
		case 'kg':
		case 'kgs':
		case 'kilos':
		case 'kilograms':
			$weight *= 1000;
			break;
		case 'g':
		case 'grams':
			break;
		case 'tonnes':
			$weight *= 1000000;
			break;
	}

	// Now we're in a standardized measurement, start converting from grams to the unit we need
	switch(strtolower($to_unit)) {
		case 'lbs':
		case 'pounds':
		case 'pound':
		case 'lb':
			$weight *= 0.00220462262;
			break;
		case 'ounces':
			$weight *= 0.0352739619;
			break;
		case 'kg':
		case 'kgs':
		case 'kilos':
		case 'kilograms':
			$weight *= 0.001;
			break;
		case 'g':
		case 'grams':
			break;
		case 'tonnes':
			$weight *= 0.000001;
			break;
	}
	return $weight;
}

function GenerateCouponCode(){
	$len = rand(8, 12);
	$retval = chr(rand(65, 90));
	for ($i = 0; $i < $len; $i++) {
		if (rand(1, 2) == 1) {
			$retval .= chr(rand(65, 90));
		} else {
			$retval .= chr(rand(48, 57));
		}
	}
	return $retval;
}


function get_coupon_uses($coupon_guid){
	$guid_one = (int)$coupon_guid;
	$relationship = 'coupon_uses';
	$dbprefix = elgg_get_config('dbprefix');
		
	if ($row = get_data("SELECT * FROM {$dbprefix}entity_relationships WHERE guid_one=$guid_one AND relationship='$relationship' limit 0,999999", "entity_row_to_elggstar")) {
		return $row;
	}
	return false;
}


function generate_vat($vat_rate = '',$sub_total = '',$country_rate = ''){
	
	if($country_rate == '')
	{
		$vat_amt = ($vat_rate * $sub_total) / 100;
		$tot_amt = $tax_amt + $sub_total ;
	}
	else
	{
		$vat_amt = ($country_rate * $sub_total) / 100;
		$tot_amt = $tax_amt + $sub_total ;
	}
    return $tot_amt;
	return false;
}

function elgg_cart_quantity($entity,$status=false,$status_val=0){
	
	if ($entity->guid > 0) {
		if($product = get_entity($entity->product_id))
			$product_price = $product->price;
		if (elgg_get_context() == "confirm") {
			$quantity_box = $entity->quantity;
			$quantity_text = elgg_echo("quantity:available");
		}elseif(elgg_get_context() == "order" || elgg_get_context() == "purchased_products"){
			$quantity_box = $entity->quantity;
			$quantity_text = elgg_echo("quantity:available");
		}else{
			if(elgg_is_logged_in()){
				$quantity_box = elgg_view('input/text',array('name' => "cartquantity[{$entity->guid}]",'class'=>"input_quantity", 'value'=>$entity->quantity));
				$quantity_text = elgg_echo("quantity");
			}
		}
		
		$sub_total = $product_price * $entity->quantity;
		if($related_product_price)
			$sub_total += $related_product_price;
		$display_sub_total = get_price_with_currency($sub_total);
		$info = "<div>";
		if($entity->product_type_id == 1){
			$info .= "<b>".elgg_echo("quantity")." :</b> ". $quantity_box;
		}
		$info .= '<span class=\"space\">&nbsp;</span><B>'.elgg_echo("stores:price").' :</B>'. $display_sub_total;
		
		if($status){
			$status = elgg_view("socialcommerce/product_status",array('status'=>$status_val,'action'=>$status));
		}
		$info .= "</div>";
		
		$price_text = elgg_echo("stores:total");
		if($product->status == 1){
			;
			
		}
		if($product->product_type_id == 1){
			$quantity = "<div style='margin-bottom:5px;'><B>{$quantity_text}:</B> {$quantity_box}</div>";
		}else if($product->product_type_id == 2 && elgg_get_context() == 'purchased_products'){
		
			$download = '<div class="dproducts_download"><p><a href="'.elgg_get_config('url')."action/socialcommerce/download?product_guid={$entity->guid}\">".elgg_echo("product:download")."</a></p></div>";
		}
		$info = <<<EOF
			<div>
				{$related_product_display}
				<table>
					<tr>
						<td style="width:160px;">
							{$quantity}
							<div><B>{$price_text}:</B> {$display_sub_total}</div>
							<div style="margin-bottom:5px;">{$status}</div>
						</td>
						<td style="width:50px;"></td>
						<td>
							<div style="padding-top:5px;">
								<div style="float:left;">
									{$download}
								</div>
								<div class="clear"></div>
							</div>
						</td>
					</tr>
				</table>
			</div>		
EOF;
		
		return $info;
	}
}

function calculate_cart_total($cart_user=0, $product_user=0 ){
			
	if(elgg_is_logged_in()){
		if($cart_user > 0)
			$user_guid = $cart_user;
		else
			$cart_user = elgg_get_logged_in_user_guid();
		$cart = elgg_get_entities(array( 	
			'type' => 'object',
			'subtype' => 'cart',
			'owner_guid' => $cart_user,
			)); 			
		
		$cart = $cart[0];
		$cart_items = elgg_get_entities_from_relationship(array(
			'relationship' => 'cart_item',
			'relationship_guid' => $cart->guid, 
			));  		
	}
	
	if($cart_items){
		$total = 0;
		foreach ($cart_items as $cart_item){
			if(is_array($cart_item)){
				$cart_item = (object) array('product_id'=>$cart_item['product_id'],
											'quantity' => $cart_item['quantity'],
											'amount' => $cart_item['amount'],
											'time_created' => $cart_item['time_created']
											);
			}
			$product_tot = 0;
			if($cart_item->owner_guid > 0 && $product_user > 0){
				if($cart_item->owner_guid == $product_user){
					$quantity = $cart_item->quantity;
					if($product = get_entity($cart_item->product_id)){
						$price = $product->price;
					}
					$product_tot = $price * $quantity;
					$total += $product_tot;
				}
			}else{
				$quantity = $cart_item->quantity;
				if($product = get_entity($cart_item->product_id)){
					$price = $product->price;
				}
				$product_tot = $price * $quantity;
				$total += $product_tot;
			}

		}
	}
	return $total;
}
