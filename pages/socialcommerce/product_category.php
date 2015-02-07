<?php
	/**
	 * Elgg category - product category
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	
	gatekeeper();
	$page_owner = elgg_get_logged_in_user_entity();
	$product_category = get_input('stores_guid');
	$search_viewtype = get_input('search_viewtype');
	$limit = $search_viewtype == 'gallery' ? 20 : 10 ;
	$title = elgg_view_title(elgg_view('output/category', array('value' => $product_category, 'display'=>1 )));
	elgg_set_context('search');
	
	if (elgg_is_admin_logged_in()) {
		$tab = get_input('tab') ? get_input('tab') : 'active';
		$vars = array(
			'tabs' => array(
				array('title' => elgg_echo('active:products'), 'url' => "$url" . '?tab=active', 'selected' => ($tab == 'active')),
				array('title' => elgg_echo('deleted:products'), 'url' => "$url" . '?tab=deleted', 'selected' => ($tab == 'deleted')),
			)
		);
		$content = elgg_view('navigation/tabs', $vars);
			
			switch ($tab){
				case "active":
					$options = array(
						'metadata_name_value_pairs' => array(
							array('name' => 'status', 'operand' => '=', 'value' => 1 ),
							array('name' => 'category', 'operand' => '=', 'value' => $product_category)
							),
						'metadata_name_value_pairs_operator' => 'AND',
						'type_subtype_pairs' => array('object' => 'stores'),
						);
					$content .= elgg_list_entities_from_metadata($options);
					break;
				case "deleted":
					$options = array(
					'metadata_name_value_pairs' => array(
						array('name' => 'status', 'operand' => '=', 'value' => 0 ),
						array('name' => 'category', 'operand' => '=', 'value' => $product_category)
					),
					'metadata_name_value_pairs_operator' => 'AND',
					'type_subtype_pairs' => array('object' => 'stores'),
					);
					$content .= elgg_list_entities_from_metadata($options);
					break;
				default:
					$content .= '<div>'.elgg_echo('no:data').'</div>';
			}
			if(empty($content)){ $content .= '<div>'.elgg_echo('no:data').'</div>';	}
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

		if(empty($content)){ $content .= '<div>'.elgg_echo('no:data').'</div>'; }
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
