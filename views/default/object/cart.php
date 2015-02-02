<?php
	/**
	 * Elgg cart - individual view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
	$cart = $vars['entity'];
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
	
		$info = '<p> <a href="'.$product_url.'">'.$title.'</a></p>';
		$info .= '<p class="owner_timestamp">'.$friendlytime.'</p>';
		$info .= '<p>Quantity: '.$quantity.'</p>';
		
		$body_vars = array('product_guid' => $product->guid);
		$delete_form = elgg_view_form('socialcommerce/cart/delete', $form_vars, $body_vars);
		
		$info .= $delete_form;
						
		$product_image_guid = sc_product_image_guid($cart->product_id);
		$image = '<img src ="'.elgg_get_config('url').'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/image/'.$product_image_guid.'/'.'medium'.'"/>'; 				
		echo elgg_view('page/components/image_block', array('image' => $mage, 'body' => $info));
