<?php
/**
 * Elgg view - extend header
 * 
 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
global $CONFIG;
$context = get_context();
if($context == 'socialcommerce' || $context == 'stores' || $context == 'search' || $context == 'main'){
	
?>
<?PHP
}

// @todo - set up like this it loads all the time ??

?>
<script type="text/javascript" src="<?php echo $CONFIG->wwwroot; ?>mod/<?php echo $CONFIG->pluginname; ?>/js/socialcommerce.js"></script>