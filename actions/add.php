<?php
	/**
	 * Elgg product - add product action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * version elgg 1.9.4
	 **/ 
	
	$title = htmlspecialchars(get_input('storestitle', '', false), ENT_QUOTES, 'UTF-8');
	$desc = get_input("storesbody");
	$access_id = (int) get_input("access_id");
	$container_guid = (int) get_input('container_guid', 0);
	$guid = (int) get_input('file_guid');
	$tags = get_input("storestags");
	$file_name = trim($_FILES['upload']['name']);
	$category = get_input("storescategory");
	$product_type_id = get_input("product_type_id");
	$tax_country = trim(get_input("tax_country"));
	$price = trim(get_input("price"));
	$thumbnail_name = trim($_FILES['product_image']['name']);
	
if ($container_guid == 0) {
	$container_guid = elgg_get_logged_in_user_guid();
}
		
/*****	start Validation	*****/
		
		if(empty($title)){
			register_error(elgg_echo('title'));
			forward(REFERER);
		}
		if(empty($desc)){
			register_error(elgg_echo('stores:text'));
			forward(REFERER);
		}
		if(empty($category)){
			register_error(elgg_echo('category'));
			forward(REFERER);
		}
	
		if(empty($product_type_id) or $product_type_id <= 0){
			register_error(elgg_echo('product:type'));
			forward(REFERER);
		}
		
		if(empty($access_id)){
			register_error(elgg_echo('access:id'));
			forward(REFERER);
		}
		
		//	make sure we have a product image
		if(empty($thumbnail_name)){
			register_error(elgg_echo('no:product:image'));
			forward(REFERER);
		}
		
		if(!$product_fields = elgg_get_config('product_fields')[$product_type_id]){
			register_error(elgg_echo('product:fields'));
			forward(REFERER);
		}

		//	if this is a file upload let's make sure we have it
		if($product_fields['upload']['mandatory'] === 1){
			// check if upload attempted and failed
			if (!empty($_FILES['upload']['name']) && $_FILES['upload']['error'] != 0) {
				$error = elgg_get_friendly_upload_error($_FILES['upload']['error']);
				register_error($error);
				forward(REFERER);
			}
		}
		
		foreach ($product_fields as $shortname => $valtype){
			if($valtype['mandatory'] == 1 and $shortname != 'upload'){
				$value = get_input($shortname);
				if($shortname == 'quantity'){
					if(!is_numeric($value)) {
						register_error(elgg_echo('quantity'));
						forward(REFERER);
					}
				}
				if($shortname == 'price'){
					if((!is_numeric($value)) or $value == 0 ) {
						register_error(elgg_echo('price'));
						forward(REFERER);
					}
				}
			}
		}
/*****	end Validation	*****/

	// check whether this is a new file or an edit
	$new_file = true;
	if ($guid > 0) {
		$new_file = false;
	}
	
if ($new_file) {
		// must have a file if a new file upload
		if (empty($file_name)) {
			$error = elgg_echo('file:nofile');
			register_error($error);
			forward(REFERER);
		}
	
	$file = new ElggFile();
	$file->subtype = "stores";

	// if no title on new upload, grab filename
	if (empty($title)) {
		$title = htmlspecialchars($_FILES['upload']['name'], ENT_QUOTES, 'UTF-8');
	}

} else {
	// load original file object
	$file = new ElggFile($guid);
	if (!$file) {
		register_error(elgg_echo('file:cannotload'));
		forward(REFERER);
	}

	// user must be able to edit file
	if (!$file->canEdit()) {
		register_error(elgg_echo('file:noaccess'));
		forward(REFERER);
	}

	if (!$title) {
		// user blanked title, but we need one
		$title = $file->title;
	}
}

	$file->title = $title;
	$file->description = $desc;
	$file->access_id = $access_id;
	$file->container_guid = $container_guid;
	$file->tags = string_to_tag_array($tags);
	$file->status = 1;
	$file->product_type_id = $product_type_id;
	$file->category = $category;
	$file->countrycode = $tax_country;
	$file->price = $price;
	// we have a file upload, so process it
