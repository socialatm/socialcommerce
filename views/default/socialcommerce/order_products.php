<?php
	/**
	 * Elgg view - order products
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	$order = $vars['entity'];
	if ($order) {
		$order_items = elgg_get_entities_from_relationship(array(
			'relationship' => 'order_item',
			'relationship_guid' => $order->guid, 
			));  		
		
		if($order_items){
			$tax_price = 0;
			foreach ($order_items as $order_item){
				$tax_price += $order_item->tax_price;
				$product = get_entity($order_item->product_id);
				$order_item_guid = $order_item->getGUID();
				$title = $order_item->title;
				$discount_price = $price = $order_item->price;

				
				$related_product_price = 0;
				$related_products_display = $related_products_price_display = '';
				$quantity = $order_item->quantity;
				$shipping = $order_item->shipping_price;
				$total = $quantity * $discount_price;
				$grand_total += $total;

				$shipping_total += $shipping;
				elgg_set_context('order');
				$status = elgg_view("socialcommerce/product_status",array('entity'=>$order_item,'status'=>$order_item->status,'action'=>'view'));
				$display_price = get_price_with_currency($price);
				$display_total = get_price_with_currency($total);
				if($product->mimetype && $product->product_type_id == 2){
					$download_action_url = $CONFIG->url."action/socialcommerce/download?product_guid=".$order_item->guid;						
					$download_action_url = elgg_add_action_tokens_to_url($download_action_url);							
					$icon = "<div title='Download' class='order_icon_class'><a href=\"{$download_action_url}\">" . elgg_view("socialcommerce/icon", array("mimetype" => $product->mimetype, 'thumbnail' => $product->thumbnail, 'stores_guid' => $product->guid, 'size' => 'small')) . "</a></div>";
				}else{
					$icon = "";
				}
				$item_details .= <<<EOF
					<tr>
						<td style="width: 350px;">
							<div style="float:left;">{$title}</div>{$icon}<div class="clear"></div>
						</td>
						<td style="text-align:left;">{$status}</td>
						<td style="text-align:center;">{$quantity}</td>
						<td style="text-align:right;">
							{$display_price}
						</td>
						<td style="text-align:right;">
							{$display_total}
						</td>
					</tr>
EOF;
			}
		   
		 	if($tax_price){
				$display_tax_dollar = get_price_with_currency($tax_price);
		    }
			if($shipping_total > 0){
				$display_shipping_total = get_price_with_currency($shipping_total);
				$checkout_shipping_text = elgg_echo('checkout:shipping');
				$shipping_price = <<<EOF
					<tr>
						<td class="order_total" colspan="5">
							<div style="width:100px;float:right;">{$display_shipping_total}</div>
							<div style="padding-right:30px;">{$checkout_shipping_text}: </div> 
						</td>
					</tr>
EOF;

				$checkout_tax = elgg_echo('checkout:tax');
				$tax_line = <<<TAX
					<tr>
						<td class="order_total" colspan="5">
							<div style="width:100px;float:right;">{$display_tax_dollar}</div>
							<div style="padding-right:30px;">$checkout_tax: </div> 
						</td>
					</tr>

TAX;
				if(!$tax_price)
				{
					$tax_line = '';
				}
			}
			$grand_total += $shipping_total;
			
			$billing_details = elgg_view("socialcommerce/order_display_address",array('entity'=>$order,'type'=>'b'));
			$order_billing_address_head = elgg_echo('order:billing:address:head');
			if($order->s_first_name && $order->s_last_name){
				$shipping_details = elgg_view("socialcommerce/order_display_address",array('entity'=>$order,'type'=>'s'));
				$order_shipping_address_head = elgg_echo('order:shipping:address:head');
				$shipping_details = <<<EOF
					<div class="order_details">
						<h3>{$order_shipping_address_head}</h3>
						{$shipping_details}
					</div>			
EOF;
			}
			$order_datre = '<b>'.elgg_echo('order:date').':</b> '.date("dS M Y h:i a", $order->time_created);
			if($order->s_first_name && $order->s_last_name){
				$order_recipient = '<b>'.elgg_echo('order:recipient').":</b> ".$order->s_first_name." ".$order->s_last_name;
			}else{
				$order_recipient = '<b>'.elgg_echo('order:recipient').":</b> ".$order->b_first_name." ".$order->b_last_name;
			}
			if($order->shipping_method){
				$order_shipping_method = "<div><B>".elgg_echo('order:shipping:method').": </B>".$order->shipping_method."</div>";
			}
			if($tax_price){
				$grand_total = $grand_total + $tax_price;
			}
		    $order_total = '<b>'.elgg_echo('order:total').":</b> ".get_price_with_currency($grand_total);
			$order_item_follows = sprintf(elgg_echo('order:item:follows'),$order->guid);
			$action = $CONFIG->url.'socialcommerce/'.$_SESSION['user']->username.'/order/';
			$display_grand_total = get_price_with_currency($grand_total);
		
			$cart_item_text = elgg_echo('checkout:cart:item');
			$qty_text = elgg_echo('checkout:qty');
			$item_price_text = elgg_echo('checkout:item:price');
			$cart_item_total_text = elgg_echo('checkout:item:total');
			$cart_total_cost = elgg_echo('checkout:total:cost');
			$order_status = elgg_echo('order:status');
			$order_body = <<<EOF
				<div class="ordered_items">
					<div style="float:right;">
						<form method="post" action="{$action}">
							<input class="order_view_details" type="image" src="{$CONFIG->url}mod/socialcommerce/images/order_back.gif" value="Back To Order">
						</form>
					</div>
					<div style="margin-bottom:10px;line-height:20px;">
						<div>{$order_datre}</div>
						<div>{$order_recipient}</div>
						<div>{$order_total}</div>
						{$order_shipping_method}
					</div>
					<div>
						<div class="order_details">
							<h3>{$order_billing_address_head}</h3>
							{$billing_details}
						</div>
						{$shipping_details}
						<div class="clear"></div>						
					</div>
					<div clas="order" style="line-height:30px;">
						<B>{$order_item_follows}</B>
					</div>
					<div>
						<table class="checkout_table">
							<tr>
								<th><B>{$cart_item_text}</B></th>
								<th style="text-align:left;"><B>{$order_status}</B></th>
								<th style="text-align:center;"><B>{$qty_text}</B></th>
								<th style="text-align:right;"><B>{$item_price_text}</B></th>
								<th style="text-align:right;"><B>{$cart_item_total_text}</B></th>
							</tr>
							{$item_details}
							{$tax_line}
							{$shipping_price}
							<tr>
								<td class="order_total" colspan="5">
									<div style="width:100px;float:right;">{$display_grand_total}</div>
									<div style="padding-right:30px;">{$cart_total_cost}: </div> 
								</td>
							</tr>
						</table>
					</div>
				</div>		
EOF;
			echo $order_body;
		}
	}
?>
