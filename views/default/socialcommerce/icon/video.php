<?php
	/**
	 * Elgg icon - video
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
	echo '<img src="'.elgg_get_config('url').'mod/socialcommerce/graphics/icons/video'.$ext.'.gif" border="0" />';

?>
