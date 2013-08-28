<?php
	/**
	 * Elgg social commerce - login page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	global $CONFIG;
	// Load Elgg engine
		require_once(get_config('path').'engine/start.php');

		$last_forward_from = get_input('forward_url');
		if($last_forward_from){
			$_SESSION['last_forward_from'] = $last_forward_from;
		}
		$area2 = elgg_view("socialcommerce/login");
		
	// Create a layout
		$body = elgg_view_layout('one_column', $area2);
	
	// Finally draw the page
		page_draw(sprintf(elgg_echo("stores:your"),page_owner_entity()->name), $body);
	
?>