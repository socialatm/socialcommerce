<?php
	/**
	 * Elgg category - add category page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	
	$category = get_entity($page[2]);
	$title = isset($category) ? 'category:edit' : 'stores:addcategory';
	$title = elgg_view_title(elgg_echo($title));			

	$content = elgg_view_form('socialcommerce/category/save', '', array('entity' => $category) );
	
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
		
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);

	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo($title), $body);
