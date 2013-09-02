<?php
	/**
	 * Elgg input - product type
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	$class = isset($vars['class'])? $vars['class'] : "input-product-type" ;
	if (!array_key_exists('value', $vars)) { $vars['value'] = 1; }
	
	$default_produt_types = $CONFIG->produt_type_default;			// @todo - spelling issue...
	$product_type_label = elgg_echo('product:type');
	
	//	make sure $vars['value'] is an array...
	$vars['value'] = is_array($vars['value']) ? $vars['value'] : array($vars['value']);
	
 	if (is_array($default_produt_types) && sizeof($default_produt_types) > 0) {	 
?>
		<p>
			<label><span style="color:red">*</span><?php echo $product_type_label?></label><br />
			<select <?php if($vars['multiple']) echo $vars['multiple']; ?> id="<?php echo $vars['internalname']; ?>" name="<?php echo $vars['internalname']; ?><?php if($vars['multiple']) echo "[]"; ?>" <?php if (isset($vars['js'])) echo $vars['js']; ?> <?php if ((isset($vars['disabled'])) && ($vars['disabled'])) echo ' disabled="yes" '; ?> class="<?php echo $class; ?>">
			<?php
			    foreach($default_produt_types as $option) {
			        if ($option->value == $vars['value']  || in_array($option->value,$vars['value'])) {
			            echo "<option value=\"{$option->value}\" selected=\"selected\">". htmlentities($option->display_val, ENT_QUOTES, 'UTF-8') ."</option>";
			        } else {
			            echo "<option value=\"{$option->value}\">". htmlentities($option->display_val, ENT_QUOTES, 'UTF-8') ."</option>";
			        }
			    }
			?> 
			</select>
		</p>	
<?php
	}	
?>
