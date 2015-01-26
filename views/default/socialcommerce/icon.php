<?php
	/**
	 * Elgg view - icon
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
 	**/
	
	$mime = $vars['mimetype'];
	if (isset($vars['thumbnail'])) {
		$thumbnail = $vars['thumbnail'];
	} else {
		$thumbnail = false;
	}
	
	$size = $vars['size'];
	if ($size != 'large') {
		$size = 'small';
	}
	
	// Handle 
	switch ($mime) {
		case 'image/jpg' 	:
		case 'image/jpeg' 	:
		case 'image/png' 	:
		case 'image/gif' 	:
		case 'image/bmp' 	: 
			if ($thumbnail) {
				if ($size == 'small') {
					echo '<img src="'.elgg_get_config('url').'action/socialcommerce/icon?stores_guid='.$vars['stores_guid'].'&mimetype='.$mime.'" />';
				} else {
					echo '<img src="'.elgg_get_config('url').'mod/socialcommerce/graphics/icons/general.gif" />';
				}
			} else {
				if ($size == 'large') {
					echo '<img src="'.elgg_get_config('url').'socialcommerce/graphics/icons/general_lrg.gif" />';
				} else {
					echo '<img src="'.elgg_get_config('url').'mod/socialcommerce/graphics/icons/general_lrg.gif" />';
				}
			}
		break;
		default : 
			if (!empty($mime) && elgg_view_exists('socialcommerce/icon/'.$mime)) {
				echo elgg_view("socialcommerce/icon/{$mime}", $vars);
			} else if (!empty($mime) && elgg_view_exists("socialcommerce/icon/" . substr($mime,0,strpos($mime,'/')) . "/default")) {
				echo elgg_view("socialcommerce/icon/" . substr($mime,0,strpos($mime,'/')) . "/default");
			} else {
				echo '<img src="'.elgg_get_config('url').'mod/socialcommerce/graphics/icons/general.gif" />';
			}	 
		break;
	}
