<?php
/**
* The Header Colors section options.
*
* @package shopkeeper
*/

add_action( 'customize_register', 'shopkeeper_customizer_header_colors_controls' );
/**
 * Adds controls for header colors section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_header_colors_controls( $wp_customize ) {

    // Navigation Font Color.
    $wp_customize->add_setting(
        'main_header_font_color',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'default'    => '#000',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'main_header_font_color',
            array(
                'label'    => esc_html__( 'Navigation Font Color', 'shopkeeper' ),
                'section'  => 'header_colors',
                'priority' => 10,
            )
        )
    );

    // Header Background Color.
    $wp_customize->add_setting(
        'main_header_background_color',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'default'    => '#FFFFFF',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'main_header_background_color',
            array(
                'label'    => esc_html__( 'Header Background Color', 'shopkeeper' ),
                'section'  => 'header_colors',
                'priority' => 10,
            )
        )
    );

    // Menu Dropdown Font Color.
    $wp_customize->add_setting(
        'main_header_dropdown_font_color',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'default'    => '#000000',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'main_header_dropdown_font_color',
            array(
                'label'    => esc_html__( 'Menu Dropdown Font Color', 'shopkeeper' ),
                'section'  => 'header_colors',
                'priority' => 10,
            )
        )
    );

    // Menu Dropdown Background Color.
    $wp_customize->add_setting(
        'main_header_dropdown_background_color',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'default'    => '#ffffff',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'main_header_dropdown_background_color',
            array(
                'label'    => esc_html__( 'Menu Dropdown Background Color', 'shopkeeper' ),
                'section'  => 'header_colors',
                'priority' => 10,
            )
        )
    );
}
