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
require_once('C:/Program Files (x86)/Zend/Apache2/htdocs/krumo/class.krumo.php');
$arr2 = get_defined_vars();
	 
?>

<label for="first_name"><?php echo elgg_echo('first:name'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'first_name',
					'id' => 'first_name',
					'value' => $first_name,
					'class' => '',
					'internalname'=>'first_name',
					'style' => '',
					));
			?>
<label for="last_name"><?php echo elgg_echo('last:name'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'last_name',
					'id' => 'last_name',
					'value' => $last_name,
					'class' => '',
					'internalname'=>'last_name',
					));
			?>
<label for="address_line_1"><?php echo elgg_echo('address:line:1'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'address_line_1',
					'id' => 'address_line_1',
					'value' => $address_line_1,
					'class' => '',
					'internalname'=>'address_line_1',
					));
			?>
<label for="address_line_2"><?php echo elgg_echo('address:line:2'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'address_line_2',
					'id' => 'address_line_2',
					'value' => $address_line_2,
					'class' => '',
					'internalname'=>'address_line_2',
					));
			?>
<label for="city"><?php echo elgg_echo('city'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'city',
					'id' => 'city',
					'value' => $city,
					'class' => 'elgg-input-text',
					'internalname'=>'last_name',
					));
			?>
<label for="state"><?php echo elgg_echo('state'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'state',
					'id' => 'state',
					'value' => $state,
					'class' => '',
					'internalname'=>'state',
					));
			?>
<label for="pincode"><?php echo elgg_echo('pincode'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'pincode',
					'id' => 'pincode',
					'value' => $pincode,
					'class' => '',
					'internalname'=>'pincode',
					));
			?>
<label for="country"><?php echo elgg_echo('country'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'country',
					'id' => 'country',
					'value' => $country,
					'class' => '',
					'internalname'=>'country',
					));
			?>


<div>
<label for="phoneno"><?php echo elgg_echo('phone:no'); ?>:</label>
			<?php echo elgg_view('input/text', array(
					'name' => 'phoneno',
					'id' => 'phoneno',
					'value' => $phoneno,
					'class' => '',
					'internalname'=>'phoneno',
					));
			?>
</div>
<div>
<label for="billing"><?php echo elgg_echo('billing:address'); ?>:</label>
			<?php echo elgg_view('input/checkbox', array(
					'name' => 'billing',
					'id' => 'billing',
					'value' => $vars['type'] == 'billing'? 1: 0,
					'class' => '',
					'internalname'=>'billing',
					'checked' => $vars['type'] == 'billing'? 1: 0,
					));
			?>
</div>
<div>
			<?php echo elgg_view('input/submit', array(
					'value' => elgg_echo('save:address'),
					'id' => 'address-submit-button',
					));
			?>
</div>
			