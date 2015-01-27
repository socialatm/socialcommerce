<?php
	/**
	 * Elgg view - product image
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
	$stores = $vars['entity'];
	
//	echo '<b>'.__FILE__ .' at '.__LINE__.'</b>';
	require_once('C:/Program Files (x86)/Zend/Apache2/htdocs/krumo/class.krumo.php');
	$arr2 = get_defined_vars();
//	krumo($arr2);
//	krumo::session();
//	krumo($stores->display);

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
			<div class="product_image">
			<a href="<?php echo $vars['entity']->getURL(); ?>" class="icon" >
					
			<img onmouseover="display_zoome_image(<?php echo $vars['entity']->guid; ?>,this)" onmouseout="hide_zoome_image(<?php echo $vars['entity']->guid; ?>)"
			
			title="<?php echo $vars['entity']->title; ?>"

			src="<?php echo $vars['entity']->getIconURL($vars['size']); ?>"

			border="0"

			<?php echo $align; ?> 
			
			title="<?php echo $name; ?>"

			<?php echo $vars['js']; ?> /></a>
			
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
