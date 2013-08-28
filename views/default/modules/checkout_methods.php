<?php
	/**
	 * Elgg modules - checkout methods
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	$checkout_methods = get_checkout_methods();
	$checkoutmethods = "";
	
	$settings = $vars['entity'];
	$order = get_input('order');
	if(!$order)
		$order = 0;
	if($settings){
		$settings = $settings[0];
		$selected_checkoutmethods_guid = $settings->guid;
		$selected_checkoutmethods = $settings->checkout_methods;
		if(!is_array($selected_checkoutmethods)){
			$selected_checkoutmethods = array($selected_checkoutmethods);
		}
	}
	if($checkout_methods && $selected_checkoutmethods){
?>
		<div>
			<script type="text/javascript" src="<?php echo $CONFIG->wwwroot; ?>mod/<?php echo $CONFIG->pluginname; ?>/js/chili-1.7.pack.js"></script>
			<script type="text/javascript" src="<?php echo $CONFIG->wwwroot; ?>mod/<?php echo $CONFIG->pluginname; ?>/js/jquery.accordion.js"></script>
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
				foreach ($selected_checkoutmethods as $selected_checkoutmethod){
					$method = $checkout_methods[$selected_checkoutmethod];
					$checkout_contents = elgg_view("modules/checkout/{$selected_checkoutmethod}/{$method->view}",array('entity'=>$settings,'method'=>$method,'base'=>$selected_checkoutmethod,'order'=>$i));
?>
					<h3>
						<a>
							<span class="list1b_icon"></span>
							<B><?php echo $method->label; ?> :</B>
						</a>
					</h3>
					<div class="ui_content">
						<div class="content">
							<?php echo $checkout_contents; ?>
						</div>
					</div>
<?php 
					$i++;
				}
		echo "</div></div>";
	}
?>