<?php
	/**
	 * Elgg view - sold product
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
gatekeeper();
$product = $vars['entity'];
$product_guid = $product->getGUID();
$tags = $product->tags;
$title = $product->title;
$desc = $product->description;
$price = $product->price;
$search_viewtype = get_input('search_viewtype');

$quantity = $product->quantity;
$owner = $vars['entity']->getOwnerEntity();
$friendlytime = elgg_view_friendly_time($vars['entity']->time_created);
$quantity_text = elgg_echo('quantity');
$price_text = elgg_echo('price');

$mime = $product->mimetype;
if($product){
	if($product->product_type_id == 1){
		if($product->quantity > 0){
			$quantity = $product->quantity;
		}else{
			$quantity = 0;
		}
		$quantity = "<span><B>{$quantity_text}:</B> {$quantity}</span>";
	}
	
	$info = "<p> <a href=\"{$product->getURL()}\"><B>{$title}</B></a></p>";
	
	$info .= '<p class="owner_timestamp">';
	
	$info .= '<a href="'.elgg_get_config('url').'socialcommerce/'.$owner->username.'">'.$owner->username.'</a> '.$friendlytime;
		
		
		$numcomments = $product->countComments();
		if ($numcomments)
			$info .= ", <a href=\"{$product->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
	$info .= "</p>";
	$tags_out =  elgg_view('output/tags',array('value' => $tags));
	$category_out =  elgg_view('output/category',array('value' => $product->category));
	$product_type_out =  elgg_view('output/product_type',array('value' => $product->product_type_id));
	$display_price = get_price_with_currency($product->price);
	$info .= <<<EOF
		<div style="margin:5px 0;">
			<span style="width:115px;float:left;display:block;"><B>{$price_text}:</B> {$display_price}</span>
			{$quantity}
		</div>
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
	$rating = elgg_view("socialcommerce/view_rating",array('id'=>$product->guid,'units'=>5,'static'=>''));
	$cart_url = addcartURL($product);
	$cart_text = elgg_echo('add:to:cart');
	$wishlist_text = elgg_echo('add:wishlist');
	if($product->status == 1){
		if($product->owner_guid != $_SESSION['user']->guid){
			$entity_hidden = elgg_view('input/securitytoken');
			$url = elgg_get_config('url');
			$cart_wishlist = <<<EOF
				<div class="cart_wishlist">
					<a title="{$cart_text}" class="cart" href="{$cart_url}">&nbsp;</a>
				</div>
				<div class="cart_wishlist">
					<form name="frm_wishlist_{$product->guid}" method="POST" action="{$url}action/socialcommerce/add_wishlist">
						<a title="{$wishlist_text}" class="wishlist" onclick=" document.frm_wishlist_{$product->guid}.submit();" href="javascript:void(0);">&nbsp;</a>
						<INPUT type="hidden" name="product_guid" value="{$product->guid}">
					</form>
				</div>
EOF;
		}
		$not_available = "";
	}else{
		$not_available = "<div style='color:red;padding-top:10px;'>".elgg_echo('not:available')."</div>";	
	}
	$info .= <<<EOF
		<div>
			<table>
				<tr>
					<td width="230">{$rating}</td>
					<td style="vertical-align:bottom;">
						<div class="cart_wishlist" style="padding-bottom:5px;">
							<div style="clear:both;"></div>
							<div class="cart_wishlist">
							</div>
							{$cart_wishlist}
							<div style="clear:both;"></div>	
						<div>
					</td>
				</tr>
			</table>
			{$not_available}
		</div>	
		
EOF;
	$product_image_guid = sc_product_image_guid($product->guid);
	$image = '<img src ="'.elgg_get_config('url').'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/image/'.$product_image_guid.'/'.'small'.'"/>'; 
								
	echo elgg_view('page/components/image_block', array('image' => $image.$icon, 'body' => $info));
}
