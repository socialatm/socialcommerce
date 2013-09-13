<?php
	/**
	 * Elgg form - confirm cart lists
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	if(isloggedin()){
		if($vars['not_allow'] == 1){
			$hidden = "<input type=\"hidden\" name=\"not_allow\" value=\"1\">";
			$action = "#";
		}else{
			$action = $CONFIG->checkout_base_url."pg/socialcommerce/".$_SESSION['user']->username."/checkout_process/";
		}
		$username = "/".$_SESSION['user']->username;
	}
	$submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('check:out')));
	$byu_more = elgg_echo('buy:more');
	$hidden_values = elgg_view('input/securitytoken');
	$buy_more_link = $CONFIG->wwwroot.'pg/socialcommerce'.$username."/all";
	$form_body = <<< BOTTOM
		{$java_script}
		<form method="post" id="checkout_form" action="{$action}" {$java_function}>
			<div class="content_area_user_bottom">
				<div class="bottom_content">
					<span class="buy_more"><a href="$buy_more_link">$byu_more</a></span>
					<span>$submit_input</span>&nbsp;
					<span class="space"></span>
					{$hidden}
				</div>
			</div>
		</form>
BOTTOM;
echo $form_body;
?>
