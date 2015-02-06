<?php
	/**
	 * Elgg my account - view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 8 @version elgg 1.9.4
	 **/ 

	gatekeeper();
	$title = elgg_view_title(elgg_echo('stores:my:account'));
	
	$limit = 10;
	$offset = get_input('offset');
	if(!$offset) { $offset = 0; }
			
	$position = strstr(elgg_get_config('url'),'https://') ? 'https://' : 'http://' ;
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
		case 'address':
			$content .= elgg_view("socialcommerce/myaccount_address");
			break;
		case 'transactions':
			$options = array(
				'type' => 'object',
				'subtype' => 'order',
				'owner_guid' => elgg_get_logged_in_user_guid()
				);
			$transactions = elgg_list_entities($options);
			$content .=	elgg_view("socialcommerce/my_account", array('entity'=>$transactions, 'filter'=>$page[2], 'nav'=>$nav ));
			break;
		default:
			$content .= elgg_view("modules/general_settings");
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
