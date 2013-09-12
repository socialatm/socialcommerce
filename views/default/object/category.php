<?php
	/**
	 * Elgg category - individual view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	global $CONFIG;
	
	$category = $vars['entity'];
	if(!isloggedin()){
		forward("pg/{$CONFIG->pluginname}/" . $_SESSION['user']->username);
	}
	$product_guid = $category->getGUID();
	$title = $category->title;
	$desc = $category->description;
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = friendly_time($vars['entity']->time_created);
	
	//$mime = $category->mimetype;
	
	if (get_context() == "search") {	// Start search listing version 
		/*$info = "<p> <a href=\"{$category->getURL()}\">{$title}</a></p>";
		$info .= "<p class=\"owner_timestamp\"><a href=\"{$vars['url']}pg/{$CONFIG->pluginname}/{$owner->username}\">{$owner->name}</a> {$friendlytime}";
		$numcomments = elgg_count_comments($category);
		if ($numcomments)
			$info .= ", <a href=\"{$category->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
		$info .= "</p>";
		
		$icon = "<a href=\"{$category->getURL()}\">" . elgg_view("{$CONFIG->pluginname}/icon", array("mimetype" => $mime, 'thumbnail' => $category->thumbnail, 'category_guid' => $product_guid, 'size' => 'small')) . "</a>";
		
		echo elgg_view_listing($icon, $info);*/
		
?>
		<div>
			<a  class="object_category_string" href="<?php echo $vars['url']; ?>pg/<?php echo $CONFIG->pluginname; ?>/<?php echo $category->guid; ?>/product_cate">
				<?php echo $category->title; ?>
			</a>
			<?php if($category->owner_guid == $_SESSION['user']->guid){ ?>
				[ <a href="<?php echo $category->getURL(); ?>">View</a> ]
			<?php } ?>
		</div>
<?php
	} else {							// Start main version
?>
	<div class="storesrepo_stores">
		<div class="storesrepo_icon">
					<?php 
						echo elgg_view("{$CONFIG->pluginname}/icon", array("mimetype" => $mime, 'thumbnail' => $category->thumbnail, 'category_guid' => $product_guid)); 
						
					?>					
		</div>
		
		<div class="storesrepo_title_owner_wrapper">
		<?php
			//get the user and a link to their gallery
			$user_gallery = $vars['url'] . "mod/socialcommerce/search.php?md_type=simpletype&subtype=category&tag=image&owner_guid=" . $owner->guid . "&search_viewtype=gallery";
		?>
		<div class="storesrepo_title"><h2><a href="<?php echo $category->getURL(); ?>"><?php echo $title; ?></a></h2></div>
		<div class="storesrepo_owner">
				<?php

					echo elgg_view("profile/icon",array('entity' => $owner, 'size' => 'tiny'));
				
				?>
				<p class="storesrepo_owner_details"><b><a href="<?php echo $vars['url']; ?>pg/<?php echo $CONFIG->pluginname; ?>/<?php echo $owner->username; ?>"><?php echo $owner->name; ?></a></b><br />
				<small><?php echo $friendlytime; ?></small></p>
		</div>
		</div>

		
		<div class="storesrepo_maincontent">
		
				<div class="storesrepo_description"><?php echo autop($desc); ?></div>
		
<?php
	if ($category->canEdit()) {
?>
	<div class="storesrepo_controls">
				<p>
					<a href="<?php echo $vars['url']; ?>mod/<?php echo $CONFIG->pluginname; ?>/edit_category.php?category_guid=<?php echo $category->getGUID(); ?>"><?php echo elgg_echo('edit'); ?></a>&nbsp; 
					<?php 
						echo elgg_view('output/confirmlink',array(
						
							'href' => $vars['url'] . "action/{$CONFIG->pluginname}/delete_category?category=" . $category->getGUID(),
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
?>