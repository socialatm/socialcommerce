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
	
 	$content = $title
		.'<div class="contentWrapper stores">'.
			elgg_echo('cart:cancel:content')
			.'<form action="'.elgg_get_config('url').'socialcommerce/'.$_SESSION['user']->username.'/cart" method="post">
				<input type="submit" name="btn_submit" value="'.elgg_echo("checkout:confirm:btn").'" class="elgg-button elgg-button-submit">
			</form><br /><span class="buy_more"> or <a href="'.elgg_get_config('url').'socialcommerce/'.$_SESSION['user']->username.'/all">'.elgg_echo('buy:more').'</a></span>
		</div>';

	echo $content;			//	@todo - look at these links
?>
