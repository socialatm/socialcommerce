<?php
	/**
	 * Elgg cart - add action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	global $CONFIG;
	
	// Get variables
	$quantity = get_input("cartquantity");
	$product_guid = get_input("stores_guid");

	$container_guid = (int) get_input('container_guid', 0);
	if (!$container_guid && isloggedin()){
		$container_guid = $_SESSION['user']->getGUID();
	}
	// Get product enthity
	$product = get_entity($product_guid);
	if($product->product_type_id == 2){
		$quantity = 1;
	}
	$product_type_details = get_product_type_from_value($product->product_type_id);
	if($product_type_details->addto_cart != 1){
		$reditrect = $product->getURL();
		forward($reditrect);
	}
	// Check the quantity of a product
	if($product->quantity > 0 || $product->product_type_id == 2){
		if(($product->quantity >= $quantity && $quantity > 0) || $product->product_type_id == 2){
			if(isloggedin()){
				// Get carts of a particular user for find that product is already in particular user's cart
				$carts = elgg_get_entities(array(
					'type' => 'object',
					'subtype' => 'cart',
					'owner_guid' => $_SESSION['user']->getGUID(), 
					));
					
				if($carts){
					$cart = $carts[0];
					$cart_guid = $cart->guid;
					$cart_item = get_stores_from_relationship('cart_item',$cart_guid,'product_id',$product_guid,'object','cart_item',$_SESSION['user']->getGUID());
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
								register_error(sprintf(elgg_echo("cart:quantity:less"),$product->title));
								$return = $CONFIG->url . 'pg/socialcommerce/' . $product->getOwnerEntity()->username . "/buy/" . $product->getGUID() . "/" . $product->title;
							}
						} else {
							register_error(elgg_echo("cart:already:added"));
							$cart_added = true;
							$return = $CONFIG->url . 'pg/socialcommerce/' . $product->getOwnerEntity()->username . "/buy/" . $product->getGUID() . "/" . $product->title;
						}
					}else{
						$cart_item = new ElggObject();
						$cart_item->access_id = 2;
						$cart_item->subtype = "cart_item";
						$cart_item->quantity = $quantity;
						$cart_item->product_id = $product_guid;
						$cart_item->amount = $product->price;
						if ($container_guid){
							$cart_item->container_guid = $container_guid;
						}
						$cart_item_guid = $cart_item->save();
						if($cart_item_guid){
							$result = add_entity_relationship($cart_guid,'cart_item',$cart_item_guid);
							
						}
					}
				}else{
					$cart = new ElggObject();
					$cart->access_id = 2;
					$cart->subtype = "cart";
					if ($container_guid){
						$cart->container_guid = $container_guid;
					}
					$cart_guid = $cart->save();
					if($cart_guid){
						$cart_item = new ElggObject();
						$cart_item->access_id = 2;
						$cart_item->title = $product->title;
						$cart_item->subtype = "cart_item";
						$cart_item->quantity = $quantity;
						$cart_item->product_id = $product_guid;
						$cart_item->amount = $product->price;
						if ($container_guid){
							$cart_item->container_guid = $container_guid;
						}
						$cart_item_guid = $cart_item->save();
						if($cart_item_guid){
							$result = add_entity_relationship($cart_guid,'cart_item',$cart_item_guid);
							
						}
					}
				}
			}
			if(!$cart_added){
				if ($result){
					system_message(elgg_echo("cart:added"));
					$return = $CONFIG->url . 'pg/socialcommerce/' . $_SESSION['user']->username . "/cart/";
				}else {
					register_error(elgg_echo("cart:addfailed"));
					$return = $CONFIG->url . 'pg/socialcommerce/' . $product->getOwnerEntity()->username . "/buy/" . $product->getGUID() . "/" . $product->title;
				}	
			}
			$container_user = get_entity($container_guid);
		}else{
			register_error(elgg_echo("cart:addfailed:quantity"));
			$return = $CONFIG->url . 'pg/socialcommerce/' . $product->getOwnerEntity()->username . "/buy/" . $product->getGUID() . "/" . $product->title;
		}
	}else{
		register_error(elgg_echo("cart:addfailed:pquantity"));
		$return = $CONFIG->url . 'pg/socialcommerce/' . $product->getOwnerEntity()->username . "/buy/" . $product->getGUID() . "/" . $product->title;
	}
	forward($return);
?>