<?php
	/**
 	 * Elgg country tax	 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	global $CONFIG;
	$country_code = trim(get_input('code'));
	
	$tax_entity = elgg_get_entities_from_metadata(array(
		'metadata_name' => 'tax_country',
		'metadata_value' => $country_code,
		'type' => 'object',
		'subtype' => 'addtax_country',
		'owner_guid' => '', 
		'limit' =>'1'
		));
	
	foreach($tax_entity as $tax_entitys) {
		$tax_rate = $tax_entitys->taxrate;
	}
	echo $tax_rate ;
?>
