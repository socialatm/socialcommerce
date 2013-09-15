<?php
	/**
	 * Elgg paypal checkout - language
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$english = array(
		'paypal:standard' => "PayPal Website Payments (Standard)",
		'paypal:instruction1' => '<a target="_blank" href="%s">Register for a free PayPal account here</a>',
		'settings' => 'Settings',
		'mode' => "Mode",
		'payment:name' => "Payment Name",
		'paypal:email' => "PayPal Email",
		'enter:paypal:email' => 'your paypal email goes here',
		'stores:paypal' => 'PayPal',
		'stores:sandbox' => 'Sandbox',
		'not:fill:paypal:settings' => 'You have selected PayPal Website Payments (Standard) for Checkout. To integrate PayPal Website Payments (Standard) into your store you should fill the settings in <B>Checkout</B> tab.',
		'missing:fields' => 'You have selected PayPal Website Payments (Standard) for Checkout. You are missing the following fields in PayPal Website Payments (Standard). Your should fill the following fields in <B>Checkout</B> tab.<br/>%s',
		'checkout:paypal:help' => 'This is the one type of checkout method in paypal',
		'paypal:settings:not:saved' => '%s settings not saved! Please try again.',
	);
					
	add_translation("en",$english);
?>