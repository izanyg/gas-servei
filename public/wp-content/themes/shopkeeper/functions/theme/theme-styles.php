<?php
/**
 * Theme styles
 *
 * @package shopkeeper
 */

/**
 * Vendor styles
 */
function shopkeeper_vendor_styles() {

    $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

    wp_enqueue_style( 'animate', 		get_template_directory_uri() . '/css/vendor/animate'.$suffix.'.css', NULL, '1.0.0', 'all' );
    wp_enqueue_style( 'fresco', 		get_template_directory_uri() . '/css/vendor/fresco/fresco'.$suffix.'.css', NULL, '2.3.0', 'all' );
    wp_enqueue_style( 'easyzoom', 		get_template_directory_uri() . '/css/vendor/easyzoom'.$suffix.'.css', NULL, '2.4.0', 'all' );
    wp_enqueue_style( 'select2', 		get_template_directory_uri() . '/css/vendor/select2'.$suffix.'.css', NULL, '4.0.5', 'all' );
    wp_enqueue_style( 'swiper', 		get_template_directory_uri() . '/css/vendor/swiper.min.css', NULL, '6.4.1', 'all' );
}
add_action( 'wp_enqueue_scripts', 'shopkeeper_vendor_styles' );

/**
 * Theme styles
 */
function shopkeeper_theme_styles() {

    $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

    // Enqueue Main Font
    if( 'google' === Shopkeeper_Opt::getOption( 'main_font_source', 'default' ) ) {
        $main_font = Shopkeeper_Opt::getOption( 'main_font_google', 'Roboto' );
        $google_font_url = Shopkeeper_Fonts::get_google_font_url( $main_font );
        if ( $google_font_url ) {
            wp_enqueue_style( 'shopkeeper-google-main-font', $google_font_url, false, shopkeeper_theme_version(), 'all' );
        }
    }

    // Enqueue Secondary Font
    if( 'google' === Shopkeeper_Opt::getOption( 'secondary_font_source', 'default' ) ) {
        $body_font = Shopkeeper_Opt::getOption( 'secondary_font_google', 'Roboto' );
        $google_font_url = Shopkeeper_Fonts::get_google_font_url($body_font);
        if ( $google_font_url ) {
            wp_enqueue_style( 'shopkeeper-google-body-font', $google_font_url, false, shopkeeper_theme_version(), 'all' );
        }
    }

    if( Shopkeeper_Opt::getOption( 'smooth_transition_between_pages', false ) ) {
        wp_enqueue_style( 'shopkeeper-page-in-out', get_template_directory_uri() . '/css/misc/page-in-out'.$suffix.'.css', NULL, shopkeeper_theme_version(), 'all' );
    }

    wp_enqueue_style( 'shopkeeper-icon-font',       get_template_directory_uri() . '/inc/fonts/shopkeeper-icon-font/style'.$suffix.'.css', NULL, shopkeeper_theme_version(), 'all' );
    wp_enqueue_style( 'shopkeeper-styles',          get_template_directory_uri() . '/css/styles'.$suffix.'.css', NULL, shopkeeper_theme_version(), 'all' );
    wp_enqueue_style( 'shopkeeper-default-style',   get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'shopkeeper_theme_styles', 99 );

/**
 * Plugin styles
 */
function shopkeeper_plugin_styles() {

    $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

    wp_enqueue_style( 'shopkeeper-mixed-plugins-styles', get_template_directory_uri() . '/css/plugins/misc'.$suffix.'.css', NULL, shopkeeper_theme_version(), 'all' );

    if( SHOPKEEPER_GERMAN_MARKET_IS_ACTIVE || SHOPKEEPER_WOOCOMMERCE_GERMANIZED_IS_ACTIVE ) {
        wp_enqueue_style( 'shopkeeper-german-market-styles', get_template_directory_uri() . '/css/plugins/german-market'.$suffix.'.css', NULL, shopkeeper_theme_version(), 'all' );
    }

    if ( SHOPKEEPER_DOKAN_MULTIVENDOR_IS_ACTIVE ) {
        wp_enqueue_style( 'shopkeeper-dokan-styles', get_template_directory_uri() . '/css/plugins/dokan'.$suffix.'.css', NULL, shopkeeper_theme_version(), 'all' );
    }

    if ( SHOPKEEPER_WOOCOMMERCE_PRODUCT_ADDONS_IS_ACTIVE ) {
        wp_enqueue_style( 'shopkeeper-addons-styles', get_template_directory_uri() . '/css/plugins/woo-addons'.$suffix.'.css', NULL, shopkeeper_theme_version(), 'all' );
    }

    if( SHOPKEEPER_WISHLIST_IS_ACTIVE ) {
        wp_enqueue_style( 'shopkeeper-wishlist-styles', get_template_directory_uri() . '/css/plugins/wishlist'.$suffix.'.css', NULL, shopkeeper_theme_version(), 'all' );
    }

    if( SHOPKEEPER_ELEMENTOR_IS_ACTIVE ) {
        wp_enqueue_style( 'shopkeeper-elementor-styles', get_template_directory_uri() . '/css/plugins/elementor'.$suffix.'.css', NULL, shopkeeper_theme_version(), 'all' );
    }

    if( SHOPKEEPER_WOO_SWATCHES_IS_ACTIVE ) {
        wp_enqueue_style( 'shopkeeper-wooswatches-styles', get_template_directory_uri() . '/css/plugins/woo-swatches'.$suffix.'.css', NULL, shopkeeper_theme_version(), 'all' );
    }

    if( SHOPKEEPER_PRODUCT_BLOCKS_IS_ACTIVE ) {
        wp_enqueue_style( 'shopkeeper-product-blocks-styles', get_template_directory_uri() . '/css/plugins/product-blocks'.$suffix.'.css', NULL, shopkeeper_theme_version(), 'all' );
    }
}
add_action( 'wp_enqueue_scripts', 'shopkeeper_plugin_styles', 100 );
