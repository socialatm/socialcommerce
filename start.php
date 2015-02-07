<?php
	/**
	 * Elgg products - start page
	 * 
	 * @package Elgg products
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
 	**/
	
	require_once('C:/Program Files (x86)/Zend/Apache2/htdocs/krumo/class.krumo.php');
//	krumo($CONFIG);
//	krumo::defines();
//	die();
	
	function socialcommerce_init() {
	    
// require_once('C:/Program Files (x86)/Zend/Apache2/htdocs/krumo/class.krumo.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
	    
		// load socialcommerce model
		require(elgg_get_config('pluginspath').'socialcommerce/modules/module.php');
		
		// make products show up in seach results
		elgg_register_entity_type( 'object', 'stores' );
					
		// register js files ->   elgg_register_js( $name, $url, $location = 'head', $priority = null )
		elgg_register_js( 'jquery.validate', elgg_get_config('url').'mod/socialcommerce/js/socialcommerce/checkout/jquery.validate.js', $location = 'footer', $priority = null );
		elgg_register_js( 'jquery.steps.min', elgg_get_config('url').'mod/socialcommerce/js/socialcommerce/checkout/jquery.steps.min.js', $location = 'footer', $priority = null );
		elgg_register_js( 'socialcommerce.checkout', elgg_get_config('url').'mod/socialcommerce/js/socialcommerce/checkout/socialcommerce.checkout.js', $location = 'footer', $priority = null );
						
		//	register css
		elgg_register_css('jquery.steps', elgg_get_config('url').'mod/socialcommerce/views/default/socialcommerce/css/checkout/jquery.steps.css', $priority = null);
		
		// register ajax views
		elgg_register_ajax_view('socialcommerce/change_country_state');
		elgg_register_ajax_view('socialcommerce/checkout');
		
		// extend CSS
			elgg_extend_view("css", "socialcommerce/css");
			elgg_extend_view("js", "socialcommerce/js/rating");
			
			elgg_extend_view("index/righthandside", "socialcommerce/products_list",600);
			elgg_extend_view("index/righthandside", "socialcommerce/most_popular_products",600);
					
			elgg_extend_view("page_elements/header_contents", "socialcommerce/header");
			
			elgg_extend_view("page/elements/head", "socialcommerce/extend_header");
			
			elgg_extend_view("page_elements/footer", "socialcommerce/extend_footer",400);
		
		// Extend hover-over menu	
			elgg_extend_view("profile/menu/links","socialcommerce/menu");
					
		// Load the language file
			register_translations(elgg_get_config('pluginspath').'socialcommerce/languages/');
			
		// Register a page handler, so we can have nice URLs
			elgg_register_page_handler("socialcommerce", "socialcommerce_page_handler");
			
		// Register an image handler for stores
			elgg_register_page_handler("storesimage","socialcommerce_image_handler");
			
		// Add widgets
			if(elgg_is_admin_logged_in()){
				elgg_register_widget_type('recent', elgg_echo("stores:recent:widget"),elgg_echo("stores:recent:widget:description"));
			}
			
			elgg_register_widget_type('mostly',elgg_echo("stores:mostly:widget"),elgg_echo("stores:mostly:widget:description"));
			
			if(!elgg_is_admin_logged_in()){
				elgg_register_widget_type('purchased',elgg_echo("stores:purchased:widget"),elgg_echo("stores:purchased:widget:description"));
			}
			
		// Register URL handlers
			elgg_register_plugin_hook_handler('entity:url', 'object', 'stores_set_url');
			elgg_register_plugin_hook_handler('entity:url', 'object', 'category_set_url');
			elgg_register_plugin_hook_handler('entity:url', 'object', 'cart_set_url');

			
		// Now override icons
			elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'socialcommerce_image_hook');
			
		// Register socialcommerce settings
			register_socialcommerce_settings();
			
		// Register country and state for socialcommerce
			register_country_state();

		sc_register_subtypes();
		
	    	if (elgg_get_context() == "stores" || elgg_get_context() == "socialcommerce") {
	    		if(!isset($_REQUEST['search_viewtype']))
	    			set_input('search_viewtype','list');
	    	}
    }
   
	// load product types
 	require(elgg_get_config('pluginspath').'socialcommerce/modules/product_types.php');
		
	function socialcommerce_pagesetup() {
		/*****	add menu items	*****/
		$user = elgg_get_logged_in_user_entity();
		
		// Set up menu for logged in users
			if (elgg_is_logged_in()) {
				elgg_register_menu_item('site', array(
					'name' => 'stores',
					'text' => elgg_echo('item:object:stores'),
					'href' => 'socialcommerce/'. $user->username.'/all/products/',
				));
			}
		$menu_item = array(
			'name' => 'category',			
			'text' => elgg_echo('stores:category'), 			
			'href' => elgg_get_config('url').'socialcommerce/'.$user->username .'/category/',			
			'contexts' => array('stores', 'socialcommerce'),	
			'parent_name' => 'stores',	
			);
			elgg_register_menu_item('site', $menu_item);
		
				if( elgg_is_admin_logged_in() ){
				
					$product_type_default = elgg_get_config('product_type_default');
					
					foreach($product_type_default as $key) {
		
						$menu_item = array(
							'name' => 'new_product_'.$key->display_val,			
							'text' => sprintf(elgg_echo("product:type:menu"),$key->display_val), 			
							'href' => elgg_get_config('url').'socialcommerce/'. $user->username.'/add/'.$key->value.'/',			
							'contexts' => array('stores', 'socialcommerce'),	
							'parent_name' => 'stores',	
							);
						elgg_register_menu_item('site', $menu_item);
					}
									
					$menu_item = array(
						'name' => 'new_product',			
						'text' => elgg_echo('stores:addpost'), 			
						'href' => elgg_get_config('url').'socialcommerce/'. $user->username .'/add/',			
						'contexts' => array('stores', 'socialcommerce'),	
						'parent_name' => 'stores',	
						);
						elgg_register_menu_item('site', $menu_item);
			
					$menu_item = array(
						'name' => 'new_category',			
						'text' => elgg_echo('stores:addcategory'), 			
						'href' => elgg_get_config('url').'socialcommerce/'. $user->username .'/addcategory/',			
						'contexts' => array('stores', 'socialcommerce'),	
						'parent_name' => 'stores',	
						);
						elgg_register_menu_item('site', $menu_item);
			
					$menu_item = array(
						'name' => 'sold_items',			
						'text' => elgg_echo('stores:sold:products'), 			
						'href' => elgg_get_config('url').'socialcommerce/'. $user->username .'/sold/',			
						'contexts' => array('stores', 'socialcommerce'),	
						'parent_name' => 'stores',
						'link_class' => 'elgg-menu-content',
						);
						elgg_register_menu_item('site', $menu_item);
						
				}		//	end if( elgg_is_admin_logged_in() ){
					
		$menu_item = array(
			'name' => 'stores_user',			
			'text' => sprintf(elgg_echo('stores:user'), $user->username), 			
			'href' => elgg_get_config('url').'socialcommerce/'.$user->username .'/products/',			
			'contexts' => array('stores', 'socialcommerce'),	
			'parent_name' => 'stores',	
			);
			elgg_register_menu_item('site', $menu_item);
			
		$menu_item = array(
			'name' => 'stores_user_friends',			
			'text' => sprintf(elgg_echo('stores:user:friends'), $user->username), 			
			'href' => elgg_get_config('url').'socialcommerce/'.$user->username .'/friends/products/',			
			'contexts' => array('stores', 'socialcommerce'),	
			'parent_name' => 'stores',	
			);
			elgg_register_menu_item('site', $menu_item);
	}
	
	function socialcommerce_page_handler( $page ) {
	
//	krumo($page);
	
		$base_path = elgg_get_config('pluginspath').'socialcommerce/pages/socialcommerce/';
		
		/*****	The first component of a socialcommerce URL is the username	*****/
		if (isset($page[0]) && !is_numeric($page[0])){
			set_input('username', $page[0]);
		}
		if(is_numeric($page[0])){
			set_input('stores_guid', $page[0]);
		}
		
		// The second part dictates what we're doing
		if (isset($page[1])) {
			switch($page[1]) {
				case "add":				require($base_path.'add.php');
										break;
				case "addcategory":		require($base_path.'add_category.php'); 
										break;
				case "address":			require($base_path.'address.php');
										break;
				case "all":				require($base_path.'all.php');
										break;
				case "buy":				set_input('stores_guid', $page[2]);
										require($base_path.'buy.php');
										break;
				case "cancel":			sc_view_cancel_page();
										break;
				case "cart":			require($base_path.'cart.php');
										break;
				case "cart_success":	view_success_page();
										break;
				case "category":		require($base_path.'category.php'); 
										break;
				case "cateread":		set_input('guid',$page[2]);
										require(dirname(dirname(dirname(__FILE__))) . '/pages/entities/index.php');
										break;
				case "checkout":		require($base_path.'checkout.php'); 
									  	break;
				case "checkout_address": require($base_path.'checkout_address.php'); 
									  	break;
				case "checkout_process": require($base_path.'checkout_process.php'); 
									  	break;
				case "confirm":			require($base_path.'cart_confirm.php');
										break;						
				case "country_state":	require($base_path.'manage_country_state.php'); 	
									  	break;						
				case "currency_settings": require($base_path.'load_currency_settings.php'); 
								
				//	@todo this needs to be fixed to use a form 
				case "delete":			require(elgg_get_config('pluginspath').'socialcommerce/actions/socialcommerce/delete.php'); 
										break;
									
				case "edit":			require($base_path.'edit.php'); 	
										break;
				case "edit_address":	require($base_path.'edit_address.php'); 	
										break;
				case "edit_category":	require($base_path.'add_category.php'); 
										break;
				case "friends":			require($base_path.'friends.php'); 	
										break;
				case "image":			require($base_path.'image.php'); 	
										break;
				case "ipn":				makepayment_paypal();
										break;						
				case "more_order_item":	require($base_path.'more_order_item.php');
									  	break;						
				case "my_account":		require($base_path.'my_account.php');
									  	break;	
				case "order":			set_input('search_viewtype', 'list');
										require($base_path.'order.php');
										break;
				case "order_products":	if($page[2]) { set_input('guid',$page[2]); }
										require($base_path.'order_products.php'); 
										break;
				case "product_cate":	require($base_path.'product_category.php');
									  	break;
				case "read":			require($base_path.'product.php');
										break;
				case "search":			require(elgg_get_config('pluginspath').'socialcommerce/search.php'); 
										break;
				case "sold":			require($base_path.'sold.php');
									  	break;
				case "type":			require($base_path.'product_type.php');
									  	break;
				case "view_address":	require($base_path.'address_view.php'); 
									  	break;
				case "wishlist":		require($base_path.'wishlist.php');
										break;
				default:				echo "request for $identifier $page[1]"; 
										break;
			}
		/*****	If the URL is just 'socialcommerce/username', or just 'socialcommerce/', load index.php	*****/
		} else {
			require($base_path.'index.php'); 
			return true;
		}
		return false;
	}
	
	/**
	 * Takes the product guid and returns the product image guid.
	 * @author ray peaslee
	 * @version elgg 1.9.4
	 * @return int $product_image_guid
	 */
	 
	function sc_product_image_guid($product_guid) {
	
		$options = array(
			'relationship' => 'product_image',
			'relationship_guid' => $product_guid,
		);
		$product_image = elgg_get_entities_from_relationship($options);
		$product_image_guid = $product_image[0]->guid;
		
		return $product_image_guid;
	}
	
	/**
	 * This hooks into the getIconURL API and provides nice user image for users where possible.
	 *
	 * @param unknown_type $hook
	 * @param unknown_type $entity_type
	 * @param unknown_type $returnvalue
	 * @param unknown_type $params
	 * @return unknown
	 */
	 
	function socialcommerce_image_hook($hook, $entity_type, $returnvalue, $params) {
		if ((!$returnvalue) && ($hook == 'entity:icon:url') && ($params['entity'] instanceof ElggEntity)) {
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
				$url = elgg_get_config('url')."storesimage/{$entity->guid}/$size/$icontime.jpg";
				return $url;
			}
		}
	}
	
	/**
	 * Handle stores Image.
	 * @param unknown_type $page
	 */
	 
	function socialcommerce_image_handler($page) {
		// The username should be the file we're getting
		if (isset($page[0])) {
			set_input('stores_guid',$page[0]);
		}
		if (isset($page[1])) {
			set_input('size',$page[1]);
		}
		// Include the standard profile index
		include( elgg_get_config('pluginspath').'socialcommerce/graphics/icon.php' );
	}
	
	/**
	 * Returns an overall product type from the mimetype
	 *
	 * @param string $mimetype The MIME type
	 * @return string The overall type
	 */
	 
	function get_general_product_type($mimetype) {
		
		switch($mimetype) {
			
			case "application/msword":	return "document";
										break;
			case "application/pdf":		return "document";
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
	 * Populates the ->getUrl() method for file objects
	 *
	 * @param ElggEntity $entity File entity
	 * @return string File URL
	 */
		
	function stores_set_url($hook, $type, $url, $params) {
		$entity = $params['entity'];
		if (elgg_instanceof($entity, 'object', 'stores')) {
			$title = elgg_get_friendly_title($entity->title);
			return elgg_get_config('url').'socialcommerce/'.$entity->getOwnerEntity()->username.'/read/'.$entity->getGUID().'/'.$title;
		}
	}
	
	/**
	 * Populates the ->getUrl() method for file objects
	 *
	 * @param ElggEntity $entity File entity
	 * @return string File URL
	 */
		
	function category_set_url($hook, $type, $url, $params) {
		$entity = $params['entity'];
		if (elgg_instanceof($entity, 'object', 'sc_category')) {
			$title = elgg_get_friendly_title($entity->title);
			return elgg_get_config('url').'socialcommerce/'.$entity->getOwnerEntity()->username.'/cateread/'.$entity->getGUID().'/'.$title;
		}
	}
	
	function cart_set_url($hook, $type, $url, $params) {
		$entity = $params['entity'];
		if (elgg_instanceof($entity, 'object', 'cart')) {
			$title = elgg_get_friendly_title($entity->title);
			return elgg_get_config('url').'socialcommerce/'.$entity->getOwnerEntity()->username.'/cateread/'.$entity->getGUID().'/'.$title;
		}
	}
	
	/**
	 * Populates the ->getUrl() method for file objects
	 *
	 * @param ElggEntity $entity File entity
	 * @return string File URL
	 */
	function addcartURL( $entity ) {
		$title = $entity->title;
		$title = elgg_get_friendly_title( $title );								//	@todo - I have no idea why $title is in here...
		return	elgg_get_config('url').'action/socialcommerce/add_to_cart/';
	}
	
	function get_sold_products(){
			echo '<b>'.__FILE__ .' at '.__LINE__; die();		
		//	function get_sold_products() needs a re-write
			return $sold_products;
	}
	
	function gettags(){
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
		return elgg_view( 'socialcommerce/tagsmenu', array( 'tags'=>$tagarr ));
	}
	
	/*****	send email function	*****/

	 function stores_send_mail( $from, $to, $subject, $message, $headers = null) {
	 	
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
       	return mail( $to_email, $subject, $message, $headers );
	 }
	 
	/*****	Override the order_can_create function to return true for create order	****/
	
	function order_can_create($hook_name, $entity_type, $return_value, $parameters) {
		$entity = $parameters['entity'];
		$context = elgg_get_context();
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
		elgg_register_event_handler('init','system','socialcommerce_init');
		elgg_register_event_handler('init','system','sc_product_fields_setup', 10000); 	// Ensure this runs after other plugins
		
		elgg_register_event_handler('pagesetup','system','socialcommerce_pagesetup');
		
  	// Override permissions
		elgg_register_plugin_hook_handler('permissions_check','user','order_can_create');
		elgg_register_plugin_hook_handler('permissions_check','object','order_can_create');
		
	//	register actions
		$action_path = elgg_get_config('pluginspath').'socialcommerce/actions/';
	
		//	products
		elgg_register_action("socialcommerce/add", $action_path.'add.php');
		elgg_register_action("socialcommerce/edit", $action_path.'edit.php');
		
		elgg_register_action("socialcommerce/product/delete", $action_path.'socialcommerce/product/delete.php');
		
		elgg_register_action("socialcommerce/icon", $action_path.'icon.php');
		
		//	category
		elgg_register_action("socialcommerce/category/save", $action_path.'socialcommerce/category/save.php');			//	01/24/2015
		elgg_register_action("socialcommerce/delete_category", $action_path.'delete_category.php');
		
		//	cart
		elgg_register_action('socialcommerce/add_to_cart', $action_path.'socialcommerce/add_to_cart.php' );
		elgg_register_action("socialcommerce/cart/delete", $action_path.'socialcommerce/cart/delete.php');
		elgg_register_action("socialcommerce/cart/update", $action_path.'socialcommerce/cart/update.php');
		
		//	address
		elgg_register_action("socialcommerce/address/save", $action_path.'socialcommerce/address/save.php');
		elgg_register_action("socialcommerce/address/delete", $action_path.'socialcommerce/address/delete.php');
		
		elgg_register_action("socialcommerce/makepayment", $action_path.'makepayment.php');
		elgg_register_action("socialcommerce/add_order", $action_path.'add_order.php');
		elgg_register_action("socialcommerce/change_order_status", $action_path.'change_order_status.php');
		
		//	wishlist
		elgg_register_action("socialcommerce/add_wishlist", $action_path.'add_wishlist.php');	// remove once the new add wishlist form is working
		elgg_register_action("products/add_wishlist", $action_path.'products/add_wishlist.php');
		elgg_register_action("socialcommerce/remove_wishlist", $action_path.'remove_wishlist.php');
		
		elgg_register_action("socialcommerce/download", $action_path.'download.php');
		elgg_register_action("socialcommerce/contry_tax", $action_path.'contry_tax.php');
		elgg_register_action("socialcommerce/addcommon_tax", $action_path.'addcommon_tax.php');
		elgg_register_action("socialcommerce/addcountry_tax", $action_path.'addcountry_tax.php');
		elgg_register_action('socialcommerce/manage_socialcommerce', $action_path.'manage_socialcommerce.php');
		elgg_register_action('socialcommerce/settings/save', $action_path.'socialcommerce/settings/save.php' );
		
?>
