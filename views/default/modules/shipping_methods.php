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
	 
	global $CONFIG;
	$shipping_methods = get_shipping_methods();
	$checkoutmethods = "";
	
	$settings = $vars['entity'];
	$order = get_input('order');
	if(!$order)
		$order = 0;
	if($settings){
		$settings = $settings[0];
		$selected_shippingmethods_guid = $settings->guid;
		$selected_shippingmethods = $settings->shipping_methods;
		if(!is_array($selected_shippingmethods)){
			$selected_shippingmethods = array($selected_shippingmethods);
		}
	}
	if($shipping_methods && $selected_shippingmethods){
?>
		<div>
			<script type="text/javascript" src="<?php echo $CONFIG->wwwroot; ?>mod/socialcommerce/js/chili-1.7.pack.js"></script>
			<script type="text/javascript" src="<?php echo $CONFIG->wwwroot; ?>mod/socialcommerce/js/jquery.accordion.js"></script>
			<script type="text/javascript">
				$(document).ready(function(){
					jQuery('#list1b').accordion({
						autoheight: false,
						header: 'h3',
						active: <?php echo $order; ?>
					});
				});
			</script>
			<div class="basic" id="list1b">
<?php 
				$i = 0;
				foreach ($selected_shippingmethods as $selected_shippingmethod){
					$method = $shipping_methods[$selected_shippingmethod];
					$shipping_contents = elgg_view("modules/shipping/{$selected_shippingmethod}/{$method->view}",array('entity'=>$settings,'method'=>$method,'base'=>$selected_shippingmethod,'order'=>$i));
?>
					<h3>
						<a>
							<span class="list1b_icon"></span>
							<B><?php echo $method->label; ?> :</B>
						</a>
					</h3>
					<div class="ui_content">
						<div class="content">
							<?php echo $shipping_contents; ?>
						</div>
					</div>
<?php 
					$i++;
				}
		echo "</div></div>";
	}
?>