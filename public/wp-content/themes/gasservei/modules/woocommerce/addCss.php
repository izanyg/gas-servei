<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
/** CSS To Add Custom tab Icon */
add_action( 'admin_head', function () {
    ?>
    <style>
        #woocommerce-product-data ul.wc-tabs li.my-custom-tab_options a:before { font-family: WooCommerce; content: '\e006'; }
    </style>
    <?php
});
