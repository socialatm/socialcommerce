<?php
	/**
	 * Elgg address - edit action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	global $CONFIG;
	
	// Get variables
	//$title = trim(get_input('title'));
	$firstname = trim(get_input('first_name'));
	$lastname = trim(get_input('last_name'));
	$address_line_1 = trim(get_input('address_line_1'));
	$address_line_2 = trim(get_input('address_line_2'));
	$city = trim(get_input('city'));
	$state = trim(get_input('state'));
	$country = trim(get_input('country'));
	$pincode = trim(get_input('pincode'));
	$mobileno = trim(get_input('mobileno'));
	$phoneno = trim(get_input('phoneno'));
	$access_id = get_input('access_id');
	$ajax = get_input('ajax');
	
	$guid = (int) get_input('address_guid');
	$container_guid = (int) get_input('container_guid', 0);
	if (!$container_guid){
		$container_guid = $_SESSION['user']->getGUID();
	}
	$container_user = get_entity($container_guid);
	/*if(empty($title)){
		$error_field = ", ".elgg_echo("title");
	}*/
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
	if(!empty($error_field)){
		if(!$ajax){
			//$_SESSION['address']['title'] = $title;
			$_SESSION['address']['first_name'] = $firstname;
			$_SESSION['address']['last_name'] = $lastname;
			$_SESSION['address']['address_line_1'] = $address_line_1;
			$_SESSION['address']['address_line_2'] = $address_line_2;
			$_SESSION['address']['city'] = $city;
			$_SESSION['address']['state'] = $state;
			$_SESSION['address']['country'] = $country;
			$_SESSION['address']['pincode'] = $pincode;
			$_SESSION['address']['mobileno'] = $mobileno;
			$_SESSION['address']['phoneno'] = $phoneno;
			$_SESSION['address']['access_id'] = $access_id;
			$error_field = substr($error_field,2);
			register_error(sprintf(elgg_echo("address:validation:null"),$error_field));
		}else{
			echo sprintf(elgg_echo("address:validation:null"),$error_field);
		}
	}else{
		if (!$address = get_entity($guid)) {
			if(!$ajax){
				register_error(elgg_echo("address:edit:failed"));
				forward($CONFIG->wwwroot . "socialcommerce/" . $container_user->username . "/address/");
				exit;
			}else{
				echo elgg_echo("address:edit:failed");
			}
		}
		
		$result = false;
		
		$container_guid = $address->container_guid;
		$container = get_entity($container_guid);
		
		if ($address->canEdit()) {
		
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
			$address->mobileno = $mobileno;
			$address->phoneno = $phoneno;
			$address->access_id = 2;
			
			$result = $address->save();
		}
		
		if ($result){
			if(!$ajax){
				system_message(elgg_echo("address:saved"));
			}else{
				echo "$result";
			}
			// Remove the blog post cache
			unset($_SESSION['address']);
		}else{
			if(!$ajax){
				register_error(elgg_echo("address:edit:failed"));
			}else{
				echo elgg_echo("address:edit:failed");
			}
		}
	}
	if(!$ajax){
		forward($CONFIG->wwwroot . "socialcommerce/" . $container->username . "/address/");
	}
?>
