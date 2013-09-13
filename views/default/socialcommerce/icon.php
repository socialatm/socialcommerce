<?php
	/**
	 * Elgg view - icon
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
 	**/
	 
	// Get engine
	require_once(get_config('path').'engine/start.php');

	global $CONFIG;
	
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
					echo "<img src=\"{$vars['url']}action/socialcommerce/icon?stores_guid={$vars['stores_guid']}&mimetype={$mime}\" border=\"0\" />";
				} else {
					echo "<img src=\"{$vars['url']}mod/socialcommerce/thumbnail.php?stores_guid={$vars['stores_guid']}&mimetype={$mime}\" border=\"0\" />";
				}
			} else {
				if ($size == 'large') {
					echo "<img src=\"{$CONFIG->wwwroot}mod/socialcommerce/graphics/icons/general_lrg.gif\" border=\"0\" />";
				} else {
					echo "<img src=\"{$CONFIG->wwwroot}mod/socialcommerce/graphics/icons/general.gif\" border=\"0\" />";
				}
			}
		break;
		default : 
			if (!empty($mime) && elgg_view_exists("{$CONFIG->pluginname}/icon/{$mime}")) {
				echo elgg_view("socialcommerce/icon/{$mime}", $vars);
			} else if (!empty($mime) && elgg_view_exists("socialcommerce/icon/" . substr($mime,0,strpos($mime,'/')) . "/default")) {
				echo elgg_view("socialcommerce/icon/" . substr($mime,0,strpos($mime,'/')) . "/default");
			} else {
				echo "<img src=\"{$CONFIG->wwwroot}mod/socialcommerce/graphics/icons/general.gif\" border=\"0\" />";
			}	 
		break;
	}
?>
