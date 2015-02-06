<?php
	/**
	 * Elgg view - my account address
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	
	$user = elgg_get_logged_in_user_entity();
	$user_guid = $user->guid;
	$address = elgg_get_entities(array( 	
		'type' => 'object',
		'subtype' => 'address',
		'owner_guid' => $user->guid
		));
	
	$delete_confirm_msg = elgg_echo('delete:confirm:address');
	$load_action = elgg_get_config('url').'socialcommerce/'.$user->username.'/view_address'; 
	$delete_action = elgg_get_config('url').'action/socialcommerce/delete_address';
		 
	if($address){ 
 		$list_address = elgg_view("socialcommerce/list_address", array('entity'=>$address, 'display'=>'list_with_action', 'selected'=>$selected_address, 'type'=>'myaccount' ));
		$content = <<<EOF
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
		$content = elgg_view("socialcommerce/forms/checkout_edit_address", array('ajax'=>1,'type'=>'myaccount','first'=>1 ));
	}
	
	
	$content = <<<EOF
		<script>
			function add_myaddress(){
				$("#myaccount_address").load("{$load_action}", { 
					u_guid: {$user->guid},
					todo:'add_myaddress'
				});
			}
			function edit_myaddress(guid){
				$("#myaccount_address").load("{$load_action}", { 
					u_guid: {$user_guid},
					a_id: guid,
					todo:'edit_myaddress'
				});
			}
			function myaccount_cancel_address(){
				$("#myaccount_address").load("{$load_action}", { 
					todo:'reload_myaccount_address',
					u_guid: {$user_guid}
				});
			}
			function delete_myaddress(guid){
				var elgg_token = $('[name=__elgg_token]');
				var elgg_ts = $('[name=__elgg_ts]');
				if(confirm('{$delete_confirm_msg}')){
					$.post("{$delete_action}", {
						u_guid: {$user_guid},
						a_id: guid,
						ajax: 1,
						__elgg_token: elgg_token.val(),
						__elgg_ts: elgg_ts.val()
					},
					function(data){
						if(data > 0){
							$("#myaccount_address").load("{$load_action}", { 
								u_guid: {$user_guid},
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
					{$content}
				</div>
			</div>
		</div>			
EOF;
	echo $content;
