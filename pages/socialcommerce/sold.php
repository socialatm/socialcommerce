<?php
	/**
	 * Elgg view - sold products
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	gatekeeper();

	require_once(get_config('path').'engine/start.php');
	global $CONFIG;
	
	$title = elgg_view_title($title = elgg_echo('stores:sold:products'));
	elgg_set_context('search');
	$limit = 10;
	$offset = get_input('offset') ? get_input('offset') : 0;
	
		
	$sold_products = get_sold_products($_SESSION['user']->guid, $limit, $offset );
	$count = get_data("SELECT FOUND_ROWS( ) AS count");
	$count = $count[0]->count;
	if($sold_products){
		$baseurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$nav = elgg_view('navigation/pagination',array(
									'baseurl' => $baseurl,
									'offset' => $offset,
									'count' => $count,
									'limit' => $limit
								));
		$content = "";
		
		foreach ($sold_products as $sold_product){
			$sold_product = get_entity($sold_product->value);
			$content .= elgg_view("socialcommerce/sold_products",array('entity'=>$sold_product));
		}
		$content = $nav.$content.$nav;
	}else{
		$content = elgg_echo('no:data');
	}
	
	$content = '<div class="contentWrapper stores">'.$content.'</div>';
	elgg_set_context('socialcommerce');
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
	
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo("stores:sold"), $body);
?>
