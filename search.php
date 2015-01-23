<?php
	/**
	 * Elgg search - view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	/*****
	$user_gallery = elgg_get_config('url').'socialcommerce/'.$_SESSION['user']->username.'/search/subtype/stores/md_type/simpletype/tag/image/owner_guid/'.$owner->guid.'search_viewtype/gallery';
	
	md_type = metadata type
	
	*****/
	
	// Get input
		$md_type = 'tags';
		$tag = get_input('tag');
		$search_viewtype = get_input('search_viewtype');

	$title = empty($tag) ? elgg_view_title(elgg_echo('stores:type:all')) : elgg_view_title(elgg_echo($tag));
		
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar = gettags();
		
	// Set context
	elgg_set_context('search');
	$limit = 10;
		
		if (elgg_is_admin_logged_in()) {
		
			$filter = get_input("filter") ? get_input("filter") : 'active' ;
			
			switch($filter){
				case "active":
					if (!empty($tag)) {
						$content = elgg_get_entities_from_metadata(array(
										'meta_array' => array('status'=>1, $md_type=>$tag),
										'type_subtype_pairs' => array('object' => 'stores'),
										'owner_guid' => 0,
										'limit' => 10,
										));
					}else{
						$content = elgg_list_entities_from_metadata(array(
													'status' => 1,
													'type_subtype_pairs' => array('object' => 'stores'),
													'owner_guid' => 0,
													'limit' => 10,
													));
					}
				break;
				case "deleted":
					if (!empty($tag)) {
						$content = elgg_get_entities_from_metadata(array(
										'meta_array' => array('status'=>0, $md_type=>$tag),
										'type_subtype_pairs' => array('object' => 'stores'),
										'owner_guid' => 0,
										'limit' => 10,
										));
					}else{
						$content = elgg_list_entities_from_metadata(array(
													'status' => 0,
													'type_subtype_pairs' => array('object' => 'stores'),
													'owner_guid' => 0,
													'limit' => 10,
													));
					}
				break;
			}
			if(empty($content)){
				$content = "<div style=\"padding:10px;\">".elgg_echo('no:data')."</div>";	
			}
			
			$content = elgg_view("socialcommerce/product_tab_view",array('base_view' => $area2, "filter" => $filter ));
		}else{
			if (!empty($tag)) {
				$content = elgg_get_entities_from_metadata(array(
										'meta_array' => array('status'=>1, $md_type=>$tag),
										'type_subtype_pairs' => array('object' => 'stores'),
										'owner_guid' => 0,
										'limit' => 10,
										));
			}else{
				$content = elgg_list_entities_from_metadata(array(
													'status' => 1,
													'type_subtype_pairs' => array('object' => 'stores'),
													'owner_guid' => 0,
													'limit' => 10,
													));
			}
		}
		$content = <<<EOF
			{$title}
			<div class="contentWrapper stores">
				{$area2}
			</div>
EOF;
		elgg_set_context("stores");
		
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);

	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page($title, $body);
?>
