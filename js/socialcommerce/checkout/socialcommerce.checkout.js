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
				alert(target);
				myFunction(currentIndex);
			//	$('#buy_now_form').ajaxForm(options);
			//	$('#buy_now_form').submit();
			
			var target = $(".body_current");
			
			//	start testing jquery.form
				var options = { 
					beforeSubmit:  showRequest,  // pre-submit callback 
					success:       showResponse  // post-submit callback 
	//				dataType:  	   json 
	//				target;		   '#target'
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
					$("#wizard-p-3").empty().html(responseText);
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
			},		//	end onFinishing
			
					//	start onFinished
				onFinished: function (event, currentIndex)
                {
                    alert("Submit the form to PayPal here!");
                },
					
					// end onFinished
				
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
				alert('the Current Form: <b>'+window.currentForm+'</b>');
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
