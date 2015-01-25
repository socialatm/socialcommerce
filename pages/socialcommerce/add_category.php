<?php
	/**
	 * Elgg category - add category page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	/***** @link	http://localhost/elgg-1.8.16/socialcommerce/rainman/edit_category/132	*****/
	/* @todo change this from admin_gatekeeper to if pageowner is entity owner they can edit exisiting category
		or check if page owner has permission to add a new category */
	admin_gatekeeper();
	$category = get_entity($page[2]);
	$subtype = get_subtype_from_id($category->subtype) ;
	$options = $subtype === 'sc_category' ? $category : '';

	// set the title
	$title = $category == FALSE ?  'stores:addcategory':'category:edit';
	$title = elgg_view_title(elgg_echo($title));			

	// Get the form
	$content = elgg_view_form('socialcommerce/category/save', '', array($options) );
	
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
