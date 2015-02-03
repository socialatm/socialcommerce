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
			$cart_item = (object) array(
				'product_id'=>$cart_item['product_id'],
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
			
			$info = '<p><a href="'.$product_url.'">'.$title.'</a></p>';
			$info .= '<p class="owner_timestamp">'.$friendlytime.'</p>';
			$info .= '<p>Quantity: '.$cart_item->quantity.'</p>';
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
			//	add the delete item from cart form
			$body_vars = array('product_guid' => $product->guid);
			$delete_form = elgg_view_form('socialcommerce/cart/delete', $form_vars, $body_vars);
						
			$product_image_guid = sc_product_image_guid($product->guid);
			$image = '<img src ="'.elgg_get_config('url').'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/image/'.$product_image_guid.'/'.'small'.'"/>'; 
			
			if($product->mimetype && $product->product_type_id == 2){							
				$icon = '<div><a href="'.$product->getURL().'">'.elgg_view("socialcommerce/icon", array("mimetype" => $mime, 'thumbnail' => $product->thumbnail, 'stores_guid' => $product->guid, 'size' => 'small')).'</a></div>';
			}else{
				$icon = '';	
			}
			$display_cart_items .= elgg_view('page/components/image_block', array('image' => $image.$icon, 'body' => $info));
		}
	}
	
	$confirm_cart_list = elgg_view("socialcommerce/forms/confirm_cart_list");
}else{
	$display_cart_items = elgg_echo('cart:null');
}

$button_text = elgg_echo('cart:update');
$form_vars = array('action' => 'socialcommerce/update_cart');
$body_vars = array('product_guid' => $product->guid, 'button_text' => $button_text );	
$add_to_cart_form = elgg_view_form('socialcommerce/add_to_cart', $form_vars, $body_vars);
	
echo $cart_body = $display_cart_items.$add_to_cart_form.$delete_form.$confirm_cart_list;
