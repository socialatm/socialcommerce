<?php
	/**
	 * Elgg category - edit action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	global $CONFIG;
	
	// Get variables
	$title = trim(get_input("categorytitle"));
	$product_type_id = trim(get_input("product_type_id"));
	$desc = get_input("categorybody");
	
	$guid = (int) get_input('category_guid');
	
	if (!$category = get_entity($guid)) {
		register_error(elgg_echo("category:addfailed"));
		forward($CONFIG->wwwroot . "pg/socialcommerce/" . $_SESSION['user']->username . "/category/");
		exit;
	}
	
	$result = false;
	//Validation
	if(empty($title)){
		$error_field = elgg_echo("title");
	}
	if(empty($product_type_id) || $product_type_id <=0){
		$error_field = elgg_echo("product:type");
	}
	$container_guid = $category->container_guid;
	$container = get_entity($container_guid);
	if(!empty($error_field)){
		$_SESSION['category']['categorytitle'] = $title;
		$_SESSION['category']['categorybody'] = $desc;
		$_SESSION['category']['product_type_id'] = $product_type_id;
		
		register_error(sprintf(elgg_echo("product:validation:null"),$error_field));
		$container_user = get_entity($container_guid);
		$redirect = $CONFIG->wwwroot . "mod/socialcommerce/edit_category.php?category_guid=".$guid;
	}else{
		if ($category->canEdit()) {
		
			$category->access_id = 2;
			$category->title = $title;
			$category->product_type_id = $product_type_id;
			$category->description = $desc;
			
			$result = $category->save();
		}
		
		if ($result){
			system_message(elgg_echo("category:saved"));
			unset($_SESSION['category']);
		}else{
			register_error(elgg_echo("category:addfailed"));
		}
		
		$container_user = get_entity($container_guid);
		$redirect = $CONFIG->wwwroot . "pg/socialcommerce/" . $container_user->username . "/category/";
	}
	forward($redirect);
?>
