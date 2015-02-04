<?php
	/**
	 * Elgg view - product list
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version	elgg 1.9.4
	 **/ 
	 
$products = elgg_get_entities_from_metadata(array(
 	'status' => 1,
	'type_subtype_pairs' => array('object' => 'stores'),
	'owner_guid' => 0,
	'limit' => 16,
	));  	

// @todo - why a limit of 16 above ??

if($products){
	$products_list = "";
	$i = 0;
	foreach ($products as $product){
		$product_path = $product->getURL();
		$mime = $product->mimetype;
		
		$product_image_guid = sc_product_image_guid($product->guid);
		$image = '<img src ="'.elgg_get_config('url').'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/image/'.$product_image_guid.'/'.'small'.'"/>'; 
									  
		if($i%8 == 0){
			$products_list .= "</tr><tr>";
		}
		$products_list .= <<<EOF
			<td>
				<div id="products_list_{$product->guid}" class="products_list">
					<a onmouseover="products_list_mouseover_action($product->guid)" onmouseout="products_list_mouseout_action($product->guid)" href="{$product_path}">
						$image
					</a>
				</div>
			</td>
EOF;
	$i++;
	}
	$latest_popular_text = elgg_echo('latest:products');
	echo $cart_body = <<<EOF
		<script>
			function products_list_mouseover_action(product_guid){
				$("#products_list_"+product_guid).fadeTo("fast", 1); 
				$("#products_list_"+product_guid+" img").css("width","42px");
				$("#products_list_"+product_guid+" img").css("border","1px solid #e89005");
				$("#products_list_"+product_guid+" img").css("padding","1px");
			}
			function products_list_mouseout_action(product_guid){
				$("#products_list_"+product_guid).fadeTo("fast", 0.8); 
				$("#products_list_"+product_guid+" img").css("width","45px");
				$("#products_list_"+product_guid+" img").css("border","none");
				$("#products_list_"+product_guid+" img").css("padding","0");
			}
		</script>
		<div class="index_box">
			<h2>{$latest_popular_text}</h2>
			<div class="contentWrapper">
				<table class="products_list_table">
					<tr>
						{$products_list}
					</tr>
				</table>
				<div style="clear:both;"></div>
			</div>
		</div>
EOF;
}
