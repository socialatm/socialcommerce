<?php
	/**
	 * Elgg product - view wishlist
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	// Load Elgg engine
		require_once(get_config('path').'engine/start.php');
		global $CONFIG;
		gatekeeper();
		set_context('stores');
	// Get the current page's owner
		$page_owner = page_owner_entity();
		$page_owner = $_SESSION['user'];
		set_page_owner($_SESSION['guid']);
		
	
	// Set stores title
		$title = elgg_view_title(elgg_echo('stores:your:wishlist'));
	
	// Get objects
		$limit = 10;
		$offset = get_input('offset');
		if(!$offset)
			$offset = 0;
			
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
												'baseurl' => $baseurl,
												'offset' => $offset,
												'count' => $count,
												'limit' => $limit,
											));
											
		$area2 .= elgg_view("{$CONFIG->pluginname}/wishlist",array('entities'=>$entities));
		$area2 = <<<EOF
			{$title}
			<div class="contentWrapper stores">
				{$nav}
				{$area2}
				{$nav}
			</div>
EOF;
		
		// These for left side menu
			$area1 .= gettags();
		//$area1 .= get_storestype_cloud(page_owner());
	// Create a layout
		$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
		if($CONFIG->wishlist_item_count){
			$count = " (".$CONFIG->wishlist_item_count.")";
		}
	
	// Finally draw the page
		page_draw(sprintf(elgg_echo('stores:my:wishlist').$count,page_owner_entity()->name), $body);
	
?>