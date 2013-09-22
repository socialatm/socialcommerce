<?php
	/**
	 * Elgg order - view page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	gatekeeper();
	$page_owner = elgg_get_logged_in_user_entity();
	
	global $autofeed;
		
	$title = elgg_view_title(elgg_echo('stores:orders'));
	
	// Get objects
		elgg_set_context('order');
		$view = get_input('view');
		
		$content = elgg_list_entities(array(
						'type' => 'object',
						'subtype' => 'order',
						'owner_guid' => elgg_get_page_owner_guid(),
						'limit' => 10,
						));
		
		if(empty($content)){ $content = elgg_echo('order:null'); }
		
		if($view != 'rss'){
		
			$content = '<div class="contentWrapper stores">'.$content.'</div>';
		}
	
	elgg_set_context('stores');
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
	// set autofeed as false for not display the Subscribe to feed link in owner block
	$autofeed = false;
	
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo("stores:orders"), $body);
?>
