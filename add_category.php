<?php
	/**
	 * Elgg category - add entry page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	// Load Elgg engine
		require_once(get_config('path').'engine/start.php');
		admin_gatekeeper();
		global $CONFIG;
		
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}
		$container_guid = page_owner();
	//set the title
		$area2 = elgg_view_title(elgg_echo('stores:addcate'));

	// Get the form
		$area2 .= "<div class=\"contentWrapper\">".elgg_view("socialcommerce/forms/edit_category")."</div>";
		
	// These for left side menu
		$area1 .= gettags();
		
	// Get the body
		$body = elgg_view_layout("two_column_left_sidebar", $area1, $area2);	
			
	// Display page
		page_draw(elgg_echo('stores:addcate'),$body);
?>
