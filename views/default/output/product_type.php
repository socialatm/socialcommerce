<?php
	/**
	 * Elgg output - product type view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
 		 
	if ($vars['value'] <= 0)
		$vars['value'] = 1;
		
	if ($vars['display'] <= 0)
		$vars['display'] = "";
		
	$default_product_types = elgg_get_config('product_type_default');
		
	if($vars['display'] == 1){
		echo $vars['options'][$vars['value']];
	}else{
		if (is_array($default_product_types) && sizeof($default_product_types) > 0 && $vars['value']) {	 
?>
			<a  class="object_product_type_string" href="<?php echo elgg_get_config('url'); ?>socialcommerce/<?php echo $vars['value'];?>/type">
				<?php 
					foreach ($default_product_types as $default_product_type){
						if($default_product_type->value == $vars['value']){
							echo $default_product_type->display_val; 
							break;
						}
					}
				?>
			</a>
<?php
		}	
	}
