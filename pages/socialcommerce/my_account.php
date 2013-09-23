<?php
	/**
	 * Elgg my account - view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	gatekeeper();
	$page_owner = elgg_get_page_owner_entity();
		
	$title = elgg_view_title(elgg_echo('stores:my:account'));
	
	$limit = 10;
	$offset = get_input('offset');
	if(!$offset) { $offset = 0; }
			
	$position = strstr($CONFIG->url,'https://') ? 'https://' : 'http://' ;
	$baseurl = $position.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	
	$tab = get_input('tab') ? get_input('tab') : 'address';

	$vars = array(
        'tabs' => array(
                  array('title' => elgg_echo('address'), 'url' => "$url" . '?tab=address', 'selected' => ($tab == 'address')),
                  array('title' => elgg_echo('transactions'), 'url' => "$url" . '?tab=transactions', 'selected' => ($tab == 'transactions')),
		)
	);

	$content .= elgg_view('navigation/tabs', $vars);

	switch($tab) {
		case 'address':			$content .= elgg_view("socialcommerce/myaccount_address");
								break;
		case 'transactions':	$transactions = get_purchased_orders('trans_category','sold_product,withdraw_fund','object','transaction','','','','','',$limit,$offset,'',$_SESSION['user']->guid);
									$count = get_data("SELECT FOUND_ROWS( ) AS count");
									$count = $count[0]->count;
									$nav = elgg_view('navigation/pagination', array(
											'baseurl' => $baseurl,
											'offset' => $offset,
											'count' => $count,
											'limit' => $limit
											));
								$content .=	elgg_view("socialcommerce/my_account", array('entity'=>$transactions, 'filter'=>$page[2], 'nav'=>$nav ));
								break;
		default:				$content .= elgg_view("modules/general_settings");
								break;
	}
		
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar = gettags();
			
	$params = array(
	'title' => $title,
	'content' => $content,
	'sidebar' => $sidebar,
	);

	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo('stores:my:account'), $body);
?>
