<?php
	/**
	 * Elgg icon - mp3 audio
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
?>

<object type="audio/mpeg" data="<?php echo $vars['url']; ?>action/socialcommerce/download?stores_guid=<?php echo $vars['entity']->getGUID(); ?>" width="200" height="20">
  <param name="autoplay" value="false">
  <param name="autoStart" value="0">
</object>
