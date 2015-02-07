<?php
	/**
	 * Elgg address - add/display entry page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
	gatekeeper();
	$user = elgg_get_logged_in_user_entity();
	$title = elgg_echo('stores:address');
	
	$new_address_link = elgg_view('output/url', array(
		'href' => 'socialcommerce/'.$user->username.'/address/new',
		'text' => elgg_echo('add:new:address'),
		'class' => 'right'
		));
		
	switch($page[2]) {
		case "new":
			$content = elgg_view('socialcommerce/forms/checkout_edit_address');
			break;
		default:
			// If the user has addresses show them. If not show the add new address form
			if(	elgg_get_entities(array('type' => 'object', 'subtype' => 'address', 'owner_guid' => $user->guid ))) {
				elgg_set_context('search');
			
				$content = elgg_list_entities(array(
					'type' => 'object',
					'subtype' => 'address',
					'owner_guid' => $user->guid,
					'limit' => 10
					));
						
				elgg_set_context('address');
			}else{
				$content = elgg_view('socialcommerce/forms/checkout_edit_address');
			}
	}	
			
	$content = '<div class="contentWrapper stores">'.$content.'</div>';
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
		
	$params = array(
		'title' => elgg_view_title($title.$new_address_link),
		'content' => $content,
		'sidebar' => $sidebar,
	);

	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page($title, $body);
