<?php
	/**
	 * Elgg icon - mid audio
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
 ?>

<object type="audio/midi" data="<?php echo elgg_get_config('url'); ?>action/socialcommerce/download?stores_guid=<?php echo $vars['entity']->getGUID(); ?>" width="200" height="20">
  <param name="autoplay" value="false">
  <param name="autoStart" value="0">
</object>
