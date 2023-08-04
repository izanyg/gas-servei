<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Remove Sku view in single product
 */
add_filter( 'wc_product_sku_enabled', function ( $enabled ) {
    global $product;
    if ( ! is_admin() && $product->is_type('variable') ) {
        return false;
    }
    return $enabled;
} );
