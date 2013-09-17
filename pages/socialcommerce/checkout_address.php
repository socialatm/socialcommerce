<?php
	/**
	 * Elgg address - checkout view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	require_once(get_config('path').'engine/start.php');
	global $CONFIG;
	$address = (int) get_input('guid');
	$title = elgg_view_title(elgg_echo('address:edit'));
	
	if ($address = get_entity($address)) {
		$content = elgg_view("socialcommerce/forms/edit_address", array('entity' => $address,'ajax'=>1));
    } else {
		$content = elgg_view("socialcommerce/forms/edit_address", array('ajax'=>1));
	}
	echo $content;
?>
