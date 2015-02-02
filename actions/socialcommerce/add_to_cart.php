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
	
	$quantity = get_input('quantity') ? (int)get_input('quantity') : 1;
		
	$product_type_details = sc_get_product_type_from_value($product->product_type_id);
	//	@todo - throw an error message here...	if product is on backorder or something like that
	if($product_type_details->addto_cart != 1){			//	@todo - throw an error message here...	
		forward($product->getURL());
	}
		
	// Get the users shopping cart
	$cart = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'cart',
		'owner_guid' => $user->guid,
		'limit' => 1
	));
	$cart = $cart[0];
	
	// if the user does not have a shopping cart let's create one
	if(is_null($cart)){
		$cart = new ElggObject();
		$cart->access_id = ACCESS_PRIVATE;
		$cart->subtype = "cart";
		$cart->owner_guid = $user->guid;
		$cart_guid = $cart->save();
	}
	// if unable to create cart throw an error message
	if(is_null($cart->guid)){
		register_error(elgg_echo('cart:not:created'));
		forward(REFERER);
	}
	
	//	get the product if it's in the cart
	$in_cart = elgg_get_entities_from_metadata(array(
		'container_guid' => $cart->guid,
		'metadata_name_value_pairs' => array( 'name' => 'product_id', 'value' => $product->guid, 'operand' => '=' )
	)); 

	if(empty($in_cart)){
		// do this if the product is NOT already in the cart
		$cart_item = new ElggObject();
		$cart_item->access_id = ACCESS_PRIVATE;
		$cart_item->subtype = "cart_item";
		$cart_item->title = 'cart item for user: '.$user-guid;
		$cart_item->quantity = $quantity;
		$cart_item->product_id = $product->guid;
		$cart_item->amount = $product->price;
		$cart_item->owner_guid = $user->guid;
		$cart_item->container_guid = $cart->guid;
		$cart_item_guid = $cart_item->save();
		if($cart_item_guid){
			$result = add_entity_relationship($cart->guid, 'cart_item', $cart_item_guid );
		}else{
			register_error(elgg_echo('cart:item:not:added'));
			forward(REFERER);
		}
	}else{
		// do this if the product is already in the cart
		$in_cart = $in_cart[0];
		$in_cart->quantity = $in_cart->quantity + $quantity;
		$result = $in_cart->save();
		//	throw an error message if unsuccessful
		if(!$result){
			register_error(elgg_echo('cart:item:not:updated'));
			forward(REFERER);
		}
	}
forward(elgg_get_config('url').'socialcommerce/'.$user->username.'/cart');
