<?php
	/**
	 * Elgg search - over write gallery view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	$entities = $vars['entities'];
	if (is_array($entities) && sizeof($entities) > 0) {
		
?>
	<table class="search_gallery">
		<tr>
<?php
		$col = 0;
		foreach($entities as $entity) {
			if ($col%5 == 0 && $col != 0) {
				echo "</tr><tr>";
			}
			echo "<td class=\"product_gallery_item\">";
			echo elgg_view_entity($entity);
			echo "</td>";
			$col++;			
		}
		if ($col > 0) echo "</tr>";
		
?>
		</tr>
	</table>
<?php
	}
?>
