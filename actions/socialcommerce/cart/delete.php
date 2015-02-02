<?php
/**
* Elgg file delete
* 
* @package ElggFile
*/

echo '<b>'.__FILE__ .' at '.__LINE__; die();

require_once('C:/Program Files (x86)/Zend/Apache2/htdocs/krumo/class.krumo.php');

$user = elgg_get_logged_in_user_entity();

//	$guid is the product we want to delete
$guid = (int)$page[2];

//	get the product image
$product_image = elgg_get_entities_from_relationship(array(
	'relationship' => 'product_image',
	'relationship_guid' => $guid,
));
$product_image_guid = $product_image[0]->guid;

//	remove the relationship
// remove_entity_relationship($guid, 'product_image', $product_image_guid);

// @todo - also need to remove the product from any carts or wishlists
// remove_entity_relationship($user->guid, 'wishlist', $guid );

// Get the users shopping cart
	$cart = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'cart',
		'owner_guid' => $user->guid,
		'limit' => 1
	));
	$cart = $cart[0];
	
//	get all the items that are in the cart
	$cart_items = elgg_get_entities_from_relationship(array(
		'relationship' => 'cart_item',
		'relationship_guid' => $cart->guid,
	));
	
foreach($cart_items as $cart_item){
	if($cart_item->product_id == guid) {
		//	remove the item form the cart and delete it
		remove_entity_relationship($cart->guid, 'cart_item', $cart_item->guid );
		$result = $cart_item->delete();
//		krumo($cart_item->product_id);
	}
}

$remove = array($guid); 

// if there is a product image add it to the array to be removed
if($product_image_guid){
	$remove[] = $product_image_guid;
}	

$arr2 = get_defined_vars();
krumo($arr2);
krumo($user->username);
die();


$file = new FilePluginFile($guid);
if (!$file->guid) {
	register_error(elgg_echo("file:deletefailed"));
	forward(REFERER);
}

if (!$file->canEdit()) {
	register_error(elgg_echo("file:deletefailed"));
	forward(REFERER);
}

if (!$file->delete()) {
	register_error(elgg_echo("file:deletefailed"));
	forward(REFERER);
} else {
	system_message(elgg_echo("file:deleted"));
}
forward('socialcommerce/'.$user->username.'/all');
