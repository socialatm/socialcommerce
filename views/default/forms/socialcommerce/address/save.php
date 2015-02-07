<?php
	/**
	 * Elgg socialcommerce address form
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
 	 **/
?>

<label for="first_name"><?php echo elgg_echo('first:name'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'first_name',
					'id' => 'first_name',
					'value' => $vars['entity']->first_name,
					'class' => '',
					'style' => ''
					));
			?>
<label for="last_name"><?php echo elgg_echo('last:name'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'last_name',
					'id' => 'last_name',
					'value' => $vars['entity']->last_name,
					'class' => ''
					));
			?>
<label for="address_line_1"><?php echo elgg_echo('address:line:1'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'address_line_1',
					'id' => 'address_line_1',
					'value' => $vars['entity']->address_line_1,
					'class' => ''
					));
			?>
<label for="address_line_2"><?php echo elgg_echo('address:line:2'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'address_line_2',
					'id' => 'address_line_2',
					'value' => $vars['entity']->address_line_2,
					'class' => ''
					));
			?>
<label for="city"><?php echo elgg_echo('city'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'city',
					'id' => 'city',
					'value' => $vars['entity']->city,
					'class' => 'elgg-input-text'
					));
			?>
<label for="state"><?php echo elgg_echo('state'); ?>:</label>
		<div>
			<?php echo $vars['state_list']; ?>
		</div>
			
<label for="pincode"><?php echo elgg_echo('pincode'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'pincode',
					'id' => 'pincode',
					'value' => $vars['entity']->pincode,
					'class' => ''
					));
			?>
<label for="country"><?php echo elgg_echo('country'); ?>:</label>
		<div>
			<?php echo $vars['country_list']; ?>
		</div>

<label for="phoneno"><?php echo elgg_echo('phone:no'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'phoneno',
					'id' => 'phoneno',
					'value' => $vars['entity']->phoneno,
					'class' => ''
					));
			?>
<?php echo elgg_view('input/submit', array(
		'name' => 'submit',
		'id' => 'submit',
		'value' => elgg_echo('save'),
		'class' => 'elgg-button elgg-button-action'
		));
	?>
	
<?php
	if(isset($vars['entity'])){
		echo elgg_view('input/hidden', array(
			'name' => 'address_guid',
			'id' => 'address_guid',
			'value' => $vars['entity']->guid,
			'class' => ''
			));
	}
		