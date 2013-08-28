<?php
	/**
	 * Elgg my account - view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	// Load Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		gatekeeper();
	// Get the current page's owner
		$page_owner = page_owner_entity();
		
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}
		if($page_owner->guid != $_SESSION['guid']){
			register_error(elgg_echo('stores:user:not:match'));
			forward();
		}
	// Set stores title
		$title = elgg_view_title(elgg_echo('stores:my:account'));
	
	// Get objects
		$filter = get_input("filter");
		if(!$filter)
			$filter = "address";
		$limit = 10;
		$offset = get_input('offset');
		if(!$offset)
			$offset = 0;
			
			$position = strstr($CONFIG->checkout_base_url,'https://');
			if($position === false)
			{
				$baseurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}else{
				$baseurl = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}
		switch($filter){
			case "address":
				$area2 = elgg_view("{$CONFIG->pluginname}/myaccount_address");
			break;
			case "transactions":
				/*$cound = get_entities_from_metadata('trans_category','sold_product','object','transaction',$_SESSION['user']->guid,$limit,$offset,'','',true);
				$transactions = get_entities_from_metadata('trans_category','sold_product','object','transaction',$_SESSION['user']->guid,$limit,$offset);*/
				$transactions = get_purchased_orders('trans_category','sold_product,withdraw_fund','object','transaction','','','','','',$limit,$offset,'',$_SESSION['user']->guid);
				$count = get_data("SELECT FOUND_ROWS( ) AS count");
				$count = $count[0]->count;
				$nav = elgg_view('navigation/pagination',array(
													'baseurl' => $baseurl,
													'offset' => $offset,
													'count' => $count,
													'limit' => $limit
												));
				$area2 = elgg_view("{$CONFIG->pluginname}/my_account",array('entity'=>$transactions,'filter'=>$filter,'nav'=>$nav));
			break;
		}
			
		$area2 = "<div class=\"contentWrapper\">".elgg_view("{$CONFIG->pluginname}/my_account_tab_view",array('base_view' => $area2, "filter" => $filter))."</div>";
		$area2 .= <<<EOF
			<div id="load_action"></div>
			<div id='load_action_div'>
				<img src="{$CONFIG->wwwroot}mod/{$CONFIG->pluginname}/images/loadingAnimation.gif">
				<div style="color:#FFFFFF;font-weight:bold;font-size:14px;margin:10px;">Processing...</div>
			</div>
EOF;
	// These for left side menu
		$area1 = gettags();
			
	// Create a layout
		$body = elgg_view_layout('two_column_left_sidebar', $area1, $title.$area2);
	
	// Finally draw the page
		page_draw(sprintf(elgg_echo("stores:my:account"),page_owner_entity()->name), $body);
	
?>