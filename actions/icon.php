<?php
	/**
	 * Elgg icon
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 

	// Get the guid
	$stores_guid = get_input("stores_guid");
	
	// Get the stores
	$stores = get_entity($stores_guid);
	
	if ($stores)
	{
		$mime = get_input("mimetype");
		if (!$mime) $mime = "application/octet-stream";
		
		$filename = $stores->thumbnail;
		
		header("Content-type: $mime");
		if (strpos($mime, "image/")!==false)
			header("Content-Disposition: inline; filename=\"$filename\"");
		else
			header("Content-Disposition: attachment; filename=\"$filename\"");

			
		$readfile = new ElggFile();
		$readfile->owner_guid = $stores->owner_guid;
		$readfile->site_guid = $stores->site_guid;
		$readfile->mimetype = $stores->mimetype;
		$readfile->setFilename($filename);
			
		/*
		if ($file->open("read"));
		{
			while (!$file->eof())
			{
				echo $file->read(10240, $file->tell());	
			}
		}
		*/

		$contents = $readfile->grabFile();
		if (empty($contents)) {
			echo file_get_contents(dirname(dirname(__FILE__)) . "/graphics/icons/general.jpg" );
		} else {
			echo $contents;
		}
		exit;
	}
	else
		register_error(elgg_echo("stores:downloadfailed"));
?>