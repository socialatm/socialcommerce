<?php
	/**
	 * Elgg product - add to cart view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	require_once(get_config('path').'engine/start.php');
	global $CONFIG;
	
	if (!elgg_is_logged_in()) {
		system_message(elgg_echo("add:cart:not:login"));
		$_SESSION['last_forward_from'] = current_page_url();
		forward();
	}else {
		$product_guid = (int) get_input('stores_guid');
		$entity = get_entity($product_guid);
		if($entity->status != 1 || $_SESSION['user']->guid == $entity->owner_guid){
			forward();
		}
	}
	
	// Get the current page's owner
		$page_owner = elgg_get_page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			elgg_set_page_owner_guid($_SESSION['guid']);
		}
		
	$title = elgg_view_title( elgg_echo('cart:add'));
	
	// Render the category upload page
		if ($entity) {
			if($entity->owner_guid == $_SESSION['user']->guid)
				forward($CONFIG->wwwroot.'socialcommerce/'.$_SESSION['user']->username."/read/{$product_guid}/{$entity->title}");
			elgg_set_context('cartadd');
			$content .= elgg_view_entity($entity, true);
			
			$sidebar .= gettags();
			
			$params = array(
				'title' => $title,
				'content' => $content,
				'sidebar' => $sidebar,
				);
			$body = elgg_view_layout('one_sidebar', $params);
			echo elgg_view_page($title, $body);
		} else {
			forward();
		}
?>
