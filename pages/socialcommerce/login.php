<?php
	/**
	 * Elgg social commerce - login page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	global $CONFIG;
	require_once(get_config('path').'engine/start.php');

	$last_forward_from = get_input('forward_url');
		if($last_forward_from){
			$_SESSION['last_forward_from'] = $last_forward_from;
		}
	$content = elgg_view("socialcommerce/login");
	$title = sprintf(elgg_echo("stores:your"), elgg_get_page_owner_entity()->name);	
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page($title, $body);
?>
