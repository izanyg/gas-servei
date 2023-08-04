<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Add a sidebar.
 */
function gss_register_footer_sidebars() {
    register_sidebar( array(
        'name'          => __( 'Footer GSS info', 'gasservei' ),
		'id'            => 'gss-footer-info',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer GSS below links', 'gasservei' ),
		'id'            => 'gss-footer-below-links',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'gss_register_footer_sidebars' );