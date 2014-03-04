<?php
	/**
	 * Elgg view - list shipping methods
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$socialcommerce = elgg_get_plugin_from_id('socialcommerce');
	
	if($socialcommerce){
		$selected_shipping_methods = unserialize(elgg_get_plugin_setting('shipping_method', 'socialcommerce'));
		$shipping_methods = sc_get_shipping_methods();
		$shipping_method_select = elgg_echo('shipping:method:select');
		$shipping_method_validation_text = elgg_echo('shipping:method:validation:text');
		
		$body_vars = array();

		foreach ($selected_shipping_methods as $selected_shipping_method){
			if(file_exists(SHIPPING_PATH.$selected_shipping_method.'/action.php')) {
				require_once(SHIPPING_PATH.$selected_shipping_method."/action.php");
			}else{
				throw new PluginException(sprintf(elgg_echo('misconfigured:shipping:method'), $selected_shipping_method));
			}
			
		$products = $_SESSION['CHECKOUT']['product'];
			
		$function = 'price_calc_'.$selected_shipping_method;
		if(function_exists($function)){
			$price = $function($products);
		}else {
			throw new PluginException(sprintf(elgg_echo('misconfigured:shipping:function'), $function));
		}

		$shipping_price = 0;
		if(is_array($price)){
			foreach ($price as $s_price){
				$shipping_price += $s_price;		//	@todo - we could actually assign the shipping cost to the individual items here
			}
		}
	
		$display_name = $shipping_settings->display_name ? $shipping_settings->display_name : $shipping_methods[$selected_shipping_method]->label;
			
		if($selected_shipping_method == $_SESSION['CHECKOUT']['shipping_method']){
			$checked = "checked";
		}else{
			if((empty($_SESSION['CHECKOUT']['shipping_method']))){
				$checked = "checked";
			}else{
				$checked = "";
			}
		} 
			
		$display_shipping_price = get_price_with_currency( $shipping_price );
		
		$_SESSION['CHECKOUT']['shipping_price'] = $shipping_price;
		
		$body_vars['shipping_methods'] = (object)array(
										'selected_shipping_method' => $selected_shipping_method,
										'checked' => $checked, 
										'shipping_price' => $shipping_price,
										'display_name' => $display_name,
										'display_shipping_price' => $display_shipping_price
										);
		

		}		/*****	end foreach ($selected_shipping_methods as $selected_shipping_method) *****/
		
		
		/*	select shipping method form */
		
		$action = $CONFIG->url."ajax/view/socialcommerce/checkout";
		$form_vars = array('action' => $action, 'id'=> 'select_shipping_method_form' ); 
		$shipping_method_form = elgg_view_form("address/shipping", $form_vars, $body_vars);
		
		$method_display = '<div>'.$shipping_method_select.'</div>';
		$method_display .= '<div>'.$shipping_method_form.'</div>';
		
	}
	else{
		if($CONFIG->no_shipping ==2){
			
			$method_display = elgg_echo('checkout:shipping:method:no');	
		}
		else
		{
			$method_display = elgg_echo('checkout:shipping:method:no:settings');	
		}
	}
	echo $method_display;
