<?php
	/**
	 * Elgg css
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author twentyfiveautumn.com
	 * @copyright twentyfiveautumn.com 2013
	 * @link http://twentyfiveautumn.com/
	 **/ 
?>

p.storesrepo_owner {
	margin:0;
	padding:0;
}
.storesrepo_owner_details {
	/* font-size: 90%; */
	margin:0;
	padding:0;
	line-height: 1.2em;
}
.storesrepo_owner_details small {
	color:#666666;
}
.storesrepo_owner .usericon {
	margin-right: 5px;
	float: left;
}

.storesrepo_download a {
	font: 12px/100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #ffffff;
	background:#4690d6;
	border: 1px solid #4690d6;
	-webkit-border-radius: 3px; 
	-moz-border-radius: 3px;
	width: auto;
	height: 25px;
	padding: 2px 6px 2px 6px;
	margin:10px 0 10px 0;
	cursor: pointer;
}
.left{
	float:left;
}
.right{
	float:right;
}
.storesrepo_download a:hover {
	background: #0054a7;
	text-decoration: none;
}

/* STORES REPRO WIDGET VIEW */
.storesrepo_widget_singleitem {
	background-color: #eeeeee;
	margin:0 0 10px 0;
	min-height:60px;
	display:block;
}
.storesrepo_listview_icon {
	float: left;
	margin-right: 10px;
}
.storesrepo_timestamp {
	color:#666666;
	margin:0;
}
.storesrepo_listview_desc {
	display:none;
	padding:0 5px 10px 0;
	line-height: 1.2em;
}
.storesrepo_widget_content {
	margin-left: 70px;
}
.storesrepo_title {
	margin:0;
	padding:6px 5px 0 0;
	line-height: 1.2em;
}
.storesrepo_title a:hover {
	text-decoration: none;
}
.collapsable_box #storesrepo_widget_layout {
	margin:0;
}

/* widget gallery view */
.storesrepo_widget_galleryview img {
	padding:2px;
    border:1px solid #efefef;
    margin:2px;
}

.storesrepo_title_owner_wrapper {
	padding-top:10px;
	padding-bottom:5px;
}
storesrepo_icon img {
	width:350px;
}
.storesrepo_icon {
	margin:10px 0 0 10px;
	padding: 0 5px 5px 0;	
	float: left;
	width: 350px;
	
}
.right_section_contents{
	margin-left:10px;
	padding:0px;
	width:310px;
	float:left;
}
.storesrepo_title {
	margin:0;
	padding:10px;
	line-height: 1.2em;
}
.storesrepo_owner {
	padding:0 0 0 10px;
}
.storesrepo_description {
	margin:5px 0 0 0;
	padding:0 0 5px 10px;
}
.storesrepo_download{
	padding:0 0 20px 10px;
	margin:0;
}
.storesrepo_controls {
	padding:0 0 10px 10px;
	margin:0;
}
.storesrepo_description p {
	padding:0 0 5px 0;
	margin:0;
}
.storesrepo_specialcontent img {
	padding:5px;
	margin:0 0 0 10px;
	border:1px dotted silver; 
}
.storesrepo_tags {
	padding:10px 0 10px 10px;
	margin:0;
}

/* stores repro gallery items */
.stores .search_gallery .price{
	width:250px !important;
}
.stores .search_gallery{
	margin: 3px;
}
.stores .search_gallery_item{
	width: 314px;
}
.stores .search_gallery_item .search_listing_info p {
	margin:5px 5px 0 40px;
	text-align:left;
}
.stores .search_gallery_item .ratingblock p {
	margin:0;
}
.stores .search_gallery_item .cart_wishlist {
	padding:0 0 0 5px;
}
.stores .search_gallery_item .tag_td{
	width:100px !important;
	padding-left:34px;
}
.stores .search_gallery_item .object_category_string {
	margin:0 0 0 5px;
}
.stores .search_gallery_item .object_product_type_string {
	margin:0 0 0 5px;
}
.search_gallery .storesrepo_controls {
	padding:0;
}
.search_gallery .storesrepo_title {
	font-weight: bold;
	line-height: 1.1em;
	margin:0 0 10px 0;
}

.storesrepo_gallery_item {
	margin:0;
	padding:0;
}
.storesrepo_gallery_item p {
	margin:0;
	padding:0;
}
.search_gallery .storesrepo_comments {
	font-size:90%;
}

.storesrepo_user_gallery_link {
	float:right;
	margin:5px 5px 5px 50px;
}
.storesrepo_user_gallery_link a {
	padding:2px 25px 5px 0;
	background: transparent url(<?php echo elgg_get_config('url'); ?>_graphics/icon_gallery.gif) no-repeat right top;
	display:block;
}
.storesrepo_user_gallery_link a:hover {
	background-position: right -40px;
}

