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
echo $content;
