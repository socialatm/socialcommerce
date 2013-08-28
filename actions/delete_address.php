<?php
	/**
	 * Elgg address - delete action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
 	global $CONFIG;
	$guid = (int) get_input('a_id');
	$user_guid = (int) get_input('u_guid');
	$ajax = get_input('ajax');
	if ($address = get_entity($guid)) {
		if ($address->canEdit()) {
			if (!$address->delete()) {
				if(!$ajax){
					register_error(elgg_echo("address:deletefailed"));
				}else{
					echo elgg_echo("address:deletefailed");
				}
			} else {
				if(!$ajax){
					system_message(elgg_echo("address:deleted"));
				}else{
					echo 1;
				}
			}
		} else {
			$container = $_SESSION['user'];
			if(!$ajax){
				register_error(elgg_echo("address:deletefailed"));
			}else{
				echo elgg_echo("address:deletefailed");
			}
		}
	} else {
		if(!$ajax){
			register_error(elgg_echo("address:deletefailed"));
		}else{
			echo elgg_echo("address:deletefailed");
		}
	}
	if(!$ajax){
		forward("pg/{$CONFIG->pluginname}/" . $_SESSION['user']->username . "/category/");
	}

?>