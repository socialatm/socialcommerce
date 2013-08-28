<?PHP
	/**
	 * Elgg currency - view page
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
 	**/
	 
	global $CONFIG;
	$status = $vars['status'];
	$entity = $vars['entity'];
	if($entity){
		$currency_name = $entity->currency_name;
		$currency_country = $entity->currency_country;
		$currency_code = $entity->currency_code;
		$exchange_rate = $entity->exchange_rate;
		$currency_token = $entity->currency_token;
		$token_location = $entity->token_location;
		$decimal_token = $entity->decimal_token;
		$default = $entity->set_default;
		if($default == 1){
			$exchange_rate = 1;
			$disable = 'disabled';
		}else {
			$disable = '';
		}
	}else{
		$currency_name = 'American Dollar';
		$currency_country = 'USA';
		$currency_code = 'USD';
		if($status == 'default'){
			$exchange_rate = 1;
			$disable = 'disabled';
			$default = 1;
		}else {
			$exchange_rate = '';
			$disable = '';
			$default = 0;
		}
		$currency_token = '$';
		$token_location = 'left';
		$decimal_token = 2;
	}
?>
<h3><?php echo elgg_echo('currency:details'); ?></h3>
<div>
	<table class="currency content" width="100%">
		<tr>
			<td style="text-align:right;width:140px;"><B><span style="color:red;">*</span> <?php echo elgg_echo('currency:name'); ?></B></td>
			<td>:</td>
			<td style="width:140px;" style="text-align:left;"><?php echo elgg_view('input/text',array('internalname'=>'currency_name','value'=>$currency_name,'disabled'=>'disabled')); ?></td>
			<td style="width:50%"></td>
		</tr>
		<tr>
			<td style="text-align:right;"><B><span style="color:red;">*</span> <?php echo elgg_echo('currency:country'); ?></B></td>
			<td>:</td>
			<td style="text-align:left;">
			<select name="currency_country" class="input-text" disabled="disabled">
				<?php 
					if($CONFIG->country){
						foreach ($CONFIG->country as $country){
							if($currency_country == $country['iso3']){
								$selected = "selected";
							}else{
								$selected = "";
							}
							echo "<option value='".$country['iso3']."' ".$selected.">".$country['name']."</option>";
						}	
					}
				?>
			</select>
			<?php /* echo elgg_view('input/text',array('internalname'=>'currency_country','value'=>$currency_country)); */ ?></td>
			<td style="width:50%"></td>
		</tr>
		<tr>
			<td style="text-align:right;"><B><span style="color:red;">*</span> <?php echo elgg_echo('currency:code'); ?></B></td>
			<td>:</td>
			<td style="text-align:left;"><?php echo elgg_view('input/text',array('internalname'=>'currency_code','value'=>$currency_code,'disabled'=>'disabled')); ?></td>
			<td style="width:50%"></td>
		</tr>
		<tr>
			<td style="text-align:right;"><B><span style="color:red;">*</span> <?php echo elgg_echo('exchange:rate'); ?></B></td>
			<td>:</td>
			<td style="text-align:left;"><?php echo elgg_view('input/text',array('internalname'=>'exchange_rate','value'=>$exchange_rate,'disabled'=>$disable)); ?></td>
			<td>
				<?php if($default != 1 || $status != 'default'){ ?>
					<div class="buttonwrapper" style="position:relative;top:5px;float:left;">
						<a onclick="get_exchange_rate();" class="squarebutton"><span> <?php echo elgg_echo('get:exchange:rate'); ?></span></a>
					</div>
					<span><img id="run_exchange_rate" style="position:relative;left:10px;top:5px;display:none;" src="<?php echo $CONFIG->wwwroot."mod/".$CONFIG->pluginname; ?>/images/working.gif"> </span>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td style="text-align:right;width:140px;"><B><span style="color:red;">*</span> <?php echo elgg_echo('currency:token'); ?></B></td>
			<td>:</td>
			<td style="text-align:left;"><?php echo elgg_view('input/text',array('internalname'=>'currency_token','value'=>$currency_token,'disabled'=>'disabled')); ?></td>
		</tr>
		<tr>
			<td style="text-align:right;width:140px;"><B><span style="color:red;">*</span> <?php echo elgg_echo('token:location'); ?></B></td>
			<td>:</td>
			<td style="text-align:left;">
				<?php echo elgg_view('input/pulldown',array('internalname'=>'token_location','value'=>$token_location,'options_values'=>array('left'=>'Left','right'=>'Right'),'disabled'=>'disabled')); ?>
			</td>
		</tr>
		<tr>
			<td style="text-align:right;"><B><span style="color:red;">*</span> <?php echo elgg_echo('decimal:token'); ?></B></td>
			<td>:</td>
			<td style="text-align:left;"><?php echo elgg_view('input/text',array('internalname'=>'decimal_token','value'=>$decimal_token,'disabled'=>'disabled')); ?></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td style="text-align:left;">
				<div>
					<?php if($default == 0 || $status != 'default'){ ?>
						<div class="buttonwrapper">
							<a onclick="cancel_currency_settings();" class="squarebutton"><span> <?php echo elgg_echo('stores:cancel'); ?> </span></a>
						</div>
					<?php } ?>
				</div>
				<input type='hidden'"' id='manage_action' name='manage_action' value="add_currency">
				<input type='hidden'"' name='guid' value="<?php echo $entity->guid; ?>">
				<input type='hidden'"' name='order' value="<?php echo $order; ?>">
				<input type='hidden'"' name='set_default' value="<?php echo $default; ?>">
				<?php echo elgg_view('input/securitytoken'); ?>
			</td>
		</tr>
	</table>
</div>