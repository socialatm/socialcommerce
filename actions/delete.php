<?php
	/**
	 * Elgg product - delete action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	
	$user = elgg_get_logged_in_user_entity();
	$product_guid = (int)$page[2];
	
	// be sure user has permission to delete before continuing
	if(!$product->canEdit()){
		register_error(elgg_echo("stores:deletefailed"));
		forward('socialcommerce/'.$user->username.'/all/');
	}
	
	if ($stores = get_entity($product_guid)) {
			$delete = $stores->delete();
						
			if (!$delete) {
				register_error(elgg_echo("stores:deletefailed"));
			} else {
				system_message(elgg_echo("stores:deleted"));
			}
	
	} else {
		register_error(elgg_echo("stores:deletefailed"));
	}
	forward("socialcommerce/".$user->username.'/all/');
