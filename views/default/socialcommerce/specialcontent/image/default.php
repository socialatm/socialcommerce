<?php
	/**
	 * Elgg icon - default image
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	echo '<b>'.__FILE__ .' at '.__LINE__; die(); 
	if ($vars['full'] && $smallthumb = $vars['entity']->smallthumb) {
 
		echo "<p><a href=\"{$vars['url']}action/socialcommerce/download?stores_guid={$vars['entity']->getGUID()}\"><img src=\"{$vars['url']}mod/stores/thumbnail.php?stores_guid={$vars['entity']->getGUID()}&size=large\" /></a></p>";
	}
