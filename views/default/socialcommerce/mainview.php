<?php
	/**
	 * Elgg view - product mainview
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	
	$stores = $vars['entity'];
	$product_guid = $stores->getGUID();
	$tags = $stores->tags;
	$title = $stores->title;
	$desc = $stores->description;
	$price = $stores->price;
	$quantity = $stores->quantity;
	$mime = $stores->mimetype;
	$product_type_details = sc_get_product_type_from_value($stores->product_type_id);
	$friendlytime = elgg_view_friendly_time($stores->time_created);
	
	$product_owner = $stores->getOwnerEntity();
	$product_owner_guid = $product_owner->guid;
	
	$user = elgg_get_logged_in_user_entity();
	$user_guid = $user->guid;
		
	$search_viewtype = get_input('search_viewtype');
		
	if(isset($_SESSION['product'])) { unset($_SESSION['product']); }
	if(isset($_SESSION['related_product'])) { unset($_SESSION['related_product']); }
	
?>
<div>
		<div>
<?php 

		$product_image_guid = sc_product_image_guid($product_guid);
		echo '<img src ="'.elgg_get_config('url').'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/image/'.$product_image_guid.'/'.'medium'.'"/>'; 	
?>	
		</div>

		<div class="right_section_contents">
			<div class="storesrepo_title_owner_wrapper">
<?php
				//get the user and a link to their gallery
				$user_gallery = elgg_get_config('url').'socialcommerce/'.$_SESSION['user']->username.'/search/subtype/stores/md_type/simpletype/tag/image/owner_guid/'.$product_owner_guid.'search_viewtype/gallery';
?>
					<?php echo elgg_view_entity($product_owner, array('full_view' => false)); ?>
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
						if($stores->mimetype && $stores->product_type_id == 2){
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
	//	add the edit & delete buttons
	if($stores->canEdit()){
?>
		<div class="storesrepo_controls">
			<div class="elgg-button-action" >
				<a href="<?php echo elgg_get_config('url'); ?>socialcommerce/product/edit/<?php echo $stores->guid; ?>"><?php echo elgg_echo('edit'); ?></a>
			</div>
			<div class="elgg-button-action" >
				<?php 
					echo elgg_view('output/confirmlink',array(
						'href' => elgg_get_config('url').'socialcommerce/'.$user->username.'/delete/'.$stores->guid,
						'text' => elgg_echo("delete"),
						'confirm' => elgg_echo('stores:delete:confirm'),
					));  
				?>
			</div>
		</div>
<?php
				
	}		//	end if($stores->canEdit())
				
	// if user is not the product owner show the add to cart and add to wishlist forms
	if($user_guid != $product_owner_guid){
		if($stores->status == 1){
			if($product_type_details->addto_cart == 1) { 
				if($stores->status == 1){
					if($stores->owner_guid != $user->guid && $product_type_details->addto_cart == 1){
						$body_vars = array('product_guid' => $stores->guid);	
						$add_to_cart_form = elgg_view_form('socialcommerce/add_to_cart', $form_vars, $body_vars);
						echo $add_to_cart_form;
								
						$body_vars = array('product_guid' => $stores->guid);	
						$add_to_wishlist_form = elgg_view_form('socialcommerce/add_wishlist', $form_vars, $body_vars);
						echo $add_to_wishlist_form;
					}
				}
?>				
			</div>
		</div>
		<div class="clear"></div>
<?php 
			}	//	end if($product_type_details->addto_cart == 1)
		}	//	end if($stores->status == 1)
	}					//	end if($user_guid != $product_owner_guid)
?>		
		<table width="100%">
			<tr>
				<td>
					<?php
						$display_fields = '';
						$product_fields = elgg_get_config('product_fields')[$stores->product_type_id];
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
					<?php echo  elgg_view("custom_field/display",array('entity'=>$stores)); ?>
					<div class="features"><?php echo elgg_echo('features:des'); ?></div>
					<div class="storesrepo_description"><?php echo elgg_autop($desc); ?></div>
				</td>
			</tr>
		</table>
</div>
	
<?php
	if($product_owner_guid == $user_guid){
		echo elgg_view("socialcommerce/order_view", array('entity'=>$stores));
	}

	if ($vars['full']) { echo elgg_view_comments($stores); }
