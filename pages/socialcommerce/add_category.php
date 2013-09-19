<?php
	/**
	 * Elgg category - add category page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	admin_gatekeeper();
	$page_owner = elgg_get_logged_in_user_entity();
	$container_guid = elgg_get_plugin_from_id('socialcommerce')->guid;
	
	//set the title
	$title = elgg_view_title(elgg_echo('stores:addcategory'));

	// Get the form
	$content .= '<div class="contentWrapper">'.elgg_view('socialcommerce/forms/edit_category').'</div>';
		
	// sidebar
	$sidebar .= gettags();
		
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);

	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo('stores:addcategory'), $body);
?>
