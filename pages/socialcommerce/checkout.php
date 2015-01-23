<?php
	/**
	 * Elgg products - checkout page
	 * 
	 * @package Elgg products
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 

// echo __FILE__ .' at '.__LINE__; 

$payment = new stdClass();
$_SESSION['PAYMENT'] = $payment;


require_once('C:/Program Files (x86)/Zend/Apache2/htdocs/krumo/class.krumo.php');
$arr2 = get_defined_vars();
krumo($_SESSION['CHECKOUT']); // die();
krumo($_SESSION);
//krumo(get_input('checkout_status'));
	 
$page_owner = elgg_get_logged_in_user_entity();
$checkout_status = get_input('checkout_status')? get_input('checkout_status') : 'begin';
krumo($checkout_status);

switch ($checkout_status):
	case 'begin':
		unset($_SESSION['CHECKOUT']);
		$cart = elgg_get_entities(array( 	
				'type' => 'object',
				'subtype' => 'cart',
				'owner_guid' => $page_owner->guid,
				)); 
	
		if($cart){				//	@todo - should probably register an error and forward if cart is empty...
			$cart = $cart[0];
			$cart_items = elgg_get_entities_from_relationship(array(
				'relationship' => 'cart_item',
				'relationship_guid' => $cart->guid, 
				)); 
			if($cart_items){
				foreach ($cart_items as $cart_item){
					$product = get_entity($cart_item->product_id);
					if($_SESSION['CHECKOUT']['allow_shipping'] != 1){
						if( $product->product_type_id == 2 )				//	@todo - we can change this setting when we're building shipping methods.... 
								$_SESSION['CHECKOUT']['allow_shipping'] = 0;
						else 
							$_SESSION['CHECKOUT']['allow_shipping'] = 1;
					}
					$_SESSION['CHECKOUT']['product'][$cart_item->product_id] = (object)array('quantity'=>$cart_item->quantity,'price'=>$cart_item->amount,'type'=>$product->product_type_id);
				}
			}
		}
		break;
    case 'billing':
		$_SESSION['CHECKOUT']['confirm_billing_address'] = 1;
					if($address_guid = get_input('billing_address_guid')){
						$selected_address = get_entity($address_guid);
						$_SESSION['CHECKOUT']['billing_address'] = (object) array(
							'guid'=>$selected_address->guid,
							'firstname'=>$selected_address->first_name,
							'lastname'=>$selected_address->last_name,
							'address_line_1'=>$selected_address->address_line_1,
							'address_line_2'=>$selected_address->address_line_2,
							'city'=>$selected_address->city,
							'state'=>$selected_address->state,
							'country'=>$selected_address->country,
							'pincode'=>$selected_address->pincode,
							'mobileno'=>$selected_address->mobileno,
							'phoneno'=>$selected_address->phoneno
						);
					}
        break;
    case 'shipping':
		$_SESSION['CHECKOUT']['confirm_shipping_method'] = 1;	
		$_SESSION['CHECKOUT']['shipping_method'] = get_input('shipping_method');
		break;
    case 'payment':
        $_SESSION['CHECKOUT']['confirm_checkout_method'] = 1;	
		$_SESSION['CHECKOUT']['checkout_method'] = get_input('checkout_method');
		break;
	case 'confirmation':
        $checkout_confirm = 1;
		$redirect = check_checkout_form();
		break;
    default:
        continue;
endswitch;

$url = 'socialcommerce/' . $_SESSION['user']->username.'/checkout/';

$content = '
        <div class="content">
			<div id="wizard">
                <h2>'.elgg_echo('checkout:billing').'</h2>
                <div>';
$content .= 		elgg_view("socialcommerce/billing_details_new", array('checkout_order'=>$checkout_order)).'
                </div>';
				
$content .= '
                <h2>'.elgg_echo('checkout:shipping').'</h2>
                <div>';
				
$content .= 		elgg_view("socialcommerce/shipping_details_new", array('checkout_order'=>$checkout_order)).
					 elgg_view("socialcommerce/list_shipping_methods_new").'
                </div>';

$content .= '
                <h2>'.elgg_echo('checkout:payment').'</h2>
                <div>';
				
$content .= 				elgg_view("socialcommerce/list_checkout_methods_new").'
				
                   
                </div>';

$content .= '
                <h2>'.elgg_echo('checkout:confirmation').'</h2>
                <div>';
				
$content .= 				 elgg_view("socialcommerce/cart_confirm_list_new", array('checkout_confirm'=>$checkout_confirm)).'
							 
                    
                </div>
            </div>
        </div>';

/*****	lets try this	*****/		

//--------- Order Confirmation ----------//	
		if(isset($_SESSION['CHECKOUT']['checkout_method']) && $_SESSION['CHECKOUT']['checkout_method'] != ""){
			$checkout_plugin = $_SESSION['CHECKOUT']['checkout_method'];
			$order_confirmation_details = elgg_view("socialcommerce/cart_confirm_list_new",array('checkout_confirm'=>$checkout_confirm));
			$checkout_checkout_confirm = elgg_echo('checkout:checkout:confirm');
			if($checkout_confirm){
				$check_out_details = <<<EOF
					<h3>
						<a>
							<span class="list1b_icon"></span>
							<B>{$checkout_checkout_confirm}</B>
						</a>
					</h3>
					<div class="ui_content">
						<div class="content">
							{$redirect}
							<div class="clear"></div>
						</div>
					</div>
EOF;
			}
		}
		
		$class = $_SESSION['CHECKOUT']['allow_shipping'] == 1 ? '' : 'class="shipping_disable"';
		$no_coupon = elgg_echo('no:coupon:in:couponcode');
		$exp_date = elgg_echo('coupon:exp_date');
		$coupon_maxuses = elgg_echo('coupon:maxuses:limit');
		$not_applied = elgg_echo('coupon:not_applied');
		$coupon_applied = elgg_echo('coupon:applied');
		$checkout_billing_details = elgg_echo('checkout:billing:details');
		$checkout_checkout_method = elgg_echo('checkout:checkout:method');
		$checkout_shipping_method = elgg_echo('checkout:shipping:method');
		$checkout_order_confirm = elgg_echo('checkout:order:confirm');

$content .= '<div>'.		
				$check_out_details.'
			</div>
			<div id="load_action"></div>
			<div id="load_action_div">
				<img src="'.$CONFIG->url.'mod/socialcommerce/images/loadingAnimation.gif">
				<div style="color:#FFFFFF;font-weight:bold;font-size:14px;margin:10px;">Processing...</div>
			</div>';


/***** END lets try this	*****/

$title = elgg_echo('checkout:confirm:btn');
$content = '<div class="contentWrapper stores">'.$content.'</div>';
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
	
	elgg_load_css('jquery.steps');
	elgg_load_js('jquery.validate');
	elgg_load_js('jquery.steps.min');
	elgg_load_js('socialcommerce.checkout');

	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo('checkout:confirm:btn'), $body);
