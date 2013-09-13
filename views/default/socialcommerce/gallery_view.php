<?php
	/**
	 * Elgg view - gallery view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	
	$stores = $vars['entity'];
	$action = get_input('action');
	$product_guid = $stores->getGUID();
	$tags = $stores->tags;
	$title = $stores->title;
	$desc = $stores->description;
	
	
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = friendly_time($vars['entity']->time_created);
	$quantity_text = elgg_echo('quantity');
	$price_text = elgg_echo('price');
	$search_viewtype = get_input('search_viewtype');
	$mime = $stores->mimetype;
	
	$image =  elgg_view("socialcommerce/image", array(
								'entity' => $vars['entity'],
								'size' => 'medium',
								'display' => 'image'
							  ));
							  
	$info = "<div> <a href=\"{$stores->getURL()}\"><B>{$title}</B></a></div>";
	$info .= "<div class=\"owner_timestamp\">
		<a href=\"{$owner->getURL()}\">{$owner->name}</a> {$friendlytime}";
		$numcomments = elgg_count_comments($stores);
		if ($numcomments)
			$info .= ", <a href=\"{$stores->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
	$info .= "</div>";
	$product_type_out =  elgg_view('output/product_type',array('value' => $stores->product_type_id));
	$category_out =  elgg_view('output/category',array('value' => $stores->category));
	$tags_out =  elgg_view('output/tags',array('value' => $tags));
	if($stores->product_type_id == 1){
		if($stores->quantity > 0)
			$quantity = $stores->quantity;
		else 
			$quantity = 0;
		$quantity = "<B>{$quantity_text}:</B> {$quantity} &nbsp;";
	}else{
		$quantity = "";
	}
	$display_price = get_price_with_currency($stores->price);
	$rating = elgg_view("socialcommerce/view_rating",array('id'=>$stores->guid,'units'=>5,'static'=>''));
	$output = <<<EOF
		<script>
			function findPosX(obj) {
			    var curleft = 0;
			    if (obj.offsetParent) {
			        while (1) {
			            curleft+=obj.offsetLeft;
			            if (!obj.offsetParent) {
			                break;
			            }
			            obj=obj.offsetParent;
			        }
			    } else if (obj.x) {
			        curleft+=obj.x;
			    }
			    return curleft;
			}
			function display_gallery_product_details(e,guid){
				var window_width = $(document).width();
				var div_width = $("#gallery_product_details_"+guid).width();
				var div_height = $("#gallery_product_details_"+guid).height();
				div_height = div_height + 28;
				var mouseX = e.pageX;
				var leftPos = '-120px';
				var div_position = findPosX(document.getElementById('gallery_'+guid));
				
				if(div_width + div_position >= window_width )leftPos = '-150px';
				$("#gallery_product_details_"+guid).css('left',leftPos);
				$("#gallery_product_details_"+guid).css('top','-' + div_height + 'px');
				$("#gallery_product_details_"+guid).show();
				
			}
			function hide_gallery_product_details(guid){
				$("#gallery_product_details_"+guid).hide();
			}
		</script>
		<div id="gallery_{$product_guid}" onmouseover="display_gallery_product_details(event,{$product_guid})" onmouseout="hide_gallery_product_details({$product_guid})" class="gallery_product">
			<div style="position:relative;">
				<div id="gallery_product_details_{$product_guid}" class="pop_up_box gallery_product_details">
    		    	<div class="top_pop_box">
			        	<div class="left_top left"></div>
			            <div class="inner_top left"></div>
			            <div class="right_top left"></div>
			            <div class="clear"></div>
			        </div>
			        <div class="inner_area">
			        	<div class="inner_div">
			        		<div class="gallery_product_inner">
								{$info}
								<div>{$product_type_out}</div>
								<div class="gallery_product_cat">{$category_out}</div>
								<div class="gallery_product_tags object_tag_string">{$tags_out}</div>
								<div style="margin-bottom:5px;">{$quantity} <B>{$price_text}:</B> {$display_price}</div>
								{$rating}
							</div>
			            </div>
			        </div>
			        <div class="bottom_pop_box">
			        	<div class="left_bottom left"></div>
			            <div class="inner_bottom left"></div>
			            <div class="right_bottom left"></div>
			            <div class="clear"></div>
			        </div>	
			        <div class="arrow_bg"></div>
			        <div class="clear"></div>
			    </div>		
				<div class="gallery_product_icon">
					<a href="{$stores->getURL()}">{$image}</a>
				</div>
				<div class="gallery_product_price">{$display_price}</div>
				<div style="clear:both;"></div>
			</div>
		</div>
EOF;
	echo $output;
?>
