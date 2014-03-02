<?php
	/**
	 * Elgg address - add/display entry page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	gatekeeper();
	$page_owner = elgg_get_page_owner_entity();
	$container_guid = elgg_get_page_owner_guid();
		
	$title = elgg_view_title(elgg_echo('stores:address'));
		
	// Get address objects
	if(	elgg_get_entities(array( 	
			'type' => 'object',
			'subtype' => 'address',
			'owner_guid' => $page_owner->guid,
			)) 
	){
			
	elgg_set_context('search');
			
			$content = elgg_list_entities(array(
						'type' => 'object',
						'subtype' => 'address',
						'owner_guid' => $page_owner->guid,
						'limit' => 10,
						));
						
		elgg_set_context('address');
	}else{
			$content = elgg_view("socialcommerce/forms/edit_address");
		}
		
	$content = '<div class="contentWrapper stores">'.$content.'</div>';
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
