<?php
   /**
	* Elgg view - extend header
	* 
	* @package Elgg SocialCommerce
	* @license http://www.gnu.org/licenses/gpl-2.0.html
	* @author twentyfiveautumn.com
	* @copyright twentyfiveautumn.com 2013
	* @link http://twentyfiveautumn.com/
	**/ 
	 
$context = elgg_get_context();
if($context == 'socialcommerce' || $context == 'stores' || $context == 'search' || $context == 'main'){
	
}

// @todo - set up like this it loads all the time ??

?>
<script type="text/javascript" src="<?php echo elgg_get_config('url'); ?>mod/socialcommerce/js/socialcommerce.js"></script>
