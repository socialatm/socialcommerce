<?php
	/**
	 * Elgg category - add action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 

	global $CONFIG;
	
	// Get variables
	$title = trim(get_input("categorytitle"));
	$product_type_id = trim(get_input("product_type_id"));
	$desc = get_input("categorybody");
	$container_guid = (int) get_input('container_guid', 0);
	if (!$container_guid){
		$container_guid = $_SESSION['user']->getGUID();
	}
	
	//Validation
	if(empty($title)){
		$error_field = elgg_echo("title");
	}
	if(empty($product_type_id) || $product_type_id <=0){
		$error_field = elgg_echo("product:type");
	}
	if(!empty($error_field)){
		$_SESSION['category']['categorytitle'] = $title;
		$_SESSION['category']['categorybody'] = $desc;
		$_SESSION['category']['product_type_id'] = $product_type_id;
		
		register_error(sprintf(elgg_echo("product:validation:null"),$error_field));
		$container_user = get_entity($container_guid);
		$redirect = $CONFIG->wwwroot . "pg/{$CONFIG->pluginname}/" . $container_user->username . "/addcategory/";
	}else{
		// Extract categories from, save to default social commerce (for now)
		$category = new ElggObject();
		
		$category->access_id = 2;
		$category->subtype="category";
		$category->title = $title;
		$category->product_type_id = $product_type_id;
		$category->description = $desc;
		
		if ($container_guid){
			$category->container_guid = $container_guid;
		}
		
		$result = $category->save();
		
		if ($result){
			system_message(elgg_echo("category:saved"));
			unset($_SESSION['category']);
		}else{
			register_error(elgg_echo("category:uploadfailed"));
		}
			
		$container_user = get_entity($container_guid);
		$redirect = $CONFIG->wwwroot . "pg/{$CONFIG->pluginname}/" . $container_user->username . "/category/";
	}
	forward($redirect);

?>