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
	
	echo __FILE__ .' at '.__LINE__; die();
	gatekeeper();
	$page_owner = elgg_get_logged_in_user_entity();
	 
	require_once(get_config('path').'engine/start.php');
	global $CONFIG;
	
	$order_guid = get_input('guid');
		if($order_guid){
			$order = get_entity($order_guid);
		}else{
			$redirect = $CONFIG->url.'socialcommerce/'.$_SESSION['user']->username.'/order';
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
