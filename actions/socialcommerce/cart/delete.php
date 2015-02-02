<?php
	/**
	 * Elgg cart - remove item from cart action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 

$user = elgg_get_logged_in_user_entity();

//	$guid is the product we want to delete
$guid = get_input('product_guid');

// Get the users shopping cart
$cart = elgg_get_entities(array(
	'type' => 'object',
	'subtype' => 'cart',
	'owner_guid' => $user->guid,
	'limit' => 1
));
$cart = $cart[0];
	
//	get the product if it's in the cart
$cart_item = elgg_get_entities_from_metadata(array(
	'container_guid' => $cart->guid,
	'metadata_name_value_pairs' => array( 'name' => 'product_id', 'value' => $guid, 'operand' => '=' )
));
$cart_item = $cart_item[0];

// remove the product relationship to the cart
remove_entity_relationship($cart->guid, 'cart_item', $cart_item->guid );

// delete the item from the cart
if (!$cart_item->delete()) {
	register_error(elgg_echo('cart:item:not:deleted'));
} else {
	system_message(elgg_echo('cart:deleted'));
}
forward('socialcommerce/'.$user->username.'/cart');
