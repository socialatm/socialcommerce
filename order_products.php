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
	 
	// Load Elgg engine
		require_once(get_config('path').'engine/start.php');
		gatekeeper();
		global $CONFIG;
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}
		$order_guid = get_input('guid');
		if($order_guid){
			$order = get_entity($order_guid);
		}else{
			$redirect = $CONFIG->wwwroot.'pg/socialcommerce/'.$_SESSION['user']->username.'/order';
			forward($redirect);
		}
	// Set stores title
		$title = elgg_view_title(sprintf(elgg_echo('order:heading'),$order->guid));
	
	// Get objects
		elgg_set_context('order');
		$area2 .= elgg_view("socialcommerce/order_products",array('entity'=>$order));
		$area2 = <<<EOF
			{$title}
			<div class="contentWrapper stores">
				{$area2}
			</div>
EOF;
		elgg_set_context('stores');
		// These for left side menu
			$area1 .= gettags();
		//$area1 .= get_storestype_cloud(page_owner());
	// Create a layout
		$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
	
	// Finally draw the page
		page_draw(sprintf(elgg_echo('order:heading'),$order->guid), $body);
?>
