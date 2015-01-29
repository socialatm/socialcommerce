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
	 
	require_once('C:/Program Files (x86)/Zend/Apache2/htdocs/krumo/class.krumo.php');
	echo 'Trying to use old image format<b>'.__FILE__ .' at '.__LINE__;
	krumo::includes();
	die();
	
/*********************************************************************************************************************************************

This will tell us what files are trying to use the old product image handler

search for:  elgg_view("socialcommerce/image" in the included files

here is the new format:

$url = elgg_get_config('url').'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/image/'.$product_guid.'/'.$size; 	

***********************************************************************************************************************************************/	
			
/***************************	OLD STUFF BELOW	*************************************************/


		// Get display
		$display = $vars['display'] ? $vars['display'] : 'full';
		
		// icontime? @todo: is it used anywhere?
		$icontime = $product->icontime ? $product->icontime : 'default';
		
			
		// Get any align and js
		if (!empty($vars['align'])) {
			$align = " align=\"{$vars['align']}\" ";
		} else {
			$align = "";
		}
			
			
		
		
		if($vars['display'] == "full"){
		
?>
			<div class="product_image">
				<a href="<?php echo $product->getURL(); ?>" class="icon" >
					
					<img src="<?php echo 'file://'.$file; ?>"
			
					title="<?php echo $product->title; ?>" width = "600px" height = "600px"

					<?php echo $align; ?> 
			
					<?php echo $vars['js']; ?> />
				</a>
			</div>
	
<?php
		}else if ($vars['display'] == "image"){
?>
			<img title="<?php echo $vars['entity']->title; ?>" src="<?php echo 'file://'.$file; ?>" <?php echo $align; ?> title="<?php echo $name; ?>" <?php echo $vars['js']; ?> />
<?php

		}else if ($vars['display'] == "url"){
			echo $vars['entity']->getIconURL($vars['size']); 
		}
	}

