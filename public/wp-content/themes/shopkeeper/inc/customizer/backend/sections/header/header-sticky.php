<?php
/**
* The Header Sticky section options.
*
* @package shopkeeper
*/

/**
 * Checks if sticky header is enabled.
 */
function sk_header_is_sticky(){

    return Shopkeeper_Opt::getOption( 'sticky_header', true );
}

/**
 * Checks if sticky header and topbar are enabled.
 */
function sk_sticky_header_and_topbar_enabled(){

    return Shopkeeper_Opt::getOption( 'sticky_header', true ) && Shopkeeper_Opt::getOption( 'top_bar_switch', false );
}

add_action( 'customize_register', 'shopkeeper_customizer_header_sticky_controls' );
/**
 * Adds controls for header sticky section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_header_sticky_controls( $wp_customize ) {

    // Sticky Header.
    $wp_customize->add_setting(
		'sticky_header',
		array(
			'type'                 => 'theme_mod',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'shopkeeper_sanitize_checkbox',
			'default'              => true,
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'sticky_header',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Sticky Header', 'shopkeeper' ),
				'section'  => 'sticky_header',
				'priority' => 10,
			)
		)
	);

    // Include Top Bar.
    $wp_customize->add_setting(
    	'sticky_top_bar',
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
    		'sticky_top_bar',
    		array(
    			'type'            => 'checkbox',
    			'label'           => esc_html__( 'Include Top Bar', 'shopkeeper' ),
    			'section'         => 'sticky_header',
    			'priority'        => 10,
                'active_callback' => 'sk_sticky_header_and_topbar_enabled',
    		)
    	)
    );

    // Sticky Header Background Color.
    $wp_customize->add_setting(
        'sticky_header_background_color',
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
            'sticky_header_background_color',
            array(
                'label'    => esc_html__( 'Sticky Header Background Color', 'shopkeeper' ),
                'section'  => 'sticky_header',
                'priority' => 10,
                'active_callback' => 'sk_header_is_sticky',
            )
        )
    );

    // Sticky Header Text Color.
    $wp_customize->add_setting(
        'sticky_header_color',
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
            'sticky_header_color',
            array(
                'label'    => esc_html__( 'Sticky Header Text Color', 'shopkeeper' ),
                'section'  => 'sticky_header',
                'priority' => 10,
                'active_callback' => 'sk_header_is_sticky',
            )
        )
    );

    // Sticky Logo.
    $wp_customize->add_setting(
        'sticky_header_logo',
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
            'sticky_header_logo',
            array(
                'type'        => 'image',
                'label'       => esc_html__( 'Sticky Logo', 'shopkeeper' ),
                'section'     => 'sticky_header',
                'priority'    => 10,
                'active_callback' => 'sk_header_is_sticky',
            )
        )
    );

    // Sticky Logo Height.
    $wp_customize->add_setting(
        'sticky_logo_height',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
            'default'    => 33,
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'sticky_logo_height',
            array(
                'type'        => 'number',
                'label'       => esc_html__( 'Sticky Logo Height', 'shopkeeper' ),
                'description' => esc_html__( "(0px - 300px)", 'shopkeeper' ),
                'section'     => 'sticky_header',
                'priority'    => 10,
                'active_callback' => 'sk_header_is_sticky',
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
        'sticky_spacing_above_logo',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
            'default'    => 15,
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'sticky_spacing_above_logo',
            array(
                'type'        => 'number',
                'label'       => esc_html__( 'Spacing Above the Logo', 'shopkeeper' ),
                'section'     => 'sticky_header',
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
        'sticky_spacing_below_logo',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
            'default'    => 15,
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'sticky_spacing_below_logo',
            array(
                'type'        => 'number',
                'label'       => esc_html__( 'Spacing Below the Logo', 'shopkeeper' ),
                'section'     => 'sticky_header',
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

    $wp_customize->selective_refresh->add_partial( 'sticky_header_logo', array(
        'selector' => '.site-header .site-branding .sticky-logo',
        'settings' => 'sticky_header_logo',
        'render_callback' => function() {
            return shopkeeper_get_logo();
        },
    ) );
}
