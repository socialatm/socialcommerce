<?php
	/**
	 * Elgg view - my account
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global  $CONFIG;
	$teansactions = $vars['entity'];	// @todo $teansactions ?? do you mean transactions ??
	$filter = $vars['filter'];
	$nav = $vars['nav'];
	$class ="contentWrapper";
	$nll_msg = elgg_echo("my:account:no:data:found");
	$colspan = 6;
	
	
	if($teansactions){
		$grand_total = 0;
		$settings = elgg_get_entities(array( 	
			'type' => 'object',
			'subtype' => 'splugin_settings',
			'owner_guid' => 0,
			'order_by' => '',
			'limit' => 9999,
			)); 			
		
		if($settings){
			$settings = $settings[0];
		}
		foreach ($teansactions as $teansaction){
			if($filter == "transactions"){
				$teansaction = get_entity($teansaction->guid);
			}
			$amount = $teansaction->amount;
			$transaction_date = date("d-m-Y",$teansaction->time_created);
			$title = elgg_echo($teansaction->title);
			$item_title = $Payment_fee = $quantity = "";
			if($teansaction->order_item_guid){
				$oreder_item = get_entity($teansaction->order_item_guid);
				if($oreder_item && $oreder_item->product_id){
					$product = get_entity($oreder_item->product_id);
					$product_owner = get_user($product->owner_guid);
					if($product){
						$product_url = $CONFIG->wwwroot."pg/{$CONFIG->pluginname}/".$product_owner->username."/read/".$product->guid."/".$product->title;
						$p_title = trim($product->title);
						if(strlen($p_title) > 20){
							$p_title = substr($p_title,0,20)."...";
						}
						$item_title = "<a href=\"{$product_url}\">{$p_title}</a>";
					}
					$Payment_fee = $oreder_item->payment_fee_per_item;
					$quantity  = $oreder_item->quantity;
				}
				
			}
			
			if(empty($item_title)){
				$item_title = "...";
			}
			$amount = $amount - ($Payment_fee * $quantity);
			$display_amount = get_price_with_currency($amount);
				
				$site_fee = 0;
				$net_amount = $Payment_fee + $amount;
				$grand_total += $amount;
				if($teansaction->trans_type == "debit"){
					$sign = "-";
				}else{
					$sign = "";
				}
				$display_net_amount = get_price_with_currency($net_amount);
				$display_Payment_fee = get_price_with_currency($Payment_fee);
				$td = "<td style=\"text-align:right;\">{$sign}{$display_net_amount}</td>";
				$td .= "<td style=\"text-align:right;\">{$display_Payment_fee}</td>";
				$td .= "<td style=\"text-align:right;\">{$sign}{$display_amount}</td>";
				
			
			$order_body .= <<<BODY
				<tr>
					<td>{$transaction_date}</td>
					<td>{$title}</td>
					<td>{$item_title}</td>
					{$td}
				</tr>
BODY;
		}
	}else{
		$order_body = "<td colspan=\"{$colspan}\" style=\"text-align:center;font-weight:bold;padding:15px;\">{$nll_msg}</td>";
	}
	
		$th = "<th>".elgg_echo('net:amount')."</th>";
		$th .= "<th>".elgg_echo('paypal:fee')."</th>";
		$th .= "<th>".elgg_echo('trans:total')."</th>";
	
	if($nav){
		$nav = "<div class=\"search_listing\">{$nav}</div>";
	}
	$date_txt = elgg_echo('date');
	$title_txt = elgg_echo('title');
	$product_txt = elgg_echo('product');
	$body = <<< WIDGET
		<div class="{$class}">
			<div class="stores">
				{$nav}
				<table id="my_account_table">
					<tr>
						<th>{$date_txt}</th>
						<th>{$title_txt}</th>
						<th>{$product_txt}</th>
						{$th}
					</tr>
					{$order_body}
				</table>
				{$nav}
			</div>
		</div>
WIDGET;
	echo $body;
?>