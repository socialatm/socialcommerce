<?php
	/**
	 * Elgg webservicex currency api - actions
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	/*
	 * accepts 3 character uppercase currency codes
	 * @todo - need to add validation to the function --- register_error(elgg_echo('provider:request:unavailable'))
	 *
	 */

	function get_exchange_rate($from_Currency,$to_Currency ) {
		$from_Currency = urlencode(strtoupper($from_Currency));
		$to_Currency = urlencode(strtoupper($to_Currency));
 		$url = "http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency=".$from_Currency."&ToCurrency=".$to_Currency;
		$ch = curl_init();
		$timeout = 0;
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$rawdata = curl_exec($ch);
		curl_close($ch);
	    $data = explode('>', $rawdata);
		$data = explode('<', $data['2']);
		$var = round($data['0'],2);
	    return $var;
	}	
?>
