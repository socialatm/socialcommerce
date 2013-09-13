<?php
	/**
	 * Elgg view - short
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	$search_viewtype = get_input('search_viewtype');
	
	if($search_viewtype == "gallery"){
		echo elgg_view("socialcommerce/gallery_view", $vars );
	}else{
		echo elgg_view("socialcommerce/list_view", $vars );
	}
?>
