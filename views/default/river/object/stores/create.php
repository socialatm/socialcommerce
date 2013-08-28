<?php
	/**
	 * Elgg river - create product
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 

	$performed_by = get_entity($vars['item']->subject_guid); 
	$object = get_entity($vars['item']->object_guid);
	
	$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	if($vars['item']->action_type == 'create')
		$string = sprintf(elgg_echo("stores:river:created"),$url) . " ";
	else
		$string = sprintf(elgg_echo("stores:river:updated"),$url) . " ";
	$string .= "<a href=\"" . $object->getURL() . "\">" . elgg_echo("stores:river:item") . "</a>";

	echo $string;
	
?>