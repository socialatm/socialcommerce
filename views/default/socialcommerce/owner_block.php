<?php
	/**
	 * Elgg view - over write owner block
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;

	if(elgg_is_logged_in()){
?>
		<div id="owner_block_stores">
			<?php if (elgg_is_admin_logged_in()) { ?>
				<!--My Account-->
				<div class="scommerce_settings">
						<a href="<?php echo $CONFIG->url.'admin/plugin_settings/socialcommerce/'; ?>" />
						<?php echo elgg_echo('socialcommerce:settings'); ?>
					</a>
				</div>
			<?php } ?>
			<!--My Account-->
			<div class="my_account">
				<a href="<?php echo get_config('url').'socialcommerce/'.$_SESSION['user']->username.'/my_account/address/"/>'; ?>
					<?php echo elgg_echo('stores:my:account'); ?>
				</a>
			</div>
			<?php 
			if(!elgg_is_admin_logged_in()){
			?>
			<!--Cart-->
			<?php 
				if($CONFIG->cart_item_count){
					$c_count = " (".$CONFIG->cart_item_count.")";
				}
			?>
			<div class="cart">
				<a href="<?php echo $CONFIG->url ?>socialcommerce/<?php echo $_SESSION['user']->username; ?>/cart" />
					<?php echo elgg_echo('stores:my:cart').$c_count; ?>
				</a>
			</div>
			<!--Wishlist-->
			<?php 
				if($CONFIG->wishlist_item_count){
					$w_count = " (".$CONFIG->wishlist_item_count.")";
				}
			?>
			<div class="wishlist">
				<a href='<?php echo $CONFIG->url."socialcommerce/" . $_SESSION['user']->username . "/wishlist"; ?>' />
					<?php echo elgg_echo('stores:my:wishlist').$w_count ?>
				</a>
			</div>
			<!--orders-->
			<div class="orders">
				<a href='<?php echo $CONFIG->url."socialcommerce/" . $_SESSION['user']->username . "/order/"; ?>' />
					<?php echo elgg_echo('stores:my:order') ?>
				</a>
			</div>
			<?php 
			}
			?>
		</div>
<?php
	}else{
		if($CONFIG->cart_item_count){
			$c_count = " (".$CONFIG->cart_item_count.")";
?>
		<div id="owner_block_stores">
			<!--Cart-->
			<div class="cart">
				<a href="<?php echo $CONFIG->url ?>socialcommerce/gust/cart" />
					<?php echo elgg_echo('stores:gust:cart').$c_count; ?>
				</a>
			</div>
		</div>
<?php
		}
	}
?>
