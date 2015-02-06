<?php
	/**
	 * Elgg product - view all
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
	$title = elgg_view_title(elgg_echo('stores:all:products'));
	elgg_set_context('search');
	$search_viewtype = get_input('search_viewtype');
	$limit = ($search_viewtype == 'gallery') ? 20 : 10;
	$view = get_input('view');
	
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
				$content .= elgg_list_entities_from_metadata(array(
					'status' => 1,
					'type_subtype_pairs' => array('object' => 'stores'),
					'limit' => $limit
					));
				break;
			case "deleted":	
				$content .= elgg_list_entities_from_metadata(array(
					'status' => 0,
					'type_subtype_pairs' => array('object' => 'stores'),
					'limit' => $limit
					));
				break;
			}
		
		if(empty($content)){ $content .= '<div>'.elgg_echo('product:null').'</div>';	}
	}else{
		$content = elgg_list_entities_from_metadata(array(
			'status' => 1,
			'type_subtype_pairs' => array('object' => 'stores'),
			'limit' => $limit,
			));	

		if(empty($content)){ $content = elgg_echo('product:null');}
	}
		
	$content = '<div class="contentWrapper stores">'.$content.'</div>';
	elgg_set_context('stores');
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
		
	$params = array(
		'title' => $title,
		'content' => $content.$content2,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo('stores:all:products'), $body);
	