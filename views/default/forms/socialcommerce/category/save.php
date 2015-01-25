<?php
	/**
	 * Elgg socialcommerce add/edit category form
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
 	 **/
?>

<label for="categorytitle"><?php echo elgg_echo('title'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'categorytitle',
					'id' => 'categorytitle',
					'value' => $vars[0]->title,
					'class' => '',
					'style' => '',
					));
			?>

			<?php echo elgg_view('input/product_type', array(
					'name' => 'product_type_id',
					'id' => 'product_type_id',
					'value' => $vars[0]->product_type_id,
					'class' => '',
					));
			?>
<label for="categorybody"><?php echo elgg_echo('category:text'); ?>:</label>
			<?php echo elgg_view('input/longtext', array(
					'name' => 'categorybody',
					'id' => 'categorybody',
					'value' => $vars[0]->description,
					'class' => '',
					));
			?>
			
			<?php echo elgg_view('input/hidden', array(
					'name' => 'category_guid',
					'value' => $vars[0]->guid,
					));
			?>

			<?php echo elgg_view('input/submit', array(
					'name' => 'save',
					'id' => 'save',
					'value' => elgg_echo('save'),
					'class' => 'elgg-button elgg-button-submit',
					));
			?>
