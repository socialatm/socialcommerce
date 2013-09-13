<?php
	/**
	 * Elgg view - product status
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
global $CONFIG;
$order_item = $vars['entity'];
$action = $vars['action'];
$order_status = $vars['status'];
$statuses = array(0=>'Pending',1=>'Shipped',2=>'received');
$Status_text = elgg_echo("stores:status");
if(isloggedin() && $action == "edit"){
	$offset = get_input('offset');
	if(!$offset)
		$offset = 0;
	$entity_status = $order_item->status;
	foreach ($statuses as $key=>$status){
		if($key == $entity_status){
			$select = "Selected";
		}else{
			$select = "";
		}
		$order_options .= "<option value=\"{$key}\" {$select}>{$status}</option>";
	}
	$action = $CONFIG->wwwroot."action/{$CONFIG->pluginname}/change_order_status";
	$submit_btn_text = elgg_echo('change:status:btn');
	$status_body = <<<EOF
		<span class="order_item_status">
			<div style="float:left;;margin-top:2px;">
				<B>{$Status_text}:</B> 
				<select name="order_status" id="order_status">
					{$order_options}
				</select>
			</div>
			<div class="buttonwrapper" style="float:left">
				<a onclick="change_status_function();" class="squarebutton" style="color:#222222;"><span> {$submit_btn_text} </span></a>
			</div>
			<input type="hidden" name="order_item_guid" id="order_item_guid" value="{$order_item->guid}">
		</span>
EOF;
}elseif ($action == "view"){
	if($order_status)
		$order_status = $statuses[$order_status];
	else 
		$order_status = $statuses[0];
	$status_body = <<<EOF
		<span class="order_item_status">
			<span id="status_val_{$order_item->guid}">{$order_status}</span>
		</span>
EOF;
}
echo $status_body;
?>
