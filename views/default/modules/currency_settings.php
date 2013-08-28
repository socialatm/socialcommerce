<?php
	/**
	 * Elgg modules - currency methods
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	//$socialcommerce_settings = $vars['entity'];
	$ajax = $vars['ajax'];
	
	// @todo - what about this 9999 limit??
	$currency_settings = elgg_get_entities(array( 	
		'type' => 'object',
		'subtype' => 's_currency',
		'owner_guid' => 0,
		'order_by' => '',
		'limit' => 9999,
		)); 			
		
	if($currency_settings){
		$body = elgg_view('modules/currency/list_settings',array('entity'=>$currency_settings));
	}else{
		$body = '<div style="text-align:center;padding:5px 0 10px 0;"><B>'.elgg_echo('add:default:currency').'</B></div>';
		$body .= elgg_view('modules/currency/settings_form',array('status'=>'default'));
	}
	$action = $CONFIG->wwwroot."action/".$CONFIG->pluginname."/manage_socialcommerce";
	$load_action = $CONFIG->wwwroot."pg/".$CONFIG->pluginname."/".$_SESSION['user']->username."/currency_settings";
	
	if($ajax){
		echo $body;
	}else{
?>
		<script>
			function save_currency_settings(){
				var guid = $('[name=guid]');
				var m_action = $('#manage_action');
				var c_name = $('[name=currency_name]');
				var c_country = $('[name=currency_country]');
				var c_code = $('[name=currency_code]');
				var e_rate = $('[name=exchange_rate]');
				var c_token = $('[name=currency_token]');
				var t_location = $('[name=token_location]');
				var d_token = $('[name=decimal_token]');
				var set_def = $('[name=set_default]');
				var elgg_token = $('[name=__elgg_token]');
				var elgg_ts = $('[name=__elgg_ts]');
				if(guid.val() > 0){
					guid = guid.val();
				}else{
					guid = 0;
				}
				if($.trim(c_name.val()) == ""){
					alert('Please enter a currency name.');
					c_name.focus();
					return false;
				}
				
				if($.trim(c_country.val()) == ""){
					alert('Please enter a currency Country.');
					c_country.focus();
					return false;
				}
				
				if($.trim(c_code.val()) == ""){
					alert('Please enter a currency code.');
					c_code.focus();
					return false;
				}
				
				if($.trim(e_rate.val()) == ""){
					alert('Please enter an exchange rate for this currency.');
					e_rate.focus();
					return false;
				}else{
					var regex = /^((\d+(\.\d*)?)|((\d*\.)?\d+))$/;
					if(!regex.test(e_rate.val())){
						alert("Please enter a valid exchange rate. The exchange rate must be a decimal number.");
						e_rate.focus();
						return false;
					}	
				}
				
				if($.trim(c_token.val()) == ""){
					alert('Please enter a currency Sign.');
					c_token.focus();
					return false;
				}
				
				if($.trim(t_location.val()) == ""){
					alert('Please enter the Sign Location.');
					t_location.focus();
					return false;
				}
				
				if($.trim(d_token.val()) == ""){
					alert('Please enter the Decimal Places.');
					d_token.focus();
					return false;
				}else{
					var regex = /^\d+$/;
					if(!regex.test(d_token.val())){
						alert('Please enter a vlid Decimal Places. The Decimal Places must be a number.');
						d_token.focus();
						return false;
					}
				}
				
				$.post("<?php echo $action; ?>", {
					guid: guid,
					u_id: <?php echo $_SESSION['user']->guid; ?>,
					c_name: c_name.val(),
					manage_action: m_action.val(),
					c_country: c_country.val(),
					c_code: c_code.val(),
					e_rate: e_rate.val(),
					c_token: c_token.val(),
					t_location: t_location.val(),
					d_token: d_token.val(),
					set_def: set_def.val(),
					__elgg_token: elgg_token.val(),
					__elgg_ts: elgg_ts.val()
				},
				function(data){
					if(data > 0){
						$("#currency_settings").load("<?php echo $load_action; ?>", { 
							u_id: <?php echo $_SESSION['user']->guid; ?>,
							todo:'currency_settings'
						});
					}else{
						alert(data);
					}
				});
			}
			function add_currency(){
				$("#currency_settings").load("<?php echo $load_action; ?>", { 
					u_id: <?php echo $_SESSION['user']->guid; ?>,
					todo:'settings_form'
				});
			}
			function cancel_currency_settings(){
				$("#currency_settings").load("<?php echo $load_action; ?>", { 
					u_id: <?php echo $_SESSION['user']->guid; ?>,
					todo:'currency_settings'
				});
			}
			function edit_currency(c_guid){
				$("#currency_settings").load("<?php echo $load_action; ?>", { 
					u_id: <?php echo $_SESSION['user']->guid; ?>,
					c_id: c_guid,
					todo:'edit_settings'
				});
			}
			function delete_currency(c_guid){
				var elgg_token = $('[name=__elgg_token]');
				var elgg_ts = $('[name=__elgg_ts]');
				$.post("<?php echo $action; ?>", {
					u_id: <?php echo $_SESSION['user']->guid; ?>,
					c_id: c_guid,
					__elgg_token: elgg_token.val(),
					__elgg_ts: elgg_ts.val(),
					manage_action:'delete_currency'
				},
				function(data){
					if(data > 0){
						$("#currency_settings").load("<?php echo $load_action; ?>", { 
							u_id: <?php echo $_SESSION['user']->guid; ?>,
							todo:'currency_settings'
						});
					}else{
						alert(data);
					}
				});
			}
			function set_default_currency(c_guid){
				var elgg_token = $('[name=__elgg_token]');
				var elgg_ts = $('[name=__elgg_ts]');
				$.post("<?php echo $action; ?>", {
					u_id: <?php echo $_SESSION['user']->guid; ?>,
					c_id: c_guid,
					__elgg_token: elgg_token.val(),
					__elgg_ts: elgg_ts.val(),
					manage_action:'set_default_currency'
				},
				function(data){
					if(data > 0){
						$("#currency_settings").load("<?php echo $load_action; ?>", { 
							u_id: <?php echo $_SESSION['user']->guid; ?>,
							todo:'currency_settings'
						});
					}else{
						alert(data);
					}
				});
			}
			function get_exchange_rate(){
				var c_code = 'USD';
				var e_rate = $('[name=exchange_rate]');
				var elgg_token = $('[name=__elgg_token]');
				var elgg_ts = $('[name=__elgg_ts]');
				$("#run_exchange_rate").css("display","block");
				$.post("<?php echo $action; ?>", {
					u_id: <?php echo $_SESSION['user']->guid; ?>,
					c_code: c_code,
					__elgg_token: elgg_token.val(),
					__elgg_ts: elgg_ts.val(),
					manage_action:'get_exchange_rate'
				},
				function(data){
					$("#run_exchange_rate").css("display","none");
					if(data >= 0){
						e_rate.val(data);
					}else{
						alert(data);
					}
				});
			}
		</script>
		<div id="currency_settings" class="currency_settings basic">
			<?php echo $body; ?>
		</div>
<?php
	}
?>