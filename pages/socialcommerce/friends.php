<?php
	/**
	 * Elgg view - friend's product
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	$title = elgg_view_title(elgg_echo('stores:yours:friends'));
	elgg_set_context('search');
	$search_viewtype = get_input('search_viewtype');
	$limit = ($search_viewtype == 'gallery') ? 20 : 10 ;
	$view = get_input('view');
	$user = elgg_get_logged_in_user_entity();
	
	if ($friends = $user->getFriends(array('limit' => 0))) {
		$friendguids = array();
		foreach($friends as $friend) {
			$friendguids[] = $friend->getGUID();
		}
		$content = elgg_list_entities_from_metadata(array(
					'status' => 1,
					'type_subtype_pairs' => array('object' => 'stores'),
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
