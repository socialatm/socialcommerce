<?php
	/**
	 * Elgg default shipping - language
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$english = array(
		'default:shipping:instructions' => "Update the shipping settings in the form below.",
		'flat:rate:per:item' => "Flat Rate Per Item",
		'settings' => 'Settings',
		'display:name' => 'Display Name',
		'shipping:cost:per:item' => "Shipping&nbsp;Cost&nbsp;Per&nbsp;Item",
		
		'not:fill:default:settings' => 'You have selected Default Method for Shipping. To integrate this method into your store you should fill the settings in <B>Shipping</B> tab.',
		'default:missing:fields' => 'You have selected Default Method for Shipping. You are missing the following fields in this method. Your should fill the following fields in <B>Shipping</B> tab.<br/>%s',
		'shipping:default:help' => 'This is the default shipping method. In this method we set a flat rate per item',
	);
					
	add_translation("en",$english);
?>