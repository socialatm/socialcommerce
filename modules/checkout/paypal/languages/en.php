<?php
	/**
	 * Elgg paypal checkout - language
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$english = array(
		'paypal:standard' => "PayPal Website Payments (Standard)",
		'paypal:instructions' => "To integrate PayPal into your store you need to follow a few simple steps, which are shown below:",
		'paypal:instruction1' => '<a target="_blank" href="%s">Register for a free PayPal account here</a>',
		'paypal:instruction2' => 'Fill in the other details below',
		'settings' => 'Settings',
		'mode' => "Mode",
		'display:name' => "Display Name",
		'paypal:email' => "PayPal Email ID",
		'stores:paypal' => 'PayPal',
		'mode' => 'Mode',
		'stores:sandbox' => 'Sandbox',
		'not:fill:paypal:settings' => 'You have selected PayPal Website Payments (Standard) for Checkout. To integrate PayPal Website Payments (Standard) into your store you should fill the settings in <B>Checkout</B> tab.',
		'missing:fields' => 'You have selected PayPal Website Payments (Standard) for Checkout. You are missing the following fields in PayPal Website Payments (Standard). Your should fill the following fields in <B>Checkout</B> tab.<br/>%s',
		'checkout:paypal:help' => 'This is the one type of checkout method in paypal',
	);
					
	add_translation("en",$english);
?>