.input_quantity{
	width: 50px;
	padding:2px;
	font-size:12px;
}
.update_cart_quantity{
	padding:5px;
	width:230px;
}
.update_cart_quantity .qtext{
	color:#666666;
	font-size:11px;
}
.cart_subtotal{
	padding:5px;
	float:right;
}
.content_area_user_bottom{
	-moz-border-radius-bottomleft:8px;
	-moz-border-radius-bottomright:8px;
	-moz-border-radius-topleft:8px;
	-moz-border-radius-topright:8px;
	background:#F5F5F5 none repeat scroll 0 0;
	border-bottom:2px solid #4690D6;
	line-height:1.2em;
	text-align:right;
}
.stores_remove{
	background: transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/cart_del.png) no-repeat left top;
}
.stores_remove a{
	padding-left:20px;
	font-weight:bold;
}
.stores_update_cart{
	background: transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/cart_update.png) no-repeat left top;
}
.stores_update_cart a{
	padding-left:20px;
	font-weight:bold;
}
.space{
	padding-left:49px;
}
.bottom_content span{
	padding-left:10px;
	padding-right:10px;
}
.address_listing_info{
	margin-left:50px;
	min-height:40px;
	padding-bottom: 5px;
}
.address_listing_info td{
	padding: 5px;
}
.address_listing_info_head{
	color: #0054A7;
}
.address_listing_info th{
	font-weight: bold;
}
.stores .search_listing {
	border:1px solid #cccccc;
	margin:0 0 5px 0;
}
.search_gallery_item:hover{
	color:#E89005;
}
.search_gallery_item{
	color:#000000;
}
.stores .search_listing:hover {
	border:1px solid #4690D6;
	background:#f4f4f4;
	color: #000000;
}
#owner_block_submenu .submenu_group .submenu_group_stores_tag ul li a {
	color:#666666;
}
#owner_block_submenu .submenu_group .submenu_group_stores_tag ul li a:hover {
	color:white;
	background: #999999;
}
.submenu_group_stores_tag{
	max-height: 150px;  height: expression(this.height > 150 ? 150: true);
	overflow-x:hidden;
	overflow-y:auto;
}
.order_item_status .submit_button{
	margin:0px;
	font-size:11px;
}
.cart_wishlist{
	float:left;
	padding-right:10px;
	font-size:12px;
}

.stores a:hover {
	text-decoration:none;
}
.cart_wishlist .cart{
	background: transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/Cart_add.png) no-repeat left top;
}
.cart_wishlist .cart{
	padding-left:20px;
	font-weight:bold;
}
.cart_wishlist .wishlist{
	background: transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/add_wishlist.gif) no-repeat left top;
}
.cart_wishlist .wishlist{
	padding-left:20px;
	font-weight:bold;
}
.cart_wishlist a:hover{
	text-decoration:none;
}
/*-------  styles for the unit rater ---------*/

.ratingblock {
	display:block;
	margin-bottom:8px;
	font-size:11px;
}

.ratingblock .loading {
	height: 16px;
	background: url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/working.gif) 50% 50% no-repeat;
	}

.unit-rating { /* the UL */
	list-style:none;
	margin: 0px;
	padding:0px;
	height: 16px;
	position: relative;
	float:left;
	background: url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/starrating.gif) top left repeat-x;		
	}

.unit-rating li{
    text-indent: -90000px;
	padding:0px;
	margin:0px;
	float: left;
	}
	
.unit-rating li a {
	outline: none;
	display:block;
	width:16px;
	height: 16px;
	text-decoration: none;
	text-indent: -9000px;
	z-index: 20;
	position: absolute;
	padding: 0px;
	}
	
.unit-rating li a:hover{
	background: url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/starrating.gif) left center;
	z-index: 2;
	left: 0px;
	}

unit-rating a.r1-unit{left: 0px;}
.unit-rating a.r1-unit:hover{width:16px;}
.unit-rating a.r2-unit{left:16px;}
.unit-rating a.r2-unit:hover{width: 32px;}
.unit-rating a.r3-unit{left: 32px;}
.unit-rating a.r3-unit:hover{width: 48px;}
.unit-rating a.r4-unit{left: 48px;}	
.unit-rating a.r4-unit:hover{width: 64px;}
.unit-rating a.r5-unit{left: 64px;}
.unit-rating a.r5-unit:hover{width: 80px;}

.unit-rating li.current-rating {
	background: url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/starrating.gif) left 16px;
	position: absolute;
	height: 16px;
	display: block;
	text-indent: -9000px;
	z-index: 1;
	}

.voted {color:#999;}
.thanks {color:#36AA3D;}
.static {color:#5D3126;}	

.ratingblock p{
	margin-bottom:5px;
	margin-top: 5px;
	margin-left:90px
}

/*-------  styles for tell a friend ---------*/
#load_action_outer{
	margin: 0 auto;
	z-index:99999;
	left:0px;
	position:absolute;
	width:100%;
	height:100%;
	display:none;
}
#load_action{
	left:0px;
	position:absolute;
	top:0px;
	background-color:#000000;
	height:500px;
	opacity:0.6;
    filter:alpha(opacity=60);
	z-index:9999;
	width:100%;
	display:none;
}
#load_action_div{
	margin: 0 auto;
	z-index:99999;
	left:0px;
	position:absolute;
	width:100%;
	height:100%;
	display:none;
	text-align:center;
}
#load_action_bg{
	-moz-border-radius-bottomleft:10px;
	-moz-border-radius-bottomright:10px;
	-moz-border-radius-topleft:10px;
	-moz-border-radius-topright:10px;
	background-color:#FFFFFF;
	height:auto;
	padding:10px;
	margin:0 auto;
	width:450px;
	min-height: 420px;  height: expression(this.height < 420 ? 420: true);
}
#load_action_bg .head{
	font-weight:bold;
	text-align:center;
	color:#0054A7;
	padding:10px 0 5px;
}
#load_action_bg table{
	margin: 0 auto;
}
#load_action_bg td{
	padding: 5px 2px;
}
#load_action_bg .form_outer{
	-moz-border-radius-bottomleft:10px;
	-moz-border-radius-bottomright:10px;
	-moz-border-radius-topleft:10px;
	-moz-border-radius-topright:10px;
	border:2px solid #0054A7;
}
#load_action_bg .mceEditor td{
	padding: 0;
}
#load_action_bg .mceEditor #description_tbl{
	width: 400px !important;
	height: 100px !important;
}

