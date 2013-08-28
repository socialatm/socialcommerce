<?php
	/**
	 * Elgg view - side menu
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
?>

	<p class="user_menu_stores">
		<a href="<?php echo $vars['url']; ?>pg/<?php echo $CONFIG->pluginname; ?>/<?php echo $vars['entity']->username; ?>"><?php echo elgg_echo("stores"); ?></a>	
	</p>