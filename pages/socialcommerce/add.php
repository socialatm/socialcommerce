<?php
	/**
	 * Elgg add product page
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
	$container_guid = elgg_get_page_owner_guid();
	$title = elgg_view_title(elgg_echo('stores:addpost'));
	set_input('product_type_id', $page[2]);
	
	$content = '<div class="contentWrapper">'.elgg_view("socialcommerce/forms/edit").'</div>';
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
			
	$params = array(
	'title' => $title,
	'content' => $content,
	'sidebar' => $sidebar,
	);

	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo('stores:addpost'), $body);
?>
