<?php
	/**
	 * Elgg category - individual view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 

	$category = $vars['entity'];
	$product_guid = $category->guid;
	$title = $category->title;
	$desc = $category->description;
	$owner = $category->getOwnerEntity();
	$friendlytime = elgg_view_friendly_time($category->time_created);
	
	if (elgg_get_context() == "search") {	// Start search listing version 
				
?>
		<div>
			<a  class="object_category_string" href="<?php echo elgg_get_config('url'); ?>socialcommerce/<?php echo $category->guid; ?>/product_cate">
				<?php echo $category->title; ?>
			</a>
			<?php if($category->owner_guid == $_SESSION['user']->guid){ ?>
				[ <a href="<?php echo $category->getURL(); ?>">View</a> ]
			<?php } ?>
		</div>
<?php
	} else {							// Start main version
?>
	<div>
		<div class="storesrepo_icon">
<?php 
			echo elgg_view("socialcommerce/icon", array( "mimetype" => $mime, 'thumbnail' => $category->thumbnail, 'category_guid' => $product_guid) ); 
?>					
		</div>
		
		<div class="storesrepo_title_owner_wrapper">
<?php
			//get the user and a link to their gallery
			$user_gallery = elgg_get_config('url').'socialcommerce/'.$_SESSION['user']->username.'/search/subtype/category/md_type/simpletype/tag/image/owner_guid/'.$owner->guid.'search_viewtype/gallery';
?>
		<div class="storesrepo_title"><h2><a href="<?php echo $category->getURL(); ?>"><?php echo $title; ?></a></h2></div>
			<div class="storesrepo_owner">
				<?php

					echo elgg_view("profile/icon",array('entity' => $owner, 'size' => 'tiny'));
				
				?>
				<p class="storesrepo_owner_details"><b><a href="<?php echo elgg_get_config('url'); ?>socialcommerce/<?php echo $owner->username; ?>"><?php echo $owner->name; ?></a></b><br />
				<small><?php echo $friendlytime; ?></small></p>
			</div>
		</div>
		<div class="storesrepo_maincontent">
		
				<div class="storesrepo_description"><?php echo elgg_autop($desc); ?></div>
		
<?php
	if ($category->canEdit()) {
?>
	<div class="storesrepo_controls">
		<p>
			<a href="<?php echo elgg_get_config('url'); ?>mod/socialcommerce/edit_category.php?category_guid=<?php echo $category->getGUID(); ?>"><?php echo elgg_echo('edit'); ?></a>&nbsp; 
			<?php 
				echo elgg_view('output/confirmlink',array(
					'href' => elgg_get_config('url'). "action/socialcommerce/delete_category?category=" . $category->getGUID(),
					'text' => elgg_echo("delete"),
					'confirm' => elgg_echo("category:delete:confirm"),
				));  
			?>
		</p>
	</div>
<?php		
	}
?>
	</div>
</div>

<?php
}
