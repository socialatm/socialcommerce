<?php
	/**
	 * Elgg category - add category page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	/***** @link	http://localhost/elgg-1.8.16/socialcommerce/rainman/edit_category/132	*****/
	/* @todo change this from admin_gatekeeper to if pageowner is entity owner they can edit exisiting category
		or check if page owner has permission to add a new category */
	
	admin_gatekeeper();
	$page_owner = elgg_get_logged_in_user_entity();
	$container_guid = elgg_get_plugin_from_id('socialcommerce')->guid;
	
	$category = get_entity($page[2]);
	$subtype = get_subtype_from_id($category->subtype) ;
	$options = $subtype === 'sc_category' ? $category : '';

	// set the title
	$ptitle = isset($category) ? 'category:edit' : 'stores:addcategory';
	$title = elgg_view_title(elgg_echo($ptitle));			

	// Get the form
	/* @todo upgrade to elgg_view_form	*/
	$content .= '<div class="contentWrapper">'.elgg_view('socialcommerce/forms/edit_category', array($options)).'</div>';
	
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
		
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);

	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo($ptitle), $body);
?>
