<?php
	/**
	 * Elgg socialcommerce activate page
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
 	 **/
	 
	 /***** check to be sure directory is named socialcommerce	*****/
	 
	if(basename(__DIR__ ) != 'socialcommerce'){
		echo 'you need to rename this directory to <b>socialcommerce</b> before you can continue';
		die();
	}
	 
	/*****	default settings object	*****/
	
	if(!elgg_get_plugin_from_id('socialcommerce')){
		$sc_settings = array(
			'type' => 'object',
			'subtype' => 'plugin',
			'owner_guid' => get_config('site_id'),
			'site_guid' => get_config('site_id')'
			'container_guid' => get_config('site_id'),
			'access_id' => '2',
			'enabled' => 'no',
			'title' = 'socialcommerce',
			'checkout_method' => serialize(array('paypal')),
			'default_view' => 'list',
			'river_settings' => serialize(array('product_add', 'product_checkout')),
			'socialcommerce_paypal_email' => 'your paypal email goes here',
			'socialcommerce_paypal_environment' => 'sandbox',
			'payment_name' => 'PayPal Website Payments (Standard)',
			);
		$socialcommerce = new ElggObject();

		foreach ($sc_settings as $key => $value) {
			$socialcommerce->$key = $value;
		}
		$socialcommerce->save();
		unset($sc_settings);
		
	}	/*****	end	default settings object	*****/ 
	
	/***** 
	Here are more options from the old plugin that we haven't used yet:
	
		fund_withdraw_methods = '';
		https_allow = 0;
		https_url_text = '0';
		http_proxy_server = "";
		http_proxy_port = "";
		http_verify_ssl = "";
		allow_add_product = "";
		allow_shipping_method = 1;
	
	*****/
?>
