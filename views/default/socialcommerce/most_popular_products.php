<?php
	/**
	 * Elgg view - most popular products
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
global $CONFIG;
$most_rateds = get_purchased_orders('final_value','','object','rating','','',true,'','DESC',500,0);
if($most_rateds){
	$products_list = "";
	$i = 0;
	foreach ($most_rateds as $most_rated){
		if($i == 16){
			break;
		}
		$most_rated = get_entity($most_rated->guid);
		$product = get_entity($most_rated->product_guid);
		if($product){
				$product_path = $product->getURL();
				$mime = $product->mimetype;
				$product_img = elgg_view("{$CONFIG->pluginname}/image", array(
										'entity' => $product,
										'size' => 'medium',
										'display'=>'image'
									  )
								);
				if($i%8 == 0){
					$products_list .= "</tr><tr>";
				}
				$products_list .= <<<EOF
					<td>
						<div id="popular_products_list_{$product->guid}" class="popular_products_list">
							<a onmouseover="popular_products_list_mouseover_action($product->guid)" onmouseout="popular_products_list_mouseout_action($product->guid)" href="{$product_path}">
								$product_img
							</a>
						</div>
					</td>
EOF;
			$i++;
		}
	}
	$most_popular_text = elgg_echo('most:popular:products');
	echo $cart_body = <<<EOF
		<script>
			function popular_products_list_mouseover_action(product_guid){
				$("#popular_products_list_"+product_guid).fadeTo("fast", 1); 
				$("#popular_products_list_"+product_guid+" img").css("width","42px");
				$("#popular_products_list_"+product_guid+" img").css("border","1px solid #e89005");
				$("#popular_products_list_"+product_guid+" img").css("padding","1px");
			}
			function popular_products_list_mouseout_action(product_guid){
				$("#popular_products_list_"+product_guid).fadeTo("fast", 0.8); 
				$("#popular_products_list_"+product_guid+" img").css("width","45px");
				$("#popular_products_list_"+product_guid+" img").css("border","none");
				$("#popular_products_list_"+product_guid+" img").css("padding","0");
			}
		</script>
		<div class="index_box">
			<h2>{$most_popular_text}</h2>
			<div class="contentWrapper">
				<table class="popular_products_list_table">
					<tr>
						{$products_list}
					</tr>
				</table>
				<div style="clear:both;"></div>
			</div>
		</div>
EOF;
}
?>
