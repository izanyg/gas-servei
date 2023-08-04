<?php
/**
* The Mobile Header section options.
*
* @package shopkeeper
*/

/**
 * Checks if sticky header is enabled.
 */
function sk_mobile_header_is_sticky(){

    return Shopkeeper_Opt::getOption( 'sticky_header', true );
}

function sk_mobile_sticky_header_and_topbar_enabled() {

    return Shopkeeper_Opt::getOption( 'mobile_sticky_header', true ) && Shopkeeper_Opt::getOption( 'top_bar_switch', false ) && Shopkeeper_Opt::getOption( 'top_bar_mobile', false );
}

add_action( 'customize_register', 'shopkeeper_customizer_header_mobile_controls' );
/**
 * Adds controls for header sticky section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_header_mobile_controls( $wp_customize ) {

    // Display Top Bar on mobile devices.
    $wp_customize->add_setting(
		'top_bar_mobile',
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
			'top_bar_mobile',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Mobile Top Bar', 'shopkeeper' ),
				'section'  => 'mobile_header',
				'priority' => 10,
                'active_callback' => 'sk_is_topbar_enabled',
			)
		)
	);

    // Sticky Header.
    $wp_customize->add_setting(
		'mobile_sticky_header',
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
			'mobile_sticky_header',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Sticky Mobile Header', 'shopkeeper' ),
				'section'  => 'mobile_header',
				'priority' => 10,
			)
		)
	);

    // Sticky Top Bar.
    $wp_customize->add_setting(
    	'mobile_sticky_top_bar',
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
    		'mobile_sticky_top_bar',
    		array(
    			'type'            => 'checkbox',
    			'label'           => esc_html__( 'Sticky Top Bar', 'shopkeeper' ),
    			'section'         => 'mobile_header',
    			'priority'        => 10,
                'active_callback' => 'sk_mobile_sticky_header_and_topbar_enabled',
    		)
    	)
    );

    // Mobile Logo.
    $wp_customize->add_setting(
        'mobile_header_logo',
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
            'mobile_header_logo',
            array(
                'type'        => 'image',
                'label'       => esc_html__( 'Mobile Logo', 'shopkeeper' ),
                'section'     => 'mobile_header',
                'priority'    => 10,
            )
        )
    );

    // Sticky Logo Height.
    $wp_customize->add_setting(
        'mobile_logo_height',
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
            'mobile_logo_height',
            array(
                'type'        => 'number',
                'label'       => esc_html__( 'Mobile Logo Height', 'shopkeeper' ),
                'description' => esc_html__( "(0px - 300px)", 'shopkeeper' ),
                'section'     => 'mobile_header',
                'priority'    => 10,
                'input_attrs' => array(
                    'min'  => 0,
                    'max'  => 300,
                    'step' => 1,
                ),
            )
        )
    );

    // Abort if selective refresh is not available.
    if ( ! isset( $wp_customize->selective_refresh ) ) {
        return;
    }

    $wp_customize->selective_refresh->add_partial( 'mobile_header_logo', array(
        'selector' => '.site-header .site-branding .mobile-logo',
        'settings' => 'mobile_header_logo',
        'render_callback' => function() {
            return shopkeeper_get_logo();
        },
    ) );
}
