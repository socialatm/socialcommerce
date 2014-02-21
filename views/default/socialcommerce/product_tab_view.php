<?PHP
	/**
	 * Elgg view - product tab
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$base_view = $vars['base_view'];												//	@todo - take a close look at this
	$filter = $vars['filter'];
	$baseurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$replace_url = preg_replace('/[\&\?]filter\=[a-z,A-Z]*/',"",$baseurl);
	$url = preg_replace('/[\&\?]offset\=[0-9]*/',"",$replace_url);
	if (substr_count($url,'?')) {
		$separator .= "&";
	} else {
		$separator .= "?";
	}
?>
	<div id="elgg_horizontal_tabbed_nav">
		<ul class="elgg-menu elgg-menu-filter elgg-menu-hz elgg-menu-filter-default">
			<li <?php if($filter == "active") echo "class='elgg-state-selected'"; ?>><a href="<?php echo $url.$separator; ?>filter=active"><?php echo elgg_echo('active:products'); ?></a></li>
			<li <?php if($filter == "deleted") echo "class='elgg-state-selected'"; ?>><a href="<?php echo $url.$separator; ?>filter=deleted"><?php echo elgg_echo('deleted:products'); ?></a></li>
		</ul>
	</div>
	<?php echo $base_view; ?>
