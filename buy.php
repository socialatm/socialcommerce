<?php
	/**
	 * Elgg product - add to cart view
	 * 
	* @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	global $CONFIG;
	
	if (!isloggedin()) {
		system_message(elgg_echo("add:cart:not:login"));
		$_SESSION['last_forward_from'] = current_page_url();
		forward();
	}else {
		$product_guid = (int) get_input('stores_guid');
		$entity = get_entity($product_guid);
		if($entity->status != 1 || $_SESSION['user']->guid == $entity->owner_guid){
			forward();
		}
	}
	
	global $CONFIG;
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}
		
	//set stores title
		$area2 = elgg_view_title($title = elgg_echo('cart:add'));
	
	// Render the category upload page
		
		
		if ($entity) {
			if($entity->owner_guid == $_SESSION['user']->guid)
				forward($CONFIG->wwwroot."pg/{$CONFIG->pluginname}/".$_SESSION['user']->username."/read/{$product_guid}/{$entity->title}");
			set_context('cartadd');
			$area2 .= elgg_view_entity($entity,true);
			// These for left side menu
			$area1 .= gettags();
			
			$body = elgg_view_layout('two_column_left_sidebar', $area1 , $area2);
			
			page_draw(sprintf(elgg_echo("cart:add"),page_owner_entity()->name), $body);
		} else {
			forward();
		}
	
?>