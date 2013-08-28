<?php
	/**
	 * Elgg social commerce - index page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	// Load Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}

	//set stores title
		if($page_owner == $_SESSION['user']){
			$title = elgg_view_title(elgg_echo('stores:your'));
		}else{
			$title = elgg_view_title($page_owner->username . "'s " . elgg_echo('products'));
		}
		
	// Get objects
		set_context('search');
		
		$search_viewtype = get_input('search_viewtype');
		if($search_viewtype == 'gallery'){
			$limit = 20;
		}else{
			$limit = 10;
		}
		$view = get_input('view');
		$filter = get_input("filter");
		if(!$filter)
			$filter = "active";
		switch($filter){
			case "active":
				$area2 = list_entities_from_metadata('status',1,"object","stores",page_owner(),$limit);
			break;
			case "deleted":
				$area2 = list_entities_from_metadata('status',0,"object","stores",page_owner(),$limit);
			break;
		}
		if(empty($area2)){
			$area2 = "<div style=\"padding:10px;\">".elgg_echo('no:data')."</div>";	
		}
		if($view != 'rss'){
		$area2 = elgg_view("{$CONFIG->pluginname}/product_tab_view",array('base_view' => $area2, "filter" => $filter));
		$area2 = <<<EOF
			{$title}
			<div class="contentWrapper stores">
				{$area2}
			</div>
EOF;
		}
		set_context('stores');
	// These for left side menu
		$area1 .= gettags();
		//$area1 .= get_storestype_cloud(page_owner());
	// Create a layout
		$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
	
	// Finally draw the page
		page_draw(sprintf(elgg_echo("stores:your"),page_owner_entity()->name), $body);
	
?>