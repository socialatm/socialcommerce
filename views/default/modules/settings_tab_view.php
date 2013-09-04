<?PHP
	/**
	 * Elgg modules - settings tab view
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
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
			<li <?php if($filter == "checkout") echo "class='selected'"; ?>><a href="<?php echo $url; ?>?filter=checkout"><?php echo elgg_echo('checkout:methods:tab'); ?></a></li>
			<li <?php if($filter == "shipping") echo "class='selected'"; ?>><a href="<?php echo $url; ?>?filter=shipping"><?php echo elgg_echo('shipping:methods:tab'); ?></a></li>
			<li <?php if($filter == "currency") echo "class='selected'"; ?>><a href="<?php echo $url; ?>?filter=currency"><?php echo elgg_echo('currency:tab'); ?></a></li>
		</ul>
	</div>
	<?php echo $base_view; ?>
</div>
