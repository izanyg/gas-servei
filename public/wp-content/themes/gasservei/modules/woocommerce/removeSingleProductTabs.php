<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Remove the additional information tab if attributes is empty
add_filter( 'woocommerce_product_tabs', function ( $tabs ) {
    global $product;

    // $testAttributes = $product->get_attributes();
    $testDescription = $product->get_description();

    // if (!$testAttributes) {
        unset( $tabs['additional_information'] );
    // }
    if (!$testDescription) {
        unset( $tabs['description'] );
    }

    return $tabs;
}, 99 );
