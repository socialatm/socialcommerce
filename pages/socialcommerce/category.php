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
	 
	 global $CONFIG;
	// Load Elgg engine
		require_once(get_config('path').'engine/start.php');

		if(!elgg_is_logged_in()){
			forward("socialcommerce/" . $_SESSION['user']->username);
		}
	// Get the current page's owner
		$page_owner = elgg_get_page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			elgg_set_page_owner_guid($_SESSION['guid']);
		}

	//set Category title
	$title = elgg_view_title(elgg_echo('stores:category'));
		
	// Get objects
		$offset = 0;
		$limit = 9999;
		$fullview = false;
		elgg_set_context('search');
		$digital_cats = elgg_get_entities_from_metadata(array(
			'product_type_id' => 2,
			'entity_type' =>'object',
			'entity_subtype' => 'category',
			'owner_guid' => 0,
			'limit' => $limit,
			));  	
			
		if($digital_cats){									//	@todo - forward to create a category if none exist...
			foreach($digital_cats as $digital_cat){
				$digital_area .= elgg_view_entity($digital_cat, $fullview);
			}
			$digital_category_text = elgg_echo('stores:digital');
			
			$digital_area = '<div style="width:330px;display:block;"><div style="margin:10px 0;"><b>'.$digital_category_text.'</b></div>'.$digital_area.'</div>';
		}
		
	$content = $title.'<div class="contentWrapper stores" align="left">'.$digital_area.'</div>';
	elgg_set_context('category');
	$sidebar .= gettags();
	
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page($title, $body);
?>