#order_action_outer{
	margin:60px auto 0;
	z-index:99999;
	left:0px;
	/*position:absolute;*/
	position:fixed;
	width:100%;
	height:100%;
	display:none;
	top:0;
}
#order_action{
	left:0px;
	position:absolute;
	top:0px;
	background-color:#000000;
	height:500px;
	opacity:0.6;
    filter:alpha(opacity=60);
	z-index:9999;
	width:100%;
	display:none;
}
#order_action_bg {
	-moz-border-radius-bottomleft:10px;
	-moz-border-radius-bottomright:10px;
	-moz-border-radius-topleft:10px;
	-moz-border-radius-topright:10px;
	background-color:#FFFFFF;
	height:auto;
	padding:10px;
	margin:0 auto;
	width:400px;
	/*min-height: 420px;  height: expression(this.height < 420 ? 420: true);*/
}
#order_action_bg .head{
	font-weight:bold;
	text-align:center;
	color:#0054A7;
	padding:10px 0 5px;
	font-size:15px;
}
#order_action_bg table{
	margin: 0 auto;
}
#order_action_bg td{
	padding: 5px 2px;
}
#order_action_bg .form_outer{
	-moz-border-radius-bottomleft:10px;
	-moz-border-radius-bottomright:10px;
	-moz-border-radius-topleft:10px;
	-moz-border-radius-topright:10px;
	border:2px solid #0054A7;
	font-size:11px;
}
#order_action_bg .mceEditor td{
	padding: 0;
}
#order_action_bg .mceEditor #description_tbl{
	width: 400px !important;
	height: 100px !important;
}
#order_action_bg .address_listing_info{
	margin-left:0;
}
#order_action_bg .address_listing_info table{
	margin:0;
}
.close{
	float:right;
	padding:5px;
}

.more_btn a{
	background: transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/more.gif) no-repeat right 4px;
	padding-right:15px;
	font-weight:bold;
}

.buy_more a{
	background: transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/buy_more.jpg) no-repeat left top;
	padding-left:20px;
	font-weight:bold;
}
.products_list{
	opacity:0.8;
    filter:alpha(opacity=80);
    width:39px;
    height:39px;
    margin:0 auto;
}
.products_list img{
	width:45px;
}
.products_list_table{
	margin:0;
	padding:0;
}
.products_list_table td{
	width:50px;
	height:55px;
	vertical-align:middle;
}
.popular_products_list{
	opacity:0.8;
    filter:alpha(opacity=80);
    width:39px;
    height:39px;
    margin:0 auto;
}
.popular_products_list img{
	width:45px;
}
.popular_products_list_table{
	margin:0;
	padding:0;
}
.popular_products_list_table td{
	width:50px;
	height:55px;
	vertical-align:middle;
}
#stores_widget_layout .stores_widget_galleryview {
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
	background: white;
	margin:0 0 5px 0;	
}
#stores_widget_layout .stores_widget_galleryview a{
	width:48px;
}
.stores_widget_galleryview img {
	width:45px;
}
.stores_widget_galleryview img:hover {
	border:1px solid #4690D6;
}

/* FILE REPRO WIDGET VIEW */
.stores_widget_singleitem {
	margin:0 0 5px 0;
	padding:3px;
	min-height:60px;
	display:block;
	background:white;
   	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
}
.stores_widget_singleitem_more {
	margin:0;
	padding:5px;
	display:block;
	background:white;
   	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;	
}
#stores_widget_layout .contentWrapper{
	margin:5px;
	padding:15px 10px;
}
.stores_listview_icon {
	float: left;
	margin-right: 10px;
}
.stores_widget_singleitem .search_listing{
	margin:0 0 3px;
}
.stores_listview_icon img{
	width:45px;
}
.stores_timestamp {
	color:#666666;
	margin:0;
}
.stores_listview_desc {
	display:none;
	padding:0 10px 10px 0;
	line-height: 1.2em;
}
.stores_listview_desc p {
	color:#333333;
}
.stores_widget_content {
	margin-left: 50px;
}
.stores_title {
	margin:0;
	padding:6px 5px 0 0;
	line-height: 1.2em;
	color:#666666;
	font-weight: bold;
}

