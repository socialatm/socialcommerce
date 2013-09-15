<?php
	/**
	 * Elgg view - order
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
$product = $vars['entity'];
$base_url = $vars['url'];
global $CONFIG;
$limit = 10;
$offset = get_input('offset');
if(!$offset)
	$offset = 0;
$order_items = get_purchased_orders('product_id',$product->guid,'object','order_item','','','','','DESC',$limit,$offset);
$count = get_data("SELECT FOUND_ROWS( ) AS count");
$count = $count[0]->count;
$nav = elgg_view('navigation/pagination',array(
									'baseurl' => $baseurl,
									'offset' => $offset,
									'count' => $count,
									'limit' => $limit
								));
if($order_items){
	foreach ($order_items as $order_item){
		$order_item = get_entity($order_item->guid);
		
		$owner = $order_item->getOwnerEntity();
		$owner_url = $owner->getURL();
		$friendlytime = elgg_view_friendly_time($order_item->time_created);
		$friendlytime = sprintf(elgg_echo('stores:friendlytime'),$friendlytime,$owner_url,$owner->name);
		//$info = "<p> <a href=\"{$product_url}\">{$title}</a></p>";
		$info = "<p class=\"owner_timestamp\">{$friendlytime}";
		$info .= "</p>";
		$quantity_text = elgg_echo('quantity');
		$price_text = elgg_echo('price');
		$total = $order_item->quantity * $order_item->price;
		$status = elgg_view("socialcommerce/product_status",array('entity'=>$order_item,'status'=>$order_item->status,'action'=>'view'));
		$more = "<a onclick='view_order_details($order_item->guid);' href='javascript:void(0);'>".elgg_echo('order:more')."</a>";
		$info .= <<<EOF
			<div class="storesqua_stores">
				<table>
					<tr>
						<td><B>{$quantity_text}:</B> {$order_item->quantity}</td>
						<td style="width:50px;"></td>
						<td><B>{$price_text}:</B> {$total}</td>
						<td style="width:50px;"></td>
						<td>{$status}</td>
						<td style="width:50px;"></td>
						<td class="more_btn">{$more}</td>
					</tr>
				</table>
			</div>
EOF;
		$icon = elgg_view("profile/icon",array('entity' => $owner, 'size' => 'small'));
		
		$display_cart_items .= elgg_view('page/components/image_block', array('image' => $icon, 'body' => $info));
	}
}

$action = $CONFIG->wwwroot."action/socialcommerce/update_cart";
$title = elgg_echo('stores:purchased:orders');
echo $cart_body = <<<EOF
	<script>
		function view_order_details(order_item_id){
			var window_width = $(document).width();
			var window_height = $(document).height();
			if (!document.documentElement.scrollTop){
				var scroll_pos = (document.all)?document.body.scrollTop:window.pageYOffset;
				scroll_pos = scroll_pos  + 50;
			}else{
				var scroll_pos = (document.all)?document.documentElement.scrollTop:window.pageYOffset;
				scroll_pos = scroll_pos  + 20;
			}
			
			user_id = {$_SESSION['user']->guid}
			
			$("#order_action_bg").load("{$base_url}pg/socialcommerce/" + order_item_id + "/more_order_item", {us: user_id});
			
			$("#order_action").show();
			$("#order_action").css({'width':window_width+'px','height':window_height+'px'});
			/*$("#order_action_outer").css("top",scroll_pos+"px");*/
			$("#order_action_outer").show();
		}
		function view_order_details_close(){
			$("#order_action").hide();
			$("#order_action_outer").hide();
		}
		function change_status_function(){
			var status = $("#order_status").val();
			var id = $("#order_item_guid").val();
			var user_id = {$_SESSION['user']->guid};
			var sratus_array = new Array("Pending","Shipped","received");
			var elgg_token = $('[name=__elgg_token]');
			var elgg_ts = $('[name=__elgg_ts]');
			$.post("{$base_url}action/socialcommerce/change_order_status", {
				us: user_id,
				id: id,
				status: status,
				__elgg_token: elgg_token.val(),
				__elgg_ts: elgg_ts.val()
			},
			function(data){
				$("#display_res").html(data);
				if(data.search(/successfully/) > 0){
					$("#status_val_"+id).html(sratus_array[status]);
				}
			});
		}
	</script>
	<div class="contentWrapper stores">
		<label>
			{$title}
		</label>
		<br><br>
		{$nav}
		{$display_cart_items}
		{$nav}
	</div>
	<div id="order_action"></div>
	<div id="order_action_outer" class="order">
		<div id="order_action_bg"></div>
	</div>
EOF;
?>
