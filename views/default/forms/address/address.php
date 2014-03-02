<?php
	/**
	 * Elgg socialcommerce address/address form
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
 	 **/

$selected_state = $vars['entity']->state? $vars['entity']->state : "" ;
$selected_country = $vars['entity']->country ? $vars['entity']->country : 'USA' ;

if($CONFIG->country){
			$options_values = array();
			foreach ($CONFIG->country as $country){
				$options_values[$country['iso3']] = $country['name'];
			}
	
		$country_list = elgg_view('input/dropdown', array(
													'name' => 'currency_country',
													'id' => 'country',
													'value' => $selected_country,
													'options_values' => $options_values,
													));

			if($selected_country){
				$states = get_state_by_fields('iso3',$selected_country);
				if(!empty($states)){
					$options_values = array();
					foreach ($states as $state){
						$options_values[$state->abbrv] = $state->name;
					}
					$state_list = elgg_view('input/dropdown', array(
													'name' => 'state',
													'id' => 'state',
													'value' => $selected_state,
													'options_values' => $options_values,
													));
				}else{
					$state_list = '<input class="input-text" type="text" value="'.$selected_state.'" id="'.$type.'_state" name="state"/>';
				}
			}
			
		}else {
			$country_list = '<input class="input-text" type="text" value="'.$selected_country.'" id="'.$type.'_country" name="country"/>';
		}
	 
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
<div id="state_list">
			<?php echo $state_list; ?>
</div>
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
			<?php echo $country_list; ?>
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
			