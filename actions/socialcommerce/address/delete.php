<?php
	/**
	 * Elgg address - delete action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
	$user = elgg_get_logged_in_user_entity();
	$address_guid = get_input('address_guid');
	 
 	if ($address = get_entity($address_guid)) {
		if ($address->canEdit()) {
			if (!$address->delete()) {
				register_error(elgg_echo("address:deletefailed"));
			}else{
				system_message(elgg_echo("address:deleted"));
			}
		}else{
			register_error(elgg_echo("address:deletefailed"));
		}
	}else{
		register_error(elgg_echo("address:deletefailed"));
	}
forward('socialcommerce/'.$user->username.'/address/');
