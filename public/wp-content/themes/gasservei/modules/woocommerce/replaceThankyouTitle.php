<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

function gss_title_order_received( $title, $id ) {
	if ( is_order_received_page() && get_the_ID() === $id ) {
		$title = __("Order received", "gasservei");
	}

	return $title;
}

add_filter( 'the_title', 'gss_title_order_received', 10, 2 );
