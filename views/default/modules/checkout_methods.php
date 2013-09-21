<?php
	/**
	 * Elgg modules - checkout methods
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	echo __FILE__ .' at '.__LINE__; die();
	
	/*****
		next time we land here change $splugin_settings over to $socialcommerce plugin object...
	*****/
	 
	$splugin_settings = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'splugin_settings',
			));
	$splugin_settings = $splugin_settings[0];
	 
	$checkout_methods = sc_get_checkout_methods();
	$order = get_input('order') ? get_input('order') : 0 ;
	$selected_checkoutmethods_guid = $splugin_settings->guid;
	$selected_checkoutmethods = $splugin_settings->checkout_methods;
	$selected_checkoutmethods = is_array($selected_checkoutmethods) ? $selected_checkoutmethods : array($selected_checkoutmethods);
	
	if($checkout_methods && $selected_checkoutmethods){
?>
		<div>
			<script type="text/javascript" src="<?php echo get_config('url'); ?>mod/socialcommerce/js/chili-1.7.pack.js"></script>
			<script type="text/javascript" src="<?php echo get_config('url'); ?>mod/socialcommerce/js/jquery.accordion.js"></script>
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
					$checkout_contents = elgg_view('modules/checkout/'.$selected_checkoutmethod.'/'.$method->view, array('entity'=>$splugin_settings,'method'=>$method,'base'=>$selected_checkoutmethod,'order'=>$i));
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
