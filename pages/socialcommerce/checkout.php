<?php

$hello = "HELLO WORLD";

$content = '
        <div class="content">
			<div id="wizard">
                <h2>'.elgg_echo('checkout:billing').'</h2>
                <section>';
$content .= 		elgg_view("socialcommerce/billing_details", array('checkout_order'=>$checkout_order)).'
                </section>';
				
$content .= '
                <h2>'.elgg_echo('checkout:shipping').'</h2>
                <section>';
				
$content .= 		elgg_view("socialcommerce/shipping_details", array('checkout_order'=>$checkout_order)).
					 elgg_view("socialcommerce/list_shipping_methods").'
                </section>';

$content .= '
                <h2>'.elgg_echo('checkout:payment').'</h2>
                <section>';
				
$content .= 				elgg_view("socialcommerce/list_checkout_methods").'
				
                   
                </section>';

$content .= '
                <h2>'.elgg_echo('checkout:confirmation').'</h2>
                <section>';
				
$content .= 				 elgg_view("socialcommerce/cart_confirm_list",array('checkout_confirm'=>$checkout_confirm)).'
				 
                    
                </section>
            </div>
        </div>';

$title = elgg_view_title(elgg_echo('checkout:confirm:btn'));
$content = '<div class="contentWrapper stores">'.$content.'</div>';
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
	
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	elgg_load_css('jquery.steps');  	
	elgg_load_js('jquery.steps.min');
	elgg_load_js('socialcommerce.checkout');
	echo elgg_view_page(elgg_echo('checkout:confirm:btn'), $body);
	
?>
