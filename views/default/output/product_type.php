<?php
	/**
	 * Elgg output - produt type view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
 		 
	global $CONFIG;
	if ($vars['value'] <= 0)
		$vars['value'] = 1;
		
	if ($vars['display'] <= 0)
		$vars['display'] = "";
		
	$default_produt_types = $CONFIG->produt_type_default;
		
	if($vars['display'] == 1){
		echo $vars['options'][$vars['value']];
	}else{
		if (is_array($default_produt_types) && sizeof($default_produt_types) > 0 && $vars['value']) {	 
?>
			<a  class="object_product_type_string" href="<?php echo $vars['url']; ?>pg/socialcommerce/<?php echo $vars['value'];?>/type">
				<?php 
					foreach ($default_produt_types as $default_produt_type){
						if($default_produt_type->value == $vars['value']){
							echo $default_produt_type->display_val; 
							break;
						}
					}
				?>
			</a>
<?php
		}	
	}	
?>
