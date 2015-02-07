<?php
	/**
	 * Elgg socialcommerce activate page
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
 	 **/
	 
?>

<label for="first_name"><?php echo elgg_echo('first:name'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'first_name',
					'id' => 'first_name',
					'value' => $first_name,
					'class' => '',
					'style' => ''
					));
			?>
<label for="last_name"><?php echo elgg_echo('last:name'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'last_name',
					'id' => 'last_name',
					'value' => $last_name,
					'class' => ''
					));
			?>
<label for="address_line_1"><?php echo elgg_echo('address:line:1'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'address_line_1',
					'id' => 'address_line_1',
					'value' => $address_line_1,
					'class' => ''
					));
			?>
<label for="address_line_2"><?php echo elgg_echo('address:line:2'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'address_line_2',
					'id' => 'address_line_2',
					'value' => $address_line_2,
					'class' => ''
					));
			?>
<label for="city"><?php echo elgg_echo('city'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'city',
					'id' => 'city',
					'value' => $city,
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
					'value' => $pincode,
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
					'value' => $phoneno,
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
			