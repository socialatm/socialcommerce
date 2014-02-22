<?php
	/**
	 * Elgg product - single product mainview
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$page_owner = elgg_get_logged_in_user_entity();
	$product = get_entity((int)$page[2]);
	$title = elgg_view_title($product->title);
	elgg_set_context('stores');
		
	$view = get_input('view');
	if($view != 'rss'){
		$content = '<div class="contentWrapper stores">'.$content.'</div>';
	}
	
	$content = elgg_view_entity($product);
	
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
		
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page($product->title, $body);
?>
