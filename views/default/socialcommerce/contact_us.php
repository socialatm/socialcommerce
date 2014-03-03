<?php
   /**
	* Elgg social commerce view - contact us
	* 
	* @package Elgg SocialCommerce
	* @license http://www.gnu.org/licenses/gpl-2.0.html
    * @author twentyfiveautumn.com
	* @copyright twentyfiveautumn.com 2014
	* @link http://twentyfiveautumn.com/
	**/ 
	 
global $CONFIG;
if($_SESSION['user']->guid > 0){
	$user_email = $_SESSION['user']->email;
	$user_name = $_SESSION['user']->name;
}
?>
<SCRIPT>
function IsEmail(PossibleEmail){
	var PEmail = new String(PossibleEmail);
	var regex = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
	return !regex.test(PEmail);
}
function contact_form_validation(){
	var c_email = $("#contact_email").val();
	var c_name = $("#contact_name").val();
	var subject = $("#subject").val();
	
	if($.trim(c_email) == ""){
		alert("<?php echo elgg_echo("contact:email:null"); ?>");
		$("#contact_email").focus();
		return false;
	}else{
		if(IsEmail(c_email)){
			alert("<?php echo elgg_echo("contact:email:not:valid"); ?>");
			$("#contact_email").focus();
			return false;
		}
	}
	if($.trim(c_name) == ""){
		alert("<?php echo elgg_echo("contact:name:null"); ?>");
		$("#contact_name").focus();
		return false;
	}
	if($.trim(subject) == ""){
		alert("<?php echo elgg_echo("subject:null"); ?>");
		$("#subject").focus();
		return false;
	}
}
</SCRIPT>
<div class="contact_us_box">
	<div class="index_box">
		<h2><?php echo elgg_echo("contact:us");?></h2>
		<div class="contentWrapper">
			<form onsubmit="return contact_form_validation();" method="POST" action="<?php echo $CONFIG->url; ?>action/socialcommerce/contact_us">
				<table width="100%">
					<tr>
						<td style="text-align:right"><span style="color:red;">*</span><B><?php echo elgg_echo("contact:email");?></B></td>
						<td>:</td>
						<td><input type="text" id="contact_email" name="contact_email" value="<?php echo $user_email;?>"></td>
					</tr>
					<tr>
						<td style="text-align:right"><span style="color:red;">*</span><B><?php echo elgg_echo("contact:name");?></B></td>
						<td>:</td>
						<td><input type="text" id="contact_name" name="contact_name" value="<?php echo $user_name;?>"></td>
					</tr>
					<tr>
						<td style="text-align:right"><span style="color:red;">*</span><B><?php echo elgg_echo("subject");?></B></td>
						<td>:</td>
						<td><input type="text" id="subject" name="subject" value=""></td>
					</tr>
					<tr>
						<td colspan="3" style="text-align:center"><B><?php echo elgg_echo("message");?></B><textarea style="width:350px;height:100px;" id="description" name="description"></textarea></td>
					</tr>
					<tr>
						<td colspan="3" style="text-align:center">
							<input class="submit_button" type="submit" name="btn_send" value="send">
						</td>
					</tr>
				</table>
				<?php echo elgg_view('input/securitytoken'); ?>
			</FORM>
			<div style="clear:both;"></div>
		</div>
	</div>
</div>
