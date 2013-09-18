<?php
	/**
	 * Elgg category - delete action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
		global $CONFIG;
		$guid = (int) get_input('category');
		if ($category = get_entity($guid)) {
			if ($category->canEdit()) {
				$container = get_entity($category->container_guid);
				if (!$category->delete()) {
					register_error(elgg_echo("category:deletefailed"));
				} else {
					system_message(elgg_echo("category:deleted"));
				}
			} else {
				$container = $_SESSION['user'];
				register_error(elgg_echo("category:deletefailed"));
			}
		} else {
			register_error(elgg_echo("category:deletefailed"));
		}
		forward( "socialcommerce/" . $_SESSION['user']->username .'/category/');
?>
