<?php
/**
* The Header Top Bar section options.
*
* @package shopkeeper
*/

/**
 * Checks if topbar is enabled.
 */
function sk_is_topbar_enabled(){

    return Shopkeeper_Opt::getOption( 'top_bar_switch', false );
}

add_action( 'customize_register', 'shopkeeper_customizer_header_topbar_controls' );
/**
 * Adds controls for header topbar section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_header_topbar_controls( $wp_customize ) {

    // Top Bar.
    $wp_customize->add_setting(
		'top_bar_switch',
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
			'top_bar_switch',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Top Bar', 'shopkeeper' ),
				'section'  => 'top_bar',
				'priority' => 10,
			)
		)
	);

    // Top Bar Background Color.
    $wp_customize->add_setting(
        'top_bar_background_color',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'default'    => '#333333',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'top_bar_background_color',
            array(
                'label'    => esc_html__( 'Top Bar Background Color', 'shopkeeper' ),
                'section'  => 'top_bar',
                'priority' => 10,
                'active_callback' => 'sk_is_topbar_enabled',
            )
        )
    );

    // Top Bar Text Color.
    $wp_customize->add_setting(
        'top_bar_typography',
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
            'top_bar_typography',
            array(
                'label'    => esc_html__( 'Top Bar Text Color', 'shopkeeper' ),
                'section'  => 'top_bar',
                'priority' => 10,
                'active_callback' => 'sk_is_topbar_enabled',
            )
        )
    );

    // Top Bar Text.
    $wp_customize->add_setting(
		'top_bar_text',
		array(
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'shopkeeper_sanitize_html_text',
            'transport' => 'postMessage',
			'default'    => esc_html__( 'Free Shipping on All Orders Over $75!', 'shopkeeper' ),
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'top_bar_text',
			array(
				'type'        => 'textarea',
				'label'       => esc_html__( 'Top Bar Text', 'shopkeeper' ),
                'description' => esc_html__( 'Allowed HTML tags: a, abbr, acronym, b, blockquote, cite, code, del, em, i, q, s, strike, strong', 'shopkeeper' ),
				'section'     => 'top_bar',
				'priority'    => 10,
                'active_callback' => 'sk_is_topbar_enabled',
			)
		)
	);

    // Top Bar Navigation Position.
    $wp_customize->add_setting(
        'top_bar_navigation_position',
        array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'shopkeeper_sanitize_select',
            'default'           => 'right',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'top_bar_navigation_position',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Top Bar Navigation Position', 'shopkeeper' ),
                'section'  => 'top_bar',
                'priority' => 10,
                'choices'  => array(
                    'left' 		=> esc_html__( 'Left', 'shopkeeper' ),
                    'right' 	=> esc_html__( 'Right', 'shopkeeper' ),
                ),
                'active_callback' => 'sk_is_topbar_enabled',
            )
        )
    );

    // Abort if selective refresh is not available.
    if ( ! isset( $wp_customize->selective_refresh ) ) {
        return;
    }

    $wp_customize->selective_refresh->add_partial( 'top_bar_text', array(
        'selector' => '#site-top-bar .site-top-message',
        'settings' => 'top_bar_text',
        'render_callback' => function() {
            return Shopkeeper_Opt::getOption( 'top_bar_text', 'Free Shipping on All Orders Over $75!' );
        },
    ) );
}
