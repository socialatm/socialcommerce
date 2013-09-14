<?php
	/**
	 * Elgg view - friend's product
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	require_once(get_config('path').'engine/start.php');
	
	$title = elgg_view_title($title = elgg_echo('stores:yours:friends'));
	
	set_context('search');
	$search_viewtype = get_input('search_viewtype');
	
	$limit = ($search_viewtype == 'gallery') ? 20 : 10 ;
		
	$view = get_input('view');
	$user_guid = $_SESSION['user']->guid;
	if ($friends = get_user_friends($user_guid, $subtype, 999999, 0)) {
		$friendguids = array();
		foreach($friends as $friend) {
			$friendguids[] = $friend->getGUID();
		}
		$area2 = list_entities_from_metadata('status', 1, 'object', 'stores', $friendguids, $limit );
	}
	if($view != 'rss'){
		if(empty($area2)){
			$area2 = elgg_echo('product:null');
		}
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
	$body = elgg_view_layout('two_column_left_sidebar',$area1, $area2);
	
	// Finally draw the page
	page_draw(sprintf(elgg_echo("stores:friends"),$_SESSION['user']->name), $body);
?>
