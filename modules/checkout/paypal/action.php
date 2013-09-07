<?php
	/**
	 * Elgg paypal checkout - actions
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	function set_checkout_settings_paypal(){
			
		$guid = get_input('guid');
		$display_name = get_input('display_name');
		$paypal_email = get_input('socialcommerce_paypal_email');
		$paypal_envi = get_input('socialcommerce_paypal_environment');
		
		
		if(empty($display_name)){
			register_error('missing '.elgg_echo("display:name"));
			return;
		}
		if(empty($paypal_email)){
			register_error('missing '.elgg_echo("paypal:email"));
			return;
		}
		if(empty($paypal_envi)){
			register_error('missing '.elgg_echo("mode"));
			return;
		}
		
		$checkout_settings = !empty($guid) ? get_entity($guid) : new ElggObject() ;
		$checkout_settings->access_id = 2;
		$checkout_settings->container_guid = $_SESSION['user']->guid;
		$checkout_settings->subtype = 's_checkout';
		$checkout_settings->checkout_method = 'paypal';
		$checkout_settings->display_name = $display_name;
		$checkout_settings->socialcommerce_paypal_email = $paypal_email;
		$checkout_settings->socialcommerce_paypal_environment = $paypal_envi;
		
		if($checkout_settings->save()){
			system_message(sprintf(elgg_echo("settings:saved"),$display_name));
			return true;
		}else{
			register_error(sprintf(elgg_echo("paypal:settings:not:saved"),$display_name));
			return false;
		}
	}
	
	function checkout_payment_settings_paypal(){		//	working on this right now!!
	
		$method = $_SESSION['CHECKOUT']['checkout_method'];		//	@todo - what if the $method != 'paypal'  ??
		
		/*
		 * @todo - take a hard look at $settings = elgg_get_entities_from_metadata(array( - I don't like it at all!!
		 */
		
		$settings = elgg_get_entities_from_metadata(array(
			'checkout_method' => $method,
			'entity_type' =>'object',
			'entity_subtype' => 's_checkout',
			'owner_guid' => 0,
			'limit' => 1,
			)); 
			
		if($settings){ $settings = $settings[0]; }		//	@todo - and what if settings is not found?...
		
		$total = $_SESSION['CHECKOUT']['total'];
		$validate_currency = validate_currency(get_config('currency_code'), $total, 'paypal');
		
		// $email = $settings->socialcommerce_paypal_email;		//	@todo - a mess - hardcoded for now...
		$email = 'raypea_1306946408_biz@gmail.com';

	//	$paypal_environment = $settings->socialcommerce_paypal_environment;		//	@todo - another mess - hardcoded for now...
		$paypal_environment = 'sandbox';

		if($paypal_environment == "paypal") {
			$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
		}else {
			$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		}

		$BillingDetails = $_SESSION['CHECKOUT']['billing_address'];
		$ShippingDetails = $_SESSION['CHECKOUT']['shipping_address'];
		
		$products = $_SESSION['CHECKOUT']['product'];				//	@todo - throw an error message here if $products is	empty		
		 $i = 1;
		 $hiddenProducts = array();
		 foreach($products as $p_guid=>$product){
				$product = get_entity($p_guid);
				$hiddenProducts['item_name_'.$i] = $product->title;
				$hiddenProducts['amount_'.$i] = $product->price;	//	@todo - validate_currency() here instead of on total above??	
				$hiddenProducts['quantity_'.$i] = 1 ;				//	@todo - we'll need to change this for non-digital products...
				$i++ ;
			}
		
		$hiddenFields = array(
			'cmd'			=> '_cart',
			'upload'			=> 1,
			'business'		=> $email,									// @todo - this works, sort of - sometimes but I don't really like it...
			'rm'			=> 2,

			// Order details
			//'no_shipping'	=> 1,
			//'tax'			=> 0,
			'no_note'		=> 0,
			'currency_code'	=> $validate_currency['currency_code'],
			'custom'		=>"{$method},".page_owner().','.$BillingDetails->guid.','.$ShippingDetails->guid.','.$_SESSION['CHECKOUT']['shipping_method'],
		
			// Notification and return URLS
			'return'		=> get_config('url').'pg/socialcommerce/'.$_SESSION['user']->username.'/cart_success',
			'cancel_return'	=> get_config('url').'pg/socialcommerce/'.$_SESSION['user']->username.'/cancel',
			
			'notify_url'	=> get_config('url')."action/socialcommerce/manage_socialcommerce?page_owner=".page_owner().'&manage_action=makepayment&payment_method='.$method,

			// Customer details
			'first_name'	=> $billingDetails['firstname'],
			'last_name'		=> $billingDetails['lastname'],
			//'email'			=> $billingDetails['ordbillemail'],
			'address1'		=> $billingDetails['address_line_1'],
			'address2'		=> $billingDetails['address_line_2'],
			//'day_phone_a'	=> $phone_1,
			//'day_phone_b'	=> $phone_2,
			//'day_phone_c'	=> $phone_3,
			//'night_phone_a'	=> $phone_1,
			//'night_phone_b'	=> $phone_2,
			//'night_phone_c'	=> $phone_3,
			'country'		=> get_name_by_fields('iso3',$billingDetails['country']),
			'zip'			=> $billingDetails['pincode'],
			'city'			=> $billingDetails['city'],
			'state'			=> $billingDetails['state']
			//'address_override' => 1
		);
		
		/*****	Enter extra data from client side? if value = 1 we allow to enter data. Otherwise it automatically redirects to the given url	*****/
		
		//$not_compleated = 0;
		
		/*****	This is the view to display that extra fields in client side	*****/
		
		//$field_view = "paypal_entries";
		
		$hiddenFields = array_merge( $hiddenFields, $hiddenProducts );
		return redirect_to_form($paypal_url, $hiddenFields, $not_compleated, $field_view);
			
	}			// end of function checkout_payment_settings_paypal
	
	function makepayment_paypal(){
	
	 	global $CONFIG;
		
		$custom = get_input('custom');
		//$custom = 'stores_payment';
		//$replay .= "\n CUSTOM: \n ".$custom;
		/*if(!empty($custom)){*/
			$custome = explode(',',$custom);
			$CheckoutMethod = $custome[0];
			$page_owner = $custome[1];
			$BillingDetails = $custome[2];
			$ShippingDetails = $custome[3];
			if(!$ShippingDetails)
				$ShippingDetails = 0;
			$ShippingMethods = $custome[4];
			if(!$ShippingMethods)
				$ShippingMethods = 0;
				
			$settings = elgg_get_entities_from_metadata(array(
				'checkout_method' => 'paypal',
				'entity_type' =>'object',
				'entity_subtype' => 's_checkout',
				'owner_guid' => 0,
				'limit' => 1,
				));  	
			
			if($settings){
				$settings = $settings[0];	
			}
			
			//			@todo - IPN settings need an upgrade here...
						
			$stores_paypal_email = $settings->socialcommerce_paypal_email;
			$environment = $settings->socialcommerce_paypal_environment;
			if(!$environment){
				$environment = "sandbox";
			}
			
			$req = 'cmd=_notify-validate';
			foreach ($_POST as $key => $value) {
				$value = urlencode(stripslashes($value));
				$req .= "&$key=$value";
			}
			
			$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
			
			if($environment == "sandbox"){
				$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);
			}elseif ($environment == "paypal"){
				$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
			}
			
			// assign posted variables to local variables
			$item_name 			= $_POST['item_name'];
			$item_number 		= $_POST['item_number'];
			$payment_status 	= $_POST['payment_status'];
			$payment_amount 	= (float)$_POST['mc_gross'];
			$payment_gross   	= (float)$_POST['payment_gross'];
			$payment_fee        = (float)$_POST['payment_fee'];
			$payment_currency 	= $_POST['mc_currency'];
			$txn_id 			= $_POST['txn_id'];
			$receiver_email 	= $_POST['receiver_email'];
			$payer_email 		= $_POST['payer_email'];
			$new_fund 			= $payment_gross - $payment_fee;
			$post_values = $_POST;
			/*$replay .= "\n IPN REPLAY: ";
			foreach ($_POST as $text)
				$replay .= "\n ". $text;*/
			
			$process_payment = false;
			if (!$fp) {
				// HTTP ERROR
			} else {
				fputs ($fp, $header . $req);
				while (!feof($fp)) {
					$res = fgets ($fp, 1024);
					if (strcmp ($res, "VERIFIED") == 0) {
						if (($receiver_email == $stores_paypal_email)) {
							
							switch($_POST['payment_status']) {
								case "Completed":
									$ransaction_status = "Completed";
									$process_payment = true;
									break;
								case "Pending":
									$ransaction_status = "Pending";
									$process_payment = true;
									break;
							}
							 //$replay .= "\n Final: Success";
						}
					} else if (strcmp ($res, "INVALID") == 0) {
						// log for manual investigation
					}
				}
				fclose ($fp);
			}
			
			
			if($process_payment){
				if($CONFIG->currency_code != $payment_currency){
					$converted_currency = convert_currency($payment_currency,$CONFIG->currency_code,$payment_gross);
					$payment_gross = $converted_currency;
					$converted_currency = convert_currency($payment_currency,$CONFIG->currency_code,$payment_fee);
					$payment_fee = $converted_currency;
				}
				
				$transactions = array('status'=>$ransaction_status,
									  'txn_id'=>$txn_id,
									  'email'=>$receiver_email,
									  'fee'=>$payment_fee,
									  'total'=>$payment_gross);
				return create_order($page_owner,$CheckoutMethod,$transactions,$BillingDetails,$ShippingDetails,$ShippingMethods);	
			}else{
				return false;
			}
		/*}*/
		return true;
	}
	
	function varyfy_checkout_settings_paypal(){				// @todo varyfy ??
		$settings = elgg_get_entities_from_metadata(array(
			'checkout_method' => 'paypal',
			'entity_type' =>'object',
			'entity_subtype' => 's_checkout',
			'owner_guid' => 0,
			'limit' => 1,
			));  	
		
		if($settings){
			$settings = $settings[0];
			$display_name = trim($settings->display_name);
			$paypal_email = trim($settings->socialcommerce_paypal_email);
			$paypal_envi = trim($settings->socialcommerce_paypal_environment);
			
			if($display_name == "")
				$missing_field = elgg_echo('display:name');
			if($paypal_email == "")
				$missing_field .= $missing_field != "" ? ",".elgg_echo('paypal:email') : elgg_echo('paypal:email');
			if($paypal_envi == "")
				$missing_field .= $missing_field != "" ? ",".elgg_echo('mode') : elgg_echo('mode');
			if($missing_field != ""){
				return sprintf(elgg_echo('missing:fields'),$missing_field);
			}
			return;
		}else{
			return elgg_echo('not:fill:paypal:settings');
		}
	}
	
?>