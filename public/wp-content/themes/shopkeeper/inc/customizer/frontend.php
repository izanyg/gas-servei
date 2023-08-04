<?php

function shopkeeper_sanitize_header_background_options() {

    $old_background = Shopkeeper_Opt::getOption( 'main_header_background', array('background-color' => '#FFFFFF') );

    $old_background_color = ( isset( $old_background['background-color'] ) ) ? $old_background['background-color'] : '#FFFFFF';
    $old_background_image = ( isset( $old_background['background-image'] ) ) ? $old_background['background-image'] : '';
    $old_background_repeat = ( isset( $old_background['background-repeat'] ) ) ? $old_background['background-repeat'] : 'no-repeat';
    $old_background_position = ( isset( $old_background['background-position'] ) ) ? str_replace( ' ', '-', $old_background['background-position'] ) : 'left-top';
    $old_background_size = ( isset( $old_background['background-size'] ) ) ? $old_background['background-size'] : 'cover';
    $old_background_attachment = ( isset( $old_background['background-attachment'] ) ) ? $old_background['background-attachment'] : 'scroll';

    set_theme_mod( 'main_header_background_color', $old_background_color );
    set_theme_mod( 'main_header_background_image', $old_background_image );
    set_theme_mod( 'main_header_background_image_repeat', $old_background_repeat );
    set_theme_mod( 'main_header_background_image_position', $old_background_position );
    set_theme_mod( 'main_header_background_image_size', $old_background_size );
    set_theme_mod( 'main_header_background_image_attachment', $old_background_attachment );
}

function shopkeeper_sanitize_body_background_options() {

    $old_background = Shopkeeper_Opt::getOption( 'main_background', array('background-color' => '#FFFFFF') );

    $old_background_color = ( isset( $old_background['background-color'] ) ) ? $old_background['background-color'] : '#FFFFFF';
    $old_background_image = ( isset( $old_background['background-image'] ) ) ? $old_background['background-image'] : '';
    $old_background_repeat = ( isset( $old_background['background-repeat'] ) ) ? $old_background['background-repeat'] : 'no-repeat';
    $old_background_position = ( isset( $old_background['background-position'] ) ) ? str_replace( ' ', '-', $old_background['background-position'] ) : 'left-top';
    $old_background_size = ( isset( $old_background['background-size'] ) ) ? $old_background['background-size'] : 'cover';
    $old_background_attachment = ( isset( $old_background['background-attachment'] ) ) ? $old_background['background-attachment'] : 'scroll';

    set_theme_mod( 'main_background_color', $old_background_color );
    set_theme_mod( 'main_background_image', $old_background_image );
    set_theme_mod( 'main_background_image_repeat', $old_background_repeat );
    set_theme_mod( 'main_background_image_position', $old_background_position );
    set_theme_mod( 'main_background_image_size', $old_background_size );
    set_theme_mod( 'main_background_image_attachment', $old_background_attachment );
}

function shopkeeper_sanitize_single_post_sidebar_option() {
    $blog_sidebar = Shopkeeper_Opt::getOption( 'sidebar_blog_listing', false );
    set_theme_mod( 'single_post_sidebar', $blog_sidebar );
}

function shopkeeper_sanitize_font_options() {
    $main_font = Shopkeeper_Opt::getOption( 'new_main_font', array( 'font-family' => 'NeueEinstellung', 'variant' => '500', 'subsets' => array( 'latin' ) ) );

    if( isset( $main_font['font-family'] ) ) {
        set_theme_mod( 'new_main_font', $main_font['font-family'] );
    } else {
        set_theme_mod( 'new_main_font', 'NeueEinstellung' );
    }

    $secondary_font = Shopkeeper_Opt::getOption( 'new_secondary_font', array( 'font-family' => 'Radnika' ) );

    if( isset( $secondary_font['font-family'] ) ) {
        set_theme_mod( 'new_secondary_font', $secondary_font['font-family'] );
    } else {
        set_theme_mod( 'new_secondary_font', 'Radnika' );
    }
}

if( !get_option( 'sk_kirki_options_sanitize', false ) ) {
    shopkeeper_sanitize_header_background_options();
    shopkeeper_sanitize_body_background_options();
    shopkeeper_sanitize_single_post_sidebar_option();
    shopkeeper_sanitize_font_options();
    update_option( 'sk_kirki_options_sanitize', true );
}

function shopkeeper_sanitize_new_font_options() {
    $main_font = Shopkeeper_Opt::getOption( 'new_main_font', 'NeueEinstellung' );
    $secondary_font = Shopkeeper_Opt::getOption( 'new_secondary_font', 'Radnika' );

    $web_safe_fonts = array(
        '--apple-system', 'Arial', 'Comic Sans', 'Courier New',
		'Courier', 'Garamond', 'Georgia', 'Helvetica', 'Impact', 'Palatino',
		'Times New Roman', 'Times', 'Trebuchet', 'Verdana'
	);

    if( 'NeueEinstellung' === $main_font || 'Radnika' === $main_font ) {
        set_theme_mod( 'main_font_source', 'default' );
        set_theme_mod( 'main_font_default', $main_font );
    } else if( in_array( $main_font, $web_safe_fonts ) ) {
        set_theme_mod( 'main_font_source', 'web-safe' );
        set_theme_mod( 'main_font_web_safe', $main_font );
    } else {
        set_theme_mod( 'main_font_source', 'google' );
        set_theme_mod( 'main_font_google', $main_font );
    }

    if( 'NeueEinstellung' === $secondary_font || 'Radnika' === $secondary_font ) {
        set_theme_mod( 'secondary_font_source', 'default' );
        set_theme_mod( 'secondary_font_default', $secondary_font );
    } else if( in_array( $secondary_font, $web_safe_fonts ) ) {
        set_theme_mod( 'secondary_font_source', 'web-safe' );
        set_theme_mod( 'secondary_font_web_safe', $secondary_font );
    } else {
        set_theme_mod( 'secondary_font_source', 'google' );
        set_theme_mod( 'secondary_font_google', $secondary_font );
    }
}

if( !get_option( 'sk_font_options_sanitize', false ) ) {
    shopkeeper_sanitize_new_font_options();
    update_option( 'sk_font_options_sanitize', true );
}

if( !get_option( 'sk_header_options_sanitize', false ) ) {
    set_theme_mod( 'mobile_header_logo', Shopkeeper_Opt::getOption( 'sticky_header_logo', get_template_directory_uri() . '/images/shopkeeper-logo.png' ) );
    update_option( 'sk_header_options_sanitize', true );
}