.collapsable_box #stores_widget_layout {
	margin:0 8px 0 8px;
	background: none;
}
.product_actions{
	padding-left:5px;
}
.price_list{
	float:left;
	padding-right:10px;
}
.stores_widget_singleitem .cart_wishlist{
	padding-left:10px;
	float:right;
}
.contact_us_box td{
	padding:5px;
}
.add_to_cart_form{
	clear:both;
	padding-left:10px;
}
.add_to_cart_form .submit_button {
	margin:0;
}
#my_account_table{
	width:100%;
	margin:0 auto 5px;
	border-spacing:2px;
	font-size:90%;
}
#my_account_table th{
	border:1px solid #b09b8a;
	padding:3px;
	font-weight:bold;
	background-color:#efede7;
	text-align:center;
	vertical-align:bottom;
}
#my_account_table td{
	border:1px solid #b09b8a;
	padding:6px 4px;
	font-size:99%;
	vertical-align:middle;
}
.stores .search_listing .pagination {
	margin:0;
	padding:0;
	background:none;
}
.features{
	color:#4690D6;
	font-size:130%;
	font-weight:bold;
	padding-left:10px;
}
.input-product-type{
	margin:5px 0 0;
	padding:3px;
}
.input-dropdown{
	margin:5px 0 0;
}
.full_view .product_image img{
	width:60px;
}
.object_product_type_string {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/graphics/software.png) no-repeat scroll left 2px;
	margin:0 0 0 15px;
	padding:0 0 0 16px;
}
.object_category_string {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/category.gif) no-repeat scroll left 2px;
	margin:0 0 0 15px;
	padding:0 0 0 16px;
}

.trans_details{
	margin: 10px 0 0 0;
}
.withdraw_form{
	display:none;
	margin: 25px auto 0;
	width:200px;
	border:1px solid #4690D6;
	padding:20px 15px 15px;
}
#owner_block_stores {
	margin:10px 0 0 0;
	/*border-top:1px solid #CCCCCC;*/
	border-bottom:1px solid #CCCCCC;
	padding-bottom:10px;
}
#owner_block_stores a:hover {
	color:#0054A7;
}
#owner_block_stores a {
	padding:2px 0 2px 20px;
	color:#4690D6;
	display:block;
	font-weight:bold;
	margin:2px 0 0;
	text-decoration:none;
}

#owner_block_stores .cart{
	margin:10px 0 0;
}
#owner_block_stores .wishlist{
	margin:10px 0 0;
}
#owner_block_stores .orders{
	margin:10px 0 0;
}

#owner_block_stores .cart a{
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/shopingcart.png) no-repeat scroll left 2px;
	display:inline;
}

#owner_block_stores .wishlist a{
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/wishlist.gif) no-repeat scroll left 2px;
	display:inline;
}

#owner_block_stores .orders a{
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/order_icon.png) no-repeat scroll left 2px;
	display:inline;
}

#owner_block_stores .coupon_code{
	margin:10px 0 0;
}
#owner_block_stores .coupon_code a{
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/coupon_code.gif) no-repeat scroll left 0;
	display:inline;
}

.dproducts_download{
	margin:5px 0;
	padding:0 0 1px 20px;
}
.dproducts_download a {
	font: 12px/100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: white;
	border:none;
	-webkit-border-radius: 5px; 
	-moz-border-radius: 5px;
	width: auto;
	height: 25px;
	padding:3px 6px 3px 20px;
	margin:10px 0 10px 0;
	cursor: pointer;
	background:#4690d6 url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/download.png) no-repeat scroll left;
}
.dproducts_download a:hover {
	background-color: black;
	color:white;
	text-decoration: none;
}
.stores_settings td{
	padding:5px;
	vertical-align:baseline;
}
.clear{
	clear:both;
}
.product_main_datas{
	line-height: 20px;
}
.product_odd {
	background:#D9D9D9;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
	padding:3px 3px 3px 10px;
	margin:0 0 7px;
}

.product_even{
	background:#E9E9E9;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
	padding:3px 3px 3px 10px;
	margin:0 0 7px;
}
.field_results{
	padding:0 3px 3px 10px;
}

.field_list_table {
	border:1px solid #0054A7;
	margin:0 auto;
	-webkit-border-radius: 5px; 
	-moz-border-radius: 5px;
}
.field_list_table td {
	padding:5px;
}
.field_list_table_head td {
	background-color:#0054A7;
	font-weight:bold;
	text-align:center;
	color:#FFFFFF;
}
.field_list_table_odd {
	background:#FBF6F0;
	/*background:#F8EADA;*/
}
.field_list_table_even {
	background:#FBF1E3;
}


/*----------------------------------------*/
.checkout_title {
	font-size: 13px;
	padding:3px 5px;
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/bg_common.gif);
	color: #0054A7;
	cursor:default;
	margin:10px 0;
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;
	border:1px solid #D3D3D3;
}
.checkout_body {
	padding:0 10px 0 20px;
}
.checkout_selection_div {
	padding:3px;
}
.checkout_selection_div input{
	padding:0;
	margin-right:5px;
	border:0;
}

