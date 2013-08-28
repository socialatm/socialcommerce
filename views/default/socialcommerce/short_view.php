<?php
	/**
	 * Elgg view - short
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	
	$search_viewtype = get_input('search_viewtype');
	
	if($search_viewtype == "gallery"){
		echo elgg_view("{$CONFIG->pluginname}/gallery_view",$vars);
	}else{
		echo elgg_view("{$CONFIG->pluginname}/list_view",$vars);
	}
?>