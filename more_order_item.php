<?php
	/**
	 * Elgg order - more items
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	// Load Elgg engine
	require_once(get_config('path').'engine/start.php');
	global $CONFIG;
	$user_guid = get_input('us');
	$order_item_id = get_input('stores_guid');
	if($order_item_id){
		$order_item = get_entity($order_item_id);
		if($order_item){
			$owner = $order_item->getOwnerEntity();
			
			$owner_url = $owner->getURL();
			$product = get_entity($order_item->product_id);
			$friendlytime = elgg_view_friendly_time($order_item->time_created);
			$friendlytime = sprintf(elgg_echo('stores:friendlytime'),$friendlytime,$owner_url,$owner->name);
			$quantity_text = elgg_echo('quantity');
			$price_text = elgg_echo('price');
			$sub_total = $order_item->quantity * $product->price;
			$status = elgg_view("socialcommerce/product_status",array('entity'=>$order_item,'action'=>'edit'));
			$icon = elgg_view("profile/icon",array('entity' => $owner, 'size' => 'small'));
			
			$order = elgg_get_entities_from_relationship(array(
				'relationship' => 'order_item',
				'relationship_guid' => $order_item->guid, 
				'inverse_relationship' => true,
				));  		
			
			if($order){
				$order = $order[0];
				if($order->b_first_name && $order->b_last_name){
					$billing_details = elgg_view("socialcommerce/order_display_address",array('entity'=>$order,'type'=>'b'));
					$billing_details = <<<EOF
						<div class="order_details">
							<h3>Billing Details</h3>
							{$billing_details}
						</div>			
EOF;
				}
				
				if($order->shipping_method && $product->product_type_id == 1){
					if($order->s_first_name && $order->s_last_name){
						$shipping_details = elgg_view("socialcommerce/order_display_address",array('entity'=>$order,'type'=>'s'));
						$shipping_details = <<<EOF
							<div class="order_details">
								<h3>Shipping Details</h3>
								{$shipping_details}
							</div>			
EOF;
					}
					$shipping_method = "<tr><td align='left' colspan='2'><B>Shipping Method:</B> ".$order->shipping_method."</td></tr>";
				}
			}
?>
			<div class="form_outer">
				<div class="close">
					<img onclick="view_order_details_close();" src="<?php echo $CONFIG->wwwroot; ?>mod/socialcommerce/images/close.gif">
				</div>
				<div class="head">
					<?php echo elgg_echo("order:details");?>
				</div>
				<div id="display_res"></div>
				<table>
					<tr>
						<td>
							<div class="search_listing_icon">
								<?php echo $icon;?>
							</div>
							<div class="search_listing_info">
								<div><?php echo $friendlytime;?></div>
								
								<div><B><?php echo elgg_echo('quantity');?>: </B><?php echo $order_item->quantity;?></div>
								<table width="100%"><tr><td align="left">
									<div><B><?php echo elgg_echo('price');?>: </B><?php echo get_price_with_currency($order_item->price);?></div>
								</td><td align="right">
									<div><B><?php echo elgg_echo('paypal:fee:per:item');?>: </B><?php echo get_price_with_currency($order_item->payment_fee_per_item);?></div>
								</td></tr>
								<tr><td align="left">
									<div><B><?php echo elgg_echo('total');?>: </B><?php echo get_price_with_currency($sub_total);?></div>
								</td><td align="right">
									<div><B><?php echo elgg_echo('toatal:paypal:fee');?>: </B><?php echo get_price_with_currency(($order_item->payment_fee_per_item * $order_item->quantity));?></div>
								</td></tr>
								<?php echo $shipping_method; ?>
								</table>
								<div>
									<div class="product_order" style="font-size:11px;">
										<?php echo $billing_details;?>
										<?php echo $shipping_details;?>
										<div class="clear"></div>						
									</div>
								</div>
								<div><?php echo $status;?></div>
							</div>
						</td>
					</tr>
					<tr><td height="10"></td></tr>
				</table>
				<?php echo elgg_view('input/securitytoken'); ?>
			</div>
<?php
		}
	}
?>
