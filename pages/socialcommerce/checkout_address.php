<?php
	/**
	 * Elgg address - checkout view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 

	$address = (int) get_input('guid');
	$title = elgg_view_title(elgg_echo('address:edit'));
	
	if ($address = get_entity($address)) {
		$content = elgg_view("socialcommerce/forms/edit_address", array('entity' => $address,'ajax'=>1));
    } else {
		$content = elgg_view("socialcommerce/forms/edit_address", array('ajax'=>1));
	}
	echo $content;
