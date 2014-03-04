<?php
	/**
	 * Elgg products shipping method form
	 * 
	 * @package Elgg products
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
 	 **/
	 
	$shipping_methods = array($vars['shipping_methods']);

	foreach($shipping_methods as $shipping_method){
		$value = $shipping_method->checked == 'checked'? $shipping_method->selected_shipping_method :'';
		echo		elgg_view('input/radio', array(
					'name' => 'shipping_method',
					'id' => 'shipping_method',
				//	'align' => 'horizontal',
					'value' => $value,
					'options' => array($shipping_method->display_name.' - '.$shipping_method->display_shipping_price => $shipping_method->selected_shipping_method),
					));

		echo elgg_view('input/hidden', array(
					'value' => $shipping_method->shipping_price,
					'id' => 'shipping_price',
					'name' => 'shipping_price',
					));
	}	 
?>
	<div>
			<?php echo elgg_view('input/submit', array(
					'value' => elgg_echo('checkout:select:shipping:method'),
					'id' => 'shipping-method-submit-button',
					));
			?>
	</div>
	<div>
			<?php echo elgg_view('input/hidden', array(
					'value' => 'shipping',
					'id' => 'checkout_status',
					'name' => 'checkout_status',
					));
			?>
	</div>
