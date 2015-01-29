<?php
	/**
	 * Elgg product - view wishlist
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	gatekeeper();
	elgg_set_context('stores');
	// Get the current page's owner
	$page_owner = elgg_get_page_owner_entity();
	$page_owner = $_SESSION['user'];
	elgg_set_page_owner_guid($_SESSION['guid']);
		
	// Get objects
	$limit = 10;
	$offset = get_input('offset') ? get_input('offset') : 0 ;
					
		$count = elgg_get_entities_from_relationship(array(
			'relationship' => 'wishlist',
			'relationship_guid' => $_SESSION['user']->guid, 
			'limit' => $limit,
			'offset' => $offset,
			'count' => true, 
			));  		
			
		$entities = elgg_get_entities_from_relationship(array(
			'relationship' => 'wishlist',
			'relationship_guid' => $_SESSION['user']->guid, 
			'limit' => $limit,
			'offset' => $offset,
			));  	
			
		$nav .= elgg_view('navigation/pagination',array(
												'baseurl' => $baseurl,	//	@todo - I don't see $baseurl defined here?
												'offset' => $offset,
												'count' => $count,
												'limit' => $limit,
											));
											
		$content .= elgg_view( 'socialcommerce/wishlist', array('entities'=>$entities));
		$content = <<<EOF
			<div class="contentWrapper stores">
				{$nav}
				{$content}
				{$nav}
			</div>
EOF;
	$sidebar .= elgg_view("socialcommerce/sidebar");	
	$sidebar .= gettags();
		
	if(elgg_get_config('wishlist_item_count')){
		$count = elgg_get_config('wishlist_item_count');
	}
	
	$title = sprintf(elgg_echo('stores:my:wishlist'), $count);

	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);

	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page($title, $body);
