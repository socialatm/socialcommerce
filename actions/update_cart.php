<?php
	/**
	 * Elgg cart - update action
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	 // Load Elgg engine
	 require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
	 global $CONFIG;
	 $quanties = get_input('cartquantity');
	
	 foreach ($quanties as $cart_item_guid=>$quantity){
	 	$guid = (int)$cart_item_guid;
	 	if(isloggedin()){
	 		if ($cart_item = get_entity($guid)) {
	 			if ($cart_item->canEdit()) {
	 				$product = get_entity($cart_item->product_id);
	 			}
	 		}
	 		$username = $_SESSION['user']->username;
	 	}
	 	if (is_numeric($quantity)) { 
 			if($quantity > 0){
 				if($product->quantity >= $quantity){
	 				if($cart_item->quantity != $quantity){
	 					if(isloggedin()){
				 			$cart_item->quantity = $quantity;
				 			$result = $cart_item->save();
	 					}
	 				}
	 			}else{
	 				register_error(sprintf(elgg_echo("cart:limit:quantity:failed"),$product->title,$product->quantity));
	 			}
 			}else{
 				if(empty($quantity)) $quantity = "null";
 				register_error(sprintf(elgg_echo("cart:less:quantity:failed"),$product->title,$quantity));
 			}
		}else {
			register_error(sprintf(elgg_echo("cart:pregmatch:quantity:failed"),$product->title));
		}
	 }
	 forward("pg/{$CONFIG->pluginname}/" . $username . "/cart/");
?>