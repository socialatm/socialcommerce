<?php
	/**
	 * Elgg products shopping cart form
	 * 
	 * @package Elgg products
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	
	gatekeeper();
	$user = elgg_get_logged_in_user_entity();
	$action = elgg_get_config('url').'socialcommerce/'.$user->username.'/checkout/';
	$submit_input = elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('check:out')));
	$buy_more = elgg_echo('buy:more');
	$hidden_values = elgg_view('input/securitytoken');
	$buy_more_link = elgg_get_config('url').'socialcommerce/'.$user->username.'/all';

$form_body = <<< BOTTOM
		<form method="post" id="checkout_form" action="$action" >
			<div class="content_area_user_bottom">
				<div class="bottom_content">
					<span class="buy_more"><a href="$buy_more_link">$buy_more</a></span>
					<span>$submit_input</span>&nbsp;
					<span class="space"></span>
					$hidden_values
				</div>
			</div>
		</form>
BOTTOM;
echo $form_body;
