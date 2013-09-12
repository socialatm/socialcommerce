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

	if(isloggedin()){
?>
		<div id="owner_block_stores">
			<?php if (isadminloggedin()) { ?>
				<!--My Account-->
				<div class="scommerce_settings">
					<a href="<?php echo $CONFIG->wwwroot . 'pg/socialcommerce/' . $_SESSION['user']->username . '/settings/general'; ?>" />
						<?php echo elgg_echo('socialcommerce:settings'); ?>
					</a>
				</div>
			<?php } ?>
			<!--My Account-->
			<div class="my_account">
				<a href="<?php echo get_config('checkout_base_url').'pg/socialcommerce/'.$_SESSION['user']->username.'/my_account/address/"/>'; ?>
					<?php echo elgg_echo('stores:my:account'); ?>
				</a>
			</div>
			<?php 
			if(!isadminloggedin()){
			?>
			<!--Cart-->
			<?php 
				if($CONFIG->cart_item_count){
					$c_count = " (".$CONFIG->cart_item_count.")";
				}
			?>
			<div class="cart">
				<a href="<?php echo $CONFIG->wwwroot ?>pg/<?php echo $CONFIG->pluginname; ?>/<?php echo $_SESSION['user']->username; ?>/cart" />
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
				<a href='<?php echo $CONFIG->wwwroot."pg/{$CONFIG->pluginname}/" . $_SESSION['user']->username . "/wishlist"; ?>' />
					<?php echo elgg_echo('stores:my:wishlist').$w_count ?>
				</a>
			</div>
			<!--orders-->
			<div class="orders">
				<a href='<?php echo $CONFIG->wwwroot."pg/{$CONFIG->pluginname}/" . $_SESSION['user']->username . "/order/"; ?>' />
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
				<a href="<?php echo $CONFIG->wwwroot ?>pg/<?php echo $CONFIG->pluginname; ?>/gust/cart" />
					<?php echo elgg_echo('stores:gust:cart').$c_count; ?>
				</a>
			</div>
		</div>
<?php
		}
	}
?>