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
			<li <?php if($filter == "general") echo "class='selected'"; ?>><a href="<?php echo get_config('url').'pg/socialcommerce/'.$_SESSION['user']->username.'/settings/general">'.elgg_echo('general:settings:tab'); ?></a></li>
			<li <?php if($filter == "checkout") echo "class='selected'"; ?>><a href="<?php echo get_config('url').'pg/socialcommerce/'.$_SESSION['user']->username.'/settings/checkout">'.elgg_echo('checkout:methods:tab'); ?></a></li>
			<li <?php if($filter == "shipping") echo "class='selected'"; ?>><a href="<?php echo get_config('url').'pg/socialcommerce/'.$_SESSION['user']->username.'/settings/shipping">'.elgg_echo('shipping:methods:tab'); ?></a></li>
			<li <?php if($filter == "currency") echo "class='selected'"; ?>><a href="<?php echo get_config('url').'pg/socialcommerce/'.$_SESSION['user']->username.'/settings/currency">'.elgg_echo('currency:tab'); ?></a></li>
		</ul>
	</div>
	<?php echo $base_view; ?>
</div>
