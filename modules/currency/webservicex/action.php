<?php
	/**
	 * Elgg webservicex currency api - actions
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	function get_exchange_rate($from_code, $to_code){
		$post_fields = "FromCurrency=" . urlencode(strtoupper($from_code)) . "&ToCurrency=" . urlencode(strtoupper($to_code));
		$target_url = "http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate";
		//$rtn = get_response_from_api($target_url, $post_fields,60);
		
		if (!$rtn) {
			return elgg_echo('provider:request:unavailable');
		}else{
			
		}
		
		$xml = @simplexml_load_string($rtn);
		if(!is_object($xml)) {
			return elgg_echo('provider:request:Invalid:code');
		}else{
			
		}

		if (count($xml) === 0) {
			return (double)$xml;
		} else {
			return (double)$xml[0];
		}
	}
	
	
?>