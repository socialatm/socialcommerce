<?php
	/**
	 * Elgg modules - shipping methods
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$shipping_methods = sc_get_shipping_methods();
	$selected_shippingmethods = unserialize(elgg_get_plugin_setting('shipping_method', 'socialcommerce'));
	
	if(!$selected_shippingmethods){
		$selected_shippingmethods = array($shipping_methods['default']->view);
	}

	if($shipping_methods && $selected_shippingmethods){
?>
			<br />
			<div class="basic" id="list1b">
<?php 
				$i = 0;
				foreach ($selected_shippingmethods as $selected_shippingmethod){
					$method = $shipping_methods[$selected_shippingmethod];
					$shipping_contents = elgg_view("modules/shipping/".$selected_shippingmethod.'/'.$method->view);
?>
					<h2>
						<a>
							<span class="list1b_icon"></span>
							<B><?php echo $method->label; ?> :</B>
						</a>
					</h2>
					<div class="ui_content">
						<div class="content">
							<?php echo $shipping_contents; ?>
						</div>
					</div>
<?php 
					$i++;
				}
	echo    '</div>';
	}
?>
