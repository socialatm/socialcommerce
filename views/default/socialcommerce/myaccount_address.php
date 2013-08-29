<?php
	/**
	 * Elgg view - my account address
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	
	if(
	
	$address = elgg_get_entities(array( 	
		'type' => 'object',
		'subtype' => 'address',
		'owner_guid' => page_owner(),
		)) 			
	){

 		$list_address = elgg_view("{$CONFIG->pluginname}/list_address",array('entity'=>$address,'display'=>'list_with_action','selected'=>$selected_address,'type'=>'myaccount'));
		$body = <<<EOF
			<div>
				<div style="float:right;margin-bottom:10px;">
					<div class="buttonwrapper" style="float:left;">
						<a onclick="add_myaddress();" class="squarebutton"><span> Add New Address </span></a>
					</div>
				</div>
				<div class="clear" style="margin-bottom:10px;">
					{$list_address}
				</div>
			</div>
EOF;
	}else{
		$body = elgg_view("{$CONFIG->pluginname}/forms/checkout_edit_address",array('ajax'=>1,'type'=>'myaccount','first'=>1));
	}
	$delete_confirm_msg = elgg_echo('delete:confirm:address');
	$load_action = $CONFIG->checkout_base_url."pg/".$CONFIG->pluginname."/".$_SESSION['user']->username."/view_address"; 
	$delete_action = $CONFIG->checkout_base_url."action/".$CONFIG->pluginname."/delete_address";
	$area2 = <<<EOF
		<script>
			function add_myaddress(){
				$("#myaccount_address").load("{$load_action}", { 
					u_guid: {$_SESSION['user']->guid},
					todo:'add_myaddress'
				});
			}
			function edit_myaddress(guid){
				$("#myaccount_address").load("{$load_action}", { 
					u_guid: {$_SESSION['user']->guid},
					a_id: guid,
					todo:'edit_myaddress'
				});
			}
			function myaccount_cancel_address(){
				$("#myaccount_address").load("{$load_action}", { 
					todo:'reload_myaccount_address',
					u_guid: {$_SESSION['user']->guid}
				});
			}
			function delete_myaddress(guid){
				var elgg_token = $('[name=__elgg_token]');
				var elgg_ts = $('[name=__elgg_ts]');
				if(confirm('{$delete_confirm_msg}')){
					$.post("{$delete_action}", {
						u_guid: {$_SESSION['user']->guid},
						a_id: guid,
						ajax: 1,
						__elgg_token: elgg_token.val(),
						__elgg_ts: elgg_ts.val()
					},
					function(data){
						if(data > 0){
							$("#myaccount_address").load("{$load_action}", { 
								u_guid: {$_SESSION['user']->guid},
								todo:'reload_myaccount_address'
							});
						}else{
							alert(data);
						}
					});
				}
			}
		</script>
		<div class="basic checkout_process">
			<div class="content">
				<div id="myaccount_address">
					{$body}
				</div>
			</div>
		</div>			
EOF;
	
	echo $area2;
?>