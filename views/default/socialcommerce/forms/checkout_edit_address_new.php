<?php
   /**
	* Elgg address - edit form
	* 
	* @package Elgg SocialCommerce
	* @license http://www.gnu.org/licenses/gpl-2.0.html
	* @author twentyfiveautumn.com
	* @copyright twentyfiveautumn.com 2013
	* @link http://twentyfiveautumn.com/
	**/ 
	
	require_once('C:/Program Files (x86)/Zend/Apache2/htdocs/krumo/class.krumo.php');
	
//	krumo($vars); die();
	
	$type = $vars['type'];
	$first = $vars['first'];
	// Set title, form destination
		if (isset($vars['entity'])) {
			$action = "socialcommerce/edit_address";
			$firstname = $vars['entity']->first_name;
			$lastname = $vars['entity']->last_name;
			$address_line_1 = $vars['entity']->address_line_1;
			$address_line_2 = $vars['entity']->address_line_2;
			$city = $vars['entity']->city;
			$selected_state = $vars['entity']->state;
			$selected_country = $vars['entity']->country;
			$pincode = $vars['entity']->pincode;
			$mobileno = $vars['entity']->mobileno;
			$phoneno = $vars['entity']->phoneno;
			$access_id = $vars['entity']->access_id;
		} else {
			$action = "socialcommerce/add_address_new";
			$firstname = "";
			$lastname = "";
			$address_line_1 = "";
			$address_line_2 = "";
			$city = "";
			$selected_state = "";
			$selected_country = "USA";
			$pincode = "";
			$mobileno = "";
			$phoneno = "";
			$access_id = 0;
		}

	// Just in case we have some cached details
		if (isset($vars['address'])) {
			$firstname = $vars['address']['first_name'];
			$lastname = $vars['address']['last_name'];
			$address_line_1 = $vars['address']['address_line_1'];
			$address_line_2 = $vars['address']['address_line_2'];
			$city = $vars['address']['city'];
			$selected_state = $vars['address']['state'];
			$selected_country = $vars['address']['country'];
			$pincode = $vars['address']['pincode'];
			$mobileno = $vars['address']['mobileno'];
			$phoneno = $vars['address']['phoneno'];
			$access_id = $vars['address']['access_id'];
		}

                
        $fnaem_label = elgg_echo('first:name');
        $lname_label = elgg_echo('last:name');
        $address_line_1_label = elgg_echo('address:line:1');
        $address_line_2_label = elgg_echo('address:line:2');
        $city_label = elgg_echo('city');
        $state_label = elgg_echo('state');
        $country_label = elgg_echo('country');
        $pincode_label = elgg_echo('pincode');
        $mobno_label = elgg_echo('mob:no');
        $phoneno_label = elgg_echo('phone:no');
       
        $submit_input = elgg_echo('save');

        if (isset($vars['container_guid']))
			$entity_hidden = '<input type="hidden" name="container_guid" value="'.$vars['container_guid'].'" />';
		if (isset($vars['entity']))
			$entity_hidden .= "<input type=\"hidden\" id=\"{$type}_address_guid\" name=\"address_guid\" value=\"{$vars['entity']->getGUID()}\" />";
		$entity_hidden .= elgg_view('input/securitytoken');
		if($CONFIG->country){
			$country_list = '<select onkeyup="find_state(\''.$type.'\')"  onkeydown="find_state(\''.$type.'\')" onchange="find_state(\''.$type.'\')" name="currency_country" id="'.$type.'_country" class="input-text">';
			foreach ($CONFIG->country as $country){
				if($selected_country == $country['iso3']){
					$selected = "selected";
				}else{
					$selected = "";
				}
				$country_list .= "<option value='".$country['iso3']."' ".$selected.">".$country['name']."</option>";
			}
			$country_list .= "</select>";
			if($selected_country){
				$states = get_state_by_fields('iso3',$selected_country);
				if(!empty($states)){
					$state_list = '<select name="state" id="'.$type.'_state" class="input-text">';
					foreach ($states as $state){
						if($selected_state == $state->name){
							$selected = "selected";
						}else{
							$selected = "";
						}
						$state_list .= "<option value='" . $state->name . "' " . $selected . ">" . $state->name . "</option>";
					}
					$state_list .= '</select>';
				}else{
					$state_list = '<input class="input-text" type="text" value="'.$selected_state.'" id="'.$type.'_state" name="state"/>';
				}
			}
		}else {
			$country_list = '<input class="input-text" type="text" value="'.$selected_country.'" id="'.$type.'_country" name="country"/>';
		}
		
	$form_body = elgg_view_form($action);
		
		$form_body .= <<<EOT
			{$script}<br />
			<div class="address_form">
				<table>
	        	 	<tr>
						<td><label><span style="color:red">*</span> $fnaem_label</label></td>
						<td>:</td>
			            <td><input class="input-text" type="text" value="{$firstname}" id="{$type}_first_name" name="first_name"/></td>
					</tr>
					<tr>
						<td><label><span style="color:red">*</span> $lname_label</label></td>
						<td>:</td>
						<td><input class="input-text" type="text" value="{$lastname}" id="{$type}_last_name" name="last_name"/></td>
					</tr>
					<tr>
						<td><label><span style="color:red">*</span> $address_line_1_label</label></td>
						<td>:</td>
						<td><input class="input-text" type="text" value="{$address_line_1}" id="{$type}_address_line_1" name="address_line_1"/></td>
					</tr>
					<tr>
						<td><label>&nbsp; $address_line_2_label</label></td>
						<td>:</td>
						<td><input class="input-text" type="text" value="{$address_line_2}" id="{$type}_address_line_2" name="address_line_2"/></td>
					</tr>
					<tr>
						<td><label><span style="color:red">*</span> $city_label</label></td>
						<td>:</td>
						<td><input class="input-text" type="text" value="{$city}" id="{$type}_city" name="city"/></td>
					</tr>
					<tr>
						<td><label><span style="color:red">*</span> $country_label</label></td>
						<td>:</td>
						<td>
							{$country_list}
						</td>
					</tr>
					<tr>
						<td><label><span style="color:red">*</span> $state_label</label></td>
						<td>:</td>
						<td>
							<div id="{$type}_state_list">
								{$state_list}
							</div>
						</td>
					</tr>
					<tr>
						<td><label><span style="color:red">*</span> $pincode_label</label></td>
						<td>:</td>
						<td><input class="input-text" type="text" value="{$pincode}" id="{$type}_pincode" name="pincode"/></td>
					</tr>
					<tr>
						<td><label>&nbsp;  $mobno_label</label></td>
						<td>:</td>
						<td><input class="input-text" type="text" value="{$mobileno}" id="{$type}_mobileno" name="mobileno"/></td>
					</tr>
					<tr>
						<td><label> &nbsp; $phoneno_label</label></td>
						<td>:</td>
						<td><input class="input-text" type="text" value="{$phoneno}" id="{$type}_phoneno" name="phoneno"/></td>
					</tr>
					<tr>
						<td colspan="2"></td>
						<td style="text-align:center">
							$entity_hidden
							<div>
								<div class="buttonwrapper" style="float:left;">
									<a onclick="{$type}_save_address();" class="elgg-button elgg-button-submit">{$submit_input}</a>
								</div>
								{$cancel_btn}
							</div>
						</td>
					</tr>
				</table>
			</div>
EOT;
echo $form_body;
?>
