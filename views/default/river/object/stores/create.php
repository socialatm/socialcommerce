<?php
	/**
	 * Elgg river - create product
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
	$performed_by = get_entity($vars['item']->subject_guid); 
	$object = get_entity($vars['item']->object_guid);
	
	$url = '<a href="'.$performed_by->getURL().'">'.$performed_by->name.'</a>';
	$product_url = '<a href="'.$object->getURL().'">'.$object->title.'</a>';
	
	if($vars['item']->action_type == 'create') {
		$summary = sprintf(elgg_echo("stores:river:created"), $url ). " ".$product_url;
	}else{
		$summary = sprintf(elgg_echo("stores:river:updated"),$url) . " ";
	$summary .= "<a href=\"" . $object->getURL() . "\">" . elgg_echo("stores:river:item") . "</a>";
	}
	
	// get the product image
	$product_image_guid = sc_product_image_guid($object->guid);
	$image = '<a href="'.$object->getURL().'"><img src ="'.elgg_get_config('url').'socialcommerce/'.$performed_by->username.'/image/'.$product_image_guid.'/'.'medium'.'"/></a>'; 
	
	$message = '<div class="elgg-grid theme-sandbox-grid-demo-outline">
					<div class="elgg-col elgg-col-1of3">
						'.$image.'
					</div>
					<div class="elgg-col elgg-col-2of3 elgg-col-last">
						<div><h2>'.elgg_echo('Description').':</h2></div>
						'.$object->description.'
						<div><h2>'.elgg_echo('price').': '.$object->price.'</h2></div>
					</div>
				</div>';
	
	echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => $message,
	'summary' => $summary,
));
