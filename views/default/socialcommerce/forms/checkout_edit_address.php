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
	$ajax = $vars['ajax'];
	$type = $vars['type'];
	$first = $vars['first'];
	
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
		$action = "socialcommerce/add_address";
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

	    /*$title_label = elgg_echo('title');
        $title_textbox = elgg_view('input/text', array('name' => 'title', 'value' => $title));*/
        
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
			$pincode_label_none = elgg_echo('pincode:none');
			$mobno_label_none = elgg_echo('mob:no:none');
			$address_post_url =  elgg_get_config('url').'action/'.$action;
			$address_reload_url = elgg_get_config('url').'socialcommerce/'.$user->username.'/view_address';
			
			
	$script = <<<EOF
				<script>
/*****	country/state dropdown	*****/

// alert($(".country").val());
				
$("#country").change(function () {
    var country = $(this).val();
//	alert(country);
    var url = elgg.config.wwwroot + "ajax/view/socialcommerce/change_country_state";
    $.post(url, {
        selected_country: country
    })
        .done(function (data) {
		
		alert(data);
		
		
        $("#state").empty().html(data);
    });
});

/*****	end country/state dropdown	*****/
				
	var time_out;
	
	function {$type}_save_address(){
						var type = '{$type}';
						var u_guid = '{$_SESSION['user']->guid}';
						var first_name = $('#'+type+'_first_name').val();
						var last_name = $('#'+type+'_last_name').val();
						var address_line_1 = $('#'+type+'_address_line_1').val();
						var address_line_2 = $('#'+type+'_address_line_2').val();
						var city = $('#'+type+'_city').val();
						var state = $('#'+type+'_state').val();
						var country = $('#'+type+'_country').val();
						var pincode = $('#'+type+'_pincode').val();
						var mobileno = $('#'+type+'_mobileno').val();
						var phoneno = $('#'+type+'_phoneno').val();
						var address_guid = $('#'+type+'_address_guid').val();
						var elgg_token = $('[name=__elgg_token]');
						var elgg_ts = $('[name=__elgg_ts]');
						
						
						if($.trim(first_name) == ""){
							alert("{$fnaem_label_none}");
							$('#'+type+'_first_name').focus();
							return false;
						}
						if($.trim(last_name) == ""){
							alert("{$lname_label_none}");
							$('#'+type+'_last_name').focus();
							return false;
						}
						if($.trim(address_line_1) == ""){
							alert("{$address_line_1_label_none}");
							$('#'+type+'_address_line_1').focus();
							return false;
						}
					
						if($.trim(city) == ""){
							alert("{$city_label_none}");
							$('#'+type+'_city').focus();
							return false;
						}
						if($.trim(state) == ""){
							alert("{$state_label_none}");
							$('#'+type+'_state').focus();
							return false;
						}
						if($.trim(country) == ""){
							alert("{$country_label_none}");
							$('#'+type+'_country').focus();
							return false;
						}
						if($.trim(pincode) == ""){
							alert("{$pincode_label_none}");
							$('#'+type+'_pincode').focus();
							return false;
						}
					
							
						var window_width = $(document).width();
						var window_height = $(document).height();
						var scroll_pos = (document.all)?document.body.scrollTop:window.pageYOffset;
						scroll_pos = scroll_pos  + 300;
						$("#load_action").show();
						$("#load_action").css({'width':window_width+'px','height':window_height+'px'});
						$("#load_action_div").css("top",scroll_pos+"px");
						$("#load_action_div").css({'width':window_width+'px'});
						$("#load_action_div").show();
					
						
												
						var urls="{$address_post_url}";
						var paramdata="first_name="+first_name+"&last_name="+last_name+"&address_line_1="+address_line_1+"&address_line_2="+address_line_2+"&city="+city+"&country="+country+"&state="+state+"&pincode="+pincode+"&mobileno="+mobileno+"&phoneno="+phoneno+"&address_guid="+address_guid+"&u_guid="+u_guid+"&ajax=1"+"&__elgg_token="+elgg_token.val()+"&__elgg_ts="+elgg_ts.val();
						$.ajax({
						   type: "POST",
						   url: urls,
						   data:paramdata,
						   success: function(data){
								if(data > 0){
												$("#{$type}_address").load("{$address_reload_url}", {guid: data,u_guid: u_guid,type:'{$type}',todo:'{$todo}'});
											}else{
												alert(data);
											}
									$("#load_action").hide();
									$("#load_action_div").hide();
								}
						});
						
						/*
						$.post("{$address_post_url}", {
							first_name: first_name,
							last_name: last_name,
							address_line_1: address_line_1,
							address_line_2: address_line_2,
							city: city,
							state: state,
							country: country,
							pincode: pincode,
							mobileno: mobileno,
							phoneno: phoneno,
							address_guid: address_guid,
							u_guid: u_guid,
							ajax:1,
							__elgg_token: elgg_token.val(),
							__elgg_ts: elgg_ts.val()
						},
						function(data){
							if(data > 0){
								$("#{$type}_address").load("{$address_reload_url}", {guid: data,u_guid: u_guid,type:'{$type}',todo:'{$todo}'});
							}else{
								alert(data);
							}
							$("#load_action").hide();
							$("#load_action_div").hide();
						});
						return false;
						*/
	}
					
				</script>
EOF;
		}else{
			$javascript = "";
		}
		$form_body = <<<EOT
			{$script}
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

$body_vars = array('state_list' => $state_list, 'country_list' => $country_list );
$new_form = elgg_view_form('socialcommerce/address/save', $form_vars, $body_vars);

// echo $form_body.$new_form;

echo $new_form.$script;
