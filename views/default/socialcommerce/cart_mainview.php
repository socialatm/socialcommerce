<?php
	/**
	 * Elgg view - add to cart page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	
	$stores = $vars['entity'];
	$action = get_input('action');
	$product_guid = $stores->getGUID();
	$tags = $stores->tags;
	$title = $stores->title;
	$desc = $stores->description;
	$price = $stores->price;
	
	$quantity = $stores->quantity;
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = elgg_view_friendly_time($vars['entity']->time_created);
	$quantity_text = elgg_echo('quantity');
	$price_text = elgg_echo('price');
	$search_viewtype = get_input('search_viewtype');
	$mime = $stores->mimetype;
	$product_type_details = get_product_type_from_value($stores->product_type_id);
	if($product_type_details->addto_cart != 1){
		$reditrect = $stores->getURL();
		forward($reditrect);
	}
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
		<form method="post" action="<?php echo $CONFIG->url."action/socialcommerce/addcart"; ?>">
		<div class="right_section_contents">
			<div class="storesrepo_title_owner_wrapper">
<?php
					//get the user and a link to their gallery
					$user_gallery = get_config('url').'pg/socialcommerce/'.$_SESSION['user']->username.'/search/subtype/stores/md_type/simpletype/tag/image/owner_guid/'.$owner->guid.'search_viewtype/gallery';
?>
				<div class="storesrepo_title"><h2><a href="<?php echo $stores->getURL(); ?>"><?php echo $title; ?></a></h2></div>
				<div class="storesrepo_owner">
					<?php
						echo elgg_view("profile/icon",array('entity' => $owner, 'size' => 'tiny'));
					?>
					<p class="storesrepo_owner_details"><b><a href="<?php echo $vars['url']; ?>pg/socialcommerce/<?php echo $owner->username; ?>"><?php echo $owner->name; ?></a></b><br />
					<small><?php echo $friendlytime; ?></small></p>
				</div>
			</div>
			<div class="storesrepo_maincontent">
				<?PHP if($price > 0){?>
					<div class="product_odd"><B><?php echo elgg_echo("price");?></B></div>
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
							echo "<div class=\"clear\"></div>";
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
				<div>
					<!-- Cart Button -->
					<?php echo elgg_view("socialcommerce/socialcommerce_cart",array('entity'=>$stores,'product_type_details'=>$product_type_details,'phase'=>2)); ?>
				</div>
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
									$display_fields .= <<<EOF
										<div class="storesrepo_description">
											<B>{$display_name} :</B> {$output}
										</div>
EOF;
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