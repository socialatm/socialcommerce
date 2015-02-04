<?php
	/**
	 * Elgg products update cart form
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
 	 **/
?>

<label for="quantity"><?php echo elgg_echo('quantity'); ?>:</label>
<?php echo elgg_view('input/text', array(
	'name' => 'quantity',
	'id' => 'quantity',
	'value' => $vars['quantity'],
	));
	
	echo elgg_view('input/hidden', array(
		'name' => 'product_guid',
		'id' => 'product_guid',
		'value' => $vars['product_guid'],
		'class' => '',
		'name'=>'product_guid',
		'style' => '',
		));
		
	echo elgg_view('input/submit', array(
		'name' => 'submit_add_to_cart',
		'id' => 'submit_add_to_cart',
		'value' => $vars['button_text'],
		'class' => 'elgg-button-action',
		));
		