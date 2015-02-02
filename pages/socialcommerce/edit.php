<?php
	/**
	 * Elgg product - product edit page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	/*	test if user can edit entity and exit if not	*/
	
	$stores = get_entity((int)$page[2]);
	$stores_guid = $stores->guid;
	$page_owner = elgg_get_logged_in_user_entity();
	$page_owner_guid = $page_owner->guid;
	
	if( !$stores->canEdit() ) {
		register_error(elgg_echo("product:edit:fail"));
		forward(REFERER);
	}
	
	$title = elgg_view_title(elgg_echo('stores:edit'));
	if ($stores) {
 		$content = '<div class="contentWrapper">'.elgg_view('socialcommerce/forms/edit', array('entity' => $stores)).'</div>';
		$sidebar .= elgg_view("socialcommerce/sidebar");
		$params = array(
			'title' => $title,
			'content' => $content,
			'sidebar' => $sidebar,
			);
		$body = elgg_view_layout('one_sidebar', $params);
		echo elgg_view_page(elgg_echo('stores:edit'), $body);
		exit;
	}
