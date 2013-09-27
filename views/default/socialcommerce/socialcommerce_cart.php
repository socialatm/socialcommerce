<?php
	/**
	 * Elgg view - tags menu
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	$product = $vars['entity'];
	$product_type_details = $vars['product_type_details'];
	$phase = $vars['phase'];
	if($product){
		if ($product->guid > 0 && (elgg_is_logged_in())) {
			$cart_btn = elgg_view('input/submit', array('value' => elgg_echo("add:to:cart")));
			
			$form_body = elgg_view('input/hidden', array('internalname' => 'stores_guid', 'value' => $product->getGUID()));
			$form_body .= $cart_btn;
			
			if($product->product_type_id == 1){
				$label = "<div style=\"float:left;margin-bottom:5px;\"><label>".elgg_echo("enter:quantity").": </label></div>
				<div style=\"float:left;\"><p>" . elgg_view('input/text',array('internalname' => 'cartquantity')) . "</p></div>
				<div style=\"clear:both;float:left;width:300px;\"><div style=\"float:left;padding-left:20px;\">{$form_body}</div></div>";
			}elseif ($product->product_type_id == 2){
				$label = $form_body;
			}
			$form_body = '<div class="add_to_cart_form">
							<div style="float:left;width:310px;">
							'.$label.'
							</div>
							<div style="clear:both;"></div>
						</div>';

						$add_cart_url = addcartURL($product);
			
			if($phase == 1){
				if ($product->canEdit()) {
					if($_SESSION['user']->guid != $product->owner_guid && $product->status == 1 && $product_type_details->addto_cart == 1){
						if($stores->product_type_id == 2){
							$body = $form_body;
						}else{
							$body = $cart_btn;
						}
					}
				}else{
					if($product_type_details->addto_cart == 1) {
						if($stores->product_type_id == 2){
							$body = $form_body;
						}else{
							$body = $cart_btn;
						}
					}
				}
			}else{
				$body = $form_body;
			}
		}
	}
?>
<div>
	<?php echo $body; ?>
</div>
