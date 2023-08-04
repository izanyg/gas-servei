<?php
/**
* The Header Logo section options.
*
* @package shopkeeper
*/

add_action( 'customize_register', 'shopkeeper_customizer_header_logo_controls' );
/**
 * Adds controls for header logo section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_header_logo_controls( $wp_customize ) {

    // Logo.
    $wp_customize->add_setting(
        'site_logo',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'shopkeeper_sanitize_image',
            'default'	 => get_template_directory_uri() . '/images/shopkeeper-logo.png',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_logo',
            array(
                'type'        => 'image',
                'label'       => esc_html__( 'Logo', 'shopkeeper' ),
                'section'     => 'header_logo',
                'description' => wp_kses( __( '<span class="dashicons dashicons-editor-help"></span>Applied on Non-Transparent Headers. To upload a logo for a Transparent Background go to <strong>Header Transparency</strong> section.', 'shopkeeper' ), array( 'span' => array( 'class' => array() ), 'strong' => array() )),
                'priority'    => 10,
            )
        )
    );

    // Logo Height.
    $wp_customize->add_setting(
        'logo_height',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
            'default'    => 50,
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'logo_height',
            array(
                'type'        => 'number',
                'label'       => esc_html__( 'Logo Height', 'shopkeeper' ),
                'description' => esc_html__( "(0px - 300px)", 'shopkeeper' ),
                'section'     => 'header_logo',
                'priority'    => 10,
                'input_attrs' => array(
                    'min'  => 0,
                    'max'  => 300,
                    'step' => 1,
                ),
            )
        )
    );

    // Spacing Above the Logo.
    $wp_customize->add_setting(
        'spacing_above_logo',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
            'default'    => 20,
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'spacing_above_logo',
            array(
                'type'        => 'number',
                'label'       => esc_html__( 'Spacing Above the Logo', 'shopkeeper' ),
                'section'     => 'header_logo',
                'description' => esc_html__( "(0px - 200px)", 'shopkeeper' ),
                'priority'    => 10,
                'input_attrs' => array(
                    'min'  => 0,
                    'max'  => 200,
                    'step' => 1,
                ),
            )
        )
    );

    // Spacing Below the Logo.
    $wp_customize->add_setting(
        'spacing_below_logo',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
            'default'    => 20,
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'spacing_below_logo',
            array(
                'type'        => 'number',
                'label'       => esc_html__( 'Spacing Below the Logo', 'shopkeeper' ),
                'section'     => 'header_logo',
                'description' => esc_html__( "(0px - 200px)", 'shopkeeper' ),
                'priority'    => 10,
                'input_attrs' => array(
                    'min'  => 0,
                    'max'  => 200,
                    'step' => 1,
                ),
            )
        )
    );

    // Abort if selective refresh is not available.
    if ( ! isset( $wp_customize->selective_refresh ) ) {
        return;
    }

    $wp_customize->selective_refresh->add_partial( 'site_logo', array(
        'selector' => '.site-header .site-branding .site-logo',
        'settings' => 'site_logo',
        'render_callback' => function() {
            return shopkeeper_get_logo();
        },
    ) );
}
