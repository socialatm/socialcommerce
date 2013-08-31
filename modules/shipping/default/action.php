<?php
	/**
	 * Elgg default shipping - actions
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	function set_shipping_settings_default(){
		
		$guid = get_input('guid');
		
		$error_field = "";
		$display_name = get_input('display_name');
		$shipping_per_item = get_input('shipping_per_item');
		if(empty($display_name)){
			$error_field = ", ".elgg_echo("display:name");
		}
		if(empty($shipping_per_item)){
			$error_field .= ", ".elgg_echo("shipping:cost:per:item");
		}
		if(empty($error_field)){
			if($guid){
				$shipping_settings = get_entity($guid);
			}else{
				$shipping_settings = new ElggObject();
			}
			
			$shipping_settings->access_id = 2;
			$shipping_settings->container_guid = $_SESSION['user']->guid;
			$shipping_settings->subtype = 's_shipping';
			$shipping_settings->shipping_method = 'default';
			$shipping_settings->display_name = $display_name;
			$shipping_settings->shipping_per_item = $shipping_per_item;
			$shipping_settings->save();
			
			system_message(sprintf(elgg_echo("settings:saved"),""));
			return $settings->guid;
		}elseif (!empty($error_field)){
			$error_field = substr($error_field,2);
			register_error(sprintf(elgg_echo("settings:validation:null"),$error_field));
			return false;
		}
	}
	
	function price_calc_default($products){
		$shipping_settings = elgg_get_entities_from_metadata(array(
			'shipping_method' => 'default',
			'entity_type' =>'object',
			'entity_subtype' => 's_shipping',
			'owner_guid' => 0,
			'limit' => 1,
			));  	
			
		if($shipping_settings){
			$shipping_settings = $shipping_settings[0];
			$shipping_per_item = $shipping_settings->shipping_per_item;
		}
		$shipping_price = array();
		foreach($products as $product_guid=>$product){
			if($product->type == 1)
				$shipping_price[$product_guid] = $shipping_per_item * $product->quantity;
		}
		return $shipping_price;
	}
	
	function varyfy_shipping_settings_default(){
		$settings = elgg_get_entities_from_metadata(array(
			'shipping_method' => 'default',
			'entity_type' =>'object',
			'entity_subtype' => 's_shipping',
			'owner_guid' => 0,
			'limit' => 1,
			));  	
		
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