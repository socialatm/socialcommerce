<?php
	/**
	 * Elgg product - edit
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	global $CONFIG;
	gatekeeper();

	// Render the product upload page
	
	$stores = (int) get_input('stores_guid');
	$stores = get_entity($stores);
	if(!isadminloggedin() && ($stores->owner_guid != $_SESSION['guid'] || $stores->container_guid != $_SESSION['guid'])){
		forward();
	}
	$title = elgg_view_title($title = elgg_echo('stores:edit'));
	if ($stores) {
		if ($stores->canEdit()) { 
    		$area2 = "<div class=\"contentWrapper\">".elgg_view("{$CONFIG->pluginname}/forms/edit",array('entity' => $stores))."</div>";
    		// These for left side menu
			$area1 .= gettags();
			$body = elgg_view_layout('two_column_left_sidebar', $area1, $title . $area2);
			page_draw(elgg_echo("stores:upload"), $body);
		}
	} else {
		forward();
	}
	
?>