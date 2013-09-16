<?php
	/**
	 * Elgg category - add entry page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	admin_gatekeeper();
			
	// Get the current page's owner
	$page_owner = elgg_get_page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			elgg_set_page_owner_guid($_SESSION['guid']);
		}
	$container_guid = elgg_get_page_owner_guid();
	//set the title
	$title = elgg_view_title(elgg_echo('stores:addcate'));

	// Get the form
	$content .= "<div class=\"contentWrapper\">".elgg_view("socialcommerce/forms/edit_category")."</div>";
		
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
