<?php
	/**
	 * Elgg checkout - paypal - view page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
		 
	$method = $vars['method'];
	$base = $vars['base'];
	$splugin_settings = $vars['entity'];
	$order = $vars['order'];
	$action = get_config('url').'action/socialcommerce/manage_socialcommerce';
	$method_view = $method->view;
	$display_name = $splugin_settings->display_name ? $splugin_settings->display_name : $method->label ;
	$stores_paypal_email = $splugin_settings->socialcommerce_paypal_email;
	$paypal_environment = $splugin_settings->socialcommerce_paypal_environment ? $splugin_settings->socialcommerce_paypal_environment : $base ;
		
?>
<div>
	<div>
		<?php echo elgg_echo('paypal:instructions'); ?>
	</div>
	<div>
		<ul>
			<li><?php echo sprintf(elgg_echo('paypal:instruction1'),'https://www.paypal.com/us/cgi-bin/webscr?cmd=_registration-run'); ?></li>
		   	<li><?php echo elgg_echo('paypal:instruction2'); ?></li>
		</ul>
	</div>
	<div>
		<h4><?php echo elgg_echo('settings'); ?></h4>
		<div>
			<form method="post" action="<?php echo $action; ?>">
				<table class="stores_settings" width="50%" style="float:left;">
					<tr>
						<td style="text-align:right;"><B><span style="color:red;">*</span> <?php echo elgg_echo('display:name'); ?></B></td>
						<td>:</td>
						<td style="text-align:left;"><?php echo elgg_view('input/text',array('internalname'=>'display_name','value'=>$display_name)); ?></td>
					</tr>
					<tr>
						<td style="text-align:right;"><B><span style="color:red;">*</span> <?php echo elgg_echo('paypal:email'); ?></B></td>
						<td>:</td>
						<td style="text-align:left;"><?php echo elgg_view('input/text',array('internalname'=>'socialcommerce_paypal_email','value'=>$stores_paypal_email)); ?></td>
					</tr>
					<tr>
						<td style="text-align:right;">
							<B><span style="color:red;">*</span> <?php echo elgg_echo('mode'); ?></B>
						</td>
						<td>:</td>
						<td style="text-align:left;">
							<input type="radio" name="socialcommerce_paypal_environment" value="paypal" <?php if($paypal_environment == "paypal"){ echo "checked = 'checked'";} ?> class="input-radio" />
							<B><?php echo elgg_echo('stores:paypal'); ?></B>
							&nbsp;
							<input type="radio" name="socialcommerce_paypal_environment" value="sandbox" <?php if($paypal_environment == "sandbox"){ echo "checked = 'checked'";} ?> class="input-radio" />
							<B><?php echo elgg_echo('stores:sandbox'); ?></B>
						</td>
					</tr>
					<tr>
						<td colspan="2"></td>
						<td style="text-align:left;">
							<input type='submit' name='btn_submit' value='<?php echo elgg_echo('stores:save'); ?>'>
							<input type='hidden'"' name='method' value="<?php echo $base; ?>">
							<input type='hidden'"' name='manage_action' value="checkout">
							<input type='hidden'"' name='guid' value="<?php echo $splugin_settings->guid; ?>">
							<input type='hidden'"' name='order' value="<?php echo $order; ?>">
							<?php echo elgg_view('input/securitytoken'); ?>
						</td>
					</tr>
				</table>
				<div style="float:left;margin:18px 0 0 20px;">
					<img src="<?php echo get_config('url'); ?>mod/socialcommerce/views/default/modules/checkout/paypal/images/paypal_logo.gif">
					
					<!-- @todo - not crazy about image location or inline css	-->
					
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
