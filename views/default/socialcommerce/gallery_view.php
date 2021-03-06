<?php
	/**
	 * Elgg view - gallery view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
	$product = $vars['entity'];
	$action = get_input('action');
	$product_guid = $product->guid;
	$tags = $product->tags;
	$title = $product->title;
	$desc = $product->description;
	
	
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = elgg_view_friendly_time($vars['entity']->time_created);
	$quantity_text = elgg_echo('quantity');
	$price_text = elgg_echo('price');
	$search_viewtype = get_input('search_viewtype');
	$mime = $product->mimetype;

	$product_image_guid = sc_product_image_guid($product->guid);
	$image = '<img src ="'.elgg_get_config('url').'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/image/'.$product_image_guid.'/'.'medium'.'"/>'; 
							  
	$info = "<div> <a href=\"{$product->getURL()}\"><B>{$title}</B></a></div>";
	$info .= "<div class=\"owner_timestamp\">
		<a href=\"{$owner->getURL()}\">{$owner->name}</a> {$friendlytime}";
		$numcomments = $product->countComments();
		if ($numcomments)
			$info .= ", <a href=\"{$product->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
	$info .= "</div>";
	$product_type_out =  elgg_view('output/product_type',array('value' => $product->product_type_id));
	$category_out =  elgg_view('output/category',array('value' => $product->category));
	$tags_out =  elgg_view('output/tags',array('value' => $tags));
	if($product->product_type_id == 1){
		if($product->quantity > 0)
			$quantity = $product->quantity;
		else 
			$quantity = 0;
		$quantity = "<B>{$quantity_text}:</B> {$quantity} &nbsp;";
	}else{
		$quantity = "";
	}
	$display_price = get_price_with_currency($product->price);
	$rating = elgg_view("socialcommerce/view_rating",array('id'=>$product->guid,'units'=>5,'static'=>''));
	$output = <<<EOF
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
					<a href="{$product->getURL()}">{$image}</a>
				</div>
				<div class="gallery_product_price">{$display_price}</div>
				<div style="clear:both;"></div>
			</div>
		</div>
EOF;
	echo $output;
