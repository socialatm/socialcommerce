<?php
	/**
	 * Elgg address - confirm form
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	global $checkout_order;
	$ajax = $vars['ajax'];
	$address = $vars['entity'];
	if($address)
		$address = $address[0];
	$submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('confirm:address')));
	$action = $CONFIG->url."socialcommerce/".$_SESSION['user']->username."/checkout_process/";
	$hidden_values = elgg_view('input/securitytoken');
	$form_body = <<< BOTTOM
		<form method="post" action="{$action}">
			<div class="bottom_content">
				<span style="margin-left:20px;">$submit_input</span>
				<input type="hidden" id="checkout_order" name="checkout_order" value="0">
				<input type="hidden" id="address_guid" name="address_guid" value="{$address->guid}">
			</div>
		</form>
BOTTOM;
echo $form_body;
?>
