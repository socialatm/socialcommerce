<?php
	/**
	 * Elgg checkout - paypal - success page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	gatekeeper();
	// Get objects
	
		if(isset($_SESSION['CHECKOUT'])){
			$method = $_SESSION['CHECKOUT']['checkout_method'];
			$function = 'makepayment_'.$method;

		//	$cart_success_load = get_input('cart_success_load');	//	@todo - re-visit this once IPN is working...
			$cart_success_load = 2;
			
		//	$success = get_input('success');						//	@todo - re-visit this once IPN is working...
			$success = 1;
			
			if(function_exists($function)){
				if($cart_success_load !=2 ){
					$success = $function();
				}
				
				if($success){
					if($cart_success_load != 2 ){
						$redirect =  elgg_add_action_tokens_to_url($CONFIG->wwwroot."action/socialcommerce/manage_socialcommerce?manage_action=cart_success&cart_success_load=2&success={$success}");
						forward($redirect);
						exit();
					}else{
						$body = elgg_echo('cart:success:content');
						$back_text = elgg_echo('checkout:back:text');
						$action = get_config('url').'socialcommerce/'.$_SESSION['user']->username.'/all';
						
						$area2 = <<< AREA2
							<div class="contentWrapper stores">
								<br>{$body}<br><br>
								<form action="$action" method="post">
									<input type="submit" name="btn_submit" value="{$back_text}">
								</form>
							</div>
AREA2;
					}
				}else{
					$redirect =  elgg_add_action_tokens_to_url($CONFIG->wwwroot."action/socialcommerce/manage_socialcommerce?manage_action=checkout_error");	// @todo - re-write this at some point...
					forward($redirect);
				}
				echo $area2;
			}
			unset($_SESSION['CHECKOUT']);
		}else{
			forward(get_config('url').'socialcommerce/'.$_SESSION['user']->username.'/all');
		}
?>
