<?php
   /**
	* Elgg view - cart confirm page
	* 
    * @package Elgg SocialCommerce
	* @license http://www.gnu.org/licenses/gpl-2.0.html
    * @author ray peaslee
	* @copyright twentyfiveautumn.com 2015
	* @link http://twentyfiveautumn.com/
	* @version elgg 1.9.4
	**/ 

$user = elgg_get_logged_in_user_entity();	
$cart = elgg_get_entities(array( 	
	'type' => 'object',
	'subtype' => 'cart',
	'owner_guid' => $user->guid
)); 			

if($cart){
	$cart = $cart[0];
	$cart_items = elgg_get_entities_from_relationship(array(
					'relationship' => 'cart_item',
					'relationship_guid' => $cart->guid, 
					)); 
	if($cart_items){
		foreach ($cart_items as $cart_item){
			if($product = get_entity($cart_item->product_id)){
				$product_url = $product->getURL();
				$title = $product->title;
				$mime = $product->mimetype;
				$tags = $product->tags;
				$category = $product->category;
				if($category > 0){
					$category = get_entity($category);
				}
				
				$owner = $cart_item->getOwnerEntity();
				$friendlytime = elgg_view_friendly_time($cart_item->time_created);
				
				$info = "<p> <a href=\"{$product_url}\">{$title}</a></p>";
				$info .= "<p class=\"owner_timestamp\">{$friendlytime}";
				$info .= "</p>";
				$tags_out =  elgg_view('output/tags',array('value' => $tags));
				$product_type_out =  elgg_view('output/product_type',array('value' => $product->product_type_id));
				$category_out =  elgg_view('output/category',array('value' => $category->title));
				$info .= <<<EOF
					<table style="margin-top:3px;width:100%;">
						<tr>
							<td style="width:300px;">
								<div class="object_tag_string">{$tags_out}</div>
							</td>
							<td>
								<div style="float:left;">
									{$product_type_out}
								</div>
								<div style="float:left;">
									{$category_out}
								</div>
							</td>
						</tr>
					</table>
EOF;
				$info .= elgg_cart_quantity($cart_item);
				
	$body_vars = array('product_guid' => $product->guid);
	$delete_form = elgg_view_form('socialcommerce/cart/delete', $form_vars, $body_vars);
	$info .= $delete_form;
								
	$product_image_guid = sc_product_image_guid($product->guid);
	$image = '<img src ="'.elgg_get_config('url').'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/image/'.$product_image_guid.'/'.'medium'.'"/>'; 
									
				if($product->mimetype && $product->product_type_id == 2){							
					$icon = "<div style=\"padding-top:10px;\"><a href=\"{$product->getURL()}\">" . elgg_view("socialcommerce/icon", array("mimetype" => $mime, 'thumbnail' => $product->thumbnail, 'stores_guid' => $product->guid, 'size' => 'small')) . "</a></div>";
				}
				$display_cart_items .= elgg_view('page/components/image_block', array('image' => $image.$icon, 'body' => $info));
			}
		}
		$update_cart = elgg_view("socialcommerce/forms/updatecart");
		
	}
	$confirm_cart = elgg_view("socialcommerce/forms/confirm_cart");
	$confirm_address = elgg_list_entities(array(
						'type' => 'object',
						'subtype' => 'address',
						'owner_guid' => elgg_get_page_owner_guid(),
						'limit' => 10,
						));
		
}

// Set Payment 
if(elgg_get_plugin_setting('socialcommerce_paypal_environment', 'socialcommerce' )){
	$environment = elgg_get_plugin_setting('socialcommerce_paypal_environment', 'socialcommerce' );
}else{
	$environment = "sandbox";
}
if($environment == "sandbox"){
	$business = elgg_get_plugin_setting('socialcommerce_paypal_email', 'socialcommerce');
	$paypalurl = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	
}else if ($environment == "paypal") {
	$business = elgg_get_plugin_setting('socialcommerce_paypal_email', 'socialcommerce');
	$paypalurl = "https://www.paypal.com/cgi-bin/webscr";	
}
$cencelurl = elgg_get_config('url')."socialcommerce/".$_SESSION['user']->username."/cancel/";
$returnurl = elgg_get_config('url')."socialcommerce/".$_SESSION['user']->username."/cart_success/";
$ipnurl = elgg_get_config('url')."action/socialcommerce/makepayment?page_owner=". elgg_get_page_owner_guid();

echo $cart_body = <<<EOF
	<form name="frm_cart" method="post" action="{$paypalurl}">
		{$display_cart_items}
		{$update_cart}
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="item_name" value="stores_purchase">
		<input type="hidden" name="quantity" value="1">
		<input type="hidden" name="currency_code" value="USD">
		<input type="hidden" name="paymentaction" value="sale">
		<input type="hidden" name="custom" value="stores_payment">
		<input type="hidden" name="rm" value="2">
		<input type="hidden" name="no_note" value="0">
		<input type="hidden" name="business" value="$business">
		<input type="hidden" name="cancel_return" value="{$cencelurl}">
		<input type="hidden" name="return" value="{$returnurl}">
		<input type="hidden" name="notify_url" value="{$ipnurl}">
		{$confirm_address}
		{$confirm_cart}
	</form>
EOF;
