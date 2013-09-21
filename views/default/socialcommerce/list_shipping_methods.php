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
	 

	global $CONFIG;

	$settings = elgg_get_entities(array( 	
		'type' => 'object',
		'subtype' => 'splugin_settings',
		'owner_guid' => 0,
		'order_by' => '',
		'limit' => 9999,
		)); 			
	
	if($settings && $CONFIG->no_shipping !=2){
		$selected_shipping_methods = $settings[0]->shipping_methods;
		if(!is_array($selected_shipping_methods))
			$selected_shipping_methods = array($selected_shipping_methods);
		$shipping_methods = get_shipping_methods();
		$action = $CONFIG->url."socialcommerce/".$_SESSION['user']->username."/checkout_process/";
		
		$shipping_method_select = elgg_echo('shipping:method:select');
		$shipping_method_validation_text = elgg_echo('shipping:method:validation:text');
		$method_display = <<<EOF
			<script>
				function shipping_method_validation(){
					if ($("input[name='shipping_method']").is(":checked")){
						return true;
					}else{
						alert("{$shipping_method_validation_text}");
						return false;
					}
				}
			</script>
			<div style='padding:10px 5px;'>
				<B>{$shipping_method_select}</B>
			</div>
			<form onsubmit='return shipping_method_validation();' name='shipping_method_selection' method='post' action='{$action}'>
EOF;
		$submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('checkout:select:shipping:method')));
		
		foreach ($selected_shipping_methods as $selected_shipping_method){
			$shipping_settings = elgg_get_entities_from_metadata(array(
				'shipping_method' => $selected_shipping_method,
				'entity_type' =>'object',
				'entity_subtype' => 's_shipping',
				'owner_guid' => 0,
				'limit' => 1,
				));  	
				
			if($shipping_settings)
				$shipping_settings = $shipping_settings[0];
			
			if(file_exists($CONFIG->shipping_path.$selected_shipping_method.'/action.php')) {
				include_once($CONFIG->shipping_path.$selected_shipping_method."/action.php");
			}else{
				throw new PluginException(sprintf(elgg_echo('misconfigured:shipping:method'), $selected_shipping_method));
			}
			
			$products = $_SESSION['CHECKOUT']['product'];
			
			$function = "price_calc_".$selected_shipping_method;
			if(function_exists($function)){
				$prince = $function($products);
			}else {
				throw new PluginException(sprintf(elgg_echo('misconfigured:shipping:function'), $function));
			}
			
			$shipping_price = 0;
			if(is_array($prince)){
				foreach ($prince as $s_price)	{
					$shipping_price += $s_price;
				}
			}
			
			$display_name = $shipping_settings->display_name;
			if(!$display_name)
				$display_name = $shipping_methods[$selected_shipping_method]->label;
			//	echo 'dddddddd'. $_SESSION['CHECKOUT']['shipping_method'];
			if($selected_shipping_method == $_SESSION['CHECKOUT']['shipping_method']){
				 $checked = "checked='checked'";
			}
			else
			{
				if((empty($_SESSION['CHECKOUT']['shipping_method']))){
					 $checked = "checked='checked'";
				}
				else{
					$checked = "";
				}
			} 
			$display_shipping_price = get_price_with_currency($shipping_price);
			$method_display .= <<<EOF
				<div style='padding:5px;'>
					<input type='radio' name='shipping_method' value='{$selected_shipping_method}' {$checked}> 
					<input type='hidden' name='shipping_price' value='{$shipping_price}'> 
					<span style='margin-left:5px;'>{$display_name}</span> <span style="font-weight:bold;color:#4F0A0A;">{$display_shipping_price}</span>
				</div>
EOF;
		}
		$method_display .= <<<EOF
				<div>
					{$submit_input}
					<input type="hidden" name="checkout_order" value="2">
				</div>
			</form>
EOF;
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
?>