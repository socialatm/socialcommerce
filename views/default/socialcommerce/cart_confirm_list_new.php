<?php
	/**
	 * Elgg view - cart confirm list page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 

$checkout_confirm = $vars['checkout_confirm'];

$cart = elgg_get_entities(array( 	
	'type' => 'object',
	'subtype' => 'cart',
	'owner_guid' => $_SESSION['user']->getGUID(),
	)); 			

if($cart){
	$cart = $cart[0];
	$cart_items = elgg_get_entities_from_relationship(array(
					'relationship' => 'cart_item',
					'relationship_guid' => $cart->guid, 
					)); 
	if($cart_items){
		$grand_total = $total = $tax_price = 0;
		foreach ($cart_items as $cart_item){
			if($product = get_entity($cart_item->product_id)){
				$title = $product->title;
				$discount_price = $price = $product->price;
				$country_code = $product->countrycode;

				$related_product_price = 0;
				$related_products_display = $related_products_price_display = '';
				
				$quantity = $cart_item->quantity;
				$total = $tax_total = $quantity * $discount_price;
				$grand_total += $total;
				if($related_product_price > 0){
					$grand_total += $related_product_price;
					$tax_total += $related_product_price;
				}
					
				$display_price = get_price_with_currency($price);

				$display_total = get_price_with_currency($total);
				$item_details .= <<<EOF
					<tr>
						<td style="width:350px;">
							{$title}
							{$related_products_display}
						</td>
						<td style="text-align:center;">{$quantity}</td>
						<td style="text-align:right;">
							{$display_price}
							{$related_products_price_display}
						</td>
						<td style="text-align:right;">
							{$display_total}
							{$related_products_price_display}
						</td>
					</tr>
EOF;
			}
		}
		
		
		if($tax_price > 0){
			$grand_total = $grand_total + $tax_price;
		}
		$display_tax_dollar= get_price_with_currency($tax_price);
		$grand_total += $_SESSION['CHECKOUT']['shipping_price'];
		$_SESSION['CHECKOUT']['total'] = $grand_total;
	}
}

$cencelurl = $CONFIG->url."socialcommerce/".$_SESSION['user']->username."/cancel/";
$returnurl = $CONFIG->url."socialcommerce/".$_SESSION['user']->username."/cart_success/";
$ipnurl = $CONFIG->url."action/socialcommerce/makepayment?page_owner=".elgg_get_page_owner_guid();
$redirectlurl = $CONFIG->url."socialcommerce/{$_SESSION['user']->username}/checkout/";

if($checkout_confirm)
	$disabled = 'disabled';
else 
	$disabled = '';
	
if($_SESSION['CHECKOUT']['allow_shipping'] == 1){
	$display_shipping_price = $_SESSION['CHECKOUT']['shipping_price'];
	$checkout_shipping_text = elgg_echo('checkout:shipping');
	$shipping_details = <<<EOF
		<tr>
			<td class="order_total" colspan="4">
				<div style="width:100px;float:right;">{$display_shipping_price}</div>
				<div style="padding-right:30px;">{$checkout_shipping_text}: </div> 
			</td>
		</tr>
		
			
EOF;
}
	$checkout_tax = elgg_echo('checkout:tax');
	
	$tax_line = '';

$display_grand_total = get_price_with_currency($grand_total);

$cart_item_text = elgg_echo('checkout:cart:item');
$qty_text = elgg_echo('checkout:qty');
$item_price_text = elgg_echo('checkout:item:price');
$cart_item_total_text = elgg_echo('checkout:item:total');
$cart_total_cost = elgg_echo('checkout:total:cost');
$checkout_confirm_btn = elgg_echo('checkout:confirm:btn');
echo $cart_body = <<<EOF
	<div id="coupon_apply_result"></div>
	<form name="frm_cart" method="post" action="{$redirectlurl}">
		<div id="checkout_confirm_list">
			<table class="checkout_table">
				<tr>
					<th><B>{$cart_item_text}</B></th>
					<th style="text-align:center;"><B>{$qty_text}</B></th>
					<th style="text-align:right;"><B>{$item_price_text}</B></th>
					<th style="text-align:right;"><B>{$cart_item_total_text}</B></th>
				</tr>
				{$item_details}
				{$tax_line}
				{$shipping_details}
				<tr>
					<td class="order_total" colspan="4">
						<div style="width:100px;float:right;">{$display_grand_total}</div>
						<div style="padding-right:30px;">{$cart_total_cost}: </div> 
					</td>
				</tr>
			</table>
		</div>
		{$coupon_applay}
		<input {$disabled} class="elgg-button elgg-button-submit" type="submit" name="order_confirm" value="{$checkout_confirm_btn}">
		<input type="hidden" name="checkout_status" value="confirmation">
	</form>
EOF;
?>
