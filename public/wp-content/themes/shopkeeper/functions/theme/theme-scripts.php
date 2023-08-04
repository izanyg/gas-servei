<?php
/**
 * Theme scripts
 *
 * @package shopkeeper
 */

/**
 * Vendor scripts with priority
 */
function shopkeeper_vendor_scripts_high_priority() {

    $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

    if( Shopkeeper_Opt::getOption( 'smooth_transition_between_pages', false ) ) {
        wp_enqueue_script( 'nprogress', get_template_directory_uri() . '/js/vendor/nprogress.min.js', NULL, shopkeeper_theme_version(), FALSE);
    }
}
add_action( 'wp_enqueue_scripts', 'shopkeeper_vendor_scripts_high_priority', 0 );


/**
 * Plugin scripts
 */
function shopkeeper_plugin_scripts() {

    if( SHOPKEEPER_WOO_SWATCHES_IS_ACTIVE ) {
        wp_enqueue_script( 'shopkeeper-wooswatches-scripts', get_template_directory_uri() . '/js/plugins/woo-swatches.js', array('jquery'), shopkeeper_theme_version(), TRUE );
    }
}
add_action( 'wp_enqueue_scripts', 'shopkeeper_plugin_scripts', 97 );

/**
 * Vendor scripts
 */
function shopkeeper_vendor_scripts() {

    $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

    if( ( Shopkeeper_Opt::getOption( 'layout_blog', 'layout-3' ) == 'layout-1' ) && shopkeeper_is_blog() ) {
        wp_enqueue_script( 'salvattore', get_template_directory_uri() . '/js/vendor/salvattore.min.js', array('jquery'), '1.0.9', TRUE );
    }

    wp_enqueue_script( 'foundation-init-js', get_template_directory_uri() . '/inc/foundation/js/foundation'.$suffix.'.js', 	 array('jquery'), '6.4.3',  TRUE );

    wp_enqueue_script( 'isotope-js', 		 get_template_directory_uri() . '/js/vendor/isotope.pkgd.min.js', 		 array('jquery'), 'v3.0.6', TRUE );
    wp_enqueue_script( 'fresco', 			 get_template_directory_uri() . '/js/vendor/fresco.min.js', 			 array('jquery'), '2.3.0',  TRUE );
    wp_enqueue_script( 'imagesloaded', 		 get_template_directory_uri() . '/js/vendor/imagesloaded.min.js', 		 array('jquery'), '3.1.4',  TRUE );
    wp_enqueue_script( 'easyzoom', 			 get_template_directory_uri() . '/js/vendor/easyzoom.min.js', 			 array('jquery'), '2.5.2',  TRUE );
    wp_enqueue_script( 'touchswipe', 		 get_template_directory_uri() . '/js/vendor/jquery.touchSwipe.min.js',   array('jquery'), '1.6.18', TRUE );
    wp_enqueue_script( 'swiper', 			 get_template_directory_uri() . '/js/vendor/swiper.min.js', 			 array('jquery'), '6.4.1',  TRUE );
    wp_enqueue_script( 'select2', 			 get_template_directory_uri() . '/js/vendor/select2.min.js', 			 array('jquery'), '4.1.0-beta.1',  TRUE );
    wp_enqueue_script( 'stellar', 			 get_template_directory_uri() . '/js/vendor/jquery.stellar.min.js', 	 array('jquery'), '0.6.2',  TRUE );
    wp_enqueue_script( 'velocity', 			 get_template_directory_uri() . '/js/vendor/velocity.min.js', 			 array('jquery'), '1.0.0',  TRUE );
}
add_action( 'wp_enqueue_scripts', 'shopkeeper_vendor_scripts', 98 );

/**
 * Vendor scripts
 */
