<?php
   /**
	* Elgg view - shopping cart
	* 
	* @package Elgg products
	* @license http://www.gnu.org/licenses/gpl-2.0.html
	* @author ray peaslee
	* @copyright twentyfiveautumn.com 2015
	* @link http://twentyfiveautumn.com/
	* @version 1.9.4
	**/ 
	
	gatekeeper();
	$cart = elgg_get_entities(array( 	
		'type' => 'object',
		'subtype' => 'cart',
		'owner_guid' => elgg_get_logged_in_user_entity()->guid,
		)); 			
	$cart = $cart[0];
	
	// be sure user has permission to view the shopping cart before continuing. If they don't we'll tell them it's empty.
	if(!$cart->canEdit()){
		register_error(elgg_echo("cart:null"));
		forward('socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/all/');
	}
		
	if($cart){
		$cart_items = elgg_get_entities_from_relationship(array(
			'relationship' => 'cart_item',
			'relationship_guid' => $cart->guid, 
			)); 
	}else{
		$display_cart_items = elgg_echo('cart:null');
	}

if($cart_items){
	foreach ($cart_items as $cart_item){
		if(is_array($cart_item)){
			$cart_item = (object) array('product_id'=>$cart_item['product_id'],
										'quantity' => $cart_item['quantity'],
										'amount' => $cart_item['amount'],
										'time_created' => $cart_item['time_created'],
										'guid' => $cart_item['product_id']
										);
		}
		if($product = get_entity($cart_item->product_id)){
			$product_url = $product->getURL();
			$title = $product->title;
			$mime = $product->mimetype;
			$tags = $product->tags;
			$category = $product->category;
			if(elgg_is_logged_in()){
				$owner = $cart_item->getOwnerEntity();
				$parameters = "cart_guid=".$cart_item->getGUID();
			}
			$friendlytime = elgg_view_friendly_time($cart_item->time_created);
			
			$info = "<p> <a href=\"{$product_url}\">{$title}</a></p>";
			$info .= "<p class=\"owner_timestamp\">{$friendlytime}";
			$info .= "</p>";
			$tags_out =  elgg_view('output/tags',array('value' => $tags));
			$product_type_out =  elgg_view('output/product_type',array('value' => $product->product_type_id));
			$category_out =  elgg_view('output/category',array('value' => $product->category));
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
			$info .= '<div class= "stores_remove">';
			
			$info .= elgg_view('output/confirmlink',array(
								'href' => elgg_get_config('url'). "action/socialcommerce/remove_cart?" . $parameters,
								'text' => elgg_echo("remove"),
								'confirm' => elgg_echo("cart:delete:confirm"),
							)); 
			$info .= "</div>";
			if(($product->product_type_id == 1 && $product->quantity < $cart_item->quantity) || $product->status == 0){
				$info .= "<div style='color:red;padding-top:10px;'>".elgg_echo('not:available')."</div>";
				$not_allow = 1;
			}
			
			$product_image_guid = sc_product_image_guid($product->guid);
			$image = '<img src ="'.elgg_get_config('url').'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/image/'.$product_image_guid.'/'.'small'.'"/>'; 
			
			if($product->mimetype && $product->product_type_id == 2){							
				$icon = "<div style=\"padding-top:10px;\"><a href=\"{$product->getURL()}\">" . elgg_view("socialcommerce/icon", array("mimetype" => $mime, 'thumbnail' => $product->thumbnail, 'stores_guid' => $product->guid, 'size' => 'small')) . "</a></div>";
			}else{
				$icon = "";	
			}
			$display_cart_items .= elgg_view('page/components/image_block', array('image' => $image.$icon, 'body' => $info));
		}
	}
	$update_cart = elgg_view("socialcommerce/forms/updatecart");
	$confirm_cart_list = elgg_view("socialcommerce/forms/confirm_cart_list", array('not_allow'=>$not_allow) );
}else{
	$display_cart_items = elgg_echo('cart:null');
}

if($not_allow == 1){
	$hidden = '<input type= "hidden" name="not_allow" value= "1">';
	$action = "#";
}else{
	$action = elgg_get_config('url')."action/socialcommerce/update_cart";
}
$hidden .= elgg_view('input/securitytoken');

	echo $cart_body = 
		'<form name="frm_cart" method="post" action="'.$action.'">'
		.$display_cart_items
		.$update_cart
		.$hidden
		.'</form>'
		.$confirm_cart_list;
