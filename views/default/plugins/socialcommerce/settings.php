<?php
	/**
	 * Elgg socialcommerce - settings page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$socialcommerce = elgg_get_plugin_from_id('socialcommerce');
	$tab = get_input('tab') ? get_input('tab') : 'general';

	$vars = array(
        'tabs' => array(
                  array('title' => elgg_echo('general:settings:tab'), 'url' => "$url" . '?tab=general', 'selected' => ($tab == 'general')),
                  array('title' => elgg_echo('payment:methods:tab'), 'url' => "$url" . '?tab=payment', 'selected' => ($tab == 'payment')),
				  array('title' => elgg_echo('shipping:methods:tab'), 'url' => "$url" . '?tab=shipping', 'selected' => ($tab == 'shipping')),
                  array('title' => elgg_echo('currency:tab'), 'url' => "$url" . '?tab=currency', 'selected' => ($tab == 'currency')),
        )
	);

	echo elgg_view('navigation/tabs', $vars);

	switch($tab) {
		case 'general':		echo elgg_view("modules/general_settings");
							break;
		case 'payment':		echo elgg_view("modules/checkout_methods");
							break;
		case 'shipping':	echo elgg_view("modules/shipping_methods");
							break;
		case 'currency':	echo elgg_view("modules/currency_settings");
							break;
		default:			echo elgg_view("modules/general_settings");
							break;
	}
?>
