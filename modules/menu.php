<?php
	/**
	 * Elgg socialcommerce - socialcommerce menu
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
 	**/
	
	foreach($CONFIG->product_type_default as $key) {
		
		$menu_item = array(
			'name' => 'new_product_'.$key->display_val,			
			'text' => sprintf(elgg_echo("product:type:menu"),$key->display_val), 			
			'href' => get_config('url').'socialcommerce/'. $_SESSION['user']->username .'/add/'.$key->value.'/',			
			'contexts' => array('stores', 'socialcommerce'),	
			'parent_name' => 'stores',	
			);
		elgg_register_menu_item('site', $menu_item);
	}
?>
	