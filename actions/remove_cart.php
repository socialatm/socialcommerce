<?php
	/**
	 * Elgg cart - remove action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
		global $CONFIG;
		if(isloggedin()){
			$guid = (int) get_input('cart_guid');
			if ($cart_item = get_entity($guid)) {
				if ($cart_item->canEdit()) {
					$container = get_entity($cart_item->container_guid);
					if (!$cart_item->delete()) {
						register_error(elgg_echo("cart:deletefailed"));
					} else {
						system_message(sprintf(elgg_echo("cart:deleted"),$cart_item->title));
					}
				} else {
					$container = $_SESSION['user'];
					register_error(elgg_echo("cart:deletefailed"));
				}
			} else {
				register_error(elgg_echo("cart:deletefailed"));
			}
			$username = $_SESSION['user']->username;
		}
		forward("pg/{$CONFIG->pluginname}/" . $username . "/cart/");
?>