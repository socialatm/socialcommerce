<?php
	/**
	 * Elgg social commerce - thumbnail
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
 	**/

	// Get engine
		require_once(get_config('path').'engine/start.php');
	// Get file GUID
		$file_guid = (int) get_input('stores_guid',0);
		
	// Get file thumbnail size
		$size = get_input('size','small');
		if ($size != 'small') {
			$size = 'large';
		}
		
	// Get file entity
		if ($file = get_entity($file_guid)) {
			
			if ($file->getSubtype() == "stores") {
				
				$simpletype = $file->simpletype;
				if ($simpletype == "image") {
					
					// Get file thumbnail
						if ($size == "small") {
							$thumbfile = $file->smallthumb;
						} else {
							$thumbfile = $file->largethumb;
						}
						
					// Grab the file
						if ($thumbfile && !empty($thumbfile)) {
							$readfile = new ElggFile();
							$readfile->owner_guid = $file->owner_guid;
							$readfile->setFilename($thumbfile);
							$mime = $file->getMimeType();
							$contents = $readfile->grabFile();
							
							header("Content-type: $mime");
							echo $contents;
							exit;
							
						} 
					
				}
				
			}
			
		}
		
?>