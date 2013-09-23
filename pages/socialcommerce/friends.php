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
	
	$title = elgg_view_title(elgg_echo('stores:yours:friends'));
	elgg_set_context('search');
	$search_viewtype = get_input('search_viewtype');
	$limit = ($search_viewtype == 'gallery') ? 20 : 10 ;
	$view = get_input('view');
	$user_guid = $_SESSION['user']->guid;
	
	if ($friends = get_user_friends($user_guid, $subtype, 999999, 0)) {
		$friendguids = array();
		foreach($friends as $friend) {
			$friendguids[] = $friend->getGUID();
		}
		$content = elgg_list_entities_from_metadata(array(
					'status' => 1,
					'entity_type' => 'object',
					'entity_subtype' => 'stores',
					'owner_guid' => $friendguids,
					'limit' => $limit,
					));
	}
	if($view != 'rss'){
		if(empty($content)){
			$content = elgg_echo('product:null');
		}
		$content = '<div class="contentWrapper stores">'.$content.'</div>';
	}
	elgg_set_context('stores');
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
	
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo('stores:yours:friends'), $body);
?>
