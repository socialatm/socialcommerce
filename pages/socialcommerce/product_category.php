<?php
	/**
	 * Elgg category - product category
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	gatekeeper();
	$page_owner = elgg_get_logged_in_user_entity();
	$product_category = get_input('stores_guid');
	$search_viewtype = get_input('search_viewtype');
	$limit = $search_viewtype == 'gallery' ? 20 : 10 ;
	
	$title = elgg_view_title(elgg_view('output/category', array('value' => $product_category, 'display'=>1 )));
	
	elgg_set_context('search');
		if (elgg_is_admin_logged_in()) {
			$filter = get_input("filter")? get_input("filter") : "active" ;
			switch ($filter){
				case "deleted":
					$options = array(
					'metadata_name_value_pairs' => array(
						array('name' => 'status', 'operand' => '=', 'value' => 0 ),
						array('name' => 'category', 'operand' => '=', 'value' => $product_category)
					),
					'metadata_name_value_pairs_operator' => 'AND',
					'type_subtype_pairs' => array('object' => 'stores'),
					);
	
					$content = elgg_list_entities_from_metadata($options);
				break;
				default:
					$options = array(
					'metadata_name_value_pairs' => array(
						array('name' => 'status', 'operand' => '=', 'value' => 1 ),
						array('name' => 'category', 'operand' => '=', 'value' => $product_category)
						),
					'metadata_name_value_pairs_operator' => 'AND',
					'type_subtype_pairs' => array('object' => 'stores'),
					);
	
					$content = elgg_list_entities_from_metadata($options);
					$filter = "active";
			}

			if(empty($content)){
				$content = '<div>'.elgg_echo('no:data').'</div>';	
			}
			
			$content = elgg_view("socialcommerce/product_tab_view",array('base_view' => $content, "filter" => $filter));
		}else{
			
			$options = array(
			'metadata_name_value_pairs' => array(
				array('name' => 'status', 'operand' => '=', 'value' => 1 ),
				array('name' => 'category', 'operand' => '=', 'value' => $product_category)
				),
			'metadata_name_value_pairs_operator' => 'AND',
			'type_subtype_pairs' => array('object' => 'stores'),
			);
	
	$content = elgg_list_entities_from_metadata($options);

			if(empty($content)){
				$content = '<div style="padding:10px;">'.elgg_echo('no:data').'</div>';	
			}
		}
		
	$content = '<div class="contentWrapper stores">'.$content.'</div>';
	elgg_set_context('stores');
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();

	/***** maybe
		$title = sprintf(elgg_echo("stores:your"), elgg_get_page_owner_entity()->name);
	*****/
		
	$params = array(
	'title' => $title,
	'content' => $content,
	'sidebar' => $sidebar,
	);

	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_view('output/category', array('value' => $product_category, 'display'=>1 )), $body);
?>
