<?php
	/**
	 * Elgg order - view page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	// Load Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		gatekeeper();
		global $autofeed;
		
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}
	
	// Set stores title
		$title = elgg_view_title(elgg_echo('stores:orders'));
	
	// Get objects
		set_context('order');
		$view = get_input('view');
		$area2 = elgg_list_entities(array(
						'type' => 'object',
						'subtype' => 'order',
						'owner_guid' => page_owner(),
						'limit' => 10,
						));
		
		if(empty($area2)){
			$area2 = elgg_echo('order:null');
		}
		if($view != 'rss'){
			$area2 = <<<EOF
				{$title}
				<div class="contentWrapper stores">
					{$area2}
				</div>
EOF;
		}
		set_context('stores');
	// These for left side menu
		$area1 .= gettags();
	// set autofeed as false for not display the Subscribe to feed link in owner block
		$autofeed = false;
	// Create a layout
		$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
		
	// Finally draw the page
		page_draw(sprintf(elgg_echo("stores:orders"),page_owner_entity()->name), $body);
	
?>