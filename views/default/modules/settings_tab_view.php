<?PHP
	/**
	 * Elgg modules - settings tab view
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
 	**/ 
	 
	$base_view = $vars['base_view'];
	$filter = $vars['filter'];
	$settings = $vars['entity'];

?>
<div class="">
	<div id="elgg_horizontal_tabbed_nav">
		<ul>
			<li <?php if($filter == "settings") echo "class='selected'"; ?>><a href="<?php echo $url; ?>?filter=settings"><?php echo elgg_echo('general:settings:tab'); ?></a></li>
			<?php if($settings[0]->checkout_methods){ ?>
				<li <?php if($filter == "checkout") echo "class='selected'"; ?>><a href="<?php echo $url; ?>?filter=checkout"><?php echo elgg_echo('checkout:methods:tab'); ?></a></li>
			<?php } ?>
		</ul>
	</div>
	<?php echo $base_view; ?>
</div>