<?php
	/**
	 * Elgg form - product
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
 	**/
	
	echo(__FILE__);
	
	if (isset($vars['entity'])) {
		$action = 'socialcommerce/edit/';
		$title = $vars['entity']->title;
		$body = $vars['entity']->description;
		$taxrate_name_cnty = $vars['entity']->countrycode;
		$price = $vars['entity']->price;
		$base_stock = $vars['entity']->base_stock;		// @todo - what exactly is base_stock ??
		$category = $vars['entity']->category;			// @todo - should there be a default category if one is not assigned??
		$quantity = $vars['entity']->quantity;			// @todo - I don't see a way to set the quantity ??
		$tags = $vars['entity']->tags;
		$access_id = $vars['entity']->access_id;
		$product_type_id = $vars['entity']->product_type_id;
	} else  {
		$title = elgg_echo("stores:addpost");
		$action = 'socialcommerce/add/';
		$tags = "";
		$title = "";
		$body = "";
		$base_stock = "";
		$access_id = 2;
		$product_type_id = get_input('product_type_id') ? get_input('product_type_id') : 2;
	}
		
	// Just in case we have some cached details -> see: C:\program files (x86)\Zend\Apache2\htdocs\elgg-1.8.16\actions\admin\site\flush_cache.php if any issues
	// http://docs.elgg.org/wiki/Scalability#System_cache
	if (isset($vars['product'])) {
			
		/*****	for testing purposes	*****/
		require_once('C:/Program Files (x86)/Zend/Apache2/htdocs/krumo/class.krumo.php');
		krumo($vars['product']); die();
		/*****	for testing purposes	*****/
		
		//unset($_SESSION['product']);
		$title = $vars['product']['storestitle'];
		$product_type_id = $vars['product']['product_type_id'];
		$category = $vars['product']['storescategory'];
		$body = $vars['product']['storesbody'];
		$tags = $vars['product']['storestags'];
		$access_id = $vars['product']['access_id'];
		$product_fields = $CONFIG->product_fields[$product_type_id];
		if (is_array($product_fields) && sizeof($product_fields) > 0){
			foreach ($product_fields as $shortname => $valtype){
				if($valtype['field'] != 'file')
					$_SESSION['product'][$shortname] = get_input($shortname);
				}
			}
		$price = $vars['product']['price'];
		$base_stock = $vars['product']['base_stock'];
		$quantity = $vars['product']['quantity'];
	}
		
	$chk_tax_type = '';
	$country_details = '';
    $product_type = elgg_view('input/product_type', array('internalname' => 'product_type_id', 'value' => $product_type_id));
		
    $category_lists = elgg_get_entities_from_metadata(array(
		'product_type_id' => $product_type_id,
		'type_subtype_pairs' => array('object' => 'sc_category'),
		'container_guid' => elgg_get_plugin_from_id('socialcommerce')->guid,
		));  	
		
	$options_values = array();
        if($category_lists){
        	foreach ($category_lists as $category_list){
        		$options_values[$category_list->guid] = $category_list->title;
        	}	
        }
		
	    if(!empty($category_lists)){
			$category_view = elgg_view('input/dropdown', array('internalname' => 'storescategory', 
													  'value' => $category, 
													  'js' => "id='storescategory'", 
													  'options_values' => $options_values
													  ));
        }else{
        	$category_view = elgg_echo('no:category');	
        }
		
	$text_textarea = elgg_view('input/longtext', array('internalname' => 'storesbody', 'value' => $body));
	$image_input = elgg_view("input/file",array('internalname' => 'product_image'));
	
	if ($vars['entity']->guid > 0){
		$uploaded_image = elgg_view("socialcommerce/image", array(
			'entity' => $vars['entity'],
			'size' => 'small',
			'display'=>'image'
			));
	}
	
	if (($action == "socialcommerce/add" && $product_type_id == 2 && $vars['entity']->mimetype == "")||($vars['entity']->guid > 0 && $product_type_id == 2 && $vars['entity']->mimetype == "")){
	    $upload_input = elgg_view("input/file",array('internalname' => 'upload'));
		$form_upload = 
			'<div>
				<label for="upload">'.elgg_echo('stores:file').':</label><br />'
			    .$upload_input
			.'</div>';
	}elseif ($vars['entity']->guid > 0 && $product_type_id == 2  && $vars['entity']->mimetype != ""){
		$upload_input = elgg_view("socialcommerce/icon", array("mimetype" => $vars['entity']->mimetype, 'thumbnail' => $vars['entity']->thumbnail, 'file_guid' => $vars['entity']->guid));
		$form_upload = 
			'<div>
				<label for="upload">'.elgg_echo('stores:file').':</label><br />'
				.$upload_input
				.'</div>';
	}
		
 /***** @todo - this needs work	*****/       
        $country_name = elgg_echo('country');
        $country_label = "<label><span style='color:red'>*</span>{$country_name}</label><br />";
        $country_list = "<select name='tax_country' id='tax_country' >";
            if($CONFIG->country){
			foreach ($CONFIG->country as $country){
				if($taxrate_name_cnty == $country['iso3']){
					$selected = "selected";
				}else {
					$selected = "";
				}
				$country_list .= "<option value='".$country['iso3']."' ".$selected.">".$country['name']."</option>";
			}	
		}
        $country_list .= "</select>";	  
	  
	$fields = '';
	$product_fields = $CONFIG->product_fields[$product_type_id];
		if (is_array($product_fields) && sizeof($product_fields) > 0){
			foreach ($product_fields as $shortname => $valtype){
				$value = $vars['entity']->$shortname;
				if (isset($vars['product']))
					$value = $vars['product'][$shortname];
				
				$fields .= '<div><label for="'.$shortname.'">'.elgg_echo('product:'.$shortname).'</label><br />';
				
				if($vars['entity']->mimetype != "" && $shortname == 'upload' && $valtype['field'] == 'file'){
					$fields .= "<div style='float:left;'>".elgg_view("socialcommerce/icon", array("mimetype" => $vars['entity']->mimetype, 'thumbnail' => $vars['entity']->thumbnail, 'stores_guid' => $vars['entity']->guid))."</div>";
					$fields .= "<div class='change_product_file'><a href='javascript:void(0);' onclick='load_edit_product_detaile();'><b>".elgg_echo('product:edit:file')."</a></div><div class='clear'></div>";
					$fields .= "<div id='product_file_change'>".elgg_view("input/{$valtype['field']}",array(
															'internalname' => $shortname,
															'value' => $value,
															)).'</div>';
				}else {
					$fields .= elgg_view("input/{$valtype['field']}",array(
															'internalname' => $shortname,
															'value' => $value,
															));
				}
				$fields .= '</div><br />';
			}
		}
        
	$tag_input = elgg_view('input/tags', array('internalname' => 'storestags','value' => $tags));
    $access_input = elgg_view('input/access', array('internalname' => 'access_id', 'value' => $access_id));
    $submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('save')));

	if (isset($vars['container_guid'])) { $entity_hidden = '<input type="hidden" name="container_guid" value="'.$vars['container_guid'].'" />'; }
	if (isset($vars['entity'])) { $entity_hidden .= '<input type="hidden" name="stores_guid" id="stores_guid" value="'.$vars['entity']->getGUID().'" />'; }
			
	$entity_hidden .= elgg_view('input/securitytoken');
	$post_url = $CONFIG->url."mod/socialcommerce/onchange_product_type.php";
	$id = $vars['entity']->guid ? $vars['entity']->guid : 0;
	$custom_fields = elgg_view("custom_field/view", array('entity'=>$vars['entity'], 'entity_type'=>$product_type_id) );
			
	$form_body = '
        <script>
        	function load_edit_product_detaile(){
				$("#product_file_change").show();
			}
        </script>
		<form action="'.$vars['url'].'action/'.$action.'" enctype="multipart/form-data" method="post">
			<div>
				<label for="storestitle">'.elgg_echo('title').':</label>'
					.elgg_view('input/text', array(
						'name' => 'storestitle',
						'id' => 'storestitle',
						'value' => $title,
						))
			.'</div><br />'
			.$product_type
			.'<div id="change_by_product_type">
			<div>
				<label for="storescategory">'.elgg_echo('category').':</label><br />'
					.$category_view
			.'</div><br />
			<div>
				<label for="storesbody">'.elgg_echo('stores:text').':</label><br />'
					.$text_textarea
			.'</div><br />
			<div>
				<label for="product_image">'.elgg_echo('product:image').'</label><br />'
				.$uploaded_image.$image_input
			.'</div><br />
			<div>'
				.$country_details
			.'</div>
			<div id="product_type_fields">'
				.$fields
				.$custom_fields
			.'</div>
			<div>
				<label for="storestags">'.elgg_echo('tags').'</label><br />'
				.$tag_input
			.'</div><br />
			<div>
				<label for="access_id">'.elgg_echo('access').'</label><br />'
				.$access_input
			.'</div><br />
			<div>'
				.$entity_hidden
				.$submit_input
			.'</div>
		</form>';

echo $form_body;
?>
