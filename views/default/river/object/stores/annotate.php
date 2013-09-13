<?php
	/**
	 * Elgg river - annotate product
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$statement = $vars['statement'];
	$performed_by = $statement->getSubject();
	$object = $statement->getObject();
	
	$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$string = sprintf(elgg_echo("stores:river:annotate"),$url) . " ";
	$string .= "<a href=\"" . $object->getURL() . "\">" . elgg_echo("stores:river:item") . "</a>";

	echo $string; 
?>
