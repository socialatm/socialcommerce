<?php
	/**
	 * Elgg change - order status action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$order_item_guid = get_input('id');
	$order_item_status = get_input('status');
	elgg_set_context('add_order');
	if($order_item_guid){
		$order_item = get_entity($order_item_guid);
		if($order_item){
			$order_item_id = $order_item->status = $order_item_status;
			$order_item_id = $order_item->save();
			if($order_item_id){
				echo "<div style='color:green;text-align:center;'>".elgg_echo('order:status:changed')."<div>";
			}else{
				echo "<div style='color:red;text-align:center;'>".elgg_echo('order:status:change:error')."<div>";
			}
		}
	}
	exit;
?>
