<?php
	/**
	 * Elgg product - delete action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013 / Cubet Technologies 2009-2010
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	global $CONFIG;
	$guid = (int) get_input('stores');
	if ($stores = get_entity($guid)) {

		if ($stores->canEdit()) {
			$stores->status = 0;
			$context = get_context();
			set_context('delete_product');
			$delete = $stores->save();
			set_context($context);
			//------- Delete images from data -----------//
			/*$image_prefix = "{$CONFIG->pluginname}/".$stores->guid;
			
			$delstores = new ElggFile();
			$delstores->owner_guid = $stores->owner_guid;
			$delstores->setFilename($image_prefix . ".jpg");
			$delstores->delete();
			
			$delstores = new ElggFile();
			$delstores->owner_guid = $stores->owner_guid;
			$delstores->setFilename($image_prefix . "tiny.jpg");
			$delstores->delete();
			
			$delstores = new ElggFile();
			$delstores->owner_guid = $stores->owner_guid;
			$delstores->setFilename($image_prefix . "small.jpg");
			$delstores->delete();
			
			$delstores = new ElggFile();
			$delstores->owner_guid = $stores->owner_guid;
			$delstores->setFilename($image_prefix . "medium.jpg");
			$delstores->delete();
			
			$delstores = new ElggFile();
			$delstores->owner_guid = $stores->owner_guid;
			$delstores->setFilename($image_prefix . "large.jpg");
			$delstores->delete();
			
			if($stores->filename){
				$delstores = new ElggFile();
				$delstores->owner_guid = $stores->owner_guid;
				$delstores->setFilename($stores->filename);
				$delstores->delete();	
			}
			
			$container = get_entity($stores->container_guid);
			
			$thumbnail = $stores->thumbnail;
			$smallthumb = $stores->smallthumb;
			$largethumb = $stores->largethumb;
			if ($thumbnail) {

				$delstores = new ElggFile();
				$delstores->owner_guid = $stores->owner_guid;
				$delstores->setFilename($thumbnail);
				$delstores->delete();

			}
			if ($smallthumb) {

				$delstores = new ElggFile();
				$delstores->owner_guid = $stores->owner_guid;
				$delstores->setFilename($smallthumb);
				$delstores->delete();

			}
			if ($largethumb) {

				$delstores = new ElggFile();
				$delstores->owner_guid = $stores->owner_guid;
				$delstores->setFilename($largethumb);
				$delstores->delete();

			}*/
			
			if (!$delete) {
				register_error(elgg_echo("stores:deletefailed"));
			} else {
				system_message(elgg_echo("stores:deleted"));
			}

		} else {
			
			$container = $_SESSION['user'];
			register_error(elgg_echo("stores:deletefailed"));
			
		}

	} else {
		
		register_error(elgg_echo("stores:deletefailed"));
		
	}
	
	forward("pg/{$CONFIG->pluginname}/" . $_SESSION['user']->username);
exit();
?>
