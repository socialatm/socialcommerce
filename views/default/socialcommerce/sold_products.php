<?php
	/**
	 * Elgg view - sold product
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
gatekeeper();
$stores = $vars['entity'];
$product_guid = $stores->getGUID();
$tags = $stores->tags;
$title = $stores->title;
$desc = $stores->description;
$price = $stores->price;
$search_viewtype = get_input('search_viewtype');

$quantity = $stores->quantity;
$owner = $vars['entity']->getOwnerEntity();
$friendlytime = elgg_view_friendly_time($vars['entity']->time_created);
$quantity_text = elgg_echo('quantity');
$price_text = elgg_echo('price');

$mime = $stores->mimetype;
if($stores){
	if($stores->product_type_id == 1){
		if($stores->quantity > 0){
			$quantity = $stores->quantity;
		}else{
			$quantity = 0;
		}
		$quantity = "<span><B>{$quantity_text}:</B> {$quantity}</span>";
	}
	
	$info = "<p> <a href=\"{$stores->getURL()}\"><B>{$title}</B></a></p>";
	
	$info .= '<p class="owner_timestamp">';
	
	$info .= '<a href="'.elgg_get_config('url').'socialcommerce/'.$owner->username.'">'.$owner->username.'</a> '.$friendlytime;
		
		
		$numcomments = $stores->countComments();
		if ($numcomments)
			$info .= ", <a href=\"{$stores->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
	$info .= "</p>";
	$tags_out =  elgg_view('output/tags',array('value' => $tags));
	$category_out =  elgg_view('output/category',array('value' => $stores->category));
	$product_type_out =  elgg_view('output/product_type',array('value' => $stores->product_type_id));
	$display_price = get_price_with_currency($stores->price);
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
	$rating = elgg_view("socialcommerce/view_rating",array('id'=>$stores->guid,'units'=>5,'static'=>''));
	$cart_url = addcartURL($stores);
	$cart_text = elgg_echo('add:to:cart');
	$wishlist_text = elgg_echo('add:wishlist');
	if($stores->status == 1){
		if($stores->owner_guid != $_SESSION['user']->guid){
			$entity_hidden = elgg_view('input/securitytoken');
			$cart_wishlist = <<<EOF
				<div class="cart_wishlist">
					<a title="{$cart_text}" class="cart" href="{$cart_url}">&nbsp;</a>
				</div>
				<div class="cart_wishlist">
					<form name="frm_wishlist_{$stores->guid}" method="POST" action="{$CONFIG->url}action/socialcommerce/add_wishlist">
						<a title="{$wishlist_text}" class="wishlist" onclick=" document.frm_wishlist_{$stores->guid}.submit();" href="javascript:void(0);">&nbsp;</a>
						<INPUT type="hidden" name="product_guid" value="{$stores->guid}">
					</form>
				</div>
EOF;
		}
		$not_available = "";
	}else{
		$not_available = "<div style='color:red;padding-top:10px;'>".elgg_echo('not:available')."</div>";	
	}
	$info .= <<<EOF
		<div class="storesqua_stores">
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
	$image =  elgg_view("socialcommerce/image", array(
									'entity' => $vars['entity'],
									'size' => 'small',
								  )
								);
	echo elgg_view('page/components/image_block', array('image' => $image.$icon, 'body' => $info));
}
?>
