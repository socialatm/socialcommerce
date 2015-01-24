<?php
	/**
	 * Elgg cart - individual view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	global $CONFIG;
	
	$cart = $vars['entity'];
	
	$cart_guid = $cart->getGUID();
	$title = $cart->title;
	$desc = $cart->description;
	$quantity = $cart->quantity;
	$product_guid = $cart->product_id;
	if($product = get_entity($product_guid)){
		$product_url = $product->getURL();
		$title = $product->title;
		$mime = $product->mimetype;
	}
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = elgg_view_friendly_time($vars['entity']->time_created);
	
	if (elgg_get_context() == "search") {	// Start search listing version 
		$info = "<p> <a href=\"{$product_url}\">{$title}</a></p>";
		$info .= "<p class=\"owner_timestamp\">{$friendlytime}";
		$info .= "</p>";
		$info .= elgg_cart_quantity($cart);
		$info .= "<div class=\"stores_remove\">".elgg_view('output/confirmlink',array(
							'href' => elgg_get_config('url'). "action/socialcommerce/remove_cart?cart_guid=" . $cart->getGUID(),
							'text' => elgg_echo("remove"),
							'confirm' => elgg_echo("cart:delete:confirm")
						))."</div>"; 
		$icon = elgg_view("socialcommerce/image", array(
												'entity' => $product,
												'size' => 'small',
											  ));
		
		echo elgg_view('page/components/image_block', array('image' => $icon, 'body' => $info));
	}elseif (elgg_get_context() == "confirm") {
		$info = "<p> <a href=\"{$product_url}\">{$title}</a></p>";
		$info .= "<p class=\"owner_timestamp\">{$friendlytime}";
		$info .= "</p>";
		$info .= elgg_cart_quantity($cart);
		
		$icon = elgg_view("socialcommerce/image", array(
												'entity' => $product,
												'size' => 'small',
											  ));
											  
		echo elgg_view('page/components/image_block', array('image' => $icon, 'body' => $info));
	}elseif (elgg_get_context() == "order") {	// Start search listing version 
		$info = "<p> <a href=\"{$product_url}\">{$title}</a></p>";
		$info .= "<p class=\"owner_timestamp\">{$friendlytime}";
		$info .= "</p>";
		$info .= elgg_cart_quantity($cart);
		
		$icon = elgg_view("socialcommerce/image", array(
												'entity' => $product,
												'size' => 'small',
											  ));
		
		echo elgg_view('page/components/image_block', array('image' => $icon, 'body' => $info));
	}
?>
