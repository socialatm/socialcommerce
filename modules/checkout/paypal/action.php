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
		$guid = get_input('guid');						//	@todo - check to make sure its not empty and throw an error if it is...
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

		$checkout_settings = get_entity($guid);
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
	
	function checkout_payment_settings_paypal(){
		$method = $_SESSION['CHECKOUT']['checkout_method'];		//	@todo - what if the $method != 'paypal'  ??
		$total = $_SESSION['CHECKOUT']['total'];
		$validate_currency = validate_currency(get_config('currency_code'), $total, 'paypal');
	
		$splugin_settings = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'splugin_settings',
			));
		$splugin_settings = $splugin_settings[0];
		$email = $splugin_settings->socialcommerce_paypal_email;
		$paypal_environment = $splugin_settings->socialcommerce_paypal_environment;

		if($paypal_environment == "paypal") {
			$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
		}else {
			$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		}
		
		$BillingDetails = $_SESSION['CHECKOUT']['billing_address'];
		$ShippingDetails = $_SESSION['CHECKOUT']['shipping_address'];
					
		$states = get_state_by_fields('iso3',$BillingDetails->country);		//	@todo - we should make this into a function and add it to modules/module.php
		foreach($states as $state){
			if($state->name == $BillingDetails->state ){
				$state_abbrv = $state->abbrv;
			}
		}
		
		$products = $_SESSION['CHECKOUT']['product'];				//	@todo - throw an error message here if $products is	empty & return to cart...		
		 $i = 1;
		 $hiddenProducts = array();
		 foreach($products as $p_guid=>$product){
				$product = get_entity($p_guid);
				$hiddenProducts['item_name_'.$i] = $product->title;
				$hiddenProducts['amount_'.$i] = $product->price;	//	@todo - validate_currency() here instead of on total above??	
				$hiddenProducts['quantity_'.$i] = 1 ;				//	@todo - we'll need to change this for non-digital products...
				$i++ ;
			}
			
		/****	make custom setting into an array	*****/
		$custom = array( $method, elgg_get_page_owner_guid(), $BillingDetails->guid, $ShippingDetails->guid, $_SESSION['CHECKOUT']['shipping_method'] );	//	@todo - replace the page owner thing...
		
		$hiddenFields = array(
			'cmd'			=> '_cart',
			'upload'			=> 1,
			'business'		=> $email,
			'rm'			=> 2,

			// Order details
			//'no_shipping'	=> 1,				//	@todo - have a look at these two fields...
			//'tax'			=> 0,
			'no_note'		=> 0,
			'currency_code'	=> $validate_currency['currency_code'],
			'custom'		=> $custom,
		
			// Notification and return URLS
			'return'		=> get_config('url').'socialcommerce/'.$_SESSION['user']->username.'/cart_success',
			'cancel_return'	=> get_config('url').'socialcommerce/'.$_SESSION['user']->username.'/cancel',
			'notify_url'	=> get_config('url').'socialcommerce/'.$_SESSION['user']->username.'/ipn',
	
			// Customer details
			'first_name'	=> $BillingDetails->firstname,
			'last_name'		=> $BillingDetails->lastname,
			'address1'		=> $BillingDetails->address_line_1,
			'address2'		=> $BillingDetails->address_line_2,
			'city'			=> $BillingDetails->city,
			'state'			=> $state_abbrv,
			'zip'			=> $BillingDetails->pincode,
			'country'		=> get_iso2_by_fields('iso3',$BillingDetails->country),
			'night_phone_a'	=> substr($BillingDetails->mobileno , 0, 3 ),
			'night_phone_b'	=> substr($BillingDetails->mobileno , 3, 3 ),
			'night_phone_c'	=> substr($BillingDetails->mobileno , 6, 4 ),
			'address_override' => 1,
		);
	
		$hiddenFields = array_merge( $hiddenFields, $hiddenProducts );
		return redirect_to_form( $paypal_url, $hiddenFields );
			
	}			// end of function checkout_payment_settings_paypal
	
	function makepayment_paypal(){
	
	/*****	verify with paypal first	*****/

/*****	start cURL	*****/

	// Initialize the $req variable and add CMD key value pair
	$req = 'cmd=_notify-validate';
	// Read the post from PayPal
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
	}
// Now Post all of that back to PayPal's server using curl, and validate everything with PayPal
	$splugin_settings = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'splugin_settings',
			));
	$splugin_settings = $splugin_settings[0];
	$paypal_environment = $splugin_settings->socialcommerce_paypal_environment;
		if($paypal_environment == "paypal") {
			$url = "https://www.paypal.com/cgi-bin/webscr";
		}else {
			$url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		}

$curl_result = $curl_err = '';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$curl_result = curl_exec($ch);
$curl_err = curl_error($ch);
curl_close($ch);

/***** end cURL	****/

$process_payment = false;
				
	if (strcmp(trim($curl_result), 'VERIFIED') == 0) {
		if(($_POST['receiver_email'] == $splugin_settings->socialcommerce_paypal_email)) {
							
			switch($_POST['payment_status']) {
				case "Completed":	$transaction_status = 'Completed';
									$process_payment = true;
									break;
				case "Pending":		$transaction_status = 'Pending';
									$process_payment = true;
									break;
			}
		}
	} else if (strcmp($curl_result, 'INVALID') == 0) {
		//	@todo - log for manual investigation
		exit();
	}

if($process_payment){
	$custom = unserialize($_POST['custom']);
	$CheckoutMethod = $custom[0];
	$buyer_guid = $custom[1];
	$BillingDetails = $custom[2];
	$ShippingDetails = is_null( $custom[3] ) ? 0 : $custom[3] ;
	$ShippingMethods = is_null( $custom[4] ) ? 0 : $custom[4] ;
	$payment_status 	= $_POST['payment_status'];
	$payment_amount 	= (float)$_POST['mc_gross'];
	$payment_gross   	= (float)$_POST['payment_gross'];
	$payment_fee        = (float)$_POST['payment_fee'];
	$payment_net		= $payment_gross - $payment_fee;
	$payment_currency 	= $_POST['mc_currency'];
	$txn_id 			= $_POST['txn_id'];
	$receiver_email 	= $_POST['receiver_email'];
	$payer_email 		= $_POST['payer_email'];
	$post_values = $_POST;
	
/*****	@todo - need to test this part	*****/
	if(get_config('currency_code') != $payment_currency){
		$converted_currency = convert_currency($payment_currency, get_config('currency_code'), $payment_gross);
		$payment_gross = $converted_currency;
		$converted_currency = convert_currency($payment_currency, get_config('currency_code'), $payment_fee);
		$payment_fee = $converted_currency;
	}
	
	$transactions = array(
		'status'=>$transaction_status,		//	@todo - isn't $transaction_status and $payment_status the same???
		'txn_id'=>$txn_id,
		'email'=>$receiver_email,
		'fee'=>$payment_fee,
		'total'=>$payment_gross,
		);

	create_order( $buyer_guid, $CheckoutMethod, $transactions, $BillingDetails, $ShippingDetails, $ShippingMethods );
}
exit;
	
			//	@todo - need to deal with page owner & item variables...
			$item_name 			= $_POST['item_name'];
			$item_number 		= $_POST['item_number'];
				
}			//	end function makepayment_paypal
?>
