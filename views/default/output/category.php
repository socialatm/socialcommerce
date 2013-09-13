<?php
	/**
	 * Elgg category - output view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	if ($vars['value']) {
		$category = get_entity($vars['value']);
		if ($vars['display'] <= 0)
			$vars['display'] = "";	 
		if($vars['display'] == 1){
			echo $category->title;
		}else{
?>
			<a  class="object_category_string" href="<?php echo $vars['url']; ?>pg/<?php echo $CONFIG->pluginname; ?>/<?php echo $vars['value']; ?>/product_cate">
				<?php echo $category->title; ?>
			</a>
<?php
		}
	}		
?>