function shopkeeper_theme_scripts() {

    $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

    // Enqueue Adobe TypeKit Fonts
    if( 'adobe' === Shopkeeper_Opt::getOption( 'main_font_source', 'default' ) ||
        'adobe' === Shopkeeper_Opt::getOption( 'secondary_font_source', 'default' ) ) {
        wp_enqueue_script(
            'shopkeeper-adobe_typekit',
            '//use.typekit.net/' . Shopkeeper_Opt::getOption( 'adobe_typekit_kit_id', '' ) . '.js',
            array(),
            shopkeeper_theme_version(),
            FALSE
        );
        wp_enqueue_script(
            'shopkeeper-adobe_typekit-exec',
            get_template_directory_uri() . '/js/misc/adobe-typekit.js',
            array( 'jquery' ),
            shopkeeper_theme_version(),
            FALSE
        );
    }

    /** In Footer **/
    if( is_rtl() ) {
        wp_enqueue_script( 'shopkeeper-rtl-js', get_template_directory_uri() . '/js/misc/rtl'.$suffix.'.js', array('jquery'), shopkeeper_theme_version(), TRUE );
    }

    if ( SHOPKEEPER_WPBAKERY_IS_ACTIVE) { // If VC exists/active load scripts after VC
        $dependencies = array('jquery', 'wpb_composer_front_js');
    } else { // Do not depend on VC
        $dependencies = array('jquery');
    }

    wp_enqueue_script( 'shopkeeper-scripts-dist', get_template_directory_uri() . '/js/scripts'.$suffix.'.js', $dependencies, shopkeeper_theme_version(), TRUE );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    $ajax_url = admin_url('admin-ajax.php', 'relative');
    if ( class_exists('SitePress') ) {
        $my_current_lang = apply_filters( 'wpml_current_language', NULL );
        if ( $my_current_lang ) {
            $ajax_url = add_query_arg( 'wpml_lang', $my_current_lang, $ajax_url );
    }}

    $getbowtied_scripts_vars_array = array(

        'ajax_load_more_locale' 	=> esc_html__( 'Load More Items', 'shopkeeper' ),
        'ajax_loading_locale' 		=> esc_html__( 'Loading', 'shopkeeper' ),
        'ajax_no_more_items_locale' => esc_html__( 'No more items available.', 'shopkeeper' ),
        'smooth_transition'		    => Shopkeeper_Opt::getOption( 'smooth_transition_between_pages', false ),
        'pagination_blog' 			=> Shopkeeper_Opt::getOption( 'pagination_blog', 'infinite_scroll' ),
        'layout_blog' 				=> Shopkeeper_Opt::getOption( 'layout_blog', 'layout-3' ),
        'shop_pagination_type' 		=> Shopkeeper_Opt::getOption( 'pagination_shop', 'infinite_scroll' ),
        'option_minicart' 			=> Shopkeeper_Opt::getOption( 'option_minicart', '1' ),
        'option_minicart_open' 		=> Shopkeeper_Opt::getOption( 'option_minicart_open', '1' ),
        'catalog_mode'				=> Shopkeeper_Opt::getOption( 'catalog_mode', false ),
        'product_lightbox'			=> Shopkeeper_Opt::getOption( 'product_gallery_lightbox', true ),
        'product_gallery_zoom'		=> Shopkeeper_Opt::getOption( 'product_gallery_zoom', true ),
        'mobile_product_columns'    => Shopkeeper_Opt::getOption( 'mobile_columns', 2 ),
        'sticky_header'             => Shopkeeper_Opt::getOption( 'sticky_header', true ),
        'mobile_sticky_header'      => Shopkeeper_Opt::getOption( 'mobile_sticky_header', true ),
        'back_to_top_button'        => Shopkeeper_Opt::getOption( 'back_to_top_button', false ),
        'ajax_url'					=> esc_url($ajax_url),
    );

    wp_localize_script( 'shopkeeper-scripts-dist', 'getbowtied_scripts_vars', $getbowtied_scripts_vars_array );
}
add_action( 'wp_enqueue_scripts', 'shopkeeper_theme_scripts', 99 );
