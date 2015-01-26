<?php
	/**
	 * Elgg social commerce - thumbnail
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
 	**/

	
	echo '<b>'.__FILE__ .' at '.__LINE__; die();
	// Get engine
		require_once(elgg_get_config('path').'engine/start.php');
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
