<?php
	/**
	 * Elgg social commerce - manage settings
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	gatekeeper();
	load_checkout_actions();
	load_currency_actions();
	
	$site = get_entity(get_config('site_guid'));
	$manage_action = get_input('manage_action');
	
	switch ($manage_action){
		case 'makepayment':
			$method = get_input('payment_method');
			$function = 'makepayment_'.$method;
			
			if(function_exists($function)){
				$success = $function();
			}
			break;
		case 'checkout_error':
			$body = view_checkout_error_page();
			$title = elgg_view_title(elgg_echo('checkout:error'));
			$display = true;
			elgg_set_context('socialcommerce');
			break;
		case 'withdraw':
				;
			break;
		case 'show_wsettings':
			$method = get_input('method');
			$function = 'wsettings_forms_'.$method;
			if(function_exists($function)){
				$wsettings_form = $function();
			}else{
				$wsettings_form = "Settings does not exist";
			}
			echo $wsettings_form;
			break;
		case 'withdraw_action':
			;
			break;	
		case 'get_exchange_rate':
			$to_code = get_input('c_code');

			$default_currency = elgg_get_entities_from_metadata(array(
				'metadata_name' => 'set_default',
				'metadata_value' => 1,
				'type' => 'object',
				'subtype' => 's_currency',
				'owner_guid' => 0, 
				'limit' =>'1'
			));
					
			if($default_currency){
				$default_currency = $default_currency[0];
				$from_code = $default_currency->currency_code;
				if($from_code && $to_code){
					if(function_exists('get_exchange_rate')){
						if(!defined('ISC_SAFEMODE')) {
							define('ISC_SAFEMODE', @ini_get('safemode'));
						}
						if(get_exchange_rate($from_code, $to_code) == 0)
							echo 1;
						else
							echo 1;
					}else {
						
					}
				}else{
					
				}
			}else{
				
			}
			break;
		case 'set_checkout_session':
			$url = get_input('url');
			$_SESSION['last_forward_from'] = $url;
			break;
		case 'withdraw_request':
			;
			break;
		case 'wthdwl_request_approval':
			exit;
			break;
		case 'wthdwl_request_denied':
			exit;
			break;
		case 'coupon_process':
			;
			break;
		case 'coupon_reload_process':
			;
			break;
	}
		if(!$display && $redirect){
			forward($redirect);
		}else if($display){
			page_draw($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));
		}
	exit;
?>
