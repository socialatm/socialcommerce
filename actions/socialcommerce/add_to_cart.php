<?php
	/**
	 * Elgg cart - add to cart action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
	gatekeeper();
	$user = elgg_get_logged_in_user_entity();
		
	$product_guid = get_input("product_guid");
	$product = get_entity($product_guid);
	
	$quantity = (get_input("cartquantity")) ? get_input("cartquantity") : 1;
		
	$product_type_details = sc_get_product_type_from_value($product->product_type_id);
	
	//	@todo - throw an error message here...	if product is on backorder or something like that
	if($product_type_details->addto_cart != 1){			//	@todo - throw an error message here...	
		forward($product->getURL());
	}
	
				// Get the users shopping cart
				$carts = elgg_get_entities(array(
					'type' => 'object',
					'subtype' => 'cart',
					'owner_guid' => $user->guid, 
					));
					
				if($carts){
					$cart = $carts[0];
					unset($carts);
					$cart_guid = $cart->guid;
										
					//	get all the items that are in the cart
					$cart_items = elgg_get_entities_from_relationship(array(
						'relationship' => 'cart_item',
						'relationship_guid' => $cart->guid,
					));
					
					// is this product already in the cart?
					foreach($cart_items as $key => $value){
						if($value->guid == $product_guid){
							$in_cart = TRUE;
						}
					}
					
					switch($in_cart) {
						// do this if the product is already in the cart
						case TRUE:
							echo 'product is already in the cart';
							break;
						// do this if the product is already in the cart
						default:
							echo 'product is NOT already in the cart';
					} 
					
					
require_once('C:/Program Files (x86)/Zend/Apache2/htdocs/krumo/class.krumo.php');
$arr2 = get_defined_vars();
// krumo($arr2);


krumo($in_cart);

krumo::defines();

die();
					
					
					if($cart_item){
						if($product->product_type_id == 1){
							$cart_item = get_entity($cart_item[0]->guid);
							if($product->quantity >= ($quantity+$cart_item->quantity)){
								$cart_item->quantity = $cart_item->quantity + $quantity;
								$result = $cart_item_guid = $cart_item->save();
								if($result){									
									;
								}
							}else{
								register_error(sprintf(elgg_echo("cart:quantity:less"), $product->title));
								$return = elgg_get_config('url').'socialcommerce/'.$user->username.'/buy/'.$product->guid.'/'.$product->title;
							}
						} else {
							register_error(elgg_echo("cart:already:added"));
							$cart_added = true;
							$return = elgg_get_config('url').'socialcommerce/'.$user->username.'/buy/'.$product->guid.'/'.$product->title;
						}
					}else{
						$cart_item = new ElggObject();
						$cart_item->access_id = ACCESS_PRIVATE;
						$cart_item->subtype = "cart_item";
						$cart_item->quantity = $quantity;
						$cart_item->product_id = $product_guid;
						$cart_item->amount = $product->price;
						$cart_item->container_guid = $user->guid;
						
						$cart_item_guid = $cart_item->save();
						if($cart_item_guid){
							$result = add_entity_relationship($cart_guid, 'cart_item', $cart_item_guid );
							
						}
					}
				}else{
					$cart = new ElggObject();
					$cart->access_id = ACCESS_PRIVATE;
					$cart->subtype = "cart";
					$cart->container_guid = $user->guid;
					
					$cart_guid = $cart->save();
					if($cart_guid){
						$cart_item = new ElggObject();
						$cart_item->access_id = ACCESS_PRIVATE;
						$cart_item->title = $product->title;
						$cart_item->subtype = "cart_item";
						$cart_item->quantity = $quantity;
						$cart_item->product_id = $product_guid;
						$cart_item->amount = $product->price;
						$cart_item->container_guid = $user->guid;
						
						$cart_item_guid = $cart_item->save();
						if($cart_item_guid){
							$result = add_entity_relationship($cart_guid,'cart_item',$cart_item_guid);
						}
					}
				}
			if(!$cart_added){
				if ($result){
					system_message(elgg_echo("cart:added"));
					$return = elgg_get_config('url').'socialcommerce/'.$user->username.'/cart/';
				}else {
					register_error(elgg_echo("cart:addfailed"));
					$return = elgg_get_config('url').'socialcommerce/'.$user->username.'/buy/'.$product->guid.'/'.$product->title;
				}	
			}
	
	forward($return);
