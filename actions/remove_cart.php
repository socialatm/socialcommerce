<?php
	/**
	 * Elgg cart - remove action
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
	$cart_item_guid = (int) get_input('cart_guid');
			
	// @todo - below still needs work			
	if ($cart_item = get_entity($cart_item_guid)) {
		if ($cart_item->canEdit()) {
			if (!$cart_item->delete()) {
				register_error(elgg_echo("cart:deletefailed"));
			} else {
				system_message(sprintf(elgg_echo("cart:deleted"), $cart_item->title));
				forward(REFERER);
			}
		} else {
			register_error(elgg_echo("cart:deletefailed"));
		}
	} else {
		register_error(elgg_echo("cart:deletefailed"));
	}
forward(REFERER);
