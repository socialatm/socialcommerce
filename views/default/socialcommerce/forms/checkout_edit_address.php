<?php
   /**
	* Elgg address - edit form
	* 
	* @package Elgg SocialCommerce
	* @license http://www.gnu.org/licenses/gpl-2.0.html
	* @author ray peaslee
	* @copyright twentyfiveautumn.com 2015
	* @link http://twentyfiveautumn.com/
	* @version elgg 1.9.4
	**/ 
	
	
	
	$user = elgg_get_logged_in_user_entity();
		
	require_once('C:/Program Files (x86)/Zend/Apache2/htdocs/krumo/class.krumo.php');
$arr2 = get_defined_vars();
krumo($arr2);
die();
	
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
		$phoneno = $vars['entity']->phoneno;
		$access_id = $vars['entity']->access_id;
	} else {
		$action = "socialcommerce/add_address";
		$firstname = "";
		$lastname = "";
		$address_line_1 = "";
		$address_line_2 = "";
		$city = "";
		$selected_state = "";
		$selected_country = "USA";
		$pincode = "";
		$phoneno = "";
		$access_id = 0;
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

	$countries = elgg_get_config('country');
	if($countries){
		$options_values = array();
		foreach ($countries as $country){
			$options_values[$country['iso3']] = $country['name'];
		}

		$country_list = elgg_view('input/dropdown', array(
			'name' => 'country',
			'id' => 'country',
			'value' => $selected_country,
			'options_values' => $options_values,
			'class' => 'country'
			));

			if($selected_country){
				$states = get_state_by_fields('iso3', $selected_country );
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
					$state_list = elgg_view('input/text', array(
						'name' => 'state',
						'id' => 'state',
						'value' => $selected_state,
						'class' => ''
						));
				}
			}
			
	}else {
		$country_list = elgg_view('input/text', array(
			'name' => 'country',
			'id' => 'country',
			'value' => $selected_country,
			'class' => ''
			));
	}
			
		if($ajax == 1){
			$todo = ($type == 'myaccount') ? 'reload_myaccount_address' : 'reload_checkout_address';
						
			if(!$first && $type == 'myaccount'){
				$cancel_btn = '<div class="buttonwrapper" style="float:left;">';
				$cancel_btn .= '<a onclick="'.$type.'_cancel_address();" class="squarebutton"><span> Cancel </span></a>';
				$cancel_btn .= '</div>';
			}
			
			$javascript = "onsubmit='return save_address()'";
			$fnaem_label_none = elgg_echo('first:name:none');
			$lname_label_none = elgg_echo('last:name:none');
			$address_line_1_label_none = elgg_echo('address:line:1:none');
			$address_line_2_label_none = elgg_echo('address:line:2:none');
			$city_label_none = elgg_echo('city:none');
			$state_label_none = elgg_echo('state:none');
			$country_label_none = elgg_echo('country:none');
			$pincode_label_none = elgg_echo('postal:code:none');
			$mobno_label_none = elgg_echo('mob:no:none');
			$address_post_url =  elgg_get_config('url').'action/'.$action;
			$address_reload_url = elgg_get_config('url').'socialcommerce/'.$user->username.'/view_address';
			
			
$script = <<<EOF

	<script>
		//	country/state dropdown
		$("#country").change(function () {
		var country = $(this).val();
		var url = elgg.config.wwwroot + "ajax/view/socialcommerce/change_country_state";
		$.post(url, {
			selected_country: country
		})
        .done(function (data) {
			$("#state").empty().html(data);
			});
		});
	</script>
EOF;
		}else{
			$javascript = "";
		}
$body_vars = array('state_list' => $state_list, 'country_list' => $country_list );
$new_form = elgg_view_form('socialcommerce/address/save', $form_vars, $body_vars);

echo $new_form.$script;
