<?php
	/**
	 * Elgg category - view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	gatekeeper();
	$container_guid = elgg_get_plugin_from_id('socialcommerce')->guid;
	$title = elgg_view_title(elgg_echo('stores:category'));
	$user = elgg_get_logged_in_user_entity();	
	$offset = 0;
	$limit = 9999;
	elgg_set_context('search');
	$digital_cats = elgg_get_entities_from_metadata(array(
	//		'product_type_id' => 2,
			'type_subtype_pairs' => array('object' => 'sc_category'),
			'container_guid' => $container_guid,
			'limit' => $limit,
			));  	
			
	if($digital_cats){									//	@todo - forward to create a category if none exist...
		foreach($digital_cats as $digital_cat){
			$digital_area .= elgg_view_entity($digital_cat, array('full_view' => false));
			$digital_area .= '<a href = "'.elgg_get_config('url').'socialcommerce/'.$user->username.'/edit_category/'.$digital_cat->guid.'">Edit</a>';
		}
			
		$digital_area = '<div>'.$digital_area.'</div>';
	}
		
	$content = '<div class="contentWrapper stores" >'.$digital_area.'</div>';
	elgg_set_context('category');
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
	
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo('stores:category'), $body);
?>
