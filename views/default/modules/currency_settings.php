<?php
	/**
	 * Elgg modules - currency methods
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	$socialcommerce = elgg_get_plugin_from_id('socialcommerce');
	 
	$currency_name = $socialcommerce->currency_name ? $socialcommerce->currency_name : 'American Dollar';
	$currency_country = $socialcommerce->currency_country ? $socialcommerce->currency_country : 'USA';
	$currency_code = $socialcommerce->currency_code ? : 'USD';
	$exchange_rate = $socialcommerce->exchange_rate ? $socialcommerce->exchange_rate : 1;
	$currency_token = $socialcommerce->currency_token ? $socialcommerce->currency_token	: '$';
	$token_location = $socialcommerce->token_location ? $socialcommerce->token_location	: 'left';
	$decimal_token = $socialcommerce->decimal_token ? $socialcommerce->decimal_token	: 2;
	$default = $socialcommerce->set_default ? $socialcommerce->set_default	: 1;		//	default exchange rate...
		
	foreach ($CONFIG->country as $country){
		$countries[$country['iso3']] = $country['name'] ;
	}
?>
	<br />
	<div>
		<h2><?php echo elgg_echo('add:default:currency'); ?>:</h2>
	</div>
<div>
	<div>
		<label for="currency_name"><h3><?php echo elgg_echo('currency:name'); ?>:</h3></label>
			<?php echo elgg_view('input/text', array(
					'name' => 'params[currency_name]',
					'id' => 'currency_name',
					'value' => $currency_name,
					'class' => 'elgg-input-text',
					'name'=>'currency_name',
					));
			?>
	</div><br />
	<div>
		<label for="currency_country"><h3><?php echo elgg_echo('currency:country'); ?>:</h3></label>
		<?php echo elgg_view('input/dropdown', array(
				'name' => 'f5',
				'id' => 'f5',
				'value' => $currency_country,
				'options_values' => $countries,
				'style' => array(
					'border: 1px solid #CCCCCC;',
					'border-radius: 5px 5px 5px 5px;',
					'color: #666666;',
					'font: 120% Arial,Helvetica,sans-serif;',
					'margin: 0;',
					'padding: 5px;',),
				));
		?>
	</div><br />
	<div>
		<label for="currency_code"><h3><?php echo elgg_echo('currency:code'); ?>:</h3></label>
		<?php echo elgg_view('input/text', array(
				'name' => 'params[currency_code]',
				'id' => 'currency_code',
				'value' => $currency_code,
				'class' => 'elgg-input-text',
				'name'=>'currency_code',
				));
		?>
	</div><br />
	<div>
		<label for="exchange_rate"><h3><?php echo elgg_echo('exchange:rate'); ?>:</h3></label>
		<?php echo elgg_view('input/text', array(
				'name' => 'params[exchange_rate]',
				'id' => 'exchange_rate',
				'value' => $exchange_rate,
				'class' => 'elgg-input-text',
				'name'=>'exchange_rate',
				));
		?>
	</div><br />
	<div class="buttonwrapper" >
		<a onclick="get_exchange_rate();" class="squarebutton"><?php echo '     '.elgg_echo('get:exchange:rate'); ?></a>
		<span><img id="run_exchange_rate" style="display:none;" src="<?php echo $CONFIG->url."mod/socialcommerce"; ?>/images/working.gif"> </span>
	</div><br />
	<div>
		<label for="currency_token"><h3><?php echo elgg_echo('currency:token'); ?>:</h3></label>
		<?php echo elgg_view('input/text', array(
				'name' => 'params[currency_token]',
				'id' => 'currency_token',
				'value' => $currency_token,
				'class' => 'elgg-input-text',
				'name'=>'currency_token',
				));
		?>
	</div><br />
	<div>
		<label for="token_location"><h3><?php echo elgg_echo('token:location'); ?>:</h3></label>
		<?php echo elgg_view('input/radio', array(
				'name' => 'params[token_location]',
				'id' => 'token_location',
				'value' => $token_location,
				'options' => array(elgg_echo('left') => 'left', elgg_echo('right') => 'right'),
				'class' => 'horizontal',
				));
		?>
	</div><br />
	<div>
		<label for="decimal_token"><h3><?php echo elgg_echo('decimal:token'); ?>:</h3></label>
		<?php echo elgg_view('input/text', array(
				'name' => 'params[decimal_token]',
				'id' => 'decimal_token',
				'value' => $decimal_token,
				'class' => 'elgg-input-text',
				'name'=>'decimal_token',
				));
		?>
	</div><br />
	<div>
		<?php echo elgg_view('input/hidden', array('name' => 'set_default', 'value' => $default )); ?>
	</div>
	<div>
		<?php if($default == 0 || $status != 'default'){ ?>
			<div class="buttonwrapper">
				<a onclick="cancel_currency_settings();" class="squarebutton"><span> <?php echo elgg_echo('stores:cancel'); ?> </span></a>
			</div>
		<?php } ?>
	</div>
	<div>
		<img src="<?php echo elgg_get_config('url'); ?>mod/socialcommerce/graphics/dollars.png" alt="" style="float:right"; />
	</div>
