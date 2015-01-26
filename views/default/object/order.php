<?php
	/**
	 * Elgg order - individual view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 

	gatekeeper();
	$order = $vars['entity'];
	if($order){
		if (elgg_get_context() == "order") {	
			$order_items = elgg_get_entities_from_relationship(array(
			'relationship' => 'order_item',
			'relationship_guid' => $order->guid, 
			));  		
				
			if($order_items){
				foreach ($order_items as $order_item){
					$poduct = get_entity($order_item->product_id);
					$order_item_titles .= "<a href=\"" . $poduct->getURL() . "\"><li>{$order_item->title}</li></a>";
				}
			}
			$order_datre = date("dS M Y", $order->time_created);
			$action = elgg_get_config('url').'socialcommerce/'.$_SESSION['user']->username.'/order_products';
?>
			<div class="search_listing">
				<div style="float:right;">
					<form method="post" action="<?php echo $action; ?>">
						<input class="elgg-button" type="submit" value="<?php echo elgg_echo("view:order:details"); ?>" />
						<input type="hidden" name="guid" value="<?php echo $order->guid; ?>">
					</form>
				</div>
				<div class="order_head"><B><?php echo sprintf(elgg_echo('order:heading'),$order->guid); ?></B></div>
				<div class="order_sub_con">
					<div><?php echo elgg_echo('order:date').": ".$order_datre; ?> </div>
					<?php
					if($order->s_first_name && $order->s_last_name){
						$order_recipient = elgg_echo('order:recipient').": ".$order->s_first_name." ".$order->s_last_name;
					}else{
						$order_recipient = elgg_echo('order:recipient').": ".$order->b_first_name." ".$order->b_last_name;
					}
					?>
					<div><?php echo $order_recipient; ?> </div>
					<div>
						<div><B><?php echo elgg_echo('order:item:head'); ?></B></div>
						<div>
							<ul>
								<?php echo $order_item_titles; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
<?php
		}
	}
