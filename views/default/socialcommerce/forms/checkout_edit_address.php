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
	$selected_country = isset($vars['entity']->country) ? $vars['entity']->country : 'USA' ;

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
						'value' => $vars['entity']->state,
						'options_values' => $options_values
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
		
$body_vars = array('state_list' => $state_list, 'country_list' => $country_list );
if(isset($vars['entity'])){$body_vars['entity'] = $vars['entity']; }
$new_form = elgg_view_form('socialcommerce/address/save', $form_vars, $body_vars);

echo $new_form.$script;
