<?php
/**
* The Header Transparency section options.
*
* @package shopkeeper
*/

add_action( 'customize_register', 'shopkeeper_customizer_header_transparency_controls' );
/**
 * Adds controls for header transparency section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_header_transparency_controls( $wp_customize ) {

    // Transparent Header.
    $wp_customize->add_setting(
		'main_header_transparency',
		array(
			'type'                 => 'theme_mod',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'shopkeeper_sanitize_checkbox',
			'default'              => false,
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'main_header_transparency',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Transparent Header', 'shopkeeper' ),
				'section'  => 'header_transparency',
                'description' => '<span class="dashicons dashicons-editor-help"></span><a target="_blank" href="https://www.getbowtied.com/documentation/shopkeeper/customization/how-to-work-with-header-transparency/">' . esc_html__( 'Working with Header Transparency', 'shopkeeper' ) . '</a>',
				'priority' => 10,
			)
		)
	);

    // Default Transparency Color Scheme.
    $wp_customize->add_setting(
        'main_header_transparency_scheme',
        array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'shopkeeper_sanitize_select',
            'default'           => 'transparency_light',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'main_header_transparency_scheme',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Default Transparency Color Scheme', 'shopkeeper' ),
                'section'  => 'header_transparency',
                'priority' => 10,
                'choices'  => array(
                    'transparency_light' => esc_html__( 'Light Transparency', 'shopkeeper' ),
                    'transparency_dark'  => esc_html__( 'Dark Transparency', 'shopkeeper' ),
                ),
            )
        )
    );

    // Product Categories Transparency
    $wp_customize->add_setting(
        'shop_category_header_transparency_scheme',
        array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'shopkeeper_sanitize_select',
            'default'           => 'no_transparency',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'shop_category_header_transparency_scheme',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Product Categories Transparency', 'shopkeeper' ),
                'section'  => 'header_transparency',
                'priority' => 10,
                'choices'  => array(
                    'inherit'            => esc_html__( 'Same as Above', 'shopkeeper' ),
                    'no_transparency'    => esc_html__( 'No Transparency', 'shopkeeper' ),
                    'transparency_light' => esc_html__( 'Light Transparency', 'shopkeeper' ),
                    'transparency_dark'  => esc_html__( 'Dark Transparency', 'shopkeeper' ),
                ),
            )
        )
    );

    // Product Categories Transparency
    $wp_customize->add_setting(
        'shop_product_header_transparency_scheme',
        array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'shopkeeper_sanitize_select',
            'default'           => 'no_transparency',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'shop_product_header_transparency_scheme',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Single Product Page Transparency', 'shopkeeper' ),
                'section'  => 'header_transparency',
                'priority' => 10,
                'choices'  => array(
                    'inherit'            => esc_html__( 'Same as Above', 'shopkeeper' ),
                    'no_transparency'    => esc_html__( 'No Transparency', 'shopkeeper' ),
                    'transparency_light' => esc_html__( 'Light Transparency', 'shopkeeper' ),
                    'transparency_dark'  => esc_html__( 'Dark Transparency', 'shopkeeper' ),
                ),
            )
        )
    );

    // Light Transparency Heading
    $wp_customize->add_setting(
        'main_header_light_transparency_heading',
        array(
            'type'       => 'theme_mod',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'capability' => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new SK_Customize_Heading_Control(
            $wp_customize,
            'main_header_light_transparency_heading',
            array(
                'label'    => esc_html__( 'Light Transparency', 'shopkeeper' ),
                'section'  => 'header_transparency',
                'priority' => 10,
            )
        )
    );

    // Light Transparency - Text / Icon Color
    $wp_customize->add_setting(
        'main_header_transparent_light_color',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'default'    => '#fff',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'main_header_transparent_light_color',
            array(
                'label'    => esc_html__( 'Light Transparency - Text / Icon Color', 'shopkeeper' ),
                'section'  => 'header_transparency',
                'priority' => 10,
            )
        )
    );

    // Light Transparency - Logo Light
    $wp_customize->add_setting(
        'light_transparent_header_logo',
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
            'light_transparent_header_logo',
            array(
                'type'        => 'image',
                'label'       => esc_html__( 'Light Transparency - Logo', 'shopkeeper' ),
                'section'     => 'header_transparency',
                'priority'    => 10,
            )
        )
    );

    // Dark Transparency Heading
    $wp_customize->add_setting(
        'main_header_dark_transparency_heading',
        array(
            'type'       => 'theme_mod',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'capability' => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new SK_Customize_Heading_Control(
            $wp_customize,
            'main_header_dark_transparency_heading',
            array(
                'label'    => esc_html__( 'Dark Transparency', 'shopkeeper' ),
                'section'  => 'header_transparency',
                'priority' => 10,
            )
        )
    );

    // Dark Transparency - Text / Icon Color
    $wp_customize->add_setting(
        'main_header_transparent_dark_color',
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
            'main_header_transparent_dark_color',
            array(
                'label'    => esc_html__( 'Dark Transparency - Text / Icon Color', 'shopkeeper' ),
                'section'  => 'header_transparency',
                'priority' => 10,
            )
        )
    );

    // Dark Transparency - Logo Light
    $wp_customize->add_setting(
        'dark_transparent_header_logo',
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
            'dark_transparent_header_logo',
            array(
                'type'        => 'image',
                'label'       => esc_html__( 'Dark Transparency - Logo', 'shopkeeper' ),
                'section'     => 'header_transparency',
                'priority'    => 10,
            )
        )
    );
}
