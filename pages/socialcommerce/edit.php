<?php
	/**
	 * Elgg product - edit
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	admin_gatekeeper();

	$stores = get_entity((int)$page[2]);
	
	$title = elgg_view_title($title = elgg_echo('stores:edit'));
	if ($stores) {
		if ($stores->canEdit()) { 
  			$content = '<div class="contentWrapper">'.elgg_view('socialcommerce/forms/edit',array('entity' => $stores)).'</div>';
			
			$params = array(
				'title' => $title,
				'content' => $content,
				'sidebar' => $sidebar,
				);
			$body = elgg_view_layout('one_sidebar', $params);
			echo elgg_view_page($title, $body);
			exit;
		}
	} else {
		forward();	//	@todo - maybe throw an error message here ??
	}
?>
