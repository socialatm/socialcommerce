<?php
	/**
	 * Elgg view - product image
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$stores = $vars['entity'];
	
	if ($stores instanceof ElggEntity) {
	
		// Get size
		if (!in_array($vars['size'],array('small','medium','large','tiny','master','topbar')))
			$vars['size'] = "medium";
			
		// Get display
		if (!in_array($vars['display'],array('full','image','url'))){
			$vars['display'] = "full";
		}
			
		// Get any align and js
		if (!empty($vars['align'])) {
			$align = " align=\"{$vars['align']}\" ";
		} else {
			$align = "";
		}
		
		if ($icontime = $vars['entity']->icontime) {
			$icontime = "{$icontime}";
		} else {
			$icontime = "default";
		}

		if($vars['display'] == "full"){
?>
			<script>
				function display_zoome_image(guid,e){
					$("#zome_product_image_"+guid).css('display','block');
				}
				function hide_zoome_image(guid){
					$("#zome_product_image_"+guid).css('display','none');
				}
			</script>
			<div class="product_image">
			<a href="<?php echo $vars['entity']->getURL(); ?>" class="icon" ><img onmouseover="display_zoome_image(<?php echo $vars['entity']->guid; ?>,this)" onmouseout="hide_zoome_image(<?php echo $vars['entity']->guid; ?>)"  title="<?php echo $vars['entity']->title; ?>" src="<?php echo $vars['entity']->getIconURL($vars['size']); ?>" border="0" <?php echo $align; ?> title="<?php echo $name; ?>" <?php echo $vars['js']; ?> /></a>
			</div>
			<div id="zome_product_image_<?php echo $vars['entity']->guid; ?>" class="zome_product_image">
				<img src="<?php echo $vars['entity']->getIconURL('large'); ?>">
			</div>
<?php
		}else if ($vars['display'] == "image"){
?>
			<img title="<?php echo $vars['entity']->title; ?>" src="<?php echo $vars['entity']->getIconURL($vars['size']); ?>" border="0" <?php echo $align; ?> title="<?php echo $name; ?>" <?php echo $vars['js']; ?> />
<?php
		}else if ($vars['display'] == "url"){
			echo $vars['entity']->getIconURL($vars['size']); 
		}
	}
?>
