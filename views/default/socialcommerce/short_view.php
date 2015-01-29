<?php
	/**
	 * Elgg view - short
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
	$search_viewtype = get_input('search_viewtype');
	
	if($search_viewtype == "gallery"){
		echo elgg_view("socialcommerce/gallery_view", $vars );
	}else{
		echo elgg_view("socialcommerce/list_view", $vars );
	}
