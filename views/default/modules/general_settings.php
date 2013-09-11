<?php
	/**$('#view_ship').hide()
	 * Elgg modules - general settings view
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http:/twentyfiveautumn.com/
 	**/ 

	$splugin_settings = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'splugin_settings',
			));
	$splugin_settings = $splugin_settings[0];
	
	$checkout_methods = get_checkout_methods();
	$checkoutmethods = "";
	load_checkout_actions();

	$selected_checkoutmethods = $splugin_settings->checkout_methods;
	$selected_shippingmethods = $splugin_settings->shipping_methods;
	$default_view = $splugin_settings->default_view;
	$river_settings = $splugin_settings->river_settings;
	if(!is_array($river_settings)) {
			$river_settings = array($river_settings);
	}
		//For http://url
	$https_allow_checked = "";
	$https_url_text= $splugin_settings->https_url_text;

	if($checkout_methods){
		foreach ($checkout_methods as $value=>$checkout_method){
			if(is_array($selected_checkoutmethods)){
				$selected_checkoutmethods = array_map('strtolower', $selected_checkoutmethods);
				if(!in_array(strtolower($value),$selected_checkoutmethods)){
					$selected = "";
				}else{
					$selected = "checked = \"checked\"";
				}
			}else{
				if (strtolower($value) != strtolower($selected_checkoutmethods)) {
		            $selected = "";
		        } else {
		            $selected = "checked = \"checked\"";
		        }
			}
			$checkoutmethods .= '<div class="checkout_selection_div"><input type="checkbox" name="checkout_method[]" value="'.$value.'" '.$selected.'>'.$checkout_method->label.'<span style="padding:0 5px;"><img class="help_img" onMouseOut="HideHelp(this);" onMouseOver="ShowHelp(this, \''. $checkout_method->label. '\', \''. elgg_echo('checkout:'.$value.':help').'\')" src="'.get_config('url').'mod/'.'socialcommerce/images/help.gif" border="0"></span></div>';
		}
	}else {
		$checkoutmethods = "No methods available";
	}
	
		$shippingmethods = "No shipping methods available";

	// For check the check out url
		if($https_url_text == "") {
			$https_url_text = str_replace("http://", "https://", get_config('url'));
		}
		
	$action = get_config('url').'action/socialcommerce/manage_socialcommerce';
?>
<script>
	function showData(){
			$('#view_ship').show();
	}
	function hideData(){
			$('#view_ship').hide();
	}

</script>
<div class="basic">
	<form method="post" action="<?php echo $action; ?>">
		<div class="checkout_title"><B><?php echo elgg_echo('common:settings'); ?></B></div>
		<div class="checkout_body">
			<div class="clear general">
				<div style="padding:5px 0;"><B><?php echo elgg_echo('settings:default:view'); ?></B></div>
				<div class="left" style="padding:3px 0"><input type="radio" name="default_view" <?php if($default_view == 'list') echo 'checked="checked"'; ?> value="list"></div>
				<div class="left" style="padding:3px 5px;"></div>
				<div class="left"><?php echo elgg_echo('list'); ?></div>
				<div class="left" style="padding:0 5px;"><img class="help_img" onMouseOut="HideHelp(this);" onMouseOver="ShowHelp(this, '<?php echo elgg_echo('settings:default:view'); ?>', '<?php echo elgg_echo('settings:default:view:list:help'); ?>')" src="<?php echo get_config('url'); ?>mod/socialcommerce/images/help.gif" border="0"></div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="checkout_title"><B><?php echo elgg_echo('checkout:methods'); ?></B></div>
		<div class="checkout_body">
			<?php echo $checkoutmethods; ?>
		</div>
		<div class="checkout_title"><B><?php echo elgg_echo('river:management'); ?></B></div>
		<div class="checkout_body">
			<div><?php echo elgg_echo("river:management:description")?></div>
			<div>
				<div style="padding:5px 0;"></div>
				<div class="left" style="padding:3px 0"><input type="checkbox" name="river_settings[]" <?php if(in_array('product_add',$river_settings)) echo 'checked="checked"'; ?> value="product_add"></div>
				<div class="left" style="padding:3px 5px;"></div>
				<div class="left"><?php echo elgg_echo('add:product'); ?></div>
				<div class="left" style="padding:0 5px;"><img class="help_img" onMouseOut="HideHelp(this);" onMouseOver="ShowHelp(this, '<?php echo elgg_echo('river:management'); ?>', '<?php echo elgg_echo('river:product:add:help'); ?>')" src="<?php echo get_config('url').'mod/socialcommerce'; ?>/images/help.gif" border="0"></div>
				<div class="left" style="width:33px;">&nbsp;</div>
				
				<div class="left" style="width:33px;">&nbsp;</div>
				<div class="left" style="padding:3px 0"><input type="checkbox" name="river_settings[]" <?php if(in_array('product_checkout',$river_settings)) echo 'checked="checked"'; ?> value="product_checkout"></div>
				<div class="left" style="padding:3px 5px;"></div>
				<div class="left"><?php echo elgg_echo('checkout'); ?></div>
				<div class="left" style="padding:0 5px;"><img class="help_img" onMouseOut="HideHelp(this);" onMouseOver="ShowHelp(this, '<?php echo elgg_echo('river:management'); ?>', '<?php echo elgg_echo('river:product:checkout:help'); ?>')" src="<?php echo get_config('url'); ?>mod/socialcommerce/images/help.gif" border="0"></div>
				<div class="clear"></div>

			</div>
		</div>
		<div style="margin-left:20px;">
			<input type="submit" name="btn_save" value=" Save ">
			<input type="hidden" name="manage_action" value="settings">
			<input type="hidden" name="guid" value="<?php echo $splugin_settings->guid; ?>">
			<?php echo elgg_view('input/securitytoken'); ?>
		</div>
	</form>
</div>
