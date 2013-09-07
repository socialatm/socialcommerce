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
	
	$site = get_entity($CONFIG->site_guid);
	$manage_action = get_input('manage_action');
		
	switch ($manage_action){
		case 'settings':
			$checkoutmethods = get_input('checkout_method') ? get_input('checkout_method') : array();
			//	@todo - fund_withdraw_method is not on the form
			$fund_withdraw_methods = get_input('fund_withdraw_method') ? get_input('fund_withdraw_method') : array();	
			$river_settings = get_input('river_settings')? get_input('river_settings') : array();
			//	@todo - allow_add_product is not on the form
			$allow_add_product = get_input('allow_add_product') ? get_input('allow_add_product') : array();
			// @todo - default_view does not give us a gallery option on the form
			$default_view = get_input('default_view') ? get_input('default_view') : 'list';
					
			$https_allow = get_input('https_allow');		//	@todo - not on the form
			if($https_allow){
				$https_url_text = get_input('https_url_text');
				if(empty($https_url_text)){ 
					register_error(elgg_echo("https url should not be blank"));
				}
			}
			else{
				$https_allow =0;
				$https_url_text = "";
			}
			
			$share_this = get_input('share_this','',false);			//	@todo - not on the form
						
			$guid = get_input('guid');
			$settings = !empty($guid) ? get_entity($guid) : new ElggObject() ;
			$settings->subtype = 'splugin_settings';
			$settings->access_id = 2;
			$settings->container_guid = $_SESSION['user']->guid;
			$settings->checkout_methods = $checkoutmethods;
			$settings->fund_withdraw_methods = $fund_withdraw_methods;
			$settings->default_view = $default_view;
			// For Add The https URL 
			$settings->https_allow = $https_allow;
			$settings->https_url_text = $https_url_text;
			$settings->share_this = $share_this;
			$settings->river_settings = $river_settings;
			$settings->http_proxy_server = "";
			$settings->http_proxy_port = "";
			$settings->http_varify_ssl = "";
			$settings->allow_add_product = "";
			$settings->allow_shipping_method = 1;

		if($settings->save()){
			system_message(sprintf(elgg_echo("settings:saved"), elgg_echo("item:object:splugin_settings")));
		}else{
			register_error(elgg_echo("settings:save:error"));
		}
			$redirect = $CONFIG->wwwroot.'pg/socialcommerce/'.$_SESSION['user']->username.'/settings';
			break;	
		case 'checkout':
			$order = get_input('order');
			$method = get_input('method');
			$function = 'set_checkout_settings_'.$method;
			if(function_exists($function)){
				$function();
			}
			$redirect = $CONFIG->wwwroot.'pg/socialcommerce/'.$_SESSION['user']->username.'/settings?filter=checkout&order='.$order;
			break;	
		case 'makepayment':
			$method = get_input('payment_method');
			$function = 'makepayment_'.$method;
			
			if(function_exists($function)){
				$success = $function();
			}
			break;
		case 'cart_success':
			$body = view_success_page();
			$title = elgg_view_title(elgg_echo('cart:success'));
			$display = true;
			set_context('socialcommerce');
			break;
		case 'checkout_error':
			$body = view_checkout_error_page();
			$title = elgg_view_title(elgg_echo('checkout:error'));
			$display = true;
			set_context('socialcommerce');
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
