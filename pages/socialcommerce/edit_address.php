<?php
	/**
	 * Elgg address - edit
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	gatekeeper();

	$address_guid = (int)$page[2];
	$title = elgg_view_title($title = elgg_echo('address:edit'));
	
	if ($address = get_entity($address_guid)) {
	
		if ($address->canEdit()) { 
    		$content = '<div class="contentWrapper">'.elgg_view("socialcommerce/forms/edit_address", array('entity' => $address)).'</div>';
    		$sidebar .= elgg_view("socialcommerce/sidebar");
			$sidebar .= gettags();
			
			$params = array(
				'title' => $title,
				'content' => $content,
				'sidebar' => $sidebar,
				);
			$body = elgg_view_layout('one_sidebar', $params);
			echo elgg_view_page(elgg_echo("category:edit"), $body);
		}
	} else {
		forward();
	}
?>
