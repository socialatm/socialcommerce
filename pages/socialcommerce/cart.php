<?php
	/**
	 * Elgg products shopping cart page
	 * 
	 * @package Elgg products
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	gatekeeper();
	$title = elgg_view_title(elgg_echo('my:shopping:cart'));
	elgg_set_context('shopping_cart');
	$content = '<div class="contentWrapper stores">'.elgg_view("socialcommerce/cart").'</div>';
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= get_tags();
	
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo('my:shopping:cart'), $body);
