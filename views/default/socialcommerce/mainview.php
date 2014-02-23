<?php
	/**
	 * Elgg view - product mainview
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	 
	echo (__FILE__);
	 
	$stores = $vars['entity'];
	$product_guid = $stores->getGUID();
	$tags = $stores->tags;
	$title = $stores->title;
	$desc = $stores->description;
	$price = $stores->price;
	$ts = time();
	$customer = elgg_get_logged_in_user_entity();
	$customer_guid = $customer->guid;
	$quantity = $stores->quantity;
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = elgg_view_friendly_time($vars['entity']->time_created);
	$quantity_text = elgg_echo('quantity');
	$price_text = elgg_echo('price');
	$search_viewtype = get_input('search_viewtype');
	$mime = $stores->mimetype;
	$product_type_details = sc_get_product_type_from_value($stores->product_type_id);
	
	if(isset($_SESSION['product'])) { unset($_SESSION['product']); }
	if(isset($_SESSION['related_product'])) { unset($_SESSION['related_product']); }
?>
	<div class="storesrepo_stores">
		<div class="storesrepo_icon full_view">
<?php 
			echo elgg_view("socialcommerce/image", array(
				'entity' => $vars['entity'],
				'size' => 'large',
				'display' => 'image'
			));
?>	
		</div>
		
		<form method="post" action="<?php echo addcartURL($stores); ?>">
		<?php echo elgg_view('input/hidden', array('internalname' => 'product_guid', 'value' => $product_guid)); ?>
		<?php echo elgg_view('input/hidden', array('internalname' => 'customer_guid', 'value' => $customer_guid )); ?>
		<div class="right_section_contents">
			<div class="storesrepo_title_owner_wrapper">
<?php
					//get the user and a link to their gallery
					$user_gallery = get_config('url').'socialcommerce/'.$_SESSION['user']->username.'/search/subtype/stores/md_type/simpletype/tag/image/owner_guid/'.$owner->guid.'search_viewtype/gallery';
?>
					<?php echo elgg_view_entity($owner, array('full_view' => false)); ?>
					<small><?php echo $friendlytime; ?></small>
			</div>
			
			<div class="storesrepo_maincontent">
				<?php if($price > 0){?>
					<div class="product_odd"><B><?php echo elgg_echo("Price");?></B></div>
					<div class="field_results s_price"><B><?php echo get_price_with_currency($price); ?></B></div>
				<?php }
					if($stores->product_type_id > 0){
				?>
					<div class="product_even"><B><?php echo elgg_echo("product:type");?></B></div>
					<div class="field_results">
						<?php 
						if($vars['entity']->mimetype && $stores->product_type_id == 2){
							echo "<div style=\"float:left;margin-top:20px;\">".elgg_view('output/product_type',array('value' => $stores->product_type_id))."</div>";
							echo "<div style=\"float:left;\"><a href=\"{$stores->getURL()}\">" . elgg_view("socialcommerce/icon", array("mimetype" => $mime, 'thumbnail' => $stores->thumbnail, 'stores_guid' => $product_guid, 'size' => 'small')) . "</a></div>";
							echo '<div class="clear"></div>';
						}else{
							echo elgg_view('output/product_type',array('value' => $stores->product_type_id));
						} 
						?>
					</div>
<?php }
				if($stores->category > 0){
?>
					<div class="product_odd"><B><?php echo elgg_echo("category");?></B></div>
					<div class="field_results"><?php echo elgg_view('output/category',array('value' => $stores->category)); ?></div>
				<?php } 
				if($quantity > 0 && $stores->product_type_id == 1){?>
					<div class="product_even"><B><?php echo elgg_echo("quantity");?> :</B> <?php echo $quantity ?></div>
				<?php } ?>
				<div class="storesrepo_tags">
					<span class="object_tag_string">
						<?php echo elgg_view('output/tags',array('value' => $tags)); ?>
					</span>
				</div>
<?php
				if ($stores->canEdit()) { ?>
						<div class="storesrepo_controls">
<?php
							if($_SESSION['user']->guid != $stores->owner_guid && $stores->status == 1 && $product_type_details->addto_cart == 1){
?>
								<div class="cart_wishlist">
									<a class="wishlist" href="<?php echo $CONFIG->url."action/socialcommerce/add_wishlist?pgid=".$stores->guid."&__elgg_token=".generate_action_token($ts)."&__elgg_ts={$ts}";  ?>"><?php echo elgg_echo('add:wishlist');?></a>
								</div>
							<?php } ?>
							<div class="clear"></div>
						</div>	
						
<?php
					if(can_edit_entity( $product_guid, $customer_guid )){
?>
						<div class="storesrepo_controls">
							<div class="edit_btn" style="float:left;">
								<a href="<?php echo $vars['url']; ?>socialcommerce/product/edit/<?php echo $stores->getGUID(); ?>"><?php echo elgg_echo('edit'); ?></a>
							</div>
									
								<div class="delete_btn" style="float:left;padding-left:10px;">
									<?php 
										echo elgg_view('output/confirmlink',array(
											'href' => $vars['url'] . "action/socialcommerce/delete?stores=" . $stores->getGUID(),
											'text' => elgg_echo("delete"),
											'confirm' => elgg_echo("stores:delete:confirm"),
										));  
									?>
								</div>
						</div>
<?php
					}		//	end if(can_edit_entity( $product_guid, $customer_guid )){
				}else{
					if($stores->status == 1){
?>	
						<div class="storesrepo_controls">
							<?php if($product_type_details->addto_cart == 1) { ?>
								<div class="cart_wishlist">
										<a class="wishlist" href="<?php echo $CONFIG->url."action/socialcommerce/add_wishlist?pgid=".$stores->guid."&__elgg_token=".generate_action_token($ts)."&__elgg_ts={$ts}";  ?>"><?php echo elgg_echo('add:wishlist');?></a>
								</div>
							<?php } ?>
							<div style="clear:both;"></div>	
						</div>
<?php	
					}
				}
?>
				<!-- Cart Button -->
				<?php echo elgg_view("socialcommerce/socialcommerce_cart", array('entity'=>$stores, 'product_type_details'=>$product_type_details, 'phase'=>1) ); ?>
			</div>
		</div>
		<div class="clear"></div>
		<table width="100%">
			<tr>
				<td>
					<?php
						$display_fields = '';
						$product_fields = $CONFIG->product_fields[$stores->product_type_id];
						if (is_array($product_fields) && sizeof($product_fields) > 0){
							foreach ($product_fields as $shortname => $valtype){
								if($valtype['display'] == 1 && 	$shortname != 'price' && $shortname != 'quantity' && $shortname != 'upload'){
									$display_name = elgg_echo('product:'.$shortname);
									$output = elgg_view("output/{$valtype['field']}",array('value'=>$stores->$shortname));
									$display_fields .= '<div class="storesrepo_description"><B>'.$display_name.':</B>'.$output.'</div>';
								}
							}
						}
						echo $display_fields;
					?>
					<?php echo  elgg_view("custom_field/display",array('entity'=>$vars['entity'])); ?>
					<div class="features"><?php echo elgg_echo('features:des'); ?></div>
					<div class="storesrepo_description"><?php echo autop($desc); ?></div>
				</td>
		</tr>
		</table>
		<?php echo elgg_view('input/securitytoken'); ?>
		</form>
	</div>
	
<?php
	if(elgg_is_logged_in() && $vars['entity']->owner_guid == $_SESSION['user']->guid){
		echo elgg_view("socialcommerce/order_view",array('entity'=>$vars['entity']));
	}

	if ($vars['full']) {
		echo elgg_view_comments($stores);
	}
?>
