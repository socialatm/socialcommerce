<?php
	/**
	 * Elgg product - view all
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	// Load Elgg engine
		require_once(get_config('path').'engine/start.php');
		
	// Get the current page's owner
		$page_owner = elgg_get_page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			elgg_set_page_owner_guid($_SESSION['guid']);
		}

	//set stores title
		$title = elgg_view_title(elgg_echo('stores:all:products'));
		
	// Get objects
		elgg_set_context('search');
		
		$search_viewtype = get_input('search_viewtype');
		if($search_viewtype == 'gallery'){
			$limit = 20;
		}else{
			$limit = 10;
		}
		$view = get_input('view');
		if (elgg_is_admin_logged_in()) {
			$filter = get_input("filter");
			if(!$filter)
				$filter = "active";
			switch($filter){
				case "active":	$area2 = elgg_list_entities_from_metadata(array(
													'status' => 1'
													'entity_type' => 'object',
													'entity_subtype' => 'stores',
													'owner_guid' => 0,
													'limit' => $limit,
													));
								break;
				case "deleted":	$area2 = elgg_list_entities_from_metadata(array(
													'status' => 0'
													'entity_type' => 'object',
													'entity_subtype' => 'stores',
													'owner_guid' => 0,
													'limit' => $limit,
													));
								break;
			}
			if(empty($area2)){
				$area2 = elgg_echo('product:null');
			}
			if(empty($area2)){
				$area2 = "<div style=\"padding:10px;\">".elgg_echo('no:data')."</div>";	
			}
			if($view != 'rss'){
				$area2 = elgg_view("socialcommerce/product_tab_view",array('base_view' => $area2, "filter" => $filter));
			}
		}else{
			$area2 = list_entities_from_metadata('status',1,"object","stores",0,$limit);
			if(empty($area2)){
				$area2 = elgg_echo('product:null');
			}
		}
		if($view != 'rss'){
			$area2 = <<<EOF
				{$title}
				<div class="contentWrapper stores">
					{$area2}
				</div>
EOF;
		}
		elgg_set_context('stores');
	// These for left side menu
		$area1 .= gettags();
		
	// Create a layout
		$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
	
	// Finally draw the page
		page_draw(sprintf(elgg_echo("stores:all:products"), elgg_get_page_owner_entity()->name), $body);
?>
