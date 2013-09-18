<?php
	/**
	 * Elgg view - order products
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	gatekeeper();
	 
	// Load Elgg engine
	require_once(get_config('path').'engine/start.php');
	global $CONFIG;
	
	// Get the current page's owner
		$page_owner = elgg_get_page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			elgg_set_page_owner_guid($_SESSION['guid']);
		}
		$order_guid = get_input('guid');
		if($order_guid){
			$order = get_entity($order_guid);
		}else{
			$redirect = $CONFIG->wwwroot.'socialcommerce/'.$_SESSION['user']->username.'/order';
			forward($redirect);
		}
	
	$title = elgg_view_title(sprintf(elgg_echo('order:heading'),$order->guid));
	
	// Get objects
	elgg_set_context('order');
	$content .= elgg_view("socialcommerce/order_products",array('entity'=>$order));
	$content = $title.'<div class="contentWrapper stores">'.$content.'</div>';
	elgg_set_context('stores');
	$sidebar .= gettags();
		
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page($title, $body);
?>
