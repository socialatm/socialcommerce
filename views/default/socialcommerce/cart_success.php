<?php
    /**
     * Elgg view - cart success
     * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
$cart = $cart = elgg_get_entities(array( 	
	'type' => 'object',
	'subtype' => 'cart',
	'owner_guid' => $_SESSION['user']->getGUID(),
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
				$friendlytime = friendly_time($cart_item->time_created);
				
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
				$info .= elgg_view('output/confirmlink',array(
									'href' => $vars['url'] . "action/socialcommerce/remove_cart?cart_guid=" . $cart_item->getGUID(),
									'text' => elgg_echo("remove"),
									'confirm' => elgg_echo("cart:delete:confirm"),
								)); 
				$image = elgg_view("{$CONFIG->pluginname}/image", array(
											'entity' => $product,
											'size' => 'medium',
											'display'=>'full'
										  )
									);
				if($product->mimetype && $product->product_type_id == 2){							
					$icon = "<div style=\"padding-top:10px;\"><a href=\"{$product->getURL()}\">" . elgg_view("socialcommerce/icon", array("mimetype" => $mime, 'thumbnail' => $product->thumbnail, 'stores_guid' => $product->guid, 'size' => 'small')) . "</a></div>";
				}
				$display_cart_items .= elgg_view_listing($image.$icon, $info);
			}
		}
		$update_cart = elgg_view("socialcommerce/forms/updatecart");
		
	}
	$confirm_address = elgg_list_entities(array(
						'type' => 'object',
						'subtype' => 'address',
						'owner_guid' => page_owner(),
						'limit' => 10,
						));
}

echo $cart_body = <<<EOF
	{$display_cart_items}
	{$update_cart}
	{$confirm_address}
EOF;
?>