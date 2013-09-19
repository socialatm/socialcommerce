<?php
	/**
	 * Elgg add product entry page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	gatekeeper();
	$page_owner = elgg_get_logged_in_user_entity();
	
	$container_guid = elgg_get_page_owner_guid();	//	@todo - maybe change this
	
	//set the title
	$title = elgg_view_title(elgg_echo('stores:addpost'));
	// Get the form
	$content = '<div class="contentWrapper">'.elgg_view("socialcommerce/forms/edit").'</div>';	//	@todo - elgg_get_form ??
	// These for left side menu
	$sidebar .= gettags();
			
	$params = array(
	'title' => $title,
	'content' => $content,
	'sidebar' => $sidebar,
	);

	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo('stores:addpost'), $body);
?>
