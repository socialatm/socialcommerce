<?php
	/**
	 * Elgg widget - recent - view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
?>
<script type="text/javascript">
$(document).ready(function () {

$('a.show_product_recent_desc').click(function () {
	$(this.parentNode).children("[class=stores_listview_desc]").slideToggle("fast");
	return false;
});

}); /* end document ready function */
</script>


<?php
	global $CONFIG;
    //the page owner
	$owner = $vars['entity']->owner_guid;
	$widget_guid = $vars['entity']->guid;
	//the number of files to display
	$number = (int) $vars['entity']->num_display;
	if (!$number)
		$number = 1;
		
	//How to display the files
	$display = $vars['entity']->product_display;
	if (!$display)
		$display = 1;
	
	//get the layout view which is set by the user in the edit panel
	$get_view = (int) $vars['entity']->gallery_list;
	if (!$get_view || $get_view == 1) {
	    $view = "list";
    }else{
        $view = "gallery";
    }

	//get the user's files			@todo - switch statement here ?
	if($display == 1){
		$product = elgg_get_entities_from_metadata(array(
			'status' => 1,
			'entity_type' =>'object',
			'entity_subtype' => 'stores',
			'owner_guid' => elgg_get_page_owner_guid(),
			'limit' => $number,
			))  	
			
	}else if($display == 2){
		if ($friends = get_user_friends($user_guid, $subtype, 999999, 0)) {
			$friendguids = array();
			foreach($friends as $friend) {
				$friendguids[] = $friend->getGUID();
			}
			$product = elgg_get_entities_from_metadata(array(
				'status' => 1,
				'entity_type' =>'object',
				'entity_subtype' => 'stores',
				'owner_guid' => $friendguids,
				'limit' => $number,
				))  	
		}
	}else if($display == 3){
		$product = elgg_get_entities_from_metadata(array(
				'status' => 1,
				'entity_type' =>'object',
				'entity_subtype' => 'stores',
				'owner_guid' => 0,
				'limit' => $number,
				))  	
	}
	
	// if there are files get them
	if ($product) {
    	
    	echo "<div id=\"stores_widget_layout\">";
        
        if($view == "gallery"){
        
         	$i = 0;
            //display in gallery mode
            foreach($product as $f){
            	if($i%5 == 0){
					$products_list .= "</tr><tr>";
				}
                $mime = $f->mimetype;
                $product_img = elgg_view("socialcommerce/image", array(
						'entity' => $f,
						'size' => 'medium',
						'display'=>'image'
						));
                $product_img = "<a onmouseover=\"recent_products_list_mouseover_action($f->guid,$widget_guid)\" onmouseout=\"recent_products_list_mouseout_action($f->guid,$widget_guid)\" href=\"{$f->getURL()}\">" . $product_img . "</a>";
            	$products_list .= <<<EOF
					<td>
						<div id="recent_products_list_{$f->guid}{$widget_guid}" class="popular_products_list">
							$product_img
						</div>
					</td>
EOF;
				$i++;
            }
            
             echo $cart_body = <<<EOF
				<script>
					function recent_products_list_mouseover_action(product_guid,widget_guid){
						$("#recent_products_list_"+product_guid+widget_guid).fadeTo("fast", 1); 
						$("#recent_products_list_"+product_guid+widget_guid+" img").css("width","42px");
						$("#recent_products_list_"+product_guid+widget_guid+" img").css("border","1px solid #e89005");
						$("#recent_products_list_"+product_guid+widget_guid+" img").css("padding","1px");
					}
					function recent_products_list_mouseout_action(product_guid,widget_guid){
						$("#recent_products_list_"+product_guid+widget_guid).fadeTo("fast", 0.8); 
						$("#recent_products_list_"+product_guid+widget_guid+" img").css("width","45px");
						$("#recent_products_list_"+product_guid+widget_guid+" img").css("border","none");
						$("#recent_products_list_"+product_guid+widget_guid+" img").css("padding","0");
					}
				</script>
				<div class="contentWrapper">
					<table class="popular_products_list_table">
						<tr>
							{$products_list}
						</tr>
					</table>
					<div style="clear:both;"></div>
				</div>
EOF;
            
        }else{
        	    
            //display in list mode
            foreach($product as $f){
            	
                $mime = $f->mimetype;
               	$description = $f->description;
		        if (!empty($description)){ 
		        	$more = "<a href=\"javascript:void(0);\" class=\"show_product_recent_desc\">". elgg_echo('more') ."</a><br /><div class=\"stores_listview_desc\">" . $description . "</div>";
		        }
		        $product_icon = elgg_view("socialcommerce/image", array(
										'entity' => $f,
										'size' => 'medium',
										'display'=>'image'
										));
									  
		        $time_creatd =  elgg_view_friendly_time($f->time_created);
		        $price_text = elgg_echo('price');
				$cart_url = addcartURL($f);
				$cart_text = elgg_echo('add:to:cart');
				$wishlist_text = elgg_echo('add:wishlist');
				$hidden = elgg_view('input/securitytoken');
				if($f->owner_guid != $_SESSION['user']->guid){
					$cart_wishlist = <<<EOF
						<div class="cart_wishlist">
							<a title="{$cart_text}" class="cart" href="{$cart_url}">&nbsp;</a>
						</div>
						<div class="cart_wishlist">
							<form name="frm_wishlist_{$f->guid}" method="POST" action="{$CONFIG->url}action/socialcommerce/add_wishlist">
								<a title="{$wishlist_text}" class="wishlist" onclick=" document.frm_wishlist_{$f->guid}.submit();" href="javascript:void(0);">&nbsp;</a>
								<INPUT type="hidden" name="product_guid" value="{$f->guid}">
							</form>
						</div>
EOF;
				}
				$display_price = get_price_with_currency($f->price);
		        $inner_content .= <<<EOF
		        	<div style="clear:both;" class="search_listing">
		        		<div class="stores_listview_icon"><a href="{$f->getURL()}">{$product_icon}</a></div>
		        		<div class="stores_widget_content">
		        			<div class="stores_listview_title"><p class="stores_title">{$f->title}</p></div>
		        			<div class="stores_listview_date"><p class="stores_timestamp"><small>{$time_creatd}</small></p></div>
		        			<div class="product_actions" style="padding-bottom:5px;">
								<div style="clear:both;"></div>
								<div class="price_list">
									{$price_text}: {$display_price}
								</div>
								{$cart_wishlist}
								<div style="clear:both;"></div>	
							</div>
		        			
		        			{$more}
		        		</div>
		        		<div style="clear:both;"></div>
		        	</div>
EOF;
            }
        	echo $content = <<<EOF
        		<div  class="stores_widget_singleitem stores">
        			{$inner_content}
        			<div style="clear:both;"></div>
        		</div>
EOF;
        }
        //get a link to the users files
        $users_file_url = $vars['url'] . "socialcommerce/" . get_user($f->owner_guid)->username;
        echo "</div>";
    } else {
		echo elgg_echo("stores:none");
	}
?>
