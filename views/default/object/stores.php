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
	
	if (get_context() == "search") { 	// Start search listing version 
		echo elgg_view("{$CONFIG->pluginname}/short_view",$vars);
	}elseif (get_context() == "cartadd") {
		echo elgg_view("{$CONFIG->pluginname}/cart_mainview",$vars);
	}else {
		echo elgg_view("{$CONFIG->pluginname}/mainview",$vars);
		
	}
?>
