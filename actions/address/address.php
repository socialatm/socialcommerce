<?php
	/**
	 * Elgg address - add
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$page_owner = elgg_get_logged_in_user_entity();
	 
	// Get variables
	$firstname = trim(get_input('first_name'));
	$lastname = trim(get_input('last_name'));
	$address_line_1 = trim(get_input('address_line_1'));
	$address_line_2 = trim(get_input('address_line_2'));
	$city = trim(get_input('city'));
	$state = trim(get_input('state'));
	$country = trim(get_input('country'));
	$pincode = trim(get_input('pincode'));
	$phoneno = trim(get_input('phoneno'));
	$access_id = 0;								// ACCESS_PRIVATE . unless I see a reason why someone else would need access to your addresses...
	$billing = get_input('billing');
	$container_guid = (int) $page_owner->guid;
	
	//	start validation	@todo - validation could be better
	
	if(empty($firstname)){
		$error_field .= ", ".elgg_echo("first:name");
	}
	if(empty($lastname)){
		$error_field .= ", ".elgg_echo("last:name");
	}
	if(empty($address_line_1)){
		$error_field .= ", ".elgg_echo("address:line:1");
	}
	
	if(empty($city)){
		$error_field .= ", ".elgg_echo("city");
	}
	if(empty($state)){
		$error_field .= ", ".elgg_echo("state");
	}
	if(empty($country)){
		$error_field .= ", ".elgg_echo("country");
	}
	if(empty($pincode)){
		$error_field .= ", ".elgg_echo("pincode");
	}
	
	//	end validation
	
	if(!empty($error_field)){
		echo sprintf(elgg_echo("address:validation:null"),$error_field);	//	@todo - this could be better too
		
	}else{		//	no errors so lets save the address
	
		//	@todo - maybe should check for duplicate address before adding it.
		
		$address = new ElggObject();
		
		$address->subtype="address";
		$address->title = $firstname . " " . $lastname;
		$address->first_name = $firstname;
		$address->last_name = $lastname;
		$address->address_line_1 = $address_line_1;
		$address->address_line_2 = $address_line_2;
		$address->city = $city;
		$address->state = $state;
		$address->country = $country;
		$address->pincode = $pincode;
		if(!empty($phoneno)) { $address->phoneno = $phoneno; }
		$address->billing = $billing;
		$address->access_id = $access_id;
		$address->container_guid = $container_guid;
				
		$result = $address->save();
		
		if ($result){
			system_message(elgg_echo("address:saved"));
		}else{
			register_error(elgg_echo("address:addfailed"));
		}
	}
	
//	forward(REFERER);
	forward(elgg_get_config('url')."socialcommerce/" . $page_owner->username . "/checkout/");
