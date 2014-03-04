$(document).ready(function () {

    $(function () {
        $("#wizard").steps({
            headerTag: "h2",
            bodyTag: "div",
            transitionEffect: "fade",
            transitionEffectSpeed: "slow",
			onStepChanging: function (event, currentIndex, newIndex) {
				alert("Step Changing Fired \n\n Current Index:"+currentIndex);
				myFunction(currentIndex);
					
					//	start testing jquery.form
				var options = { 
					beforeSubmit:  showRequest,  // pre-submit callback 
					success:       showResponse  // post-submit callback 
				}; 
				$('#current_billing_address_form').ajaxForm(options); 

				function showRequest(formData, jqForm, options) { 
					var queryString = $.param(formData); 
					alert('About to submit: \n\n' + queryString); 
					return true; 
				} 
 
				function showResponse(responseText, statusText, xhr, $form)  { 
					alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + 
					'\n\nThe output div should have already been updated with the responseText.'); 
				} 
				
				if ("currentForm" in window) {
					alert(window.currentForm);
				}
				var test = '#'+window.currentForm;
				
				$(test).ajaxForm(options);
				$(test).submit();
				
				//	$('#current_billing_address_form').submit();

					//	end testing jquery.form
					
				return true;
			},		//	end onStepChanging
				
				/*****	start onFinishing	*****/
			onFinishing: function (event, currentIndex) {
				alert("Submitted!");
				myFunction(currentIndex);
			//	$('#buy_now_form').ajaxForm(options);
			//	$('#buy_now_form').submit();
				return true;
			},		//	end onFinishing
				
        });			//	end $("#wizard").steps

			//	new code has to go below the wizard in order to work inside the wizard

			//	toggle between the current and add new billing address forms

        $("#billing_address_type > li:nth-child(1) > label:nth-child(1) > input:nth-child(1)").change(function () {
            $("#current_billing_address, #add_billing_address").toggle();
        });

        $("#billing_address_type > li:nth-child(2) > label:nth-child(1) > input:nth-child(1)").change(function () {
            $("#current_billing_address, #add_billing_address").toggle();
        });

			//	end toggle between the current and add new billing address forms
		
		/*****	country/state dropdown	*****/
				
		$("#country").change(function () {
			var country = $(this).val();
			var url = elgg.config.wwwroot + "ajax/view/socialcommerce/change_country_state";
			$.post(url, {
				selected_country: country
			})
			.done(function (data) {
			$("#state_list").empty().html(data);
			});
		});

			/*****	end country/state dropdown	*****/

			/**** start assignCurrentForm	*****/

		function myFunction(currentIndex) {
			switch(currentIndex) 
			{
			case 0:
				window.currentForm = $('#current_billing_address_form').prop("id");
				alert('the Current Form: '+window.currentForm);
				return true;
				break;
			case 1:
				window.currentForm = $('#select_shipping_method_form').prop("id");
				alert('the Current Form: '+window.currentForm);
				return true;
				break;
			case 2:
				window.currentForm = $('#select_payment_form').prop("id");
				alert('the Current Form: '+window.currentForm);
				return true;
				break;
			case 3:
				window.currentForm = $('#buy_now_form').prop("id");
				alert('the Current Form: '+window.currentForm);
				return true;
				break;
			default:
				alert('No Current Form');
				return true;
			}
		}

			/**** end assignCurrentForm	*****/


    }); // all code needs to be above here to work inside the jquery.steps wizard

}); 	// end document.ready

function change_modified(order) {
    jQuery('#list1b').accordion("activate", order);
}

function apply_couponcode() {
    var couponcode = $("#couponcode").val();
    if ($.trim(couponcode) == '') {
        $("#coupon_apply_result").html("Please enter the Coupon Code");
        $("#couponcode").focus();
        $("#coupon_apply_result").css({
            "color": "#9F1313"
        });
        $("#coupon_apply_result").show();
    } else {
        var elgg_token = $('[name=__elgg_token]');
        var elgg_ts = $('[name=__elgg_ts]');
        $.post("{$CONFIG->url}action/socialcommerce/manage_socialcommerce", {
            code: couponcode,
            manage_action: "coupon_process",
            __elgg_token: elgg_token.val(),
            __elgg_ts: elgg_ts.val()
        },

        function (data) {
            data = data.split(",");
            switch (data[0]) {
                case 'no_coupon':
                    $("#coupon_apply_result").html("{$no_coupon}");
                    $("#coupon_apply_result").css({
                        "color": "#9F1313"
                    });
                    break;
                case 'exp_date':
                    $("#coupon_apply_result").html("{$exp_date}" + data[1]);
                    $("#coupon_apply_result").css({
                        "color": "#9F1313"
                    });
                    break;
                case 'not_applied':
                    $("#coupon_apply_result").html("{$not_applied}");
                    $("#coupon_apply_result").css({
                        "color": "#9F1313"
                    });
                    break;
                case 'coupon_maxuses':
                    $("#coupon_apply_result").html("{$coupon_maxuses}");
                    $("#coupon_apply_result").css({
                        "color": "#9F1313"
                    });
                    break;
                case 'coupon_applied':
                    $.post("{$CONFIG->url}action/socialcommerce/manage_socialcommerce", {
                        manage_action: "coupon_reload_process",
                        __elgg_token: elgg_token.val(),
                        __elgg_ts: elgg_ts.val()
                    },

                    function (data1) {
                        if (data1) {
                            $("#checkout_confirm_list").html(data1);
                            $("#coupon_apply_result").html("{$coupon_applied}");
                            $("#coupon_apply_result").css({
                                "color": "#099F10"
                            });
                            $("#couponcode").val('');
                        }
                    });
                    break;
                default:
                    $("#coupon_apply_result").html("Unknown Error");
                    $("#coupon_apply_result").css({
                        "color": "#9F1313"
                    });
                    break;
            }
            $("#coupon_apply_result").show();
        });
    }
    return false;
}
