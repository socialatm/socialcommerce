<?php
	/**
	 * Elgg form - update cart
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	$change_quantity = elgg_echo('cart:update:text');
	$update_cart = elgg_echo('cart:update');
	$cart_payment = elgg_echo('cart:confirm:payment');
	$total = calculate_cart_total();
	$display_price = get_price_with_currency($total);
	$subtotal_text = elgg_echo('cart:subtotal');
	
	if(get_context() == "confirm") {
		$form_body .= <<< BOTTOM
			<div class="search_listing">
				<span class="address_listing_info_head"><B><h3>$cart_payment</h3></B></span>
			</div>
			<div class="search_listing_info">
				<span class="cart_subtotal">
					<span><B>{$subtotal_text} : {$display_price}</span></B>
				</span>
			</div>
			<input type="hidden" name="amount" value="{$display_price}">  
BOTTOM;
	}elseif (get_context() == "order"){
		$form_body .= <<< BOTTOM
			<div class="search_listing">
				<span class="address_listing_info_head"><B><h3>$cart_payment</h3></B></span>
			</div>
			<div class="search_listing_info">
				<span class="cart_subtotal">
					<span><B>{$subtotal_text} : {$display_price}</span></B>
				</span>
			</div>
BOTTOM;
	}else{
		$form_body .= <<< BOTTOM
			<div class="search_listing">
				<span class="update_cart_quantity">
					<span class="qtext">{$change_quantity}</span>
					<span class="stores_update_cart"><a href="javascript:void(0);" onclick="javascript:document.frm_cart.submit();">{$update_cart}</a></span>
				</span>
				<span class="cart_subtotal">
					<span><B>{$subtotal_text} : {$display_price}</span></B>
				</span>
			</div>
BOTTOM;
	}
$form_body .= elgg_view('input/securitytoken');
echo $form_body;
?>