<?php
	/**
	 * Elgg checkout process
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	gatekeeper();
	$page_owner = elgg_get_logged_in_user_entity();
	$checkout_order = get_input('checkout_order');
	
		if(is_null($checkout_order)){
			$checkout_order = 0;
			unset($_SESSION['CHECKOUT']);
			$cart = elgg_get_entities(array( 	
				'type' => 'object',
				'subtype' => 'cart',
				'owner_guid' => $page_owner->guid,
				)); 
				
			if($cart){				//	@todo - should probably register an error and forward if cart is empty...
				$cart = $cart[0];
				$cart_items = elgg_get_entities_from_relationship(array(
					'relationship' => 'cart_item',
					'relationship_guid' => $cart->guid, 
					)); 
				if($cart_items){
					foreach ($cart_items as $cart_item){
						$product = get_entity($cart_item->product_id);
						if($_SESSION['CHECKOUT']['allow_shipping'] != 1){
							if( $product->product_type_id == 2 )				//	@todo - we can change this setting when we're building shipping methods.... 
								$_SESSION['CHECKOUT']['allow_shipping'] = 0;
							else 
								$_SESSION['CHECKOUT']['allow_shipping'] = 1;
						}
						$_SESSION['CHECKOUT']['product'][$cart_item->product_id] = (object)array('quantity'=>$cart_item->quantity,'price'=>$cart_item->amount,'type'=>$product->product_type_id);
					}
				}
			}
		}else{
			$checkout_confirm = 0;
			$checkout_order = $checkout_order + 1;	
			
			switch($checkout_order){
				case 1:
					$_SESSION['CHECKOUT']['confirm_billing_address'] = 1;
					if($address_guid = get_input('billing_address_guid')){
						$selected_address = get_entity($address_guid);
						$_SESSION['CHECKOUT']['billing_address'] = (object) array(
							'guid'=>$selected_address->guid,
							'firstname'=>$selected_address->first_name,
							'lastname'=>$selected_address->last_name,
							'address_line_1'=>$selected_address->address_line_1,
							'address_line_2'=>$selected_address->address_line_2,
							'city'=>$selected_address->city,
							'state'=>$selected_address->state,
							'country'=>$selected_address->country,
							'pincode'=>$selected_address->pincode,
							'mobileno'=>$selected_address->mobileno,
							'phoneno'=>$selected_address->phoneno
						);
					}
						//$checkout_order = $checkout_order + 1;
					break;
				case 2:
					$_SESSION['CHECKOUT']['confirm_checkout_method'] = 1;	
					$_SESSION['CHECKOUT']['checkout_method'] = get_input('checkout_method');
					break;
				case 3:
					$_SESSION['CHECKOUT']['confirm_shipping_method'] = 1;	
					$_SESSION['CHECKOUT']['shipping_method'] = get_input('shipping_method');
					break;
				case 4:
					$checkout_confirm = 1;
					$redirect = check_checkout_form();
					break;
			}
		}
		
	$title = elgg_view_title(elgg_echo('checkout:process'));
		
	//--------- Billing Address Details ----------//
	$billing_details = elgg_view("socialcommerce/billing_details", array('checkout_order'=>$checkout_order));
	if($_SESSION['CHECKOUT']['confirm_billing_address'] == 1){
		$billing_address_modify = "<span id='checkout_modify_0' class='checkout_modify' onclick='change_modified(0);'>".elgg_echo('checkout:modify')."</span><span style='clear:both'></span>";
	}
	//--------- Checkout Methods Details ----------//
	$checkout_method_details = elgg_view("socialcommerce/list_checkout_methods");
	if($_SESSION['CHECKOUT']['confirm_checkout_method'] == 1){
		$checkout_method_modify = "<span id='checkout_modify_1' class='checkout_modify' onclick='change_modified(1);'>".elgg_echo('checkout:modify')."</span><span style='clear:both'></span>";
	}
	//--------- Shipping Methods Details ----------//
	$shipping_method_details = elgg_view("socialcommerce/list_shipping_methods");
	if($_SESSION['CHECKOUT']['confirm_shipping_method'] == 1){
		$shipping_method_modify = "<span id='checkout_modify_2' class='checkout_modify' onclick='change_modified(2);'>".elgg_echo('checkout:modify')."</span><span style='clear:both'></span>";
	}
	//--------- Order Confirmation ----------//	
		if(isset($_SESSION['CHECKOUT']['checkout_method']) && $_SESSION['CHECKOUT']['checkout_method'] != ""){
			$checkout_plugin = $_SESSION['CHECKOUT']['checkout_method'];
			$order_confirmation_details = elgg_view("socialcommerce/cart_confirm_list",array('checkout_confirm'=>$checkout_confirm));
			$checkout_checkout_confirm = elgg_echo('checkout:checkout:confirm');
			if($checkout_confirm){
				$check_out_details = <<<EOF
					<h3>
						<a>
							<span class="list1b_icon"></span>
							<B>{$checkout_checkout_confirm}</B>
						</a>
					</h3>
					<div class="ui_content">
						<div class="content">
							{$redirect}
							<div class="clear"></div>
						</div>
					</div>
EOF;
			}
		}
		
		$class = $_SESSION['CHECKOUT']['allow_shipping'] == 1 ? '' : 'class="shipping_disable"';
		$no_coupon = elgg_echo('no:coupon:in:couponcode');
		$exp_date = elgg_echo('coupon:exp_date');
		$coupon_maxuses = elgg_echo('coupon:maxuses:limit');
		$not_applied = elgg_echo('coupon:not_applied');
		$coupon_applied = elgg_echo('coupon:applied');
		$checkout_billing_details = elgg_echo('checkout:billing:details');
		$checkout_checkout_method = elgg_echo('checkout:checkout:method');
		$checkout_shipping_method = elgg_echo('checkout:shipping:method');
		$checkout_order_confirm = elgg_echo('checkout:order:confirm');
		
		$content = <<<EOF
			<div class="checkout_process">
				<script type="text/javascript" src="{$CONFIG->url}mod/socialcommerce/js/jquery.accordion.js"></script>
				<script type="text/javascript">
					$(document).ready(function(){
						jQuery('#list1b').accordion({
							autoheight: false,
							header: 'h3',
							event: '',
							active: {$checkout_order}
						});
					});
					function change_modified(order){
						jQuery('#list1b').accordion("activate",order);
					}
					function toggle_address_type(address,type){
						if(type == 'select') {
							$('.select_'+address+'_address').show();
							$('.add_'+address+'_address').hide();
						}else {
							$('.add_'+address+'_address').show();
							$('.select_'+address+'_address').hide();
						}
					}
					
					function validate_billing_details(){
						var billing_address_type = $("input[@name='billing_address_type']:checked").val();
						var billing_address = $("input[@name='billing_address_guid']:checked").val();
						if(billing_address_type == "existing"){
							if($.trim(billing_address) == ""){
								alert("Please select one Address");
								return false;
							}
						}else if(billing_address_type == "add"){
							alert("Please Add Address");
							return false;
						}
						return true;
					}
					
					function validate_shipping_details(){
						var shipping_address_type = $("input[@name='shipping_address_type']:checked").val();
						var shipping_address = $("input[@name='shipping_address_guid']:checked").val();
						if(shipping_address_type == "existing"){
							if($.trim(shipping_address) == ""){
								alert("Please select one Address");
								return false;
							}
						}else if(shipping_address_type == "add"){
							alert("Please Add Address");
							return false;
						}
						return true;
					}
					
					function apply_couponcode(){
						var couponcode = $("#couponcode").val();
						if($.trim(couponcode) == ''){
							$("#coupon_apply_result").html("Please enter the Coupon Code");
							$("#couponcode").focus();
							$("#coupon_apply_result").css({"color":"#9F1313"});
							$("#coupon_apply_result").show();
						}else{
							var elgg_token = $('[name=__elgg_token]');
							var elgg_ts = $('[name=__elgg_ts]');
							$.post("{$CONFIG->url}action/socialcommerce/manage_socialcommerce", { 
									code: couponcode,
									manage_action: "coupon_process",
									__elgg_token: elgg_token.val(),
									__elgg_ts: elgg_ts.val()
								},
								function(data){
									data = data.split(",");
									switch(data[0]){
										case 'no_coupon':
												$("#coupon_apply_result").html("{$no_coupon}");
												$("#coupon_apply_result").css({"color":"#9F1313"});
											break;
										case 'exp_date':
												$("#coupon_apply_result").html("{$exp_date}"+data[1]);
												$("#coupon_apply_result").css({"color":"#9F1313"});
											break;
										case 'not_applied':
												$("#coupon_apply_result").html("{$not_applied}");
												$("#coupon_apply_result").css({"color":"#9F1313"});
											break;
										case 'coupon_maxuses':
												$("#coupon_apply_result").html("{$coupon_maxuses}");
												$("#coupon_apply_result").css({"color":"#9F1313"});
											break;
										case 'coupon_applied':
												$.post("{$CONFIG->url}action/socialcommerce/manage_socialcommerce", {
														manage_action: "coupon_reload_process",
														__elgg_token: elgg_token.val(),
														__elgg_ts: elgg_ts.val()
													},
													function(data1){
														if(data1){
															$("#checkout_confirm_list").html(data1);
															$("#coupon_apply_result").html("{$coupon_applied}");
															$("#coupon_apply_result").css({"color":"#099F10"});
															$("#couponcode").val('');
														}
												});
											break;
										default:
												$("#coupon_apply_result").html("Unknown Error");
												$("#coupon_apply_result").css({"color":"#9F1313"});
											break;
									}
									$("#coupon_apply_result").show();
								}
							);
						}
						return false;
					}
				</script>
				<div class="basic" id="list1b">
					<h3>
						<a>
							<span class="list1b_icon"></span>
							<B>{$checkout_billing_details}</B>
							{$billing_address_modify}
						</a>
					</h3>
					<div class="ui_content">
						<div class="content">
							<div id="billing_address">
								{$billing_details}
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<h3>
						<a>
							<span class="list1b_icon"></span>
							<B>{$checkout_checkout_method}</B>
							{$checkout_method_modify}
						</a>
					</h3>
					<div class="ui_content">
						<div class="content">
							<div id="checkout_methods">
								{$checkout_method_details}
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<h3>
						<a>
							<span class="list1b_icon"></span>
							<B>{$checkout_shipping_method}</B>
							{$shipping_method_modify}
						</a>
					</h3>
					<div class="ui_content">
						<div class="content">
							<div id="checkout_methods">
								{$shipping_method_details}
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<h3>
						<a>
							<span class="list1b_icon"></span>
							<B>{$checkout_order_confirm}</B>
						</a>
					</h3>
					<div class="ui_content">
						<div class="content">
							<div id="checkout_methods">
								{$order_confirmation_details}
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					{$check_out_details}
				</div>
			</div>
			<div id="load_action"></div>
			<div id='load_action_div'>
				<img src="{$CONFIG->url}mod/socialcommerce/images/loadingAnimation.gif">
				<div style="color:#FFFFFF;font-weight:bold;font-size:14px;margin:10px;">Processing...</div>
			</div>
EOF;
		
	$content = '<div class="contentWrapper stores">'.$content.'</div>';
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
	
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo("checkout:process"), $body);
?>
