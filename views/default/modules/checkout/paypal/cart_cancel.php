<?php
	/**
	 * Elgg checkout - paypal - cancellation page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	gatekeeper();
	
 	$body = elgg_echo('cart:cancel:content');
 	$back_text = elgg_echo('checkout:back:text');
	$action = get_config('url')."pg/socialcommerce/{$_SESSION['user']->username}/cart";

	$area2 = $title
		.'<div class="contentWrapper stores">'.
			$body
			.'<form action="'.$action.'" method="post">
				<input type="submit" name="btn_submit" value="'.$back_text.'">
			</form>
		</div>';

	echo $area2;
?>
