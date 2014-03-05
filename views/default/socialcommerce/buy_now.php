<?php

     /**
	 * Elgg products buy now view
	 * 
	 * @package Elgg products
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$url = elgg_normalize_url('mod/socialcommerce/graphics/paypal.gif');
	$image = elgg_view('output/img', array(
				'src' => $url,
				'alt' => 'Buy Now',
				'class' => 'elgg-border-plain elgg-transition',
			));
			
	$content = '<div id="buy_now">'.$image.'<span>Connecting to PayPal</span></div>';
	echo $content;
