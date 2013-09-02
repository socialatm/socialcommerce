<?php
	/**
	 * Elgg product - edit
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	gatekeeper();

	$stores = get_entity((int)$page[2]);
	
	if(!isadminloggedin() && ($stores->owner_guid != $_SESSION['guid'] || $stores->container_guid != $_SESSION['guid'])){
		forward();
	}
	$title = elgg_view_title($title = elgg_echo('stores:edit'));
	if ($stores) {
		if ($stores->canEdit()) { 
  			$area2 = '<div class="contentWrapper">'.elgg_view('socialcommerce/forms/edit',array('entity' => $stores)).'</div>';
			$body = elgg_view_layout('two_column_left_sidebar', '', $title . $area2);
			page_draw(elgg_echo("stores:upload"), $body);
			exit;
		}
	} else {
		forward();	//	@todo - maybe throw an error message here ??
	}
?>