<?php
/**
 * Admin styles
 *
 * @package shopkeeper
 */

 /**
  * Admin styles
  */
function shopkeeper_admin_styles() {

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

    $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

    if ( is_admin() ) {

        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( 'shopkeeper_admin_styles', get_template_directory_uri() . '/css/admin/admin'.$suffix.'.css', false, shopkeeper_theme_version(), 'all' );

        if ( SHOPKEEPER_WPBAKERY_IS_ACTIVE ) {
            wp_enqueue_style( 'shopkeeper_visual_composer', get_template_directory_uri() .'/css/plugins/visual-composer'.$suffix.'.css', false, shopkeeper_theme_version(), 'all' );
        }
    }
}
add_action( 'admin_enqueue_scripts', 'shopkeeper_admin_styles' );
