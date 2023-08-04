<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

function gss_checkout_text( $title ) {
	$title = __("Place order", "gasservei");

	return $title;
}


add_filter( 'woocommerce_order_button_text', 'gss_checkout_text', 10, 2  );