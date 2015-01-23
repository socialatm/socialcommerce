<?php
	/**
	 * Elgg modules - general settings
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http:/twentyfiveautumn.com/
 	**/ 
	
	$socialcommerce = elgg_get_plugin_from_id('socialcommerce');
	$checkout_methods = sc_get_checkout_methods();
	$checkout_methods = is_array($checkout_methods) ? $checkout_methods : array($checkout_methods) ;
	
	$river_settings = $socialcommerce->river_settings;
	if(!is_array($river_settings)) { $river_settings = array($river_settings); }
			
	//For http://url					//	@todo - need to look at this stuff... leave for now
	$https_allow_checked = "";
	$https_url_text= $socialcommerce->https_url_text;
	// For check the check out url		//	@todo - need to look at this stuff... leave for now
		if($https_url_text == "") {
			$https_url_text = str_replace("http://", "https://", elgg_get_config('url'));
		}
		
	if($checkout_methods){
		$sc_checkout_options = array();
		foreach ( $checkout_methods as $value => $checkout_method ){
			$sc_checkout_options[$checkout_method->label] = $value;
		}
	}
	
	// For check the check out url			//	@todo - need to look at this stuff... leave for now
		if($https_url_text == "") {
			$https_url_text = str_replace("http://", "https://", elgg_get_config('url'));
		}
			
	$sc_default_view = $socialcommerce->default_view ? $socialcommerce->default_view : elgg_echo('list');
	$sc_checkout_methods = $socialcommerce->checkout_method ? unserialize($socialcommerce->checkout_method) : elgg_echo('no:checkout:methods');
	$sc_river_settings = $socialcommerce->river_settings ? unserialize($socialcommerce->river_settings) : elgg_echo('no:river:settings');
	
?>
		<br />
		<div class="checkout_title"><h2>
			<?php echo elgg_echo('general:settings'); ?>:</h2>
		</div>
		<div>
			<label for="default_view"><h3><?php echo elgg_echo('settings:default:view'); ?>:</h3></label>
			<?php echo elgg_view('input/radio', array(
					'name' => 'params[default_view]',
					'id' => 'default_view',
					'value' => $sc_default_view,
					'options' => array(elgg_echo('list') => 'list', elgg_echo('gallery') => 'gallery'),
					'align' => 'horizontal',
					));
			?>
		</div>
		<div>
			<label for="checkout_method"><h3><?php echo elgg_echo('checkout:methods'); ?>:</h3></label>
			<?php echo elgg_view('input/checkboxes', array(
					'name' => 'params[checkout_method]',
					'id' => 'checkout_method',
					'options' => $sc_checkout_options,
					'value' => $sc_checkout_methods,
					));
			?>
		</div>
		<div>
			<label for="river_settings"><h3><?php echo elgg_echo('river:management'); ?>:</h3></label>
				<div>
					<?php echo elgg_echo("river:management:description")?>
				</div>
			<?php echo elgg_view('input/checkboxes', array(
					'name' => 'params[river_settings]',
					'id' => 'river_settings',
					'options' => array(elgg_echo('add:product') => 'product_add', elgg_echo('checkout') => 'product_checkout'),
					'value' => $sc_river_settings,
					));
			?>
		</div>
		<div>
			<img src="<?php echo elgg_get_config('url'); ?>mod/socialcommerce/graphics/settings.png" alt="" style="float:right"; />
		</div>
