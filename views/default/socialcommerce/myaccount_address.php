<?php
	/**
	 * Elgg view - my account address
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	
	$user = elgg_get_logged_in_user_entity();
	$address = elgg_get_entities(array( 	
		'type' => 'object',
		'subtype' => 'address',
		'owner_guid' => $user->guid
		));
	
	if($address){ 
 		$new_address_link = elgg_view('output/url', array(
			'href' => 'socialcommerce/'.$user->username.'/address/new',
			'text' => elgg_echo('add:new:address'),
			'class' => 'right'
			));
		
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
		}
	}else{
		$content = elgg_view('socialcommerce/forms/checkout_edit_address');
	}
echo $new_address_link.$content;
