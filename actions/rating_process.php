<?php
	/**
	 * Elgg rating - action
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
	 
	// Load Elgg engine
	header("Cache-Control: no-cache");
	header("Pragma: nocache");
	
	require_once(elgg_get_config('path').'engine/start.php');
	
	//getting the values
	elgg_set_context('add_order');
	$vote_sent = preg_replace("/[^0-9]/","",$_REQUEST['j']);
	$id_sent = preg_replace("/[^0-9a-zA-Z]/","",$_REQUEST['q']);
	$user_guid = preg_replace("/[^0-9\.]/","",$_REQUEST['t']);
	$units = preg_replace("/[^0-9]/","",$_REQUEST['c']);
	$rating_unitwidth = 16;
	$product = get_entity($id_sent);
	if ($vote_sent > $units) die("Sorry, vote appears to be invalid."); // kill the script because normal users will never see this.
	
	$rating_val = elgg_get_entities_from_metadata(array(
		'product_guid' => $id_sent,
		'type_subtype_pairs' => array('object' => 'rating'),
		));  	

	if(!$rating_val){
		$rating_val = new ElggObject();
		
		$rating_val->subtype="rating";
		$rating_val->access_id = 2;
		$rating_val->owner_guid = $product->owner_guid;
		$rating_val->container_guid = $product->owner_guid;
		$rating_val->product_guid = $id_sent;
		$rating_val->description = '';
		$rating_val->total_votes = 0;
		$rating_val->total_value = 0;
		$rating_val->final_value = 0;
		
		$result = $rating_val->save();
	}
	
	//connecting to the database to get some information
	$rating_val = elgg_get_entities_from_metadata(array(
		'product_guid' => $id_sent,
		'type_subtype_pairs' => array('object' => 'rating'),
		));  	

	if($rating_val){
		$rating_val = $rating_val[0];
		if($rating_val){
			$checkID = unserialize($rating_val->description);
			$count = $rating_val->total_votes; //how many votes total
			$current_rating = $rating_val->total_value; //total number of rating added together and stored
			$sum = $vote_sent+$current_rating; // add together the current vote value and the total vote value
			$tense = ($count==1) ? "vote" : "votes"; //plural form votes/vote
		}
		
		($sum==0 ? $added=0 : $added=$count+1);
		((is_array($checkID)) ? array_push($checkID,$user_guid) : $checkID=array($user_guid));
		$insertid=serialize($checkID);
		
		if(!strstr($rating_val->description,'"'.$user_guid.'"')){
			if (($vote_sent >= 1 && $vote_sent <= $units) && ($user_guid > 0)) { // keep votes within range, make sure IP matches - no monkey business!
				$rating_val->owner_guid = $product->owner_guid;
				$rating_val->container_guid = $product->owner_guid;
				$rating_val->total_votes = $added;
				$rating_val->total_value = $sum;
				$rating_val->final_value = @number_format($sum/$added,2);
				$rating_val->description = $insertid;
				
				$result = $rating_val->save();
			} 
		}
	}
	
	$newtotals = elgg_get_entities_from_metadata(array(
		'product_guid' => $id_sent,
		'type_subtype_pairs' => array('object' => 'rating'),
		));  	
	
	$numbers = $newtotals[0];
	$count = $numbers->total_votes;
	$current_rating = $numbers->total_value;
	$tense = ($count==1) ? "vote" : "votes"; //plural form votes/vote

	// $new_back is what gets 'drawn' on your page after a successful 'AJAX/Javascript' vote
	
	$new_back = array();
	
	$new_back[] .= '<ul class="unit-rating" style="width:'.$units*$rating_unitwidth.'px;">';
	$new_back[] .= '<li class="current-rating" style="width:'.@number_format($current_rating/$count,2)*$rating_unitwidth.'px;">Current rating.</li>';
	$new_back[] .= '<li class="r1-unit">1</li>';
	$new_back[] .= '<li class="r2-unit">2</li>';
	$new_back[] .= '<li class="r3-unit">3</li>';
	$new_back[] .= '<li class="r4-unit">4</li>';
	$new_back[] .= '<li class="r5-unit">5</li>';
	$new_back[] .= '<li class="r6-unit">6</li>';
	$new_back[] .= '<li class="r7-unit">7</li>';
	$new_back[] .= '<li class="r8-unit">8</li>';
	$new_back[] .= '<li class="r9-unit">9</li>';
	$new_back[] .= '<li class="r10-unit">10</li>';
	$new_back[] .= '</ul>';
	$new_back[] .= '<p class="voted"> <strong>'.@number_format($sum/$added,1).'</strong>/'.$units.' ('.$count.' '.$tense.') ';
	$new_back[] .= '<span class="thanks">Thanks for voting!</span></p>';
	
	$allnewback = join("\n", $new_back);
	
	// ========================
	
	//name of the div id to be updated | the html that needs to be changed
	$output = "unit_long$id_sent|$allnewback";
	echo $output;
?>