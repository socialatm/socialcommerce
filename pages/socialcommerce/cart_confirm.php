<?php
	/**
	 * Elgg cart - confirm page
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
	
	// Load Elgg engine
	
	// Set stores title
		if($page_owner == $_SESSION['user']){
			$title = elgg_view_title(elgg_echo('cart:confirm'));
		}
	
	// Get objects
	elgg_set_context('confirm');
	$content = elgg_view("socialcommerce/cart_confirm");
	elgg_set_context('stores');
	$content = $title.'<div class="contentWrapper stores">'.$content.'</div>';
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
		
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page($title, $body);
