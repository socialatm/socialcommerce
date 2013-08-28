<?php
	/**
	 * Elgg shipping - default - view page
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
 	**/
	 
	global $CONFIG;
	$method = $vars['method'];
	$base = $vars['base'];
	$order = $vars['order'];
	
	$settings = elgg_get_entities_from_metadata(array(
		'shipping_method' => 'default',
		'entity_type' =>'object',
		'entity_subtype' => 's_shipping',
		'owner_guid' => 0,
		'limit' => 1,
		));  	
	
	if($settings){
		$settings = $settings[0];	
	}
	
	$action = $CONFIG->wwwroot."action/".$CONFIG->pluginname."/manage_socialcommerce";
	$method_view = $method->view;
	$display_name = $settings->display_name;
	if(!$display_name)
		$display_name = 'Flat Rate Per Item';
	$shipping_per_item = $settings->shipping_per_item;
?>
<div>
	<div>
		<?php echo elgg_echo('default:shipping:instructions'); ?>
	</div>
	<div style="margin-top:10px;">
		<h4 style="margin-bottom:10px;"><?php echo elgg_echo('settings'); ?></h4>
		<div>
			<form method="post" action="<?php echo $action; ?>">
				<div>
					<div>
						<!--<input type="checkbox" name="ship_method" value="flatrate_per_item">--> <B><?php echo elgg_echo('flat:rate:per:item'); ?></B>
						<div class="flatrate_item">
							<table class="stores_settings" width="40%">
								<tr>
									<td style="text-align:right;"><b><span style="color:red;">*</span>&nbsp;<?php echo elgg_echo('display:name'); ?></b></td>
									<td>:</td>
									<td style="text-align:left;"><?php echo elgg_view('input/text',array('internalname'=>'display_name','value'=>$display_name)); ?></td>
								</tr>
								<tr>
									<td style="text-align:right;"><b><span style="color:red;">*</span>&nbsp;<?php echo elgg_echo('shipping:cost:per:item'); ?></b></td>
									<td>:</td>
									<td style="text-align:left;"><?php echo elgg_view('input/text',array('internalname'=>'shipping_per_item','value'=>$shipping_per_item)); ?></td>
								</tr>
							</table>
						</div>
					</div>
					<div>
						<input type='submit' name='btn_submit' value='<?php echo elgg_echo('stores:save'); ?>'>
						<input type='hidden'"' name='method' value="<?php echo $base; ?>">
						<input type='hidden'"' name='manage_action' value="shipping">
						<input type='hidden'"' name='guid' value="<?php echo $settings->guid; ?>">
						<input type='hidden'"' name='order' value="<?php echo $order; ?>">
						<?php echo elgg_view('input/securitytoken'); ?>
					</div>
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>