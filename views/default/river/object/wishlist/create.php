<?php
	/**
	 * Elgg river - wishlist added
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
	$string = sprintf(elgg_echo("wishlist:river:created"),$url) . " ";
	$string .= "<a href=\"" . $object->getURL() . "\">" . elgg_echo("wishlist:river:item") . "</a>";
	echo $string;
	
?>