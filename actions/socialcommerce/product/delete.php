<?php
	/**
	 * Elgg product - delete product action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 

$user = elgg_get_logged_in_user_entity();

//	$product is the product we want to delete
$product_guid = get_input('product_guid');
$product = get_entity($product_guid);

// be sure user has permission to delete before continuing
if(!$product->canEdit()){
	register_error(elgg_echo("stores:deletefailed"));
	forward('socialcommerce/'.$user->username.'/all/');
}

//	get the product image
$product_image = elgg_get_entities_from_relationship(array(
	'relationship' => 'product_image',
	'relationship_guid' => $product_guid,
));
$product_image = $product_image[0];
$product_image_guid = $product_image->guid;

//	remove the relationship
remove_entity_relationship($product_guid, 'product_image', $product_image_guid);

//	delete the thumbnails first
$thumbnails = array($product_image->thumbnail, $product_image->smallthumb, $product_image->largethumb);
	foreach ($thumbnails as $thumbnail) {
		if ($thumbnail) {
			$delfile = new ElggFile();
			$delfile->owner_guid = $this->owner_guid;
			$delfile->setFilename($thumbnail);
			$delfile->delete();
		}
	}
	
//	then delete the product image
if($product_image) {
	$product_image->delete();
}

//	then delete the product
$delete = $product->delete();
						
if (!$delete) {
	register_error(elgg_echo("stores:deletefailed"));
} else {
	system_message(elgg_echo("stores:deleted"));
}

// and then forward
forward("socialcommerce/".$user->username.'/all/');
die();
