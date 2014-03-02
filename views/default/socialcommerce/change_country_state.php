<?php
	 /**
	* Elgg socialcommerce view - state dropdown for Country/State
	* 
	* @package Elgg SocialCommerce
	* @license http://www.gnu.org/licenses/gpl-2.0.html
    * @author twentyfiveautumn.com
	* @copyright twentyfiveautumn.com 2014
	* @link http://twentyfiveautumn.com/
	**/ 
	
$selected_country = get_input('selected_country');

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
		$state_list = '<input class="input-text" type="text" value="'.$selected_state.'" id="'.'state" name="state"/>';
	}
}
echo $state_list;
