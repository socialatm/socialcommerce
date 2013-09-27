<?php
	/**
	 * Elgg default shipping - actions
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	function price_calc_default( $products ){
	
		$shipping_per_item = elgg_get_plugin_setting('shipping_per_item', 'socialcommerce');
		$shipping_price = array();
		foreach($products as $product_guid => $product ){
			if($product->type != 2)
				$shipping_price[$product_guid] = $shipping_per_item * $product->quantity;
		}
		return $shipping_price;
	}
	
	function verify_shipping_settings_default(){

		echo __FILE__ .' at '.__LINE__; die();
		
		$socialcommerce = elgg_get_plugin_from_id('socialcommerce');
		
	//	@todo - not yet implemented...
				
		if($settings){
			$settings = $settings[0];
			$display_name = trim($settings->display_name);
			$shipping_per_item = trim($settings->shipping_per_item);
			
			if($display_name == "")
				$missing_field = elgg_echo('display:name');
			if($shipping_per_item == "")
				$missing_field .= $missing_field != "" ? ",".elgg_echo('shipping:cost:per:item') : elgg_echo('shipping:cost:per:item');
			
			if($missing_field != ""){
				return sprintf(elgg_echo('default:missing:fields'),$missing_field);
			}
			return;
		}else{
			return elgg_echo('not:fill:default:settings');
		}
	}
?>