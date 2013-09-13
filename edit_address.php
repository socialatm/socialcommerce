<?php
	/**
	 * Elgg address - edit
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	require_once(get_config('path').'engine/start.php');
	global $CONFIG;
	gatekeeper();
	
	// Render the category upload page
	
	$address = (int) get_input('address_guid');
	$title = elgg_view_title($title = elgg_echo('address:edit'));
	if ($address = get_entity($address)) {
		if ($address->canEdit()) { 
    		$area2 = "<div class=\"contentWrapper\">".elgg_view("socialcommerce/forms/edit_address",array('entity' => $address))."</div>";
    		// These for left side menu
			$area1 .= gettags();
			$body = elgg_view_layout('two_column_left_sidebar', $area1, $title . $area2);
			page_draw(elgg_echo("category:edit"), $body);
		}
	} else {
		forward();
	}
?>
