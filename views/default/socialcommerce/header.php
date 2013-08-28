<?php
/**
 * Elgg view - header extend
 * 
* @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
global $CONFIG, $settings;
if(isadminloggedin() && $settings == 1){
	confirm_social_commerce_settings();
}

//	@todo - take a closer look at this too

?>