<?php
	/**
	 * Elgg socialcommerce current billing address form
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2014
	 * @link http://twentyfiveautumn.com/
 	 **/
?>

<div>
	<?php echo $vars["exist_address"]; ?>
</div>
<div>
			<?php echo elgg_view('input/submit', array(
					'value' => elgg_echo('billing:address'),
					'id' => 'address-submit-button',
					));
			?>
</div>
<div>
			<?php echo elgg_view('input/hidden', array(
					'value' => 0,
					'id' => 'checkout_order',
					'name' => 'checkout_order',
					));
			?>
</div>
