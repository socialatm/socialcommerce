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
	 
	gatekeeper();

	require_once(get_config('path').'engine/start.php');
	global $CONFIG;
		
	// Render the category upload page
	
	$address = (int) get_input('address_guid');
	$title = elgg_view_title($title = elgg_echo('address:edit'));
	
	if ($address = get_entity($address)) {
		if ($address->canEdit()) { 
    		$content = $title.'<div class="contentWrapper">'.elgg_view("socialcommerce/forms/edit_address", array('entity' => $address)).'</div>';
    		$sidebar .= gettags();
			
			$params = array(
				'title' => $title,
				'content' => $content,
				'sidebar' => $sidebar,
				);
			$body = elgg_view_layout('one_sidebar', $params);
			echo elgg_view_page(elgg_echo("category:edit"), $body);
		}
	} else {
		forward();
	}
?>
