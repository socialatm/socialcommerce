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
	if(elgg_is_logged_in()){
		if($vars['not_allow'] == 1){
			$hidden = '<input type="hidden" name="not_allow" value="1">';
			$action = "#";
		}else{
			$action = $CONFIG->url."socialcommerce/".$_SESSION['user']->username."/checkout_process/";
		}
		$username = "/".$_SESSION['user']->username;
	}
	$submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('check:out')));
	$buy_more = elgg_echo('buy:more');
	$hidden_values = elgg_view('input/securitytoken');
	$buy_more_link = $CONFIG->url.'socialcommerce'.$username."/all";

$form_body = <<< BOTTOM
		<form method="post" id="checkout_form" action="$action" >
			<div class="content_area_user_bottom">
				<div class="bottom_content">
					<span class="buy_more"><a href="$buy_more_link">$buy_more</a></span>
					<span>$submit_input</span>&nbsp;
					<span class="space"></span>
					$hidden_values
				</div>
			</div>
		</form>
BOTTOM;



echo $form_body;
?>
