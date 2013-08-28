<?php
	/**
	 * Elgg icon - default image
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	if ($vars['full'] && $smallthumb = $vars['entity']->smallthumb) {
 
		echo "<p><a href=\"{$vars['url']}action/{$CONFIG->pluginname}/download?stores_guid={$vars['entity']->getGUID()}\"><img src=\"{$vars['url']}mod/stores/thumbnail.php?stores_guid={$vars['entity']->getGUID()}&size=large\" border=\"0\" /></a></p>";
		
	}

?>