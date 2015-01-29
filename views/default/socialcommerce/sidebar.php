<?php
	/**
	 * Elgg view - over write owner block
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$sc_url = elgg_get_config('url');

	if(elgg_is_logged_in()){
?>
		<div id="owner_block_stores">
			<?php if (elgg_is_admin_logged_in()) { ?>
				<!--My Account-->
				<div class="scommerce_settings elgg-menu-content">
					<a href="<?php echo $sc_url.'admin/plugin_settings/socialcommerce/'; ?>">
						<?php echo elgg_echo('socialcommerce:settings'); ?>
					</a>
				</div>
			<?php } ?>
			<!--My Account-->
			<div>
				<a href="<?php echo elgg_get_config('url').'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/my_account/address/">'; ?>
					<?php echo elgg_echo('stores:my:account'); ?>
				</a>
			</div>
			<?php 
			if(!elgg_is_admin_logged_in()){
			?>
			<!--Cart-->
			<?php 
				if(elgg_get_config('cart_item_count')){
					$c_count = " (".elgg_get_config('cart_item_count').")";
				}
			?>
			<div class="cart">
				<a href="<?php echo $sc_url ?>socialcommerce/<?php echo elgg_get_logged_in_user_entity()->username; ?>/cart">
					<?php echo elgg_echo('stores:my:cart').$c_count; ?>
				</a>
			</div>
			<!--Wishlist-->
			<?php 
				if(elgg_get_config('wishlist_item_count')){
					$w_count = " (".elgg_get_config('wishlist_item_count').")";
				}
			?>
			<div class="wishlist">
				<a href='<?php echo $sc_url.'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/wishlist'; ?>'>
					<?php echo sprintf(elgg_echo('stores:my:wishlist'), $w_count) ?>
				</a>
			</div>
			<!--orders-->
			<div class="orders">
				<a href='<?php echo $sc_url.'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/order/'; ?>'>
					<?php echo elgg_echo('stores:my:order') ?>
				</a>
			</div>
			<?php 
			}
			?>
		</div>
<?php
	}else{
		if(elgg_get_config('cart_item_count')){
			$c_count = " (".elgg_get_config('cart_item_count').")";
?>
		<div id="owner_block_stores">
			<!--Cart-->
			<div class="cart">
				<a href="<?php echo $sc_url ?>socialcommerce/gust/cart">
					<?php echo elgg_echo('stores:gust:cart').$c_count; ?>
				</a>
			</div>
		</div>
<?php
		}
	}
?>
