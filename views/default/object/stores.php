<?php
	/**
	 * Elgg product - individual view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	
	if (elgg_get_context() == "search") { 	// Start search listing version @todo - switch statement here maybe?
		echo elgg_view("socialcommerce/short_view", $vars );
	}elseif (elgg_get_context() == "cartadd") {
		echo elgg_view("socialcommerce/cart_mainview", $vars );
	}else {
		echo elgg_view("socialcommerce/mainview", $vars );
	}
?>
