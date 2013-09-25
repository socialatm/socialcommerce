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
	
	/*****************************************************************************************
		Menus
	******************************************************************************************/
	
	require_once('C:/Program Files (x86)/Zend/Apache2/htdocs/krumo/class.krumo.php');

		foreach($CONFIG->product_type_default as $key) {
		
	//	echo $key->display_val."< br />";
	//	echo $key->value."< br />";
		
		$menu_item = array(
						'name' => 'new_product_'.$key->display_val,			
						'text' => sprintf(elgg_echo("product:type:menu"),$key->display_val), 			
						'href' => get_config('url').'socialcommerce/'. $_SESSION['user']->username .'/add/?type='.$key->value,			
						'contexts' => array('stores', 'socialcommerce'),	
	//					'section' => '',		
	//					'title' => '',			
	//					'selected' => '',		
						'parent_name' => 'stores',	
	//					'link_class' => '',		
	//					'item_class' => '',		
						);
			elgg_register_menu_item('site', $menu_item);
		
		
		
		
		
		}
		
	//	echo sprintf(elgg_echo("product:type:menu"),$CONFIG->product_type_default[0]->display_val);
		
	//	krumo($CONFIG->product_type_default); die();
		
		
	// ==============================================================================================================		
	
	
?>
	