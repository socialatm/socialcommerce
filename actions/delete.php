<?php
	/**
	 * Elgg product - delete action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	$pageowner_guid = elgg_get_page_owner_guid();
	$product_guid = (int)$page[2];
	
	// be sure user has permission to delete before continuing
	if(!can_edit_entity( $product_guid, $pageowner_guid )){
		register_error(elgg_echo("stores:deletefailed"));
		forward('socialcommerce/'.$_SESSION['user']->username.'/all/');
	}
	
	if ($stores = get_entity($product_guid)) {
			$delete = delete_entity($product_guid);
						
			if (!$delete) {
				register_error(elgg_echo("stores:deletefailed"));
			} else {
				system_message(elgg_echo("stores:deleted"));
			}
	
	} else {
		register_error(elgg_echo("stores:deletefailed"));
	}
	forward("socialcommerce/".$_SESSION['user']->username.'/all/');
?>
