<?php
	/**
	 * Elgg cart - view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	gatekeeper();
	$page_owner = elgg_get_logged_in_user_entity();
	$title = elgg_view_title(elgg_echo('my:shopping:cart'));
	elgg_set_context('search');
	$content = '<div class="contentWrapper stores">'.elgg_view("socialcommerce/cart").'</div>';
	$sidebar .= elgg_view("socialcommerce/owner_block");
	$sidebar .= gettags();
	
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo('my:shopping:cart'), $body);
?>
