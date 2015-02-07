<?php
	/**
	 * Elgg address - individual view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	
	$user = elgg_get_logged_in_user_entity();
	$address = $vars['entity'];
	$address_guid = $address->guid;
	$title = $address->title;
	$firstname = $address->first_name;
	$lastname = $address->last_name;
	$address_line_1 = $address->address_line_1;
	$address_line_2 = $address->address_line_2;
	$city = $address->city;
	$state = $address->state;
	$country = $address->country;
	$pincode = $address->pincode;
	$phoneno = $address->phoneno;
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = elgg_view_friendly_time($vars['entity']->time_created);
	
	if (elgg_get_context() == "search") { 
		?>
		<div>
			<?php echo $address->title; ?>
			<br />
			<?php echo $address->address_line_1.'<br />'; ?>
			<?php 
				if(!empty($address_line_2)){
					echo $address->address_line_2.'<br />';
				}
			?>
			<?php echo $address->city.' '.$address->state.' '.$address->pincode; ?>
		</div>
		<br />
		
		<?php
		if( $address->canEdit() ) { 			
			echo '<a href="'.elgg_get_config('url').'socialcommerce/'.$user->username.'/edit_address/'.$address->guid.'">'.elgg_echo('edit:address').'</a>'; 	
			echo 'needs a delete address link here!';
		}
	}else{
?>
		<div>
			<table>
				<tr>
					<th>&nbsp; Billing Address</th>
					<th width="50"></td>
					<th>&nbsp; Delivery Address</th>
				</tr>
				<tr>
					<td>
						<table cellpadding="10">
							<tr><?php echo "<td>".elgg_echo("first:name")."</td><td> : </td><td>".$firstname."</td>" ?></tr>
							<tr><?php echo "<td>".elgg_echo("last:name")."</td><td> : </td><td>".$lastname."</td>" ?></tr>
							<tr><?php echo "<td>".elgg_echo("address:line:1")."</td><td> : </td><td>".nl2br($address_line_1)."</td>" ?></tr>
							<tr><?php echo "<td>".elgg_echo("address:line:2")."</td><td> : </td><td>".nl2br($address_line_2)."</td>" ?></tr>
							<tr><?php echo "<td>".elgg_echo("city")."</td><td> : </td><td>".$city."</td>" ?></tr>
							<tr><?php echo "<td>".elgg_echo("state")."</td><td> : </td><td>".$state."</td>" ?></tr>
							<tr><?php echo "<td>".elgg_echo("country")."</td><td> : </td><td>".$country."</td>" ?></tr>
							<tr><?php echo "<td>".elgg_echo("pincode")."</td><td> : </td><td>".$pincode."</td>" ?></tr>
							<?php if($phoneno > 0){?>
							<tr><?php echo "<td class='address_left'>".elgg_echo("phone:no")."</td><td class='address_sep'> : </td><td class='address_right'>".$phoneno."</td>" ?></tr>
							<?php } ?>
						</table>
					</td>
					<td></td>
					<td>
						<table cellpadding="10">
							<tr><?php echo "<td>".elgg_echo("first:name")."</td><td> : </td><td>".$firstname."</td>" ?></tr>
							<tr><?php echo "<td>".elgg_echo("last:name")."</td><td> : </td><td>".$lastname."</td>" ?></tr>
							<tr><?php echo "<td>".elgg_echo("address:line:1")."</td><td> : </td><td>".nl2br($address_line_1)."</td>" ?></tr>
							<tr><?php echo "<td>".elgg_echo("address:line:2")."</td><td> : </td><td>".nl2br($address_line_2)."</td>" ?></tr>
							<tr><?php echo "<td>".elgg_echo("city")."</td><td> : </td><td>".$city."</td>" ?></tr>
							<tr><?php echo "<td>".elgg_echo("state")."</td><td> : </td><td>".$state."</td>" ?></tr>
							<tr><?php echo "<td>".elgg_echo("country")."</td><td> : </td><td>".$country."</td>" ?></tr>
							<tr><?php echo "<td>".elgg_echo("pincode")."</td><td> : </td><td>".$pincode."</td>" ?></tr>
							<?php if($phoneno > 0){?>
							<tr><?php echo "<td class='address_left'>".elgg_echo("phone:no")."</td><td class='address_sep'> : </td><td class='address_right'>".$phoneno."</td>" ?></tr>
							<?php } ?>
						</table>
					</td>
				</tr>
			</table>
			<?php
				$address_exp = explode("\n",$address_1);
			?>	
			<input type="hidden" name="address1" value="<?php echo $address_exp[0] ?>">	
			<input type="hidden" name="address2" value="<?php echo $address_exp[1] ?>">	
			<input type="hidden" name="city" value="<?php echo $city ?>">	
			<input type="hidden" name="country" value="IN">	
			<input type="hidden" name="first_name" value="<?php echo $firstname ?>">	
			<input type="hidden" name="last_name" value="<?php echo $lastname ?>">	
			</div>
<?php }	
