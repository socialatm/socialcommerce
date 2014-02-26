<?php
	/**
	 * Elgg view - billing details
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
echo '<b>'. __FILE__ .' at '.__LINE__.'</b>'; 	
	require_once('C:/Program Files (x86)/Zend/Apache2/htdocs/krumo/class.krumo.php');
	
	$page_owner = elgg_get_logged_in_user_entity();
	
	if(

	$address = elgg_get_entities_from_metadata(array(
								'metadata_name_value_pair' => array('name' => 'billing', 'value' =>  1),
								'type_subtype_pairs' => array('object' => 'address'),
								'owner_guid' => elgg_get_page_owner_guid(),
								))
	){

	
//  krumo($_SESSION['CHECKOUT']['billing_address']);   die();


		if($address) { $selected_address = $address->guid; }
		
		$exist = elgg_echo('billing:address:exist');
		$exist_address = elgg_view("socialcommerce/list_address",array('entity'=>$address,'display'=>'list','selected'=>$selected_address,'type'=>'billing'));
		
		$new = elgg_echo('billing:address:new');
		
		$body_vars = array('type' => 'billing'); 
		$address_add = elgg_view_form("address/address", $form_vars, $body_vars);
		
		$submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('billing:address')));
		$action = $CONFIG->url."socialcommerce/".$page_owner->username."/checkout_process_new/";
		
		$address_details = <<<EOF
			<div>
				<form method="post" action="{$action}" onsubmit="return validate_billing_details();">
					<div style="margin-bottom:10px;">
						<input id="billing_address_exist" name="billing_address_type" checked="checked" type="radio" value="existing" onclick="toggle_address_type('billing','select');"/> {$exist}
						<div class="select_billing_address">
							{$exist_address}
						</div>
					</div>
					<div>
						<input id="billing_address_new" name="billing_address_type" type="radio" value="add" onclick="toggle_address_type('billing','add');"/> {$new}
						<div class="add_billing_address" style="display:none;">
							{$address_add}
						</div>
					</div>
					<div>
						{$submit_input}
						<input type="hidden" id="checkout_order" name="checkout_order" value="0">
					</div>
				</form>
			</div>
EOF;
	}else{
		$body_vars = array('type' => 'billing'); 
		$address_details = elgg_view_form("address/address", $form_vars, $body_vars);
	}
	echo $address_details;
?>
