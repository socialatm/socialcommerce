<?php
/**
 * Elgg icon - x-wav audio
 * 
 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
 ?>
	 
<?php global $CONFIG; ?>
<object type="audio/x-wav" data="<?php echo $vars['url']; ?>action/<?php echo $CONFIG->pluginname; ?>/download?stores_guid=<?php echo $vars['entity']->getGUID(); ?>" width="200" height="20">
  <param name="autoplay" value="false">
  <param name="autoStart" value="0">
</object>