/*--------------------------------------*/
.basic {
	/*font-family:Tahoma,Verdana,Arial,sans-serif;*/
}
.basic .ui_content {
	-webkit-border-bottom-left-radius: 4px; 
	-moz-border-radius-bottomleft: 4px;
	-webkit-border-bottom-right-radius: 4px; 
	-moz-border-radius-bottomright: 4px;
	border-left:1px solid #D3D3D3;
	border-right:1px solid #D3D3D3;
	border-bottom:1px solid #D3D3D3;
}

.basic .content {
	margin-bottom : 10px;
	border: none;
	text-decoration: none;
	font-weight: bold;
	font-size: 11px;
	margin: 0px;
	padding: 10px;
	font-weight:normal;
}
.basic .general .input-text {
	padding: 2px;
	-webkit-border-radius: 0; 
	-moz-border-radius: 0;
}
.basic h3 {
	cursor:pointer;
	position:relative;
	margin-top: 0;
	font-weight: bold;
	font-size: 13px;
	color: black;
	border:1px solid #D3D3D3;
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;
	margin-top:2px;
	background-image: url("<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/AccordionTab0.gif");
}
.basic a {
	display:block;
	padding:5px 5px 5px 25px;
	text-decoration: none;
	color: #000000;
}
.basic a:hover {
	background-image: url("<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/AccordionTab2.gif");
}
.basic .shipping_disable a:hover {
	background-image: none;
}
.basic h3.selected {
	color: black;
	border:1px solid #D3D3D3;
	-webkit-border-top-left-radius: 4px; 
	-moz-border-radius-topleft: 4px;
	-webkit-border-top-right-radius: 4px; 
	-moz-border-radius-topright: 4px;
	-webkit-border-bottom-left-radius: 0; 
	-moz-border-radius-bottomleft: 0;
	-webkit-border-bottom-right-radius: 0; 
	-moz-border-radius-bottomright: 0;
	border-bottom:0 none;
	background-image: url("");
}
.basic h3.selected a:hover {
	background-image: url("");
}
.basic .list1b_icon {
	left:0.5em;
	margin-top:-8px;
	position:absolute;
	top:15px;
	height:16px;
	width:16px;
	background-image: url("<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/ui_icon.png");
	background-position:-32px -16px;
}
.checkout_process input{
	vertical-align: top;
}
.basic .selected .list1b_icon {
	background-position:-64px -16px;
}
.basic a.ui_desc_link {
	margin:0;
	padding:0;
	display:inline;
	background-image: url("");
}
.basic a.ui_desc_link:hover {
	background-image: url("");
}
.basic .content .input-text {
	padding: 2px;
	-webkit-border-radius: 0; 
	-moz-border-radius: 0;
}
.storesrepo_controls a, .storesrepo_controls a:hover {
	font-weight:bold;
	color:#4690D6;
}
.storesrepo_controls a:hover {
	color:#0054A7;
}
#checkout_address .address_form {
	width:400px;
	margin-left:50px;
}
#checkout_address .address_form p {
	margin:0 0 5px;
}
.checkout_modify {
	color:#4690D6;
	position:absolute;
	left:600px;
	top:5px;
	cursor:pointer;
}
.checkout_table {
	width:100%;
	border: 1px solid #4690D6;
	border-collapse:collapse;
}
.checkout_table th {
	padding: 5px 8px;
	background-color: #4690D6;
	background-image: url("<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/order_bg.gif");
	color:#EEEEEE;
}
.checkout_table td {
	padding: 5px 8px;
}
.order_sub_con {
	margin-left:10px;
	font-size:11px;
	color: #555555;
	line-height:20px;
}
.order_head {
	color: #4690D6;
	font-size:13px;
}
.order_view_details {
	border:0;
	height:27px;
	padding:0;
	margin:10px 10px 0 0;
}
.ordered_items {
	font-size: 11px;
}
.order_total {
	text-align:right;
	border-top:1px solid #4690D6;
	font-weight:bold;
}
.order_details {
	float:left;
	width:200px;
	margin-left:50px;
}
.order_details h3{
	color: #4690D6;
	margin-bottom:10px;
}
.select_billing_address {
	margin:10px 20px;
}
.add_billing_address {
	margin:10px;
}
.select_shipping_address {
	margin:10px 20px;
}
.add_shipping_address {
	margin:10px;
}
.checkout_process .basic .content .input-text {
	width: 200px;
}
.checkout_process .address_form td{
	padding:3px;
}
.shipping_disable {
	color: #AFAFAF;
	font-style:italic;
}
.checkout_process .basic h3 {
	cursor:default;
}
.product_order {
	padding: 15px 0;
}
.product_order .order_details {
	margin: 0 5px;
	width:auto;
	border:1px dotted #EFEFEF;
	padding:10px;
}
.s_price {
	color: #5F0606;
	font-family: Arial,monospace,Helvetica;
	font-size: 14px;
	padding-left: 26px;
}
#withdraw_method_settings {
	margin: 10px;
}
/*popup box*/
.pop_up_box{
	width:300px;
	background:none;
	position:absolute;
	z-index:999;
	display:none;
	color: #000000;
}
.top_pop_box{
	width:100%;
	margin:0px;
	padding:0px;
}
.left_top{
	width:10px;
	height:13px;
	background:url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/left_top.png) no-repeat;
	margin:0px;
	padding:0px;
}
.inner_top{
	width:280px;
	height:13px;
	background:url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/top_center_bg.jpg) repeat-x;
	margin:0px;
	padding:0px;
}
.right_top{
	width:10px;
	height:13px;
	background:url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/right_top.png) no-repeat;
	padding:0px;
	margin:0px;
}
.inner_area{
	background:#fff;
	border-left:1px solid #cdcdcd;
	border-right:1px solid #cdcdcd;
	border-top:none;
	border-bottom:none;
}
.inner_div{
	width:auto;
	padding:1px 10px;
	background:none;
}
.bottom_pop_box{
	width:100%;
	margin:0px;
	padding:0px;
}
.left_bottom{
	width:10px;
	height:13px;
	background:url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/left_bottom.png) no-repeat;
	margin:0px;
	padding:0px;
}
.inner_bottom{
	width:280px;
	height:13px;
	background:url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/bottom_center_bg.jpg) repeat-x;
	margin:0px;
	padding:0px;
}
.right_bottom{
	width:10px;
	height:13px;
	background:url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/right_bottom.png) no-repeat;
	margin:0px;
	padding:0px;
}
.arrow_bg{
	position:absolute;
	left:50%;
	width:31px;
	height:21px;
	bottom:-20px;
	background:url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/bottom_arrow.png) no-repeat;
}

