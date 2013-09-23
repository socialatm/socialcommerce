<?php
	/**
	 * Elgg currency - list settings
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
 	**/
	global $CONFIG;
	$currency_settings = $vars['entity'];
	if($currency_settings){
		$edit_msg = elgg_echo('currency:edit');
		$delete_msg = elgg_echo('currency:delete');
		$delete_confirm_msg = elgg_echo('currency:delete_confirm');
		$img_template = '<img border="0" width="16" height="16" alt="%s" title="%s" src="'.$CONFIG->url.'mod/socialcommerce/images/%s" />';
		$edit_img = sprintf($img_template,$edit_msg,$edit_msg,"tag-pencil.png");
		
		$template .= <<<EOF
			<tr class="%s">
				<td>%s %s</td>
				<td style='text-align:center;'>%s</td>
				<td style='text-align:center;'>%s</td>
				<td style='text-align:center;'><a href="javascript:void(0);" onclick="edit_currency(%s);">$edit_img</a></td>
				<td style='text-align:center;'>%s</td>
				<td style='text-align:center;'>%s</td>
			</tr>
EOF;

		foreach ($currency_settings as $currency_setting){
			$c_guid = $currency_setting->guid;
			$currency_name = $currency_setting->currency_name;
			$currency_code = $currency_setting->currency_code;
			$exchange_rate = $currency_setting->currency_token.round($currency_setting->exchange_rate,$currency_setting->decimal_token);
			$default = $currency_setting->set_default;
			$class = $class == "field_list_table_odd" ? "field_list_table_even" : "field_list_table_odd";
			if($default){
				$default_msg = elgg_echo('currency:default');
				$default_img = sprintf($img_template,$default_msg,$default_msg,"default.gif");
				$default = "{$default_img}";
				$class = "default_class";
				$default_text = "<B>(Default)</B>";
				$delete_img = sprintf($img_template,$delete_msg,$delete_msg,"delete_disable.gif");
				$delete = "$delete_img";
			}else{
				$default_msg = elgg_echo('currency:set:default');
				$default_img = sprintf($img_template,$default_msg,$default_msg,"default_disable.gif");	
				$default = "<a href='javascript:void(0);' onclick='set_default_currency($c_guid);'>{$default_img}</a>";
				$default_text = "";
				$delete_img = sprintf($img_template,$delete_msg,$delete_msg,"delete.gif");
				$delete = "<a href='javascript:void(0);' onclick=\"if(confirm('$delete_confirm_msg')){delete_currency($c_guid);}\">$delete_img</a>";
			}
			$body .= sprintf(
		        	$template,
		        	$class,
		        	$currency_name,
		        	$default_text,
		        	$currency_code,
		        	$exchange_rate,
		        	$c_guid,
		        	$delete,
		        	$default);
		}
	}
?>
<div>
	<div align="center"><B><?php echo elgg_echo('currencies'); ?></B></div>
	<div class="list_currency clear" style="margin:10px 0;">
		<table class="field_list_table" width="100%">
			<tr class="field_list_table_head">
				<td style='text-align:left;'><?php echo elgg_echo('currency:name'); ?></td>
				<td><?php echo elgg_echo('currency:code'); ?></td>
				<td><?php echo elgg_echo('exchange:rate'); ?></td>
				<td><?php echo elgg_echo('edit'); ?></td>
				<td><?php echo elgg_echo('delete'); ?></td>
				<td><?php echo elgg_echo('default'); ?></td>
			</tr>
			<?php echo $body; ?>
		</table>
		<?php echo elgg_view('input/securitytoken'); ?>
	</div>
</div>
