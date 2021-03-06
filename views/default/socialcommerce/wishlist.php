<?php
	/**
	 * Elgg view - wishlist
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * version elgg 1.9.4
	 **/ 
	
	$products = $vars['entities'];
		
if($products){
	foreach ($products as $product){
		$rating = "";
		$owner = $product->getOwnerEntity();
		$title = $product->title;
		$product_url = $product->getURL();
		$title = $product->title;
		$mime = $product->mimetype;
		$friendlytime = '<a href="'.elgg_get_config('url').'socialcommerce/'.$owner->username.'">'.$owner->username.'</a> '.elgg_view_friendly_time($product->time_created);
		
		$info = "<p> <a href=\"{$product_url}\"><B>{$title}</B></a></p>";
		$info .= "<p class=\"owner_timestamp\">{$friendlytime}";
		$info .= "</p>";
		
		$price_text = elgg_echo('price');
		
		$total = $product->price;
		//$status = elgg_view('stores/product_status',array('entity'=>$order_item,'action'=>'view'));
		$remove_wishlist_text = elgg_echo('remove:wishlish');
		$remove_wishlist_action = elgg_add_action_tokens_to_url(elgg_get_config('url').'action/socialcommerce/remove_wishlist'); 		
		$rating = elgg_view("socialcommerce/view_rating",array('id'=>$product->guid,'units'=>5,'static'=>''));
		if($product->status == 1){
			$not_available = "";
		}else{
			$not_available = "<div style='color:red;padding:5px 0;'>".elgg_echo('not:available')."</div>";
		}
		if($stores->product_type_id == 1){
			if($stores->quantity > 0){
				$quantity = $stores->quantity;
			}else{
				$quantity = 0;
			}
			$quantity = '<span>'.elgg_echo('quantity').': '.$quantity.'</span>';
		}
		$display_total = get_price_with_currency($total);
		$entity_hidden .= elgg_view('input/securitytoken');
		$info .= <<<EOF
			<div>
				<div>
					<span>{$price_text}: {$display_total}</span>
					{$quantity}
					<div class="clear"></div>
				</div>
				<table>
					<tr>
					<td width="275px">
					</td>
						<td style="vertical-align:bottom;">
							<div>
								<form name="frm_remove_wishlist{$product->guid}" method="post" action="{$remove_wishlist_action}">
									<a onclick="document.frm_remove_wishlist{$product->guid}.submit();" href="javascript:void(0)">{$remove_wishlist_text}</a>
									<input type="hidden" name="product_guid" value="{$product->guid}">
								</form>
							</div>
						</td>
					</tr>
				</table>
			</div>
			{$not_available}
EOF;
		$product_image_guid = sc_product_image_guid($product->guid);
		$image = '<img src ="'.elgg_get_config('url').'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/image/'.$product_image_guid.'/'.'small'.'"/>'; 

		$display_cart_items .= elgg_view('page/components/image_block', array('image' => $image, 'body' => $info));
	}
}else {
	$display_cart_items = elgg_echo('wishlist:null');
}
echo $display_cart_items;
