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
					'name'=>'first_name',
					'style' => '',
					));
			?>
<label for="last_name"><?php echo elgg_echo('last:name'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'last_name',
					'id' => 'last_name',
					'value' => $last_name,
					'class' => '',
					'name'=>'last_name',
					));
			?>
<label for="address_line_1"><?php echo elgg_echo('address:line:1'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'address_line_1',
					'id' => 'address_line_1',
					'value' => $address_line_1,
					'class' => '',
					'name'=>'address_line_1',
					));
			?>
<label for="address_line_2"><?php echo elgg_echo('address:line:2'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'address_line_2',
					'id' => 'address_line_2',
					'value' => $address_line_2,
					'class' => '',
					'name'=>'address_line_2',
					));
			?>
<label for="city"><?php echo elgg_echo('city'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'city',
					'id' => 'city',
					'value' => $city,
					'class' => 'elgg-input-text',
					'name'=>'last_name',
					));
			?>
<label for="state"><?php echo elgg_echo('state'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'state',
					'id' => 'state',
					'value' => $state,
					'class' => '',
					'name'=>'state',
					));
			?>
			<?php echo $vars['state_list']; ?>
			
<label for="pincode"><?php echo elgg_echo('pincode'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'pincode',
					'id' => 'pincode',
					'value' => $pincode,
					'class' => '',
					'name'=>'pincode',
					));
			?>
<label for="country"><?php echo elgg_echo('country'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'country',
					'id' => 'country',
					'value' => $country,
					'class' => '',
					'name'=>'country',
					));
			?>
			<?php echo $vars['country_list']; ?>

<label for="mobileno"><?php echo elgg_echo('mob:no'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'mobileno',
					'id' => 'mobileno',
					'value' => $mobileno,
					'class' => '',
					'name'=>'mobileno',
					));
			?>
<label for="phoneno"><?php echo elgg_echo('phone:no'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'phoneno',
					'id' => 'phoneno',
					'value' => $phoneno,
					'class' => '',
					'name'=>'phoneno',
					));
			?>
<?php echo elgg_view('input/submit', array(
		'name' => 'submit',
		'id' => 'submit',
		'value' => elgg_echo('save'),
		'class' => 'elgg-button elgg-button-action'
		));
	?>
			