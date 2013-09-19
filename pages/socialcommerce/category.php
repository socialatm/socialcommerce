<?php
	/**
	 * Elgg category - view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	gatekeeper();
	$page_user = elgg_get_logged_in_user_entity();
	$container_guid = elgg_get_plugin_from_id('socialcommerce')->guid;
	$title = elgg_view_title(elgg_echo('stores:category'));
		
	$offset = 0;
	$limit = 9999;
	$fullview = false;
	elgg_set_context('search');
	$digital_cats = elgg_get_entities_from_metadata(array(
			'product_type_id' => 2,
			'entity_type' =>'object',
			'entity_subtype' => 'sc_category',
			'container_guid' => $container_guid,
			'limit' => $limit,
			));  	

	if($digital_cats){									//	@todo - forward to create a category if none exist...
		foreach($digital_cats as $digital_cat){
			$digital_area .= elgg_view_entity($digital_cat, $fullview);
		}
		$digital_category_text = elgg_echo('stores:digital');
		$digital_area = '<div style="width:330px;display:block;"><div style="margin:10px 0;"><b>'.$digital_category_text.'</b></div>'.$digital_area.'</div>';
	}
		
	$content = '<div class="contentWrapper stores" align="left">'.$digital_area.'</div>';
	elgg_set_context('category');
	$sidebar .= gettags();
	
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo('stores:category'), $body);
?>
