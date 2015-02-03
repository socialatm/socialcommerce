<?php
	/**
	 * Elgg view - list view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
	$stores = $vars['entity'];
	
	$tags = $stores->tags;
	$title = $stores->title;
	$desc = $stores->description;
	$mime = $stores->mimetype;
		
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = elgg_view_friendly_time($stores->time_created);
	
	$search_viewtype = get_input('search_viewtype');
	$product_type_details = sc_get_product_type_from_value($stores->product_type_id);
		
	$info = '<p><a href="'.$stores->getURL().'"><h2>'.$title.'</h2></a>';
	$info .= '<a href="'.$owner->getURL().'">'.$owner->name.'</a> '.$friendlytime.'</p>';
	
	$numcomments = $stores->countComments();
		if ($numcomments) {
			$info .= ', <a href="'.$stores->getURL().'">'.sprintf(elgg_echo("comments")).' ('.$numcomments.')</a></p>';
		}
	
	$tags_out =  elgg_view('output/tags',array('value' => $tags));
	$product_type_out =  elgg_view('output/product_type',array('value' => $stores->product_type_id));
	$category_out =  elgg_view('output/category',array('value' => $stores->category));

/*****	new	*****/

	$info .= 
		'<div style="margin:5px 0;">
			<span style="width:115px;"><B>'.elgg_echo('price').':</B>'.get_price_with_currency($stores->price).'</span>
			<span>&nbsp;</span>
		</div>
		<table style="margin-top:3px;width:100%;">
			<tr>
				<td  class="tag_td">
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

	//	if user is not the owner show the add to cart and add to wishlist buttons
	if($stores->status == 1){
		if($stores->owner_guid != $user->guid && $product_type_details->addto_cart == 1){
			$button_text = elgg_echo('add:cart');
			$body_vars = array('product_guid' => $stores->guid, 'button_text' => $button_text );	
			$add_to_cart_form = elgg_view_form('socialcommerce/add_to_cart', $form_vars, $body_vars);
					
			$body_vars = array('product_guid' => $stores->guid);	
			$add_to_wishlist_form	= elgg_view_form('socialcommerce/add_wishlist', $form_vars, $body_vars);
		}
	}
	
	$info .= <<<EOF
		<div>
			<table style="width:100%;">
				<tr>
					<td>
						<div class="cart_wishlist">
							<div style="clear:both;"></div>
							{$add_to_cart_form}
							{$add_to_wishlist_form}
							<div style="clear:both;"></div>	
						<div>
					</td>
				</tr>
			</table>
		</div>	
		
EOF;

	$product_image_guid = sc_product_image_guid($stores->guid);
	$image = '<img src ="'.elgg_get_config('url').'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/image/'.$product_image_guid.'/'.'small'.'"/>'; 
						
	if($stores->mimetype && $stores->product_type_id == 2){	
		$icon = '<div>';
		$icon .= '<a href="'.$stores->getURL().'">'. elgg_view("socialcommerce/icon", array("mimetype" => $mime, 'thumbnail' => $stores->thumbnail, 'stores_guid' => $stores->guid, 'size' => 'small')) . "</a>
		</div>";
	
	}
	
	echo elgg_view('page/components/image_block', array('image' => $image.$icon, 'body' => $info));
