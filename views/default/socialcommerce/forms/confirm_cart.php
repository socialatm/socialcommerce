<?php
	/**
	 * Elgg cart - confirm form
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	
	$submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('check:out')));
	
	$buy_more_link = $CONFIG->wwwroot."pg/{$CONFIG->pluginname}/".$_SESSION['user']->username."/all";
	$byu_more = elgg_echo('buy:more');
	$modify_cart_link = $CONFIG->wwwroot."pg/{$CONFIG->pluginname}/".$_SESSION['user']->username."/cart/";
	$modify_cart = elgg_echo('modify:cart');
	$change_address_link = $CONFIG->wwwroot."pg/{$CONFIG->pluginname}/".$_SESSION['user']->username."/address/";
	$change_address = elgg_echo('change:address');
	
	$form_body = <<< BOTTOM
		<div class="content_area_user_bottom">
			<div class="bottom_content">
				<span><a href="$buy_more_link">$byu_more</a></span>
				<span><a href="$modify_cart_link">$modify_cart</a></span>
				<span><a href="$change_address_link">$change_address</a></span>
				<span>$submit_input</span>&nbsp;
				<span class="space"></span>
			</div>
		</div>
BOTTOM;
echo $form_body;
?>
