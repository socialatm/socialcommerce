<?php
	/**
	 * Elgg product - type
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	echo __FILE__ .' at '.__LINE__; die();
	gatekeeper();
	$page_owner = elgg_get_logged_in_user_entity();
	 
	global $CONFIG;
	require_once(get_config('path').'engine/start.php');

	$product_type_id = get_input('stores_guid');
	$title = elgg_view_title(elgg_view('output/product_type',array('value' => $product_type_id,'display'=>1)));
	$search_viewtype = get_input('search_viewtype');
	$limit = $search_viewtype == 'gallery' ? 20 : 10;
	
	// Get objects
		elgg_set_context('search');
		if (elgg_is_admin_logged_in()) {
			$filter = get_input("filter") ? get_input("filter") : 'active' ;
							
			switch($filter){
				case "active":
					$content = elgg_get_entities_from_metadata(array(
									'meta_array' => array('status'=>1,'product_type_id'=>$product_type_id),
									'entity_type' => 'object',
									'entity_subtype' => 'stores',
									'owner_guid' => 0,
									'limit' => $limit,
									));
				break;
				case "deleted":
					$content = elgg_get_entities_from_metadata(array(
									'meta_array' => array('status'=>0,'product_type_id'=>$product_type_id),
									'entity_type' => 'object',
									'entity_subtype' => 'stores',
									'owner_guid' => 0,
									'limit' => $limit,
									));
				break;
			}
			
	if(empty($content)){ $content = '<div style="padding:10px;">'.elgg_echo('no:data').'</div>';}
			
			$content = elgg_view("socialcommerce/product_tab_view", array('base_view' => $content, "filter" => $filter));
		}else{
			$content .= elgg_get_entities_from_metadata(array(
									'meta_array' => array('status'=>1,'product_type_id'=>$product_type_id),
									'entity_type' => 'object',
									'entity_subtype' => 'stores',
									'owner_guid' => 0,
									'limit' => $limit,
									));
		}
		
	$content = $title.'<div class="contentWrapper stores">'.$content.'</div>';
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
