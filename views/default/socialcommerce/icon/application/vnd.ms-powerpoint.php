<?php
	/**
	 * Elgg icon - vnd ms-powerpoint
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
	$ext = ($vars['size'] == 'large') ? '_lrg' : '';
	echo '<img src="'.elgg_get_config('url').'mod/socialcommerce/graphics/icons/ppt'.$ext.'.gif" />';
