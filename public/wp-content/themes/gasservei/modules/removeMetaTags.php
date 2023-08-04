<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * remove the unwanted <meta> links
 */
global $sitepress;

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'woo_version');


// TODO : revisar de aqui abajo:
remove_action('wp_head', 'meta_generator_tag');
remove_action( 'wp_head', array( $sitepress, 'meta_generator_tag' ) );