<?php
	/**
	 * Elgg socialcommerce - Product Types
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
 	**/
	
	/**
	 * This function loads a set of default fields into the socialcommerce, then triggers a hook letting other plugins to edit
	 * add and delete fields.
	 *
	 * Note: This is a secondary system:init call and is run at a super low priority to guarantee that it is called after all
	 * other plugins have initialised.
	 */
	 
   	function sc_product_fields_setup(){
		//--- Default product types ----//
   		$default_product_types = array(
								(object)array('value'=> 1, 'display_val'=> elgg_echo('stores:simple:products'), 'addto_cart'=> 1 ),
								(object)array('value'=> 2, 'display_val'=> elgg_echo('stores:digital:products'), 'addto_cart'=> 1 ),
								(object)array('value'=> 3, 'display_val'=> elgg_echo('stores:virtual:products'), 'addto_cart'=> 1 ),
								);
		elgg_set_config('product_type_default', elgg_trigger_plugin_hook('socialcommerce:product:type', 'stores', NULL, $default_product_types));	
								 
   		//--- Default fields for simple products ----//
		$product_fields[1] = array (
			'quantity' => array('field'=>'text','mandatory'=>1,'display'=>1 ),		// @todo - mandatory is a clunker 
			'price'  => array('field'=>'text','mandatory'=>1,'display'=>1 ),
		);
		//--- Default fields for digital products ----//
		$product_fields[2] = array (
			'upload' => array('field'=>'file','mandatory'=>1,'display'=>1 ),
			'price'  => array('field'=>'text','mandatory'=>1,'display'=>1 ),
		);
		//--- Default fields for virtual products ----//
		$product_fields[3] = array (
			'quantity' => array('field'=>'text','mandatory'=>1,'display'=>1 ),
			'price'  => array('field'=>'text','mandatory'=>1,'display'=>1 ),
		);
		elgg_set_config('product_fields', elgg_trigger_plugin_hook('socialcommerce:fields', 'stores', NULL, $product_fields ));	
		
		//--- Default related product types ----//
   		$default_related_product_types = array(
									(object)array('value'=>1,'display_val'=>elgg_echo('stores:related:product'),'addto_cart'=>0),
								    (object)array('value'=>2,'display_val'=>elgg_echo('stores:services'),'addto_cart'=>0),
									);
								 
		elgg_set_config('default_related_product_types', elgg_trigger_plugin_hook('socialcommerce:relatedproduct:type', 'stores', NULL, $default_related_product_types));	
   	}
