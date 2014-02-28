				<script type="text/javascript" src="{$CONFIG->url}mod/socialcommerce/js/jquery.accordion.js"></script>
				<script type="text/javascript">
					$(document).ready(function(){
						jQuery('#list1b').accordion({
							autoheight: false,
							header: 'h3',
							event: '',
							active: {$checkout_order}
						});
						
			//	toggle between the current and add new billing address forms
			
					$("#billing_address_type > li:nth-child(1)").change(function() { 
					 	$("#current_billing_address, #add_billing_address").toggle(); 
					});
					
					$("#billing_address_type > li:nth-child(2)").change(function() { 
					 	$("#current_billing_address, #add_billing_address").toggle(); 
					});
			
			//	end toggle between the current and add new billing address forms
					
					
					}); 	// end document.ready
					
					
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