.gallery_product {
	background-color:#DDDDDD;
	padding:10px 10px 0;
	-webkit-border-radius: 5px; 
	-moz-border-radius: 5px;
	height:100%;
}
.stores .gallery_product_price {
	font-weight:bold;
	padding:8px 0;
	text-align:center;
}
.stores .search_gallery td {
	padding:1px;
}
.stores .gallery_product_cat .object_category_string {
	margin:0;
}
.stores .gallery_product_inner div{
	margin:5px 0;
}
.gallery_product_details {
	font-size:11px;
	line-height:12px;
}
.gallery_product_icon {
	z-index:10;
}
.gallery_product_icon img{
	display:block;
	z-index:100;
	width:100px;
}
.gallery_product_inner .object_product_type_string {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/graphics/software.png) no-repeat scroll left 0px;
	margin: 0;
}
.stbutton:link { 
	color: #4690D6;
	font-weight:bold;
	text-decoration:none;
}
.stbutton:hover {
	color: #0054A7;
}
.currency_settings {
	border: 1px solid #D3D3D3;
	padding:10px;
	-webkit-border-radius: 5px; 
	-moz-border-radius: 5px;
	font-size: 13px;
	font-family: Tahoma,Verdana,Arial,sans-serif;
}
.currency_settings h3{
	font-size: 13px;
	padding:3px 5px;
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/bg_common.gif);
	color: #0054A7;
	cursor:default;
}
.currency td{
	padding:5px;
	vertical-align:baseline;
}

.buttonwrapper{
	overflow: hidden;
	cursor:pointer;
	margin:0 5px;
	float:left;
}
/*------- Button ----------*/
.list_currency a:hover {
	background: none;
	display: inline;
	padding: 5px;
}
.list_currency a {
	padding: 5px;
	display: inline;
	cursor:pointer;
}
.default_class {
	background: #CFE8FF;
}

.myaccount_address {
	background: #DDDDDD;
	margin:1px 0 10px;
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;
	position:relative;
	border:1px solid #999999;
}
.myaccount_address_action {
	display:none;
	float:right;
	background:#DDDDDD;
	width: 60px;
	padding:4px 10px 4px 0;
	position:relative;
}
.myaddress_edit {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/tag-pencil.png) no-repeat scroll left 0;
	display:inline;
	height:16px;
	width:16px;
	float:right;
	padding: 0 !important;
	margin: 0 5px !important;
	cursor: pointer;
}
a.myaddress_edit:hover {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/tag-pencil.png) no-repeat scroll left 0;
}
.myaddress_delete{
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/delete.png) no-repeat scroll left 0;
	display:inline;
	height:16px;
	width:16px;
	float:right;
	padding: 0 !important;
	margin: 0 5px !important;
	cursor: pointer;
}
a.myaddress_delete:hover {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/delete.png) no-repeat scroll left 0;
}
.order_icon_class{
	float:left;
}
.order_icon_class img{
	border:1px solid #CCCCCC;
	margin:0 5px;
	padding:0;
	width:15px;
}
.help {
	text-align: left;
	font: normal 11px Tahoma,  sans-serif;
	color: #000;
	width: 275px;
}
.help_img {
	width:13px;
	padding-top:4px;
	padding-left:5px;
}
.settings_field_left {
	float:left;
	padding:3px 0;
	width:165px;
}
.settings_field_right {
	float:left;
	width:36px;
}
.checkout_body .general {
	margin-bottom:3px;
}
.fedex_fields {
	width:225px;
	font-size:12px;
}

