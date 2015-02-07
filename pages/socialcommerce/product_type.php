<?php
	/**
	 * Elgg product - type
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
	gatekeeper();
		 
	$product_type_id = get_input('stores_guid');
	$title = elgg_view_title(elgg_view('output/product_type',array('value' => $product_type_id,'display'=>1)));
	$search_viewtype = get_input('search_viewtype');
	$limit = $search_viewtype == 'gallery' ? 20 : 10;
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
							
		switch($tab){
			case "active":
				$content .= elgg_get_entities_from_metadata(array(
					'meta_array' => array('status'=>1,'product_type_id'=>$product_type_id),
					'type_subtype_pairs' => array('object' => 'stores'),
					'owner_guid' => 0,
					'limit' => $limit,
					));
				break;
			case "deleted":
				$content .= elgg_get_entities_from_metadata(array(
					'meta_array' => array('status'=>0,'product_type_id'=>$product_type_id),
					'type_subtype_pairs' => array('object' => 'stores'),
					'owner_guid' => 0,
					'limit' => $limit,
					));
				break;
		}
			
		if(empty($content)){ $content .= '<div>'.elgg_echo('no:data').'</div>';}
			
	}else{
		$content .= elgg_get_entities_from_metadata(array(
			'meta_array' => array('status'=>1,'product_type_id'=>$product_type_id),
			'type_subtype_pairs' => array('object' => 'stores'),
			'owner_guid' => 0,
			'limit' => $limit,
			));
	}
		
	$content = $title.'<div class="contentWrapper stores">'.$content.'</div>';
	elgg_set_context('stores');
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
	
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page($title, $body);
