<?php
	/**
	 * Elgg view - list view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$stores = $vars['entity'];
	$action = get_input('action');
	$product_guid = $stores->guid;
	$tags = $stores->tags;
	$title = $stores->title;
	$desc = $stores->description;
	$ts = time();
	
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = elgg_view_friendly_time($vars['entity']->time_created);
	$quantity_text = elgg_echo('quantity');
	$price_text = elgg_echo('price');
	$search_viewtype = get_input('search_viewtype');
	$mime = $stores->mimetype;
	$product_type_details = sc_get_product_type_from_value($stores->product_type_id);
	
	if($stores->product_type_id == 1){
		if($stores->quantity > 0){
			$quantity = $stores->quantity;
		}else{
			$quantity = 0;
		}
			
		$quantity = '<span><B>'.$quantity_text.':</B>'.$quantity.'</span>';
	}
		
	$info = '<p><a href="'.$stores->getURL().'"><b>'.$title.'</b></a></p>';
	$info .= '<p class="owner_timestamp">
		<a href="'.$owner->getURL().'">'.$owner->name.'</a> '.$friendlytime;
	
	$numcomments = $stores->countComments();
		if ($numcomments) {
			$info .= ', <a href="'.$stores->getURL().'">'.sprintf(elgg_echo("comments")).' ('.$numcomments.')</a></p>';
		}
	
	$tags_out =  elgg_view('output/tags',array('value' => $tags));
	$product_type_out =  elgg_view('output/product_type',array('value' => $stores->product_type_id));
	$category_out =  elgg_view('output/category',array('value' => $stores->category));
	$display_price = get_price_with_currency($stores->price);

/*****	new	*****/

	$info .= 
		'<div style="margin:5px 0;">
			<span style="width:115px;"><B>'.$price_text.':</B>'.$display_price.'</span>
			<span>&nbsp;</span>'.
			$quantity.'
		</div>
		<table style="margin-top:3px;width:100%;">
			<tr>
				<td style="width:300px;" class="tag_td">
					<div class="object_tag_string">'.$tags_out.'</div>
				</td>
				<td>
					<div style="float:left;">'.
						$product_type_out.'
					</div>
					<div style="float:left;">'.
						$category_out.'
					</div>
				</td>
			</tr>
		</table>';

/*****	end new	*****/

	$cart_url = elgg_add_action_tokens_to_url(addcartURL($stores)).'&product_guid='.$product_guid;
	$cart_text = elgg_echo('add:to:cart');
	$wishlist_text = elgg_echo('add:wishlist');
	
	if($stores->status == 1){
		if($stores->owner_guid != $_SESSION['user']->guid && $product_type_details->addto_cart == 1){
			$wishlist_action = elgg_add_action_tokens_to_url(elgg_get_config('url')."action/socialcommerce/add_wishlist?pgid=".$stores->guid);

			$cart_wishlist = '
				<div class="cart_wishlist">
					<a title="'.$cart_text.'" class="cart" href="'.$cart_url.'">Add To Cart</a>
				</div>
				<div class="cart_wishlist">
					<a class="wishlist" href="'.$wishlist_action.'">'.$wishlist_text.'</a>
				</div>';
		}
	}
	
	$info .= <<<EOF
		<div class="storesqua_stores">
			<table style="width:100%;">
				<tr>
					<td>
						<div class="cart_wishlist" style="padding:5px 0 0 10px;">
							<div style="clear:both;"></div>
							<div class="cart_wishlist">
							</div>
							{$cart_wishlist}
							<div style="clear:both;"></div>	
						<div>
					</td>
				</tr>
			</table>
		</div>	
		
EOF;

	$product_image_guid = sc_product_image_guid($product_guid);
	$image = '<img src ="'.elgg_get_config('url').'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/image/'.$product_image_guid.'/'.'small'.'"/>'; 
						
	if($stores->mimetype && $stores->product_type_id == 2){	
		$icon = '<div>';
		$icon .= '<a href="'.$stores->getURL().'">'. elgg_view("socialcommerce/icon", array("mimetype" => $mime, 'thumbnail' => $stores->thumbnail, 'stores_guid' => $product_guid, 'size' => 'small')) . "</a>
		</div>";
	
	}
	
	echo elgg_view('page/components/image_block', array('image' => $image.$icon, 'body' => $info));
