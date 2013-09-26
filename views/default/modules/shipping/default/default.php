<?php
	/**
	 * Elgg shipping - default - view page
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
 	 **/
	$socialcommerce = elgg_get_plugin_from_id('socialcommerce');
	
	$sc_shipping_method = elgg_get_plugin_setting('shipping_method', 'socialcommerce') ? unserialize(elgg_get_plugin_setting('shipping_method', 'socialcommerce')) : false;
	$sc_shipping_name = elgg_get_plugin_setting('shipping_name', 'socialcommerce') ? elgg_get_plugin_setting('shipping_name', 'socialcommerce') : elgg_echo('flat:rate:per:item');
	$sc_shipping_per_item = elgg_get_plugin_setting('shipping_per_item', 'socialcommerce') ? elgg_get_plugin_setting('shipping_per_item', 'socialcommerce') : '0.00';
	
?>
	<div>
		<?php echo elgg_echo('default:shipping:instructions'); ?>
	</div><br />
	<div>
		<label for="shipping_method"><h3><?php echo elgg_echo('flat:rate:per:item'); ?>:</h3></label>
		<?php echo elgg_view('input/checkboxes', array(
				'name' => 'params[shipping_method]',
				'id' => 'shipping_method',
				'value' => $sc_shipping_method,
				'class' => 'elgg-input-checkbox elgg-body',
				'internalname'=>'shipping_method',
				'options' => array(elgg_echo('use:flat:rate:per:item') => 'default', ),
				));
		?>
	</div><br />
	<div>
		<label for="shipping_name"><h3><?php echo elgg_echo('shipping:name'); ?>:</h3></label>
			<?php echo elgg_view('input/text', array(
					'name' => 'params[shipping_name]',
					'id' => 'shipping_name',
					'value' => $sc_shipping_name,
					'class' => 'elgg-input-text',
					'internalname'=>'shipping_name',
					));
			?>
	</div><br />
	<div> 
		<label for="shipping_per_item"><h3><?php echo elgg_echo('shipping:cost:per:item'); ?>:</h3></label>
			<?php echo elgg_view('input/text', array(
					'name' => 'params[shipping_per_item]',
					'id' => 'shipping_per_item',
					'value' => $sc_shipping_per_item,
					'class' => 'elgg-input-text',
					'internalname'=> 'shipping_per_item'
					));
			?>
	</div><br />
	<div>
		<img src="<?php echo get_config('url'); ?>mod/socialcommerce/views/default/modules/shipping/default/images/shipping.png" alt="" style="float:right";/>
	</div>
