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
	 
	// Load Elgg engine
		require_once(get_config('path').'engine/start.php');
		global $CONFIG;
		
		if (!elgg_is_logged_in()) {
			$_SESSION['last_forward_from'] = current_page_url();
			forward();
		}elseif (elgg_is_logged_in()){
			// Get the current page's owner
			$page_owner = elgg_get_page_owner_entity();
			if ($page_owner === false || is_null($page_owner)) {
				$page_owner = $_SESSION['user'];
				elgg_set_page_owner_guid($_SESSION['guid']);
			}
			if( elgg_get_page_owner_guid() != $_SESSION['user']->guid){
				forward("socialcommerce/" . $_SESSION['user']->username . "/cart/");
			}
			$header_title = elgg_echo('my:shopping:cart');
			$title = elgg_view_title($header_title);
		}
		
	elgg_set_context('search');
	$content = $title.'<div class="contentWrapper stores">'.elgg_view("socialcommerce/cart").'</div>';
	$sidebar .= gettags();
	
	if($CONFIG->cart_item_count){
			$count = ' ('.$CONFIG->cart_item_count.')';
	}
	
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page($header_title.$count, elgg_get_page_owner_entity()->name, $body);
?>
