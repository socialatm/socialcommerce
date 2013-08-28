<?php
	/**
	 * Elgg category - edit page
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
	
	if(!isadminloggedin()){
		forward("pg/{$CONFIG->pluginname}/" . $_SESSION['user']->username);
	}
	// Render the category upload page
	
	$category = (int) get_input('category_guid');
	$title = elgg_view_title($title = elgg_echo('category:edit'));
	if ($category = get_entity($category)) {
		if ($category->canEdit()) { 
    		$area2 = "<div class=\"contentWrapper\">".elgg_view("{$CONFIG->pluginname}/forms/edit_category",array('entity' => $category))."</div>";
    		// These for left side menu
			$area1 .= gettags();
			$body = elgg_view_layout('two_column_left_sidebar', $area1, $title . $area2);
			page_draw(elgg_echo("category:edit"), $body);
		}
	} else {
		forward();
	}
	
?>