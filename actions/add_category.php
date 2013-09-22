<?php
	/**
	 * Elgg category - add action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	// Get variables
	$title = trim(get_input("categorytitle"));
	$product_type_id = trim(get_input("product_type_id"));
	$product_type_id = (int) get_input("product_type_id");
	$description = get_input("categorybody");
	$container_guid = elgg_get_plugin_from_id('socialcommerce')->guid;
	$page_owner = elgg_get_logged_in_user_entity();
	
	//Validation
	if(empty($title)){ $error_field = elgg_echo("title"); }
	if(empty($product_type_id) || $product_type_id <=0){ $error_field = elgg_echo("product:type");}
	if(!empty($error_field)){
		$_SESSION['category']['categorytitle'] = $title;
		$_SESSION['category']['categorybody'] = $desc;
		$_SESSION['category']['product_type_id'] = $product_type_id;
		register_error(sprintf(elgg_echo("product:validation:null"), $error_field));
		
		$redirect = $CONFIG->url.'socialcommerce/'.$page_owner->username.'/addcategory/';
	}else{
		// Extract categories from, save to default social commerce (for now)
		$category = new ElggObject();
		$category->access_id = 2;
		$category->subtype="sc_category";
		$category->title = $title;
		$category->product_type_id = $product_type_id;
		$category->description = $description;
		$category->container_guid = $container_guid;
		
		$result = $category->save();
		
		if ($result){
			system_message(elgg_echo("category:saved"));
			unset($_SESSION['category']);
		}else{
			register_error(elgg_echo("category:uploadfailed"));
		}
		$redirect = $CONFIG->url.'socialcommerce/'.$page_owner->username.'/category/';
	}
	forward($redirect);
?>
