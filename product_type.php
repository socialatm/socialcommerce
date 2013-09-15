<?php
	/**
	 * Elgg product - type
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	global $CONFIG;
	// Load Elgg engine
		require_once(get_config('path').'engine/start.php');

	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}
		
		$product_type_id = get_input('stores_guid');
	
	// Set stores title
		$title = elgg_view_title(elgg_view('output/product_type',array('value' => $product_type_id,'display'=>1)));
		
		$search_viewtype = get_input('search_viewtype');
		if($search_viewtype == 'gallery'){
			$limit = 20;
		}else{
			$limit = 10;
		}
	
	// Get objects
		elgg_set_context('search');
		if (isadminloggedin()) {
			$filter = get_input("filter");
			if(!$filter)
				$filter = "active";
			switch($filter){
				case "active":
					$area2 = list_entities_from_metadata_multi(array('status'=>1,'product_type_id'=>$product_type_id),"object","stores",0,$limit);
				break;
				case "deleted":
					$area2 = list_entities_from_metadata_multi(array('status'=>0,'product_type_id'=>$product_type_id),"object","stores",0,$limit);
				break;
			}
			if(empty($area2)){
				$area2 = "<div style=\"padding:10px;\">".elgg_echo('no:data')."</div>";	
			}
			
			$area2 = elgg_view("socialcommerce/product_tab_view",array('base_view' => $area2, "filter" => $filter));
		}else{
			$area2 .= list_entities_from_metadata_multi(array('status'=>1,'product_type_id'=>$product_type_id),"object","stores",0,$limit);
		}
		//$area2 .= list_entities_from_metadata('product_type_id',$product_type_id,"object","stores",0);
		$area2 = <<<EOF
			{$title}
			<div class="contentWrapper stores">
				{$area2}
			</div>
EOF;
		elgg_set_context('stores');
		// These for left side menu
			$area1 .= gettags();
		//$area1 .= get_storestype_cloud(page_owner());
	// Create a layout
		$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
	
	// Finally draw the page
		page_draw(sprintf(elgg_echo("stores:your"),page_owner_entity()->name), $body);
?>
