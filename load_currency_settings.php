<?php
	/**
	 * Elgg currency settings
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	// Load Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		$user_guid = get_input('u_id');
		set_page_owner($user_guid);
		$todo = get_input('todo');
		switch ($todo){
			case 'currency_settings':
				$body = elgg_view("modules/currency_settings",array('ajax'=>1));
				break;
			case 'settings_form':
				$body = elgg_view("modules/currency/settings_form",array('ajax'=>1));
				break;
			case 'edit_settings':
				$c_guid = get_input('c_id');
				if($c_guid){
					$currency = get_entity($c_guid);
					$body = elgg_view("modules/currency/settings_form",array('entity'=>$currency,'ajax'=>1));
				}
				break;
		}
		echo $body;
?>