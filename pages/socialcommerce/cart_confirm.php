<?php
	/**
	 * Elgg cart - confirm page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	echo __FILE__ .' at '.__LINE__; die();
	gatekeeper();
	$page_owner = elgg_get_logged_in_user_entity();
	
	// Load Elgg engine
	require_once(elgg_get_config('path').'engine/start.php');
	global $CONFIG;

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
?>
