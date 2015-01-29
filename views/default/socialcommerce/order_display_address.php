<?php
	/**
	 * Elgg view - order display address
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$order = $vars['entity'];
	$type = $vars['type'];
	if($order){
		$name = $type.'_first_name';
		$firstname = trim($order->$name);
		
		$name = $type.'_last_name';
		$lastname = trim($order->$name);
		
		if($firstname != '' || $lastname != '')
			echo "<div>".$firstname." ".$lastname."</div>";
			
		$name = $type.'_address_line_1';
		$address_line_1 = trim($order->$name);
		if($address_line_1 != '')
			echo "<div>".$address_line_1."</div>";
			
		$name = $type.'_address_line_2';
		$address_line_2 = trim($order->$name);
		if($address_line_2 != '')
			echo "<div>".$address_line_2."</div>";
			
		$name = $type.'_city';
		$city = trim($order->$name);
		if($city != '')
			echo "<div>".$city."</div>";
			
		$name = $type.'_state';
		$state = trim($order->$name);
		if($state != '')
			echo "<div>".$state."</div>";
			
		$name = $type.'_country';
		$country = trim(get_name_by_fields('iso3',$order->$name));
		if($country != '')
			echo "<div>".$country."</div>";
			
		$name = $type.'_pincode';
		$pincode = trim($order->$name);
		if($pincode != '')
			echo "<div>".$pincode."</div>";
			
		$name = $type.'_mobileno';
		$mobileno = trim($order->$name);
		if($mobileno != '')
			echo "<div>".$mobileno."</div>";
			
		$name = $type.'_phoneno';
		$phoneno = trim($order->$name);
		if($phoneno != '')
			echo "<div>".$phoneno."</div>";
	}
?>