#my_request_table{
	width:100%;
	margin:0 auto 5px;
	border-spacing:2px;
	font-size:90%;
}
#my_request_table th{
	border:1px solid #b09b8a;
	padding:3px;
	font-weight:bold;
	background-color:#efede7;
	text-align:center;
	vertical-align:bottom;
}
#my_request_table td{
	border:1px solid #b09b8a;
	padding:6px 4px;
	font-size:99%;
	vertical-align:middle;
}
#my_request_table .with_app_den {
	background:#23819E;
	color:#FFFFFF;
	font-weight:bold;
	padding:5px 10px;
	-webkit-border-radius: 2px; 
	-moz-border-radius: 2px;
}
#my_request_table .with_app_den:hover {
	background:#333333;
}
#my_request_table .with_app_den_success {
	background:#cccccc;
	color:#FFFFFF;
	font-weight:bold;
	padding:5px 10px;
	-webkit-border-radius: 2px; 
	-moz-border-radius: 2px;
	cursor:default;
}
#my_request_table .with_more_desc {
	display:none;
}
#my_request_table .with_mor_den_success {
	color:#ccc;
	font-weight:bold;
	cursor:default;
}
.display_none {
	display:none;
}
.display_block {
	display:block;
}
.withdraw .condition_head{
	font-weight:bold;
	font-size:14px;
}
.withdraw ul{
	list-style-type:circle;
}
.coupons .coupon_btn {
	margin:10px 0;
}
.coupons .coupon_btn a{
	color:#444444;
}
.edit_coupon {
	color:#4E4F4F;
	font-size:11px;
	margin-top:5px;
	padding:4px;
	width:100%;
	border-spacing:2px;
}
.edit_coupon .label {
	color:#4E4F4F;
	font-family:Tahoma;
	font-size:11px;
	padding:6px 10px 0;
	text-decoration:none;
	vertical-align:top;
	width:170px;
	font-weight:bold;
}
.edit_coupon input {
	-webkit-border-radius: 0; 
	-moz-border-radius: 0;
	padding:2px;
	width:200px;
}
.required {
	color:Red;
}
.stores_select_box {
	border:1px solid #CCCCCC;
	width:200px;
	height:140px;
	overflow-y:scroll;
	
}
.stores_select_box ul{
	padding-left:5px;
	margin:5px 0 5px;
}

/* Some resets for compatibility with existing CSS */
.date_selector, .date_selector * {
  width: auto;
  height: auto;
  border: none;
  background: none;
  margin: 0;
  padding: 0;
  text-align: left;
  text-decoration: none;
}
.date_selector {
  background: #F2F2F2;
  border: 1px solid #bbb;
  padding: 5px;
  margin: -1px 0 0 0;
  position: absolute;
  z-index: 100000;
  display: none;
}
.date_selector_ieframe {
  position: absolute;
  z-index: 99999;
  display: none;
}
  .date_selector .nav {
    width: 17.5em; /* 7 * 2.5em */
  }
  .date_selector .month_nav, .date_selector .year_nav {
    margin: 0 0 3px 0;
    padding: 0;
    display: block;
    position: relative;
    text-align: center;
  }
  .date_selector .month_nav {
    float: left;
    width: 55%;
  }
  .date_selector .year_nav {
    float: right;
    width: 35%;
    margin-right: -8px; /* Compensates for cell borders */
  }
  .date_selector .month_name, .date_selector .year_name {
    font-weight: bold;
    line-height: 20px;
  }
  .date_selector .button {
    display: block;
    position: absolute;
    top: 0;
    width: 18px;
    height: 18px;
    line-height: 17px;
    font-weight: bold;
    color: #003C78;
    text-align: center;
    font-size: 120%;
    overflow: hidden;
    border: 1px solid #F2F2F2;
  }
    .date_selector .button:hover, .date_selector .button.hover {
      background: none;
      color: #003C78;
      cursor: pointer;
      border-color: #ccc;
    }
  .date_selector .prev {
    left: 0;
  }
  .date_selector .next {
    right: 0;
  }
  .date_selector table {
    border-spacing: 0;
    border-collapse: collapse;
    clear: both;
  }
    .date_selector th, .date_selector td {
      width: 2.5em;
      height: 2em;
      padding: 0;
      text-align: center;
      color: black;
    }
    .date_selector td {
      border: 1px solid #ccc;
      line-height: 2em;
      text-align: center;
      white-space: nowrap;
      color: #003C78;
      background: white;
    }
    .date_selector td.today {
      background: #FFFEB3;
    }
    .date_selector td.unselected_month {
      color: #ccc;
    }
    .date_selector td.selectable_day {
      cursor: pointer;
    }
    .date_selector td.selected {
      background: #D8DFE5;
      font-weight: bold;
    }
    .date_selector td.selectable_day:hover, .date_selector td.selectable_day.hover {
      background: #003C78;
      color: white;
    }
    
