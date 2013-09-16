<?php
	/**
	 * Elgg address - add/display entry page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	// Get the current page's owner
		$page_owner = elgg_get_page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			elgg_set_page_owner_guid($_SESSION['guid']);
		}
		$container_guid = elgg_get_page_owner_guid();

	//set title
	$title = elgg_view_title(elgg_echo('stores:address'));
		
	// Get address objects
	if(	elgg_get_entities(array( 	
			'type' => 'object',
			'subtype' => 'address',
			'owner_guid' => elgg_get_page_owner_guid(),
			)) 
		){
			
	elgg_set_context('search');
			
			$content .= elgg_list_entities(array(
						'type' => 'object',
						'subtype' => 'address',
						'owner_guid' => elgg_get_page_owner_guid(),
						'limit' => 10,
						));
						
			$content .= elgg_view("socialcommerce/forms/confirm_address");
			elgg_set_context('address');
	}else{
			$content .= elgg_view("socialcommerce/forms/edit_address");
		}
		
		$content = <<<EOF
			<div class="contentWrapper stores">
				{$content}
			</div>
EOF;

	// sidebar
	$sidebar .= gettags();
		
	$params = array(
	'title' => $title,
	'content' => $content,
	'sidebar' => $sidebar,
	);

	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page($title, $body);
?>
