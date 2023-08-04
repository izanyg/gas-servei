<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * wp_enqueue_scripts from parent theme
 */
add_action( 'wp_enqueue_scripts', function () {
    // enqueue parent styles
    wp_enqueue_style( 'shopkeeper-icon-font', get_template_directory_uri() . '/inc/fonts/shopkeeper-icon-font/style.css' );
    wp_enqueue_style( 'shopkeeper-styles', get_template_directory_uri() .'/css/styles.css' );
    wp_enqueue_style( 'shopkeeper-default-style', get_template_directory_uri() .'/style.css' );

    // enqueue child styles
    wp_enqueue_style( 'shopkeeper-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'shopkeeper-default-style' ),
        time(),
        'all'
    );

    // enqueue RTL styles
    if( is_rtl() ) {
        wp_enqueue_style( 'shopkeeper-child-rtl-styles',  get_template_directory_uri() . '/rtl.css', array( 'shopkeeper-styles' ), wp_get_theme()->get('Version') );
    }

    wp_register_script('gasservei_script', get_stylesheet_directory_uri() . '/dist/scripts.js', array('jquery'),'1.1', true);

    wp_enqueue_script('gasservei_script');
}, 99 );


add_action( 'admin_enqueue_scripts', function () {
    wp_enqueue_style( 'admin_css', get_stylesheet_directory_uri() . '/assets/css/admin/admin_styles.css', false, '1.0.0' );
});


add_filter( 'use_widgets_block_editor', '__return_false' );
