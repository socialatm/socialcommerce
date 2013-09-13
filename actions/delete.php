<?php
	/**
	 * Elgg product - delete action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	$guid = (int) get_input('stores');
	if ($stores = get_entity($guid)) {

		if ($stores->canEdit()) {
			$stores->status = 0;
			$context = get_context();
			set_context('delete_product');
			$delete = $stores->save();
			set_context($context);
						
			if (!$delete) {
				register_error(elgg_echo("stores:deletefailed"));
			} else {
				system_message(elgg_echo("stores:deleted"));
			}
		} else {
			$container = $_SESSION['user'];
			register_error(elgg_echo("stores:deletefailed"));
		}
	} else {
		register_error(elgg_echo("stores:deletefailed"));
	}
	forward("pg/socialcommerce/" . $_SESSION['user']->username);
exit();
?>
