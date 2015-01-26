<?php
	/**
	 * Elgg view - socialcommerce menu
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
?>

	<p class="user_menu_stores">
		<a href="<?php echo elgg_get_config('url'); ?>socialcommerce/<?php echo $vars['entity']->username; ?>"><?php echo elgg_echo("stores"); ?></a>	
	</p>
	