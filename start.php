<?php
	/**
	 * Elgg Commerce - start page
	 * 
	 * @package Elgg Commerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
 	**/
	
	/*
	 *	we'll have to explicitly include classes for now but they will autoload once we move to elgg 1.8
	 *	require_once("/classes/splugin_settings.php");
	 *	$bear = new bear();
	 */
		 
	// Load socialcommerce model
    	require_once(dirname(__FILE__)."/modules/module.php");
   
	// Load system configuration
		global $CONFIG;
				
	// Set Config Values	
		$CONFIG->default_price_sign = "$";
		$CONFIG->default_currency_name = 'US Dollar';
		$CONFIG->pluginname = "socialcommerce";
			
	/**
	 * Social Commerce plugin initialization functions.
	 */
	function socialcommerce_init() {
	    
	    // Load system configuration
			global $CONFIG;
		
		// Set up menu for logged in users
			if (isloggedin()) {
				add_menu(elgg_echo('stores'), $CONFIG->wwwroot . 'pg/socialcommerce/' . $_SESSION['user']->username."/all");
			}
	
		// Extend CSS
			elgg_extend_view("css", "socialcommerce/css");
			elgg_extend_view("js", "socialcommerce/js/behavior");
			elgg_extend_view("js", "socialcommerce/js/rating");
			elgg_extend_view("index/righthandside", "socialcommerce/products_list",600);
			elgg_extend_view("index/righthandside", "socialcommerce/most_popular_products",600);
					
			elgg_extend_view("owner_block/extend", "socialcommerce/owner_block",500);
			
			elgg_extend_view("page_elements/header_contents", "socialcommerce/header");
			
			elgg_extend_view("metatags", "socialcommerce/extend_header");
			
			elgg_extend_view("page_elements/footer", "socialcommerce/extend_footer",400);
		
		// Extend hover-over menu	
			elgg_extend_view("profile/menu/links","socialcommerce/menu");
			//extend_view('groups/right_column','stores/groupprofile_files');
			
		// Load the language file
			register_translations($CONFIG->pluginspath . "socialcommerce/languages/");
			
		// Register a page handler, so we can have nice URLs
			register_page_handler("socialcommerce", "socialcommerce_page_handler");
			
		// Register an image handler for stores
			register_page_handler("storesimage","socialcommerce_image_handler");
			
		// Add a new file widget
			if(isadminloggedin()){
			add_widget_type('recent',elgg_echo("stores:recent:widget"),elgg_echo("stores:recent:widget:description"));
			}
			//add_widget_type('mostly',elgg_echo("stores:mostly:widget"),elgg_echo("stores:mostly:widget:description"));
			if(!isadminloggedin()){
			add_widget_type('purchased',elgg_echo("stores:purchased:widget"),elgg_echo("stores:purchased:widget:description"));
			}
		// Register a URL handler for files
			register_entity_url_handler('stores_url','object','stores');
			register_entity_url_handler('category_url','object','category');
			register_entity_url_handler('cart_url','object','cart');
			
		// Now override icons
			register_plugin_hook('entity:icon:url', 'object', 'socialcommerce_image_hook');
			
		// Register entity type
			register_entity_type('object','stores');
		
		// Register socialcommerce settings
			register_socialcommerce_settings();
			
		// Register country and state for socialcommerce
			register_country_state();

			register_subtypes();
					
	
	    	if (get_context() == "stores" || get_context() == "socialcommerce") {
	    		if(!isset($_REQUEST['search_viewtype']))
	    			set_input('search_viewtype','list');
	    	}
	    	
   }
   
   /**
	 * This function loads a set of default fields into the socialcommerce, then triggers a hook letting other plugins to edit
	 * add and delete fields.
	 *
	 * Note: This is a secondary system:init call and is run at a super low priority to guarantee that it is called after all
	 * other plugins have initialised.
	 */
   	function product_fields_setup(){
   		global $CONFIG;
   		//--- Default product types ----//
   		$default_produt_types = array((object)array('value'=>2,'display_val'=>elgg_echo('stores:digital:products'),'addto_cart'=>1)
								 );
								 
		$CONFIG->produt_type_default = trigger_plugin_hook('socialcommerce:product:type', 'stores', NULL, $default_produt_types);
								 
   		//--- Default fields for digital products ----//
		$product_fields[2] = array (
			'upload' => array('field'=>'file','mandatory'=>1,'display'=>1),
			'price' => array('field'=>'text','mandatory'=>1,'display'=>1)
		);
		$CONFIG->product_fields = trigger_plugin_hook('socialcommerce:fields', 'stores', NULL, $product_fields);
		
		//--- Default related product types ----//
   		$default_relatedprodut_types = array((object)array('value'=>1,'display_val'=>elgg_echo('stores:related:product'),'addto_cart'=>0),
								      (object)array('value'=>2,'display_val'=>elgg_echo('stores:services'),'addto_cart'=>0)
								 );
								 
		$CONFIG->default_relatedprodut_types = trigger_plugin_hook('socialcommerce:relatedprodut:type', 'stores', NULL, $default_relatedprodut_types);
   	}
		
	function socialcommerce_pagesetup() {
		global $CONFIG;
		//add submenu options
		if (get_context() == "stores" || get_context() == "socialcommerce") {
			//if ((page_owner() == $_SESSION['guid'] || !page_owner()) && isloggedin()) {
			if (isset($_SESSION['guid']) && isloggedin()) {	
				add_submenu_item(elgg_echo('stores:everyone'),$CONFIG->wwwroot."pg/socialcommerce/" . $_SESSION['user']->username . "/all",'stores');
				add_submenu_item(elgg_echo('stores:category'),$CONFIG->wwwroot."pg/socialcommerce/" . $_SESSION['user']->username . "/category/",'stores');
				$splugin_settings = elgg_get_entities(array( 	
					'type' => 'object',
					'subtype' => 'splugin_settings',
					)); 			
				
				if($splugin_settings){
					$settings = $splugin_settings[0];
				}
				$All_Store_Entities = elgg_get_entities(array(
					'type' => 'object', 
					'subtype' => 'stores', 
					'owner_guid' => 0, 
					'order_by' => '', 
					'limit' => 15, 
					'offset' => 0, 
					'count' => true, 
					'site_guid' => 0, 
					'container_guid' => null, 
					'timelower' => 0, 
					'timeupper' => 0
					));
												  
				if(isadminloggedin() && $All_Store_Entities<11){
					add_submenu_item(elgg_echo('stores:addpost'),$CONFIG->wwwroot."pg/socialcommerce/" . $_SESSION['user']->username . "/add",'create');
				}
				if(isadminloggedin()){
				add_submenu_item(elgg_echo('stores:sold:products'),$CONFIG->wwwroot."pg/socialcommerce/" . $_SESSION['user']->username . "/sold",'sold');
				}
				if(isadminloggedin()){
					add_submenu_item(elgg_echo('stores:addcate'),$CONFIG->wwwroot."pg/socialcommerce/" . $_SESSION['user']->username . "/addcategory/",'create');
				}
			} else if (page_owner()) {
				$page_owner = page_owner_entity();
				add_submenu_item(sprintf(elgg_echo('stores:user'),$page_owner->name),$CONFIG->wwwroot."pg/socialcommerce/" . $page_owner->username);
				if ($page_owner instanceof ElggUser)
					add_submenu_item(sprintf(elgg_echo('stores:user:friends'),$page_owner->name),$CONFIG->wwwroot."pg/socialcommerce/" . $page_owner->username . "/friends/");
			}
		}
		
		if (get_context() == 'admin' && isadminloggedin()) {
			add_submenu_item(elgg_echo('socialcommerce:default:settings'), $CONFIG->wwwroot . 'pg/'.$CONFIG->pluginname.'/' . $_SESSION['user']->username . '/settings');
		}
		
		
	}
	
	function socialcommerce_page_handler($page) {
		global $CONFIG;
		
		// The first component of a blog URL is the username
		if (isset($page[0]) && !is_numeric($page[0])){
			set_input('username',$page[0]);
		}
		if(is_numeric($page[0])){
			set_input('stores_guid', $page[0]);
		}
		$page_0 = array('all','login');
		if(in_array($page[0],$page_0)){
			switch($page[0]) {
				case "all":				include(dirname(__FILE__) . "/all.php");
										break;
				case "login":           include(dirname(__FILE__) . "/login.php");
									  	break;
			}
			return true;
		}
		// The second part dictates what we're doing
		if (isset($page[1])) {
			switch($page[1]) {
				case "read":			if($page[2] > 0){
											set_input('guid',$page[2]);
											$product = get_entity($page[2]);
										}
										@include(dirname(dirname(dirname(__FILE__))) . "/entities/index.php");
										break;
				case "category":		include(dirname(__FILE__) . "/category.php");
										break;
				case "addcategory":		include(dirname(__FILE__) . "/add_category.php");
										break;
				case "cart":			include(dirname(__FILE__) . "/cart.php");
										break;
				case "cateread":		set_input('guid',$page[2]);
										include(dirname(dirname(dirname(__FILE__))) . "/entities/index.php");
										break;
				case "buy":				set_input('stores_guid',$page[2]);
										include(dirname(__FILE__) . "/buy.php");
										//@include(dirname(dirname(dirname(__FILE__))) . "/entities/index.php");
										break;
				case "all":				include(dirname(__FILE__) . "/all.php");
										break;
				case "address":			include(dirname(__FILE__) . "/address.php");
										break;
				case "confirm":			include(dirname(__FILE__) . "/cart_confirm.php");
										break;
				case "cart_success":	view_success_page();
										break;
				case "order":			set_input('search_viewtype','list');
										include(dirname(__FILE__) . "/order.php");
										break;
				case "wishlist":		include(dirname(__FILE__) . "/wishlist.php");
										break;
				case "cancel":			view_cancel_page();
										break;
				case "ipn":				makepayment_paypal();
										break;
				case "administration":	include(dirname(__FILE__) . "/administration/index.php");
									  	break;
				case "my_account":		include(dirname(__FILE__) . "/my_account.php");
									  	break;
				case "type":			include(dirname(__FILE__) . "/product_type.php");
									  	break;
				case "product_cate":	include(dirname(__FILE__) . "/product_category.php");
									  	break;
				case "more_order_item":	include(dirname(__FILE__) . "/more_order_item.php");
									  	break;
				case "sold":			include(dirname(__FILE__) . "/sold.php");
									  	break;
				case "add":				include(dirname(__FILE__) . "/add.php");
									  	break;
				case "settings":		include("/socialcommerce_settings.php");
										break;
				case "checkout_process":include(dirname(__FILE__) . "/checkout_process.php");
									  	break;
				case "checkout_address":include(dirname(__FILE__) . "/checkout_address.php");
									  	break;
				case "view_address":	include(dirname(__FILE__) . "/address_view.php");
									  	break;
				case "order_products":	if($page[2])
											set_input('guid',$page[2]);
										include(dirname(__FILE__) . "/order_products.php");
									  	break;
				case "currency_settings":include(dirname(__FILE__) . "/load_currency_settings.php");
									  	break;
				case "country_state"	:include(dirname(__FILE__) . "/manage_country_state.php");
									  	break;
				case "edit":			include(dirname(__FILE__) . "/edit.php");
										break;
				
				case "delete":			//	@todo - this doesn't work...
									//	include(dirname(__FILE__) . "/cart_success.php");
										break;
														
				default:				include(dirname(__FILE__) . "/index.php");
										break;
										
			}
		// If the URL is just 'socialcommerce/username', or just 'socialcommerce/', load the standard blog index
		} else {
			include(dirname(__FILE__) . "/index.php");
			return true;
		}
		
		return false;
	}
	
	/**
	 * This hooks into the getIcon API and provides nice user image for users where possible.
	 *
	 * @param unknown_type $hook
	 * @param unknown_type $entity_type
	 * @param unknown_type $returnvalue
	 * @param unknown_type $params
	 * @return unknown
	 */
	function socialcommerce_image_hook($hook, $entity_type, $returnvalue, $params)
	{
		global $CONFIG;
		
		if ((!$returnvalue) && ($hook == 'entity:icon:url') && ($params['entity'] instanceof ElggEntity))
		{
			$entity = $params['entity'];
			$type = $entity->type;
			$viewtype = $params['viewtype'];
			$size = $params['size'];
			
			if ($icontime = $entity->icontime) {
				$icontime = "{$icontime}";
			} else {
				$icontime = "default";
			}
			
			$filehandler = new ElggFile();
			$filehandler->owner_guid = $entity->owner_guid;
			$filehandler->setFilename("socialcommerce/" . $entity->guid . $size . ".jpg");
			
			if ($filehandler->exists()) {
				$url = $CONFIG->url . "pg/storesimage/{$entity->guid}/$size/$icontime.jpg";
			
				return $url;
			}
		}
	}
	/**
	 * Handle stores Image.
	 *
	 * @param unknown_type $page
	 */
	function socialcommerce_image_handler($page) {
			
		global $CONFIG;
		
		// The username should be the file we're getting
		if (isset($page[0])) {
			set_input('stores_guid',$page[0]);
		}
		if (isset($page[1])) {
			set_input('size',$page[1]);
		}
		// Include the standard profile index
		include($CONFIG->pluginspath . "socialcommerce/graphics/icon.php");
	}
	
	/**
	 * Returns an overall product type from the mimetype
	 *
	 * @param string $mimetype The MIME type
	 * @return string The overall type
	 */
	function get_general_product_type($mimetype) {
		
		switch($mimetype) {
			
			case "application/msword":
										return "document";
										break;
			case "application/pdf":
										return "document";
										break;
			
		}
		
		if (substr_count($mimetype,'text/'))
			return "document";
			
		if (substr_count($mimetype,'audio/'))
			return "audio";
			
		if (substr_count($mimetype,'image/'))
			return "image";
			
		if (substr_count($mimetype,'video/'))
			return "video";

		if (substr_count($mimetype,'opendocument'))
			return "document";	
			
		return "general";
		
	}
	
	/**
	 * Returns a list of producttypes to search specifically on
	 *
	 * @param int|array $owner_guid The GUID(s) of the owner(s) of the files 
	 * @param true|false $friends Whether we're looking at the owner or the owner's friends
	 * @return string The typecloud
	 */
	function get_storestype_cloud($owner_guid = "", $friends = false) {
		
		if ($friends) {
			if ($friendslist = get_user_friends($user_guid, $subtype, 999999, 0)) {
				$friendguids = array();
				foreach($friendslist as $friend) {
					$friendguids[] = $friend->getGUID();
				}
			}
			$friendofguid = $owner_guid;
			$owner_guid = $friendguids;
		} else {
			$friendofguid = false;
		}
		return elgg_view("socialcommerce/typecloud",array('owner_guid' => $owner_guid, 'friend_guid' => $friendofguid, 'types' => get_tags(0,10,'simpletype','object','stores',$owner_guid)));

	}
	
	/**
	 * Populates the ->getUrl() method for file objects
	 *
	 * @param ElggEntity $entity File entity
	 * @return string File URL
	 */
	function stores_url($entity) {
		
		global $CONFIG;
		$title = $entity->title;
		$title = friendly_title($title);
		return $CONFIG->url . "pg/socialcommerce/" . $entity->getOwnerEntity()->username . "/read/" . $entity->getGUID() . "/" . $title;
		
	}
	
	/**
	 * Populates the ->getUrl() method for file objects
	 *
	 * @param ElggEntity $entity File entity
	 * @return string File URL
	 */
	function category_url($entity) {
		
		global $CONFIG;
		$title = $entity->title;
		$title = friendly_title($title);
		return $CONFIG->url . "pg/socialcommerce/" . $entity->getOwnerEntity()->username . "/cateread/" . $entity->getGUID() . "/" . $title;
		
	}
	
	function cart_url($entity) {
		
		global $CONFIG;
		$title = $entity->title;
		$title = friendly_title($title);
		return $CONFIG->url . "pg/socialcommerce/" . $entity->getOwnerEntity()->username . "/cart/" . $entity->getGUID() . "/" . $title;
		
	}
	
	
	/**
	 * Populates the ->getUrl() method for file objects
	 *
	 * @param ElggEntity $entity File entity
	 * @return string File URL
	 */
	function addcartURL($entity) {
		global $CONFIG;
		$title = $entity->title;
		$title = friendly_title($title);
		//return $CONFIG->url . "pg/socialcommerce/" . $entity->getOwnerEntity()->username . "/buy/" . $entity->getGUID() . "/" . $title;
		return	elgg_add_action_tokens_to_url($CONFIG->url."action/socialcommerce/addcart?stores_guid=".$entity->getGUID());		//	@todo - fix query string
	}
	
	function elgg_addcart($entity){
		global $CONFIG;
		
		if ($entity->guid > 0 && (isloggedin())) {
			$form_body = elgg_view('input/hidden', array('internalname' => 'stores_guid', 'value' => $entity->getGUID()));
			$form_body .= "<input type='image' src=\"{$CONFIG->wwwroot}mod/{$CONFIG->pluginname}/images/shopping_cart_btn.jpg\">";//elgg_view('input/submit', array('value' => elgg_echo("add:to:cart")));
			if($entity->product_type_id == 1){
				$label = "<div style=\"float:left;margin-bottom:5px;\"><label>".elgg_echo("enter:quantity").": </label></div>
				<div style=\"clear:both;float:left;width:300px;\"><div style=\"float:left;\"><p>" . elgg_view('input/text',array('internalname' => 'cartquantity')) . "</p></div><div style=\"float:left;padding-left:20px;\">{$form_body}</div></div>";
			}elseif ($entity->product_type_id == 2){
				$label = $form_body;
			}
			
			$hidden_values = elgg_view('input/securitytoken');
			$form_body = <<<EOT
            	<form action="{$CONFIG->url}action/{$CONFIG->pluginname}/addcart" method="post">
            		<div class="add_to_cart_form">
            			<div style="float:left;width:310px;">
            				{$label}
            			</div>
            			<div style="clear:both;"></div>
            		</div>
            	</form>
EOT;
			return $form_body;
		}/*else{
			register_error(elgg_echo("notlogin:message"));
		}*/
	}
	
	/**
	 * Update an item of metadata for stores.
	 *
	 * @param int $id
	 * @param string $name
	 * @param string $value
	 * @param string $value_type
	 * @param int $owner_guid
	 * @param int $access_id
	 */
	 
	function update_metadata_for_stores($id, $name, $value, $value_type, $owner_guid, $access_id) {
		global $CONFIG;

		$id = (int)$id;

		if(!$md = get_metadata($id)) { return false; }	
		
		// If memcached then we invalidate the cache for this entry
		static $metabyname_memcache;
		if((!$metabyname_memcache) && (is_memcache_available())) { $metabyname_memcache = new ElggMemcache('metabyname_memcache'); }
		if($metabyname_memcache) { $metabyname_memcache->delete("{$md->entity_guid}:{$md->name_id}"); }
		
		//$name = sanitise_string(trim($name));
		//$value = sanitise_string(trim($value));
		$value_type = detect_extender_valuetype($value, sanitise_string(trim($value_type)));
		
		$owner_guid = (int)$owner_guid;
		if ($owner_guid==0) $owner_guid = get_loggedin_userid();
		
		$access_id = (int)$access_id;
		
		$access = get_access_sql_suffix();
		
		// Support boolean types (as integers)
		if (is_bool($value)) {
			if ($value)
				$value = 1;
			else
				$value = 0;
		}
		
		// Add the metastring
		$value = add_metastring($value);
		if (!$value) return false;
		
		$name = add_metastring($name);
		if (!$name) return false;
		
		// If ok then add it
		$result = update_data("UPDATE {$CONFIG->dbprefix}metadata set value_id='$value', value_type='$value_type', access_id=$access_id, owner_guid=$owner_guid where id=$id and name_id='$name'");
		if ($result!==false) {
			$obj = get_metadata($id);
			if (trigger_elgg_event('update', 'metadata', $obj)) {
				return true;
			} else {
				delete_metadata($id);
			}
		}
			
		return $result;
	}
	
	function get_stores_from_relationship($relationship,$relationship_guid, $metaname = "",$metavalue = "",$type = "", $subtype = "",$owner_guid = "", $metaorder_by = "", $order_by = "", $order = "ASC",$count=false){
		global $CONFIG;
		
		$relationship = sanitise_string($relationship);
		$relationship_guid = (int)$relationship_guid;
		$type = sanitise_string($type);
		$subtype = get_subtype_id($type, $subtype);
		$owner_guid = (int)$owner_guid;
		
		if($metaorder_by){
			$order_by = " CAST( v.string AS unsigned ) ".$order;
		}elseif ($order_by){
			$order_by = " e.".sanitise_string($order_by) . $order;
		}else {
			$order_by = " e.time_created desc";
		}
		
		$where = "";
		if ($relationship!="")
			$where = " AND r.relationship='$relationship' ";
		if ($relationship_guid)
			$where .= " AND r.guid_one='$relationship_guid' ";
		if ($type != "")
			$where .= " AND e.type='$type' ";
		if ($subtype)
			$where .= " AND e.subtype=$subtype ";
			
		if(is_array($owner_guid)){
			$where .= " AND e.owner_guid IN (" . implode(",",$owner_guid) . ")";
		}else{
			$where .= " AND e.owner_guid=$owner_guid ";
		}
		if($metaname){
			$nameid = get_metastring_id($metaname);
			if($nameid){
				$where .= " and m.name_id=".$nameid;
			}else{
				$where .= " and m.name_id=0";
			}
		}	
		if($metavalue || $metavalue == '0'){
			$valueid = get_metastring_id($metavalue);
			if($valueid){
				$where .= " and m.value_id=".$valueid;
			}else{
				$where .= " and m.value_id=0";
			}
		}
		
		$query = "SELECT SQL_CALC_FOUND_ROWS e.*, v.string as value FROM {$CONFIG->dbprefix}entity_relationships r JOIN {$CONFIG->dbprefix}entities e ON e.guid = r.guid_two JOIN {$CONFIG->dbprefix}metadata m ON e.guid = m.entity_guid JOIN {$CONFIG->dbprefix}metastrings v ON m.value_id = v.id WHERE (1 = 1) ".$where." AND e.enabled='yes' AND m.enabled='yes'  ORDER BY ".$order_by." ".$limit;			
		$sections = get_data($query);
		return $sections;
	}
	
	function get_sold_products($metavalue=null,$limit,$offset=0){
		global $CONFIG;
		$nameid = get_metastring_id('product_owner_guid');
		if($nameid){
			$where = " and m.name_id=".$nameid;
		}else{
			$where = " and m.name_id=0";
		}
		if($metavalue != null){
			$valueid = get_metastring_id($metavalue);
			if($valueid){
				$where .= " and m.value_id =".$valueid;
			}else{
				$where .= " and m.value_id=0";
			}
		}
		$m1_nameid = get_metastring_id('product_id');
		if($m1_nameid){
			$where .= " and m1.name_id=".$m1_nameid;
		}
		$where .= " and e.type='object'";
		$subtypeid = get_subtype_id('object','order_item');
		if($subtypeid){
			$where .= " and e.subtype=".$subtypeid;
		}else{
			$where .= " and e.subtype=-1";
		}
		
		$order = " order by e.time_created desc";	
		
		if($limit){
			$limit = " limit ".$offset.",".$limit;
		}else{
			$limit = "";
		}
		
		$query = "SELECT SQL_CALC_FOUND_ROWS DISTINCT v.string AS value, e.guid AS guid, e.owner_guid as owner_guid, e.container_guid as container_guid from {$CONFIG->dbprefix}metadata m JOIN {$CONFIG->dbprefix}entities e on e.guid = m.entity_guid JOIN {$CONFIG->dbprefix}metadata m1 ON e.guid = m1.entity_guid JOIN {$CONFIG->dbprefix}metastrings v on m1.value_id = v.id where (1 = 1) ".$where." and m.enabled='yes' GROUP BY v.string  ".$order." ".$limit;
		$sold_products = get_data($query);
		return $sold_products;
	}
	
	function get_purchased_orders($metaname=null,$metavalue=null,$type=null,$subtype=null,$where_spval=false,$where_spval_con=null,$metaorder=fale,$entityorder=null,$order='ASC',$limit=null,$offset=0,$count=false,$owner=0,$container=0,$id_not_in=null,$title=null,$where_con=""){
		global $CONFIG;
		if($metaname){
			$nameid = get_metastring_id($metaname);
			if($nameid){
				$where = " and m.name_id=".$nameid;
			}else{
				$where = " and m.name_id=0";
			}
		}
		if($metavalue != null){
			$metavalues = explode(',',$metavalue);
			foreach($metavalues as $metavalue){
				$valueid = get_metastring_id($metavalue);
				if($valueid <= 0)
					$valueid = 0;
				$metavalue_in .= !empty($metavalue_in) ? ",".$valueid : $valueid;
			}
			
			if($metavalue_in){
				$where .= " and m.value_id IN(".$metavalue_in.")";
			}else{
				$where .= " and m.value_id=0";
			}
		}
		if($type){
			$where .= " and e.type='".$type."'";
		}
		if($subtype){
			$subtypeid = get_subtype_id('object',$subtype);
			if($subtypeid){
				$where .= " and e.subtype=".$subtypeid;
			}else{
				$where .= " and e.subtype=-1";
			}
		}
		
		if(is_array($owner)){
			$where .= " AND e.owner_guid IN (" . implode(",",$owner) . ")";
		}else{
			if($owner > 0)
				$where .= " AND e.owner_guid=$owner ";
		}
		
		if($container > 0)
			$where .= " and e.container_guid=".$container;
			
		if(is_array($id_not_in)){
			$entity_guids = get_not_in_ids($id_not_in);
			if(!empty($entity_guids)){
				$where .= " and e.guid NOT IN(".$entity_guids.") ";
			}
		}	
		if($title){
			$where .= " and o.title='".$title."'";
		}
		if($where_spval){
			$current_date = strtotime(date("m/d/Y"));
			$where .= " and v.string {$where_spval_con} {$current_date}";
		}
		if($where_con){
			$where .= " {$where_con} ";
		}
		
		if($metaorder){
			$order = " order by  CAST( v.string AS unsigned ) ".$order;
		}elseif($entityorder){
			$order = " order by e.".$entityorder." ".$order;
		}else{
			$order = " order by e.time_created desc";
		}
		
		if($limit){
			$limit = " limit ".$offset.",".$limit;
		}else{
			$limit = "";
		}
		
		//$access = get_stores_access_sql_suffix();
		$query = "SELECT SQL_CALC_FOUND_ROWS e.guid AS guid, e.owner_guid as owner_guid, e.container_guid as container_guid, v.string as value from {$CONFIG->dbprefix}metadata m JOIN {$CONFIG->dbprefix}entities e on e.guid = m.entity_guid JOIN {$CONFIG->dbprefix}metastrings v on m.value_id = v.id JOIN {$CONFIG->dbprefix}objects_entity o on e.guid = o.guid where (1 = 1) ".$where." and m.enabled='yes' ".$order." ".$limit;
		$propositions = get_data($query);
		if($count){
			$count = get_data("SELECT FOUND_ROWS( ) AS count");
			return $count[0]->count;
		}
		return $propositions;
	}
	
	
	
	function get_stores_access_sql_suffix($table_prefix = ""){
		global $ENTITY_SHOW_HIDDEN_OVERRIDE;  
		
		$sql = "";
		
		if ($table_prefix)
				$table_prefix = sanitise_string($table_prefix) . ".";
		
			$access = get_access_list();
			
			$owner = get_loggedin_userid();
			if (!$owner) $owner = -1;
			
			global $is_admin;
			
			if (isset($is_admin) && $is_admin == true) {
				$sql = " (1 = 1) ";
			}

			if (empty($sql))
				$sql = " ({$table_prefix}e.access_id in {$access} or ({$table_prefix}e.access_id = 0 and {$table_prefix}e.owner_guid = $owner))";

		if (!$ENTITY_SHOW_HIDDEN_OVERRIDE)
			$sql .= " and {$table_prefix}e.enabled='yes'";
		
		return $sql;
	}
	
	function gettags(){
		global $CONFIG;
		$products = elgg_get_entities(array( 	
			'type' => 'object',
			'subtype' => 'stores',
			)); 			
			
		foreach ($products as $product){
			if(!empty($product->tags)){
				if(is_array($product->tags)){
					foreach ($product->tags as $tag)
						$tagarr[$tag] = $tag;
				}else{
					$tagarr[$tag] = $product->tags;
				}
			}
		}
		return elgg_view("{$CONFIG->pluginname}/tagsmenu",array('tags'=>$tagarr));
	}
	
	/**
	 * Function for send email
	 *
	 */
	 function stores_send_mail($from,$to,$subject,$message,$headers = null){
	 	
	 	if(is_object($from)){
	 		$from_name = $from->name;
	 		$from_email = $from->email;
	 	}else{
	 		$from_name = $from;
	 		$from_email = $from;
	 	}
	 	
	 	if(is_object($to)){
	 		$to_email = $to->email;
	 	}else{
	 		$to_email = $to;
	 	}
	 	
	 	if(!$headers){
		 	$headers = "From: \"$from_name\" <$from_email>\r\n"
				. "Content-Type: text/html; charset=iso-8859-1\r\n"
	    		. "MIME-Version: 1.0\r\n"
	    		. "Content-Transfer-Encoding: 8bit\r\n";
	 	}
    	
    	return mail($to_email,$subject,$message,$headers);
	 }
	 
	 
	 function get_site_admin() {
	 	global $CONFIG;
		$access = get_access_sql_suffix('e');
	 	
		$row = get_data_row("SELECT e.* from {$CONFIG->dbprefix}users_entity u join {$CONFIG->dbprefix}entities e on e.guid=u.guid where u.admin='yes' and $access limit 1");
		if ($row) {
			return new ElggUser($row);
		}
		else {
			return false;
		}
	}

	/**
	 * Override the order_can_create function to return true for create order
	 *
	 */
	function order_can_create($hook_name, $entity_type, $return_value, $parameters) {
		$entity = $parameters['entity'];
		$context = get_context();//echo $entity->getSubtype();exit;
		if ($context == 'add_order' && $entity->getSubtype() == "") {
			return true;
		}elseif ($context == 'add_order' && $entity->getSubtype() == "rating"){
			return true;
		}elseif ($context == 'add_order' && $entity->getSubtype() == "cart"){
			return true;
		}elseif ($context == 'add_order' && $entity->getSubtype() == "cart_item"){
			return true;
		}elseif ($context == 'add_order' && $entity->getSubtype() == "stores"){
			return true;
		}elseif ($context == 'add_order' && $entity->getSubtype() == "order"){
			return true;
		}elseif ($context == 'add_order' && $entity->getSubtype() == "order_item"){
			return true;
		}elseif ($context == 'add_order' && $entity->getSubtype() == "transaction"){
			return true;
		}elseif ($context == 'add_order'){
			return true;
		}elseif ($context == 'add_settings' && $entity->getSubtype() == "s_currency"){
			return true;
		}elseif ($context == 'related_products'){
			return true;
		}
		return null;
  	}
  	// Make sure the stores initialization function is called on initialization
		register_elgg_event_handler('init','system','socialcommerce_init');
		register_elgg_event_handler('init','system','product_fields_setup', 10000); // Ensure this runs after other plugins
		
  	// Override permissions
		register_plugin_hook('permissions_check','user','order_can_create');
		register_plugin_hook('permissions_check','object','order_can_create');
		
		register_elgg_event_handler('pagesetup','system','socialcommerce_pagesetup');
		
	// Register actions
		register_action("{$CONFIG->pluginname}/add", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/add.php");
		register_action("{$CONFIG->pluginname}/edit", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/edit.php");
		register_action("{$CONFIG->pluginname}/delete", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/delete.php");
		register_action("{$CONFIG->pluginname}/icon", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/icon.php");
		register_action("{$CONFIG->pluginname}/add_category", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/add_category.php");
		register_action("{$CONFIG->pluginname}/edit_category", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/edit_category.php");
		register_action("{$CONFIG->pluginname}/delete_category", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/delete_category.php");
		register_action("{$CONFIG->pluginname}/addcart", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/addcart.php");
		register_action("{$CONFIG->pluginname}/remove_cart", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/remove_cart.php");
		register_action("{$CONFIG->pluginname}/update_cart", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/update_cart.php");
		register_action("{$CONFIG->pluginname}/add_address", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/add_address.php");
		register_action("{$CONFIG->pluginname}/edit_address", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/edit_address.php");
		register_action("{$CONFIG->pluginname}/delete_address", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/delete_address.php");
		register_action("{$CONFIG->pluginname}/makepayment", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/makepayment.php");
		register_action("{$CONFIG->pluginname}/add_order", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/add_order.php");
		register_action("{$CONFIG->pluginname}/change_order_status", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/change_order_status.php");
		register_action("{$CONFIG->pluginname}/add_wishlist", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/add_wishlist.php");
		register_action("{$CONFIG->pluginname}/remove_wishlist", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/remove_wishlist.php");
		register_action("{$CONFIG->pluginname}/download", true, $CONFIG->pluginspath. "{$CONFIG->pluginname}/actions/download.php");
		register_action("{$CONFIG->pluginname}/retrieve", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/retrieve.php");
		
		register_action("{$CONFIG->pluginname}/contry_tax", false, $CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/contry_tax.php");
				
		register_action("{$CONFIG->pluginname}/addcommon_tax",false,$CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/addcommon_tax.php");
		register_action("{$CONFIG->pluginname}/addcountry_tax",false,$CONFIG->pluginspath . "{$CONFIG->pluginname}/actions/addcountry_tax.php");
		register_action('socialcommerce/manage_socialcommerce', false, $CONFIG->pluginspath . 'socialcommerce/actions/manage_socialcommerce.php', false);

		
?>