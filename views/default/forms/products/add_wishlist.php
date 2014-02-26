<?php
	/**
	 * Elgg products add to wishlist form
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
 	 **/
	 
	echo elgg_view('input/hidden', array(
		'name' => 'product_guid',
		'id' => 'product_guid',
		'value' => $vars['product_guid'],
		'class' => '',
		'internalname'=>'product_guid',
		'style' => '',
		));
		
	echo elgg_view('input/submit', array(
		'name' => 'submit_add_wishlist',
		'id' => 'submit_add_wishlist',
		'value' => elgg_echo('add:wishlist'),
		'class' => 'elgg-button-action',
		'internalname'=>'last_name',
		));
?>
		