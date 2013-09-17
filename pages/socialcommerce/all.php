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

	$title = elgg_view_title(elgg_echo('stores:all:products'));
		
	// Get objects
	elgg_set_context('search');
		
	$search_viewtype = get_input('search_viewtype');
	$limit = $search_viewtype == 'gallery' ? 20 : 10;
	$view = get_input('view');
	
		if (elgg_is_admin_logged_in()) {
		
			$filter = get_input("filter") ? get_input("filter") : 'active';
			switch($filter){
				case "active":	$content = elgg_list_entities_from_metadata(array(
													'status' => 1,
													'entity_type' => 'object',
													'entity_subtype' => 'stores',
													'owner_guid' => 0,
													'limit' => $limit,
													));
								break;
				case "deleted":	$content = elgg_list_entities_from_metadata(array(
													'status' => 0,
													'entity_type' => 'object',
													'entity_subtype' => 'stores',
													'owner_guid' => 0,
													'limit' => $limit,
													));
								break;
			}
			if(empty($content)){
				$content = elgg_echo('product:null');
			}
			if(empty($content)){
				$content = "<div style=\"padding:10px;\">".elgg_echo('no:data')."</div>";	
			}
			if($view != 'rss'){
				$content = elgg_view("socialcommerce/product_tab_view",array('base_view' => $content, "filter" => $filter));
			}
		}else{
			$content = elgg_list_entities_from_metadata(array(
								'status' => 1,
								'entity_type' => 'object',
								'entity_subtype' => 'stores',
								'owner_guid' => 0,
								'limit' => $limit,
								));
			if(empty($content)){
				$content = elgg_echo('product:null');
			}
		}
		if($view != 'rss'){
			$content = <<<EOF
				{$title}
				<div class="contentWrapper stores">
					{$content}
				</div>
EOF;
		}
	
	elgg_set_context('stores');
	$sidebar .= gettags();
		
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page($title, $body);
?>
