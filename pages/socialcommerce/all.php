<?php
	/**
	 * Elgg product - view all
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$page_owner = elgg_get_logged_in_user_entity();
	$title = elgg_view_title(elgg_echo('stores:all:products'));
		
	elgg_set_context('search');
		
	$search_viewtype = get_input('search_viewtype');
	$limit = ($search_viewtype == 'gallery') ? 20 : 10;
	$view = get_input('view');
	
		if (elgg_is_admin_logged_in()) {
		
			$filter = get_input("filter") ? get_input("filter") : 'active';
			switch($filter){
				case "active":	$content = elgg_list_entities_from_metadata(array(
													'status' => 1,
													'type_subtype_pairs' => array('object' => 'stores'),
													'limit' => $limit,
													));
								break;
				case "deleted":	$content = elgg_list_entities_from_metadata(array(
													'status' => 0,
													'type_subtype_pairs' => array('object' => 'stores'),
													'limit' => $limit,
													));
								break;
			}
			
			
			if(empty($content)){ $content = '<div>'.elgg_echo('product:null').'</div>';	}
			
			if($view != 'rss'){
				$content = elgg_view("socialcommerce/product_tab_view",array('base_view' => $content, "filter" => $filter));
			}
		}else{
			$content = elgg_list_entities_from_metadata(array(
								'status' => 1,
								'type_subtype_pairs' => array('object' => 'stores'),
								'limit' => $limit,
								));	

			if(empty($content)){ $content = elgg_echo('product:null');}
		}
		if($view != 'rss'){
			$content = '<div class="contentWrapper stores">'.$content.'</div>';
		}
	
	elgg_set_context('stores');
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
		
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo('stores:all:products'), $body);
?>
