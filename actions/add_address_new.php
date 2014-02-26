<?php
	/**
	 * Elgg address - add
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	require_once('C:/Program Files (x86)/Zend/Apache2/htdocs/krumo/class.krumo.php');
	
	krumo($vars); die();
	
	
	
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
	/*if(empty($address_line_2)){
		$error_field .= ", ".elgg_echo("address:line:2");
	}*/
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
	/*if(empty($mobileno)){
		$error_field .= ", ".elgg_echo("mob:no");
	}*/
	if(!empty($error_field)){
		if(!$ajax){
			//$_SESSION['address']['title'] = $title;
			$_SESSION['address']['first_name'] = $firstname;
			$_SESSION['address']['last_name'] = $lastname;
			$_SESSION['address']['address'] = $address_1;
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
		// Extract categories from, save to default social commerce (for now)
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
		$address->mobileno = $mobileno;
		if(!empty($phoneno))
			$address->phoneno = $phoneno;
		$address->access_id = 2;
		
		if ($container_guid){
			$address->container_guid = $container_guid;
		}
		
		$result = $address->save();
		
		if ($result){
			if(!$ajax){
				system_message(elgg_echo("address:saved"));
			}else{
				echo $result;
			}
			// Remove the blog post cache
			unset($_SESSION['address']);
		}else{
			register_error(elgg_echo("address:addfailed"));
		}
	}
	if(!$ajax){
		forward($CONFIG->url . "socialcommerce/" . $container_user->username . "/address/");
	}
?>
