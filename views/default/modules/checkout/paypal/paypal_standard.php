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
	 
	$socialcommerce = elgg_get_plugin_from_id('socialcommerce');
	
	$sc_payment_name = elgg_get_plugin_setting('payment_name', 'socialcommerce') ? elgg_get_plugin_setting('payment_name', 'socialcommerce') : elgg_echo('paypal:standard');
	$sc_paypal_email = elgg_get_plugin_setting('socialcommerce_paypal_email', 'socialcommerce') ? elgg_get_plugin_setting('socialcommerce_paypal_email', 'socialcommerce') : elgg_echo('enter:paypal:email');
	$sc_paypal_environment = elgg_get_plugin_setting('socialcommerce_paypal_environment', 'socialcommerce') ? elgg_get_plugin_setting('socialcommerce_paypal_environment', 'socialcommerce') : 'sandbox';
	
?>
	<div>
		<?php echo sprintf(elgg_echo('paypal:instruction1'),'https://www.paypal.com/us/cgi-bin/webscr?cmd=_registration-run'); ?>
	</div><br />
	<div>
		<label for="payment_name"><h3><?php echo elgg_echo('payment:name'); ?>:</h3></label>
			<?php echo elgg_view('input/text', array(
					'name' => 'params[payment_name]',
					'id' => 'payment_name',
					'value' => $sc_payment_name,
					'class' => 'elgg-input-text',
					'internalname'=>'payment_name',
					));
			?>
	</div><br />
	<div> 
		<label for="socialcommerce_paypal_email"><h3><?php echo elgg_echo('paypal:email'); ?>:</h3></label>
			<?php echo elgg_view('input/email', array(
					'name' => 'params[socialcommerce_paypal_email]',
					'id' => 'socialcommerce_paypal_email',
					'value' => $sc_paypal_email,
					'class' => 'elgg-input-email',
					'internalname'=>'socialcommerce_paypal_email'
					));
			?>
	</div><br />
	<div>
		<label for="socialcommerce_paypal_environment"><h3><?php echo elgg_echo('mode'); ?>:</h3></label>
			<?php echo elgg_view('input/radio', array(
					'name' => 'params[socialcommerce_paypal_environment]',
					'id' => 'socialcommerce_paypal_environment',
					'value' => $sc_paypal_environment,
					'options' => array(elgg_echo('stores:paypal') => 'paypal', elgg_echo('stores:sandbox') => 'sandbox'),
					'align' => 'horizontal',
					));
			?>
	</div>
	<div>
		<img src="<?php echo get_config('url'); ?>mod/socialcommerce/views/default/modules/checkout/paypal/images/paypal.png" alt="" style="float:right"; />
	</div>
