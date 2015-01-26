<?php
	/**
	 * Elgg currency settings
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
		$user_guid = get_input('u_id');
		elgg_set_page_owner_guid($user_guid);
		$todo = get_input('todo');
		switch ($todo){
			case 'currency_settings':
				$body = elgg_view("modules/currency_settings", array('ajax'=>1));
				break;
			case 'settings_form':
				$body = elgg_view("modules/currency/settings_form", array('ajax'=>1));
				break;
			case 'edit_settings':
				$c_guid = get_input('c_id');
				if($c_guid){
					$currency = get_entity($c_guid);
					$body = elgg_view("modules/currency/settings_form", array('entity' => $currency, 'ajax' => 1 ));
				}
				break;
		}
		echo $body;
