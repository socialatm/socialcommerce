<?php
	/**
	 * Elgg search - view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	// Load Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		
	// Get input
		$md_type = 'tags';
		$tag = get_input('tag');
		$search_viewtype = get_input('search_viewtype');

		
		

		if (empty($tag)) {
			$title = elgg_view_title(elgg_echo('stores:type:all'));
		} else {
			$title = elgg_view_title(elgg_echo($tag));
		}
		
			$area1 = gettags();
		
		// Set context
		elgg_set_context('search');
		
		$limit = 10;
		
		if (elgg_is_admin_logged_in()) {
			$filter = get_input("filter");
			if(!$filter)
				$filter = "active";
			switch($filter){
				case "active":
					if (!empty($tag)) {
						$area2 = list_entities_from_metadata_multi(array('status'=>1,$md_type=>$tag),"object","stores",0,10);
					}else{
						$area2 = elgg_list_entities_from_metadata('status',1,"object","stores",0,10);
					}
				break;
				case "deleted":
					if (!empty($tag)) {
						$area2 = list_entities_from_metadata_multi(array('status'=>0,$md_type=>$tag),"object","stores",0,10);
					}else{
						$area2 = elgg_list_entities_from_metadata('status',0,"object","stores",0,10);
					}
				break;
			}
			if(empty($area2)){
				$area2 = "<div style=\"padding:10px;\">".elgg_echo('no:data')."</div>";	
			}
			
			$area2 = elgg_view("{$CONFIG->pluginname}/product_tab_view",array('base_view' => $area2, "filter" => $filter));
		}else{
			if (!empty($tag)) {
				$area2 = list_entities_from_metadata_multi(array('status'=>1,$md_type=>$tag),"object","stores",0,10);	
			}else{
				$area2 .= elgg_list_entities_from_metadata('status',1,"object","stores",0,10);
			}
		}
		$area2 = <<<EOF
			{$title}
			<div class="contentWrapper stores">
				{$area2}
			</div>
EOF;
		/*if (!empty($tag)) {
			$area2 .= elgg_list_entities_from_metadata($md_type, $tag, 'object', 'stores', $owner_guid, $limit,1,0);
		} else {
			$area2 .= list_entities("object", "stores", 0, $limit);
		}*/
		
		elgg_set_context("stores");
		
		$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
		
		page_draw(sprintf(elgg_echo('searchtitle'),$tag),$body);

?>