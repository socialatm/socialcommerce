<?php
	/**
	 * Elgg cart - success page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	 /****
	 @todo - 
	 this is the old cart sucess page. We may want to add some of this code to
	 
	 'mod/socialcommerce/views/default/modules/checkout/paypal/cart_success.php'
	 
	 so we can show the order details on the new success page...
	 
	 okay to delete this file after we're done... We'll need to think about what happens when there are more checkout methods
	 *****/

	// Get the current page's owner
		$page_owner = elgg_get_page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			elgg_set_page_owner_guid($_SESSION['guid']);
		}
		
	// Set stores title
		$title = elgg_view_title(elgg_echo('cart:success'));
		
	// Get objects
		elgg_set_context('order');
		$body = elgg_echo('cart:success:content');
		$area2 .= <<< AREA2
			<div class="search_listing_info">
				<br>{$body}<br><br>
			</div>
AREA2;
		$area2 .= elgg_view("socialcommerce/cart_success");
		
		elgg_set_context('stores');
		
		$area2 = <<<EOF
			{$title}
			<div class="contentWrapper stores">
				{$area2}
			</div>
EOF;
		// Delete Cart;
		if(
		
		$cart =	elgg_get_entities(array( 	
			'type' => 'object',
			'subtype' => 'cart',
			'owner_guid' => $user_guid,
			)) 			
		
		){
			$cart = $cart[0];
			$cart_items = elgg_get_entities_from_relationship(array(
				'relationship' => 'cart_item',
				'relationship_guid' => $cart->guid, 
				));  
			if($cart_items){
				foreach ($cart_items as $cart_item){
					$cart_item->delete();
				}
			}
			$cart->delete();
		}
	// These for left side menu
		$area1 .= gettags();
		
	// Create a layout
	//	$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
	
	// Finally draw the page
	//	page_draw(sprintf(elgg_echo("stores:your"), elgg_get_page_owner_entity()->name), $body);
	
?>