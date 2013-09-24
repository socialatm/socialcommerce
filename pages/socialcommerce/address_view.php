<?php
	/**
	 * Elgg address - view and reload addresses
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	$type = get_input('type');
	$check_order = $type == "shipping" ? 1 : 0;
	$todo = get_input('todo');
	
	switch ($todo){
		case 'reload_checkout_address':
			$added_address = get_input('guid');
			$page_owner = get_input('u_guid');
			if(!$page_owner)
				$page_owner = elgg_get_page_owner_guid();
				
			if(
			
			$address = elgg_get_entities(array( 	
				'type' => 'object',
				'subtype' => 'adress',
				'owner_guid' => $page_owner,
				)) 			
						
			){
			
				$exist = elgg_echo($type.':address:exist');
				$exist_address = elgg_view("socialcommerce/list_address",array('entity'=>$address,'display'=>'list','selected'=>$added_address,'type'=>$type));
				
				$new = elgg_echo($type.':address:new');
				$address_add = elgg_view("socialcommerce/forms/checkout_edit_address",array('ajax'=>1,'type'=>$type));
				
				$submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo($type.':address')));
				$action = $CONFIG->url."socialcommerce/".$_SESSION['user']->username."/checkout_process/";
				$address_details = <<<EOF
					<div>
						<form method="post" action="{$action}" onsubmit="return validate_{$type}_details();">
							<div style="margin-bottom:10px;">
								<input id="{$type}_address_exist" name="{$type}_address_type" checked="checked" type="radio" value="existing" onclick="toggle_address_type('{$type}','select');"/> {$exist}
								<div class="select_{$type}_address">
									{$exist_address}
								</div>
							</div>
							<div>
								<input id="{$type}_address_new" name="{$type}_address_type" type="radio" value="add" onclick="toggle_address_type('{$type}','add');"/> {$new}
								<div class="add_{$type}_address" style="display:none;">
									{$address_add}
								</div>
							</div>
							<div>
								{$submit_input}
								<input type="hidden" id="checkout_order" name="checkout_order" value="{$checkout_order}">
							</div>
						</form>
				</div>
EOF;
			}else{
				$address_details = elgg_view("socialcommerce/forms/edit_address", array('ajax' => 1, 'type' => $type ));
			}
			echo $address_details;
			break;
		case 'load_state':
			$country = get_input('country');
			$states = get_state_by_fields('iso3',$country);
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
			echo $state_list;
			break;
		case 'add_myaddress':
			$body = elgg_view("socialcommerce/forms/checkout_edit_address",array('ajax'=>1,'type'=>'myaccount'));
			echo $body;
			break;
		case 'reload_myaccount_address':
			$user_guid = get_input('u_guid');
			if(
			
				$address = elgg_get_entities(array( 	
					'type' => 'object',
					'subtype' => 'address',
					'owner_guid' => $user_guid,
					)) 			
							
			){
				$list_address = elgg_view("socialcommerce/list_address", array('entity'=>$address, 'display' => 'list_with_action', 'selected' => $selected_address, 'type' => 'myaccount' ));
				$load_action = $CONFIG->url."socialcommerce/".$_SESSION['user']->username."/view_address"; 
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
				$body = elgg_view("socialcommerce/forms/checkout_edit_address", array('ajax' => 1, 'type' => 'myaccount', 'first' => 1 ));
			}
			echo $body;
			break;
		case 'edit_myaddress':
			$address_guid = get_input('a_id');
			if($address_guid){
				$address = get_entity($address_guid);
				if($address){
					$body = elgg_view("socialcommerce/forms/checkout_edit_address",array('entity'=>$address,'ajax'=>1,'type'=>'myaccount'));
				}else{
					$edit_address_not_posible = elgg_echo('address:edit:not:posible');
					$body = <<<EOF
						<div style="margin:10px;">
							<div>{$edit_address_not_posible}</div>
							<div style="margin:10px;">
								<div class="buttonwrapper" style="float:left;">
									<a onclick="myaccount_cancel_address();" class="squarebutton"><span> Cancel </span></a>
								</div>
								<div class="clear"></div>
							</div>
						</div>
EOF;
				}
			}
			echo $body;
			break;
	}
?>
