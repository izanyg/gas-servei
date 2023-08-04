<?php
/**
* The Header Styles section options.
*
* @package shopkeeper
*/

/**
 * Checks if background image is set.
 */
function sk_header_background_image(){
   if( '' != Shopkeeper_Opt::getOption( 'main_header_background_image', '' ) ) {
       return true;
   }
   return false;
}

/**
 * Checks if custom header width.
 */
function sk_header_is_custom_width(){
   if( 'custom' === Shopkeeper_Opt::getOption( 'header_width', 'custom' ) ) {
       return true;
   }
   return false;
}

add_action( 'customize_register', 'shopkeeper_customizer_header_styles_controls' );
/**
 * Adds controls for header styles section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_header_styles_controls( $wp_customize ) {

   // Header Layout.
   $wp_customize->add_setting(
       'main_header_layout',
       array(
           'type'              => 'theme_mod',
           'capability'        => 'edit_theme_options',
           'sanitize_callback' => 'shopkeeper_sanitize_select',
           'default'           => '1',
       )
   );

   $wp_customize->add_control(
       new WP_Customize_Control(
           $wp_customize,
           'main_header_layout',
           array(
               'type'     => 'select',
               'label'    => esc_html__( 'Header Layout', 'shopkeeper' ),
               'section'  => 'header_style',
               'priority' => 10,
               'choices'  => array(
                   '1'         => esc_html__( 'Layout 1', 'shopkeeper' ),
                   '11'        => esc_html__( 'Layout 2', 'shopkeeper' ),
                   '2'         => esc_html__( 'Layout 3', 'shopkeeper' ),
                   '22'        => esc_html__( 'Layout 4', 'shopkeeper' ),
                   '3'         => esc_html__( 'Layout 5', 'shopkeeper' ),
               ),
           )
       )
   );

   // Navigation Font Size.
   $wp_customize->add_setting(
       'main_header_font_size',
       array(
           'type'       => 'theme_mod',
           'capability' => 'edit_theme_options',
           'sanitize_callback' => 'absint',
           'default'    => 13,
       )
   );

   $wp_customize->add_control(
       new WP_Customize_Control(
           $wp_customize,
           'main_header_font_size',
           array(
               'type'        => 'number',
               'label'       => wp_kses_post( __( 'Navigation Font Size', 'shopkeeper' ) ),
               'section'     => 'header_style',
               'priority'    => 10,
               'description' => esc_html__( "(11px - 16px)", 'shopkeeper' ),
               'input_attrs' => array(
                   'min'  => 11,
                   'max'  => 16,
                   'step' => 1,
               ),
           )
       )
   );

   // Header Background Image.
   $wp_customize->add_setting(
       'main_header_background_image',
       array(
           'type'       => 'theme_mod',
           'capability' => 'edit_theme_options',
           'sanitize_callback' => 'shopkeeper_sanitize_image',
           'default'    => '',
       )
   );

   $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'main_header_background_image',
           array(
               'type'        => 'image',
               'label'       => esc_html__( 'Header Background Image', 'shopkeeper' ),
               'section'     => 'header_style',
               'priority'    => 10,
           )
       )
   );

   // Header Background Image Repeat.
   $wp_customize->add_setting(
       'main_header_background_image_repeat',
       array(
           'type'              => 'theme_mod',
           'capability'        => 'edit_theme_options',
           'sanitize_callback' => 'shopkeeper_sanitize_select',
           'default'           => 'no-repeat',
       )
   );

   $wp_customize->add_control(
       new WP_Customize_Control(
           $wp_customize,
           'main_header_background_image_repeat',
           array(
               'type'     => 'select',
               'label'    => esc_html__( 'Background Repeat', 'shopkeeper' ),
               'section'  => 'header_style',
               'priority' => 10,
               'choices'  => array(
                   'no-repeat'  => esc_html__( 'No Repeat', 'shopkeeper' ),
                   'repeat'     => esc_html__( 'Repeat All', 'shopkeeper' ),
                   'repeat-x'   => esc_html__( 'Repeat Horizontally', 'shopkeeper' ),
                   'repeat-y'   => esc_html__( 'Repeat Vertically', 'shopkeeper' ),
               ),
               'active_callback' => 'sk_header_background_image',
           )
       )
   );

   // Header Background Image Position.
   $wp_customize->add_setting(
       'main_header_background_image_position',
       array(
           'type'              => 'theme_mod',
           'capability'        => 'edit_theme_options',
           'sanitize_callback' => 'shopkeeper_sanitize_select',
           'default'           => 'left-top',
       )
   );

   $wp_customize->add_control(
       new WP_Customize_Control(
           $wp_customize,
           'main_header_background_image_position',
           array(
               'type'     => 'select',
               'label'    => esc_html__( 'Background Position', 'shopkeeper' ),
               'section'  => 'header_style',
               'priority' => 10,
               'choices'  => array(
                   'left-top'       => esc_html__( 'Left Top', 'shopkeeper' ),
                   'left-center'    => esc_html__( 'Left Center', 'shopkeeper' ),
                   'left-bottom'    => esc_html__( 'Left Bottom', 'shopkeeper' ),
                   'right-top'      => esc_html__( 'Right Top', 'shopkeeper' ),
                   'right-center'   => esc_html__( 'Right Center', 'shopkeeper' ),
                   'right-bottom'   => esc_html__( 'Right Bottom', 'shopkeeper' ),
                   'center-top'     => esc_html__( 'Center Top', 'shopkeeper' ),
                   'center-center'  => esc_html__( 'Center Center', 'shopkeeper' ),
                   'center-bottom'  => esc_html__( 'Center Bottom', 'shopkeeper' ),
               ),
               'active_callback' => 'sk_header_background_image',
           )
       )
   );

   // Header Background Image Size.
   $wp_customize->add_setting(
       'main_header_background_image_size',
       array(
           'type'              => 'theme_mod',
           'capability'        => 'edit_theme_options',
           'sanitize_callback' => 'shopkeeper_sanitize_select',
           'default'           => 'cover',
       )
   );

   $wp_customize->add_control(
       new WP_Customize_Control(
           $wp_customize,
           'main_header_background_image_size',
           array(
               'type'     => 'select',
               'label'    => esc_html__( 'Background Size', 'shopkeeper' ),
               'section'  => 'header_style',
               'priority' => 10,
               'choices'  => array(
                   'cover'      => esc_html__( 'Cover', 'shopkeeper' ),
                   'contain'    => esc_html__( 'Contain', 'shopkeeper' ),
                   'auto'       => esc_html__( 'Auto', 'shopkeeper' ),
               ),
               'active_callback' => 'sk_header_background_image',
           )
       )
   );

   // Header Background Image Attachment.
   $wp_customize->add_setting(
       'main_header_background_image_attachment',
       array(
           'type'              => 'theme_mod',
           'capability'        => 'edit_theme_options',
           'sanitize_callback' => 'shopkeeper_sanitize_select',
           'default'           => 'scroll',
       )
   );

   $wp_customize->add_control(
       new WP_Customize_Control(
           $wp_customize,
           'main_header_background_image_attachment',
           array(
               'type'     => 'select',
               'label'    => esc_html__( 'Background Attachment', 'shopkeeper' ),
               'section'  => 'header_style',
               'priority' => 10,
               'choices'  => array(
                   'scroll'   => esc_html__( 'Scroll', 'shopkeeper' ),
                   'fixed'    => esc_html__( 'Fixed', 'shopkeeper' ),
               ),
               'active_callback' => 'sk_header_background_image',
           )
       )
   );

   // Header Width.
   $wp_customize->add_setting(
       'header_width',
       array(
           'type'              => 'theme_mod',
           'capability'        => 'edit_theme_options',
           'sanitize_callback' => 'shopkeeper_sanitize_select',
           'default'           => 'custom',
       )
   );

   $wp_customize->add_control(
       new WP_Customize_Control(
           $wp_customize,
           'header_width',
           array(
               'type'     => 'select',
               'label'    => esc_html__( 'Header Width', 'shopkeeper' ),
               'section'  => 'header_style',
               'priority' => 10,
               'choices'  => array(
                   'full'   => esc_html__( 'Full Width', 'shopkeeper' ),
                   'custom' => esc_html__( 'Custom Width', 'shopkeeper' ),
               ),
           )
       )
   );

   // Custom Max Width.
   $wp_customize->add_setting(
       'header_max_width',
       array(
           'type'       => 'theme_mod',
           'capability' => 'edit_theme_options',
           'sanitize_callback' => 'absint',
           'default'    => 1680,
       )
   );

   $wp_customize->add_control(
       new WP_Customize_Control(
           $wp_customize,
           'header_max_width',
           array(
               'type'        => 'number',
               'label'       => esc_html__( 'Custom Max Width', 'shopkeeper' ),
               'section'     => 'header_style',
               'description' => esc_html__( "(960px - 1680px)", 'shopkeeper' ),
               'priority'    => 10,
               'input_attrs' => array(
                   'min'  => 960,
                   'max'  => 1680,
                   'step' => 1,
               ),
               'active_callback' => 'sk_header_is_custom_width',
           )
       )
   );
}
