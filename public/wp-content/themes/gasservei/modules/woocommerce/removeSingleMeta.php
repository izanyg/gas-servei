<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}



add_action('woocommerce_single_product_summary', 'customizing_single_product_summary_hooks', 2 );
function customizing_single_product_summary_hooks(){
    remove_action( 'woocommerce_single_product_summary_single_meta', 'woocommerce_template_single_meta', 40 );
}