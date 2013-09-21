<?php
	/**
	 * Elgg product - add action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	
	// Get variables
	
	$All_Store_Entities = elgg_get_entities(array( 	
		'type' => 'object',
		'subtype' => 'stores',
		'owner_guid' => 0,
		'order_by' => "",
		'limit' => 15,
		'offset' => 0,
		'count' => true,
		'site_guid' => 0,
		'container_guid' => null,
		'timelower' => 0,
		'timeupper' => 0,	 
	)); 	
	
	$title = trim(get_input("storestitle"));
	$file_name = trim($_FILES['upload']['name']);
	$desc = trim(get_input("storesbody"));
	$category = get_input("storescategory");
	$product_type_id = get_input("product_type_id");
	$tags = trim(get_input("storestags"));
	$access_id = (int) get_input("access_id");
	$container_guid = (int) get_input('container_guid', 0);
	$tax_country = trim(get_input("tax_country"));
	$error_field = "";

		if (!$container_guid){
			$container_guid = $_SESSION['user']->getGUID();
		}
		
		$product_fields = $CONFIG->product_fields[$product_type_id];
		
		//Validation
		if(empty($title)){
			$error_field .= ", ".elgg_echo("title");
		}
		if(empty($desc)){
			$error_field .= ", ".elgg_echo("stores:text");
		}
		if(empty($category)){
			$error_field .= ", ".elgg_echo("category");
		}
	
		if(empty($product_type_id) || $product_type_id <= 0){
			$error_field .= ", ".elgg_echo("product:type");
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
							if((!is_numeric($value)) || $value == 0 )
								$error_field .= ", ".elgg_echo("product:".$shortname);
						}
					}
				}
			}
		}
		
		if(!empty($error_field)){
			unset($_SESSION['product']);
			$_SESSION['product']['storestitle'] = $title;
			$_SESSION['product']['product_type_id'] = $product_type_id;
			$_SESSION['product']['storescategory'] = $category;
			$_SESSION['product']['storesbody'] = $desc;
			$_SESSION['product']['storestags'] = $tags;
			$_SESSION['product']['access_id'] = $access_id;
			
			if (is_array($product_fields) && sizeof($product_fields) > 0){
				foreach ($product_fields as $shortname => $valtype){
					if($valtype['field'] != 'file')
						$_SESSION['product'][$shortname] = get_input($shortname);
				}
			}
			
			$error_field = substr($error_field,2);
			
			$container_user = get_entity($container_guid);
			$redirect = $CONFIG->wwwroot . 'mod/socialcommerce/add.php';
		}else{
			// Extract stores from, save to default stores (for now)
			$stores = new ElggObject();
			$stores->subtype="stores";
			$stores->access_id = $access_id;
			
			if (is_array($product_fields) && sizeof($product_fields) > 0){
				foreach ($product_fields as $shortname => $valtype){
					if($valtype['field'] == 'file' && $shortname == 'upload' && isset($_FILES[$shortname]) && $_FILES[$shortname]['name'] != ""){
						$prefix = 'socialcommerce/';
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
					}
					$value = trim(get_input($shortname));
					if(!empty($value))
						$stores->$shortname = trim(get_input($shortname));
				}
			}
			$stores->title = $title;
			$stores->status = 1;
			$stores->description = $desc;
			$stores->product_type_id = $product_type_id;
			$stores->category = $category;
			$stores->countrycode = $tax_country;
			
			// Save tags
			$tags = explode(",", $tags);
			$stores->tags = $tags;
			
			if ($container_guid){
				$stores->container_guid = $container_guid;
			}
	
			$result = $stores->save();
			
			if ($result){
				if(in_array('product_add', unserialize(elgg_get_plugin_setting('river_settings', 'socialcommerce')) ))
					add_to_river('river/object/stores/create', 'create', $_SESSION['user']->guid, $stores->guid );
				
				// Now see if we have a file product_image
				if ((isset($_FILES['product_image'])) && (substr_count($_FILES['product_image']['type'],'image/')))
				{
					$image_prefix = 'socialcommerce/'.$result;
					
					$product_imagehandler = new ElggFile();
					$product_imagehandler->owner_guid = $stores->owner_guid;
					$product_imagehandler->setFilename($image_prefix . ".jpg");
					$product_imagehandler->open("write");
					$product_imagehandler->write(get_uploaded_file('product_image'));
					$product_imagehandler->close();
					
					$product_thumbtiny = get_resized_image_from_existing_file($product_imagehandler->getFilenameOnFilestore(),25,25, true);
					$product_thumbsmall = get_resized_image_from_existing_file($product_imagehandler->getFilenameOnFilestore(),40,40, true);
					$product_thumbmedium = get_resized_image_from_existing_file($product_imagehandler->getFilenameOnFilestore(),100,100, true);
					$product_thumblarge = get_resized_image_from_existing_file($product_imagehandler->getFilenameOnFilestore(),350,800, false);
					if ($product_thumbtiny) {
						
						$product_thumb = new ElggFile();
						$product_thumb->owner_guid = $stores->owner_guid;
						$product_thumb->setMimeType('image/jpeg');
						
						$product_thumb->setFilename($image_prefix."tiny.jpg");
						$product_thumb->open("write");
						$product_thumb->write($product_thumbtiny);
						$product_thumb->close();
						
						$product_thumb->setFilename($image_prefix."small.jpg");
						$product_thumb->open("write");
						$product_thumb->write($product_thumbsmall);
						$product_thumb->close();
						
						$product_thumb->setFilename($image_prefix."medium.jpg");
						$product_thumb->open("write");
						$product_thumb->write($product_thumbmedium);
						$product_thumb->close();
						
						$product_thumb->setFilename($image_prefix."large.jpg");
						$product_thumb->open("write");
						$product_thumb->write($product_thumblarge);
						$product_thumb->close();
						
						$stores->icontime = time();
						$stores->save();
							
					}
				}
				
				// Generate thumbnail (if image)
				if(isset($_FILES['upload']) && $file_name != ""){
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
			}
				
			if ($result){
				system_message(elgg_echo("stores:saved"));
				unset($_SESSION['product']);
			}else{
				register_error(elgg_echo("stores:uploadfailed"));
			}
			$container_user = get_entity($container_guid);
			$redirect = $CONFIG->wwwroot . 'socialcommerce/' . $container_user->username;
		}
		
	forward($redirect);
?>
