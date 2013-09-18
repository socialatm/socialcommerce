<?php
	/**
	 * Elgg view - shipping detais
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;

	if(
	
	$address = elgg_get_entities(array( 	
		'type' => 'object',
		'subtype' => 'address',
		'owner_guid' => elgg_get_page_owner_guid(),
		)) 			
	){
	
		if($_SESSION['CHECKOUT']['shipping_address'])
			$selected_address = $_SESSION['CHECKOUT']['shipping_address']->guid;
		$exist = elgg_echo('shipping:address:exist');
		$exist_address = elgg_view("socialcommerce/list_address",array('entity'=>$address,'display'=>'list','selected'=>$selected_address,'type'=>'shipping'));
		
		$new = elgg_echo('shipping:address:new');
		$address_add = elgg_view("socialcommerce/forms/checkout_edit_address",array('ajax'=>1,'type'=>'shipping'));
		
		$submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('shipping:address')));
		$action = $CONFIG->checkout_base_url."socialcommerce/".$_SESSION['user']->username."/checkout_process/";
		$address_details = <<<EOF
			<div>
				<form method="post" action="{$action}" onsubmit="return validate_shipping_details();">
					<div style="margin-bottom:10px;">
						<input id="shipping_address_exist" name="shipping_address_type" checked="checked" type="radio" value="existing" onclick="toggle_address_type('shipping','select');"/> {$exist}
						<div class="select_shipping_address">
							{$exist_address}
						</div>
					</div>
					<div>
						<input id="shipping_address_new" name="shipping_address_type" type="radio" value="add" onclick="toggle_address_type('shipping','add');"/> {$new}
						<div class="add_shipping_address" style="display:none;">
							{$address_add}
						</div>
					</div>
					<div>
						{$submit_input}
						<input type="hidden" id="checkout_order" name="checkout_order" value="1">
					</div>
				</form>
			</div>
EOF;
	}else{
		$address_details = elgg_view("socialcommerce/forms/checkout_edit_address",array('ajax'=>1,'type'=>'shipping'));
	}
	echo $address_details;
?>