.list_coupons {

}
.list_coupons table{
	width:100%;
	border: 1px solid #4690D6;
	border-collapse:collapse;
	font-size:11px;
}
.list_coupons th {
	padding: 5px 8px;
	background-color: #4690D6;
	background-image: url("<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/order_bg.gif");
	color:#EEEEEE;
	font-weight:bold;
}
.list_coupons td {
	padding: 5px 8px;
}
.coupon_edit {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/tag-pencil.png) no-repeat scroll left 0;
	display:inline;
	height:16px;
	width:16px;
	float:right;
	padding: 0 !important;
	margin: 0 5px !important;
	cursor: pointer;
}
a.coupon_edit:hover {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/tag-pencil.png) no-repeat scroll left 0;
}
.coupon_delete{
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/delete.png) no-repeat scroll left 0;
	display:inline;
	height:16px;
	width:16px;
	float:right;
	padding: 0 !important;
	margin: 0 5px !important;
	cursor: pointer;
}
a.coupon_delete:hover {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/delete.png) no-repeat scroll left 0;
}
.coupon_back {
	background:#EAFDFF;
	border:1px solid #9DD3D8;
	margin-bottom:10px;
	margin-top:10px;
	padding:10px;
	width:300px;
}
#apply_code {
	padding:2px;
	-webkit-border-radius: 2px; 
	-moz-border-radius: 2px;
}
#couponcode {
	padding:2px;
	-webkit-border-radius: 2px; 
	-moz-border-radius: 2px;
}
#coupon_apply_result {
	background: #E5EECC;
	border:1px solid #C9DF8B;
	margin:10px 0;
	padding:5px;
	display:none;
}
.display_original_price  {
	margin-right:10px;
	text-decoration:line-through;
}
.stores_select_box input{
	width:15px;
}

.create_order .fields {
	margin:5px 0;
}
.create_order input {
	padding:2px;
}
.create_order .left {
	width:95px;
}
.river_object_stores_create {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/social_commerce.gif)  no-repeat scroll left -1px;
}
.river_object_stores_update {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/social_commerce.gif)  no-repeat scroll left -1px;
}
.river_object_stores_cartadd {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/shopingcart.png) no-repeat scroll left -1px;
}
.river_object_stores_wishlistadd {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/wishlist.gif) no-repeat scroll left 0;
}
.river_object_stores_purchase {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/order_icon.png) no-repeat scroll left 0;
}

.related_products .search_listing {
	border:1px solid #CCCCCC;
	background:#EFEFEF;
	-webkit-border-radius: 2px; 
	-moz-border-radius: 2px;
}
.details_header {
	font-weight:bold;
}
.details_title_input {
	width: 500px;
}
.details_price_input {
	width: 50px;
}
.span_space {
	padding:0 10px;
}
.details_label_div {
	height:10px;
}
.related_product .title {
	color: #4690D6;
	font-weight: bold;
}
.related_product .content {
	margin-left:5px;
}
.tax_head{
	margin-top:20px;
	font-size:14px;
}
.tax_label{
	font-size:11px;
}
.edit_delete_details {
	float:right;
	margin-right:20px;
	margin-top:5px;
}
.edit_delete_details a.edit {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/edit.jpg) no-repeat scroll left 0;
	padding:0 8px;
	margin-right:5px;
}
.edit_delete_details a.delete {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/delete.gif) no-repeat scroll left 0;
	padding:0 8px;
	margin-right:5px;
}
#load_action_content{
	margin: 0 auto;
	z-index:9999;
	left:0px;
	position:absolute;
	top:250px;
	text-align:center;
	width:100%;
	height:100%;
	display:none;
	padding-left:110px;
}
.load_details_maindiv {
	background-color:#FFFFFF;
	border:2px solid #444444;
	color:#000000;
	padding:2px;
	padding:2px;
	text-align:left;
	width:500px;
	margin: 0 auto;
}
.load_details_content {
	padding:10px;
}
.load_details_titlebar {
	background-color:#444444;
	color:#FFFFFF;
	font-weight:bold;
	height:20px;
	margin-bottom:5px;
	padding:5px 0 0 5px;
	width:auto;
}
.send_details_titlebar img:hover {
	opacity:1;
	filter:alpha(opacity=100);
}
#related_messages {
	border:1px solid #CCCCCC;
	display:none;
	font-size:11px;
	margin:3px;
	padding:3px;
}
.send_details_titlebar img {
	cursor:pointer;
	opacity:0.25;
	filter:alpha(opacity=25);
}
.fieldset {
	border:1px solid #CCCCCC;
	margin:5px;
	padding:5px;
}
.legend {
	color:#4690D6;
	font-family:Verdana,Arial,Helvetica,sans-serif;
	font-size:13px;
	line-height:20px;
}
.related_detail {
	background-color:#EFF7FF;
	padding: 2px 10px;
	margin:2px 0;
	border:1px solid #BFDFFF;
	margin-right:20px;
	-webkit-border-radius: 2px; 
	-moz-border-radius: 2px;
}
.related_detail:hover {
	background-color:#DFEFFF;
}
.delete_details_from_cart{
	float:right;
}
.delete_details_from_cart a.delete {
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/delete.png) no-repeat scroll left 0;
	padding:0 8px;
	margin-right:5px;
	opacity:0.25;
	filter:alpha(opacity=25);
}
.delete_details_from_cart a.delete:hover {
	opacity:1;
	filter:alpha(opacity=100);
}
.checkout_table .related_details {
	margin-left:10px;
	padding-left:15px;
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/dot.gif) no-repeat scroll  left 3px;
}
.change_product_file {
	float:left;
	margin:25px 0 0 10px;
}
.change_product_file a{
	background:transparent url(<?php echo elgg_get_config('url'); ?>mod/socialcommerce/images/change_file.gif) no-repeat scroll left 0;
	padding-left:20px;
}
#product_file_change, #add_billing_address {
	display:none;
}
