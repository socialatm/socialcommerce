<?php
	/**
	 * Elgg social commerce - view settings page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
		global $CONFIG, $settings;
		admin_gatekeeper();
		$settings = 1;
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}
		set_context('admin');
	//set stores title
		$title = elgg_view_title(elgg_echo('socialcommerce:manage'));
		
	// Get objects
		$filter = get_input("filter");
		if(!$filter)
			$filter = "settings";
			
		$splugin_settings = elgg_get_entities(array( 	
			'type' => 'object',
			'subtype' => 'splugin_settings',
			)); 			
			
		switch($filter){
			case "settings":
				$area2 = elgg_view("modules/general_settings",array('entity'=>$splugin_settings));
				break;
			case "checkout":
				$area2 = elgg_view("modules/checkout_methods",array('entity'=>$splugin_settings));
				break;
		}
		$area2 = elgg_view("modules/settings_tab_view",array('entity'=>$splugin_settings,'base_view' => $area2, "filter" => $filter));
		
		$area2 = <<<EOF
			{$title}
			<div class="contentWrapper stores">
				{$area2}
			</div>
EOF;
		set_context('admin');
		
	// Create a layout
		$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
	
	// Finally draw the page
		page_draw(sprintf(elgg_echo("socialcommerce:manage"),page_owner_entity()->name), $body);
	
?>