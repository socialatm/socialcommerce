<?php
	/**
	 * Elgg icon - directory
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	if ($vars['size'] == 'large') {
		$ext = '_lrg';
	} else {
		$ext = '';
	}
	echo '<img src="'.elgg_get_config('url').'mod/socialcommerce/graphics/icons/vcard'.$ext.'.gif" border="0" />';
