<?php

$checkout_status = get_input('checkout_status');

switch ($checkout_status):

case 'billing':
	$_SESSION['CHECKOUT']['confirm_billing_address'] = 1;
		if($address_guid = get_input('billing_address_guid')){
			$selected_address = get_entity($address_guid);
				$_SESSION['CHECKOUT']['billing_address'] = (object) array(
					'guid'=>$selected_address->guid,
					'firstname'=>$selected_address->first_name,
					'lastname'=>$selected_address->last_name,
					'address_line_1'=>$selected_address->address_line_1,
					'address_line_2'=>$selected_address->address_line_2,
					'city'=>$selected_address->city,
					'state'=>$selected_address->state,
					'country'=>$selected_address->country,
					'pincode'=>$selected_address->pincode,
					'mobileno'=>$selected_address->mobileno,
					'phoneno'=>$selected_address->phoneno
				);
		}
	echo "Checkout Status is billing ";
	break;
case "shipping":
  echo "Your favorite color is blue!";
  break;
case "payment":
  echo "Your favorite color is green!";
  break;
case "confirmation":
  echo "Your favorite color is green!";
  break;
default:
  echo "Your favorite color is neither red, blue, or green!";
endswitch;