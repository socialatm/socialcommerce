<?php
	/**
	 * Elgg product - individual view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
	$context = elgg_get_context();
	
	switch ($context) {
    case "search":
        echo elgg_view("socialcommerce/short_view", $vars );
        break;
    case "cartadd":
        echo elgg_view("socialcommerce/cart_mainview", $vars );
        break;
    default:
       echo elgg_view("socialcommerce/mainview", $vars );
	}
