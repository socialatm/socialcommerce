<?php
	/**
	 * Elgg product - edit action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	global $CONFIG;
	$CONFIG->pluginlistcache = null;
	//----------- Get variables ---------------//
	$title = trim(get_input("storestitle"));
	$desc = trim(get_input("storesbody"));
	$file_name = trim($_FILES['upload']['name']);
	$product_type_id = get_input("product_type_id");
	$category = get_input("storescategory");
	$tags = trim(get_input("storestags"));
	$access_id = (int) get_input("access_id");
	$guid = (int) get_input('stores_guid');
	$tax_country = trim(get_input("tax_country"));
	//---------------- Check the entity --------------//
	if (!$stores = get_entity($guid)) {
		register_error(elgg_echo("stores:uploadfailed"));
		forward($CONFIG->url . "socialcommerce/" . $_SESSION['user']->username);
		exit;
	}
	
	$product_fields = $CONFIG->product_fields[$product_type_id];
	
	//------------ Validation --------------------//
	if(empty($title)){
		$error_field = ", ".elgg_echo("title");
	}
	if(empty($desc)){
		$error_field .= ", ".elgg_echo("stores:text");
	}
	if(empty($product_type_id) || $product_type_id <= 0){
		$error_field .= ", ".elgg_echo("product:type");
	}
	if(empty($category)){
		$error_field .= ", ".elgg_echo("Category");
	}
	
	if (is_array($product_fields) && sizeof($product_fields) > 0){
		foreach ($product_fields as $shortname => $valtype){
			if($valtype['mandatory'] == 1){
				$value = trim(get_input($shortname));
				if($valtype['field'] == 'file')
					$value = trim($_FILES[$shortname]['name']);
				if(empty($value)){
					if($valtype['field'] == 'file' && $shortname == 'upload'){
						if($stores->mimetype == "")
							$error_field .= ", ".elgg_echo("product:".$shortname);
					}else{
						$error_field .= ", ".elgg_echo("product:".$shortname);
					}
				}else{
					if($shortname == 'quantity'){
						if(ereg("[^0-9]",$value))
							$error_field .= ", ".elgg_echo("product:".$shortname);
					}
					if($shortname == 'base_stock'){
						if(ereg("[^0-9]",$value))
							$error_field .= ", ".elgg_echo("product:".$shortname);
					}
					if($shortname == 'price'){
						if(!is_numeric($value) || $value == 0)
							$error_field .= ", ".elgg_echo("product:".$shortname);
					}
				}
			}
		}
	}
	$validation = elgg_view("custom_field/validation",array('entity_type'=>$product_type_id));
	if($validation){
		$error_field .= ", ".$validation;
	}
	
	$result = false;
	
	$container_guid = $stores->container_guid;
	$container = get_entity($container_guid);
	
	if(!empty($error_field)){
		unset($_SESSION['product']);
		$_SESSION['product']['storestitle'] = $title;
		$_SESSION['product']['storesbody'] = $desc;
		$_SESSION['product']['product_type_id'] = $product_type_id;
		$_SESSION['product']['storescategory'] = $category;
		$_SESSION['product']['storestags'] = $tags;
		$_SESSION['product']['access_id'] = $access_id;
		
		if (is_array($product_fields) && sizeof($product_fields) > 0){
			foreach ($product_fields as $shortname => $valtype){
				if($valtype['field'] != 'file')
					$_SESSION['product'][$shortname] = get_input($shortname);
			}
		}
		
		$error_field = substr($error_field,2);
		
		register_error(sprintf(elgg_echo("product:validation:null"),$error_field));
		$container_user = get_entity($container_guid);
		$redirect = $CONFIG->url . "mod/socialcommerce/edit.php?stores_guid=".$guid;
	}else{
		if ($stores->canEdit()) {
			$old_product_type_id = $stores->product_type_id;
			$old_product_fields = $CONFIG->product_fields[$old_product_type_id];
			if($old_product_type_id != $product_type_id && is_array($old_product_fields) && sizeof($old_product_fields) > 0){
				foreach ($old_product_fields as $old_shortname => $old_valtype){
					if($old_valtype['field'] == 'file' && $old_shortname == 'upload'){
						$stores->filename = "";
						$stores->mimetype = "";
						$stores->originalfilename = "";
					}else{
						$stores->$old_shortname = "";
					}
				}
			}
			if (is_array($product_fields) && sizeof($product_fields) > 0){
				foreach ($product_fields as $shortname => $valtype){
					if($valtype['field'] == 'file' && $shortname == 'upload' && isset($_FILES[$shortname]) && $_FILES[$shortname]['name'] != ""){
						$old_filehandler = new ElggFile();
						$old_filehandler->owner_guid = $stores->owner_guid;
						$old_filehandler->setFilename($stores->filename);
						$old_file = $old_filehandler->getFilenameOnFilestore();
						if (substr_count($stores->mimetype,'image/')){
							$old_filehandler->setFilename($stores->thumbnail);
							$old_thumbnail_file = $old_filehandler->getFilenameOnFilestore();
							$old_filehandler->setFilename($stores->smallthumb);
							$old_smallthumb_file = $old_filehandler->getFilenameOnFilestore();
							$old_filehandler->setFilename($stores->largethumb);
							$old_largethumb_file = $old_filehandler->getFilenameOnFilestore();
						}
						
						$prefix = "socialcommerce/";
						$upload_file = new ElggFile();
						$filestorename = strtolower(time().$_FILES[$shortname]['name']);
						$upload_file->setFilename($prefix.$filestorename);
						$upload_file->setMimeType($_FILES[$shortname]['type']);
						$upload_file->originalfilename = $_FILES[$shortname]['name'];
						$upload_file->open("write");
						$upload_file->write(get_uploaded_file('upload'));
						$upload_file->close();
						
						$stores->filename = $upload_file->filename;
						$stores->mimetype = $upload_file->mimetype;
						$stores->originalfilename = $upload_file->originalfilename;
						$stores->simpletype = get_general_product_type($_FILES[$shortname]['type']);
					}else{
						$value = trim(get_input($shortname));
						if(!empty($value))
							$stores->$shortname = trim(get_input($shortname));
					}
				}
			}
			
			$stores->access_id = $access_id;
			$stores->title = $title;
			$stores->description = $desc;
			$stores->product_type_id = $product_type_id;
			$stores->category = $category;
			$stores->countrycode = $tax_country;
			
			// Save tags
			$tags = explode(",", $tags);
			$stores->tags = $tags;
			if(isset($_FILES['upload']) && $file_name != ""){
				$stores->simpletype = get_general_product_type($_FILES['upload']['type']);
			}
			$result = $stores->save();
		}
		
		if ($result){
			
			// Now see if we have a file product_image
			if ((isset($_FILES['product_image'])) && (substr_count($_FILES['product_image']['type'],'image/')))
			{
				$image_prefix = "socialcommerce/".$result;
				
				$filehandler = new ElggFile();
				$filehandler->owner_guid = $stores->owner_guid;
				$filehandler->setFilename($image_prefix . ".jpg");
				$filehandler->open("write");
				$filehandler->write(get_uploaded_file('product_image'));
				$filehandler->close();
				
				$thumbtiny = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),25,25, true);
				$thumbsmall = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),40,40, true);
				$thumbmedium = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),100,100, true);
				$thumblarge = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),350,800, false);
				if ($thumbtiny) {
					
					$thumb = new ElggFile();
					$thumb->owner_guid = $stores->owner_guid;
					$thumb->setMimeType('image/jpeg');
					
					$thumb->setFilename($image_prefix."tiny.jpg");
					$thumb->open("write");
					$thumb->write($thumbtiny);
					$thumb->close();
					
					$thumb->setFilename($image_prefix."small.jpg");
					$thumb->open("write");
					$thumb->write($thumbsmall);
					$thumb->close();
					
					$thumb->setFilename($image_prefix."medium.jpg");
					$thumb->open("write");
					$thumb->write($thumbmedium);
					$thumb->close();
					
					$thumb->setFilename($image_prefix."large.jpg");
					$thumb->open("write");
					$thumb->write($thumblarge);
					$thumb->close();
					
					$stores->icontime = time();
					$stores->save();
						
				}
			}
			
			// Generate thumbnail (if image)
			if(isset($_FILES['upload']) && $file_name != ""){
				if(file_exists($old_file)){
					unlink($old_file);
				}
				if(file_exists($old_thumbnail_file)){
					unlink($old_thumbnail_file);
				}
				if(file_exists($old_smallthumb_file)){
					unlink($old_smallthumb_file);
				}
				if(file_exists($old_largethumb_file)){
					unlink($old_largethumb_file);
				}
				
				if (substr_count($upload_file->getMimeType(),'image/')){
					$thumbnail = get_resized_image_from_existing_file($upload_file->getFilenameOnFilestore(),60,60, true);
					$thumbsmall = get_resized_image_from_existing_file($upload_file->getFilenameOnFilestore(),153,153, true);
					$thumblarge = get_resized_image_from_existing_file($upload_file->getFilenameOnFilestore(),600,600, false);
					if ($thumbnail) {
						$thumb = new ElggFile();
						$thumb->setMimeType($_FILES['upload']['type']);
						
						$thumb->setFilename($prefix."thumb".$filestorename);
						$thumb->open("write");
						$thumb->write($thumbnail);
						$thumb->close();
						$stores->thumbnail = $prefix."thumb".$filestorename;
						if(file_exists("thumb".$old_file)){
							unlink($old_file);
						}
						
						$thumb->setFilename($prefix."smallthumb".$filestorename);
						$thumb->open("write");
						$thumb->write($thumbsmall);
						$thumb->close();
						$stores->smallthumb = $prefix."smallthumb".$filestorename;
						
						$thumb->setFilename($prefix."largethumb".$filestorename);
						$thumb->open("write");
						$thumb->write($thumblarge);
						$thumb->close();
						$stores->largethumb = $prefix."largethumb".$filestorename;
							
					}
				}
			}
			system_message(elgg_echo("stores:saved"));
			unset($_SESSION['product']);
		}else{
			register_error(elgg_echo("stores:uploadfailed"));
		}
		$container_user = get_entity($container_guid);	
		$redirect = $CONFIG->url . "socialcommerce/" . $container_user->username;
	}
	forward($redirect);
?>