if (isset($_FILES['upload']['name']) && !empty($_FILES['upload']['name'])) {

	$prefix = "socialcommerce/";

	// if previous file, delete it
	if ($new_file == false) {
		$filename = $file->getFilenameOnFilestore();
		if (file_exists($filename)) {
			unlink($filename);
		}

		// use same filename on the disk - ensures thumbnails are overwritten
		$filestorename = $file->getFilename();
		$filestorename = elgg_substr($filestorename, elgg_strlen($prefix));
	} else {
		$filestorename = elgg_strtolower(time().$_FILES['upload']['name']);
	}
	
	$file->setFilename($prefix . $filestorename);
	$file->originalfilename = $_FILES['upload']['name'];
	$mime_type = $file->detectMimeType($_FILES['upload']['tmp_name'], $_FILES['upload']['type']);

	$file->setMimeType($mime_type);
	$file->simpletype = file_get_simple_type($mime_type);

	// Open the file to guarantee the directory exists
	$file->open("write");
	$file->close();
	move_uploaded_file($_FILES['upload']['tmp_name'], $file->getFilenameOnFilestore());

	$guid = $file->save();
	
	}
	
	/*****	we'll use this for adding mandatory fields but not now	******************************************************************
								
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
					
					$value = trim(get_input($shortname));
					if(!empty($value))
						$stores->$shortname = trim(get_input($shortname));
					$result = $stores->save();
	***************************************************************************************************************************************/			
					
	//	process the image
	if ((isset($_FILES['product_image'])) && (substr_count($_FILES['product_image']['type'],'image/'))) {
	
		$prefix = "socialcommerce/product_image/";
										
		$product_image = new ElggFile();
		$product_image->subtype = "product_image";
		$filestorename = elgg_strtolower(time().$_FILES['product_image']['name']);
		$product_image->setFilename($prefix . $filestorename);
		$product_image->originalfilename = $_FILES['product_image']['name'];
		$mime_type = $product_image->detectMimeType($_FILES['product_image']['tmp_name'], $_FILES['product_image']['type']);
		$product_image->setMimeType($mime_type);
		$product_image->simpletype = file_get_simple_type($mime_type);

		// Open the file to guarantee the directory exists
		$product_image->open("write");
		$product_image->close();
		move_uploaded_file($_FILES['product_image']['tmp_name'], $product_image->getFilenameOnFilestore());
		$product_image_guid = $product_image->save();	
					
		//	process the thumbnails	
					
		$thumbnail = get_resized_image_from_existing_file($product_image->getFilenameOnFilestore(), 60, 60, true);
		if ($thumbnail) {
			$thumb = new ElggFile();
			$thumb->setMimeType($_FILES['product_image']['type']);
			$thumb->setFilename($prefix."thumb".$filestorename);
			$thumb->open("write");
			$thumb->write($thumbnail);
			$thumb->close();
			$product_image->thumbnail = $prefix."thumb".$filestorename;
			unset($thumbnail);
		}

		$thumbsmall = get_resized_image_from_existing_file($product_image->getFilenameOnFilestore(), 153, 153, true);
		if ($thumbsmall) {
			$thumb->setFilename($prefix."smallthumb".$filestorename);
			$thumb->open("write");
			$thumb->write($thumbsmall);
			$thumb->close();
			$product_image->smallthumb = $prefix."smallthumb".$filestorename;
			unset($thumbsmall);
		}

		$thumblarge = get_resized_image_from_existing_file($product_image->getFilenameOnFilestore(), 600, 600, false);
		if ($thumblarge) {
			$thumb->setFilename($prefix."largethumb".$filestorename);
			$thumb->open("write");
			$thumb->write($thumblarge);
			$thumb->close();
			$product_image->largethumb = $prefix."largethumb".$filestorename;
			unset($thumblarge);
		}
	}
	
	/*****	add the relationship	*****/
	add_entity_relationship($file->guid, "product_image", $product_image->guid);

	/*****	add to river	*****/	

	$add_to_river = unserialize( elgg_get_plugin_setting('river_settings', 'socialcommerce'));
	$add_to_river = in_array('product_add', $add_to_river );	
			
	if ($guid and $add_to_river){
		elgg_create_river_item( array(
			'view' => 'river/object/stores/create',
			'action_type' => 'create',
			'subject_guid' => elgg_get_logged_in_user_guid(),
			'object_guid' => $file->guid
			)
		);
	}
	
	/***** end add to river	*****/
				
	if ($guid){
		system_message(elgg_echo("stores:saved"));
	}else{
		register_error(elgg_echo("stores:uploadfailed"));
	}
	forward(REFERER);
