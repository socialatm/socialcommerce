<?php
	/**
	 * Elgg view - product image
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
	/*****	url format	*****
	 *
	 * $url = elgg_get_config('url').'socialcommerce/'.elgg_get_logged_in_user_entity()->username.'/image/'.$product_guid.'/'.$size; 	
	 *
	 **/
	 
	// Get product image guid
	$product_image_guid = (int)$page['2'];

	// Get product thumbnail size
	$size = $page['3'];

	$product_image = get_entity($product_image_guid);
	
	if ($product_image instanceof ElggEntity) {
			
		$simpletype = $product_image->simpletype;
		if($simpletype != "image") {exit;}
				
		// Get file thumbnail size
		$size = $size ? $size : 'medium';
	
		// Get product thumbnail
		switch ($size) {
			case "small":
				$thumbfile = $product_image->thumbnail;
				break;
			case "medium":
				$thumbfile = $product_image->smallthumb;
				break;
			case "large":
			default:
				$thumbfile = $product_image->largethumb;
				break;
		}
	
		// let's figure out the mime type
		$file = elgg_get_config('dataroot').$product_image->site_guid.'/'.$product_image->owner_guid.'/'.$thumbfile;
		if(!file_exists($file)) {exit;};
	
		$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
		$mime = finfo_file($finfo, $file);
		finfo_close($finfo);
	
		// caching images for 10 days
		header("Content-type: $mime");
		header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+10 days")), true);
		header("Pragma: public", true);
		header("Cache-Control: public", true);
		readfile($file);
		
		exit;
		}
		die();
