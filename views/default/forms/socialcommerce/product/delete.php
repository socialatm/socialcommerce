<?php
	/**
	 * Elgg socialcommerce delete cart item form
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version ekgg 1.9.4
 	 **/
?>
	<?php echo elgg_view('input/hidden', array(
		'name' => 'product_guid',
		'value' => $vars['product_guid'],
		));
	?>

	<?php echo elgg_view('input/submit', array(
		'name' => 'submit',
		'id' => 'submit',
		'value' => elgg_echo('remove'),
		'class' => 'elgg-button elgg-button-action elgg-requires-confirmation'
		));
	?>
