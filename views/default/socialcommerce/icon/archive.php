<?php
	/**
	 * Elgg icon - archive
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	if ($vars['size'] == 'large') {
		$ext = '_lrg';
	} else {
		$ext = '';
	}
	echo '<img src="'.$CONFIG->wwwroot.'mod/socialcommerce/graphics/icons/archive'.$ext.'.gif" border="0" />';

?>
