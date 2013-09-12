<?PHP
	/**
	 * Elgg view - my account tab
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	$base_view = $vars['base_view'];
	$filter = $vars['filter'];

?>
<div class="bookraiser_profile">
	<div id="elgg_horizontal_tabbed_nav">
		<ul>
			<li <?php if($filter == "address") echo "class='selected'"; ?>><a href="<?php echo get_config('url').'pg/socialcommerce/'.$_SESSION['user']->username.'/my_account/address/';?>"><?php echo elgg_echo('address'); ?></a></li>
			<li <?php if($filter == "transactions") echo "class='selected'"; ?>><a href="<?php echo get_config('url').'pg/socialcommerce/'.$_SESSION['user']->username.'/my_account/transactions/';?>"><?php echo elgg_echo('transactions'); ?></a></li>
		</ul>
	</div>
	<?php echo $base_view; ?>
</div>
