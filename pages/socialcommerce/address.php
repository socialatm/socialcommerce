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
	$title = elgg_view_title(elgg_echo('stores:address'));
		
	// If the user has addresses show them. If not show the add new address form
	if(	elgg_get_entities(array('type' => 'object', 'subtype' => 'address', 'owner_guid' => $user->guid ))) {
		elgg_set_context('search');
			
		$content = elgg_list_entities(array(
			'type' => 'object',
			'subtype' => 'address',
			'owner_guid' => $user->guid,
			'limit' => 10,
			));
						
		elgg_set_context('address');
	}else{
		$content = elgg_view_form('socialcommerce/address/save');
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
