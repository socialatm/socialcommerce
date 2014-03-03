<?php
	/**
	 * Elgg socialcommerce contact us
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	
	$site = get_entity(get_config('site_guid'));
	$from = get_input('contact_email');
	$name = get_input('contact_name');
	$subject = get_input('subject');
	$desc = nl2br(get_input('description'));
	$to = $site->email;
	
	$messate_header = sprintf(elgg_echo('msg:header'),"Admin");
	$messate_footer = sprintf(elgg_echo('msg:footer'),$CONFIG->sitename.' Team');
	
	$message = <<<EOF
		<div style="width:500px;padding:10px;background-color:#FFFFFF;">
			<div style="border:2px solid #0054A7;padding:10px;">
				{$messate_header},<br>
				<div style="padding-left:10px;text-align:justify;">
					{$name} sent a message for you. 
				</div>
				<br>
				<div style="text-align:justify;">
					<B>{$name}'s Message:</B>
					<br>
					{$desc}
				</div>
				<br>
				{$messate_footer}
			</div>
		</div>
EOF;
	$result = stores_send_mail( $from, $to, $subject, $message ) ? system_message(elgg_echo('contact:succcess:msg')) : register_error(elgg_echo("contact:faild:msg"));
	forward();
?>
