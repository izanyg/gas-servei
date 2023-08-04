<?php
/**
* The Footer section options.
*
* @package shopkeeper
*/

add_action( 'customize_register', 'shopkeeper_customizer_footer_controls' );
/**
 * Adds controls for footer section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_footer_controls( $wp_customize ) {

    // Footer Background Color.
    $wp_customize->add_setting(
        'footer_background_color',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'default'    => '#f4f4f4',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_background_color',
            array(
                'label'    => esc_html__( 'Footer Background Color', 'shopkeeper' ),
                'section'  => 'footer',
                'priority' => 10,
            )
        )
    );

    // Footer Text Color.
    $wp_customize->add_setting(
        'footer_texts_color',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'default'    => '#868686',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_texts_color',
            array(
                'label'    => esc_html__( 'Footer Text Color', 'shopkeeper' ),
                'section'  => 'footer',
                'priority' => 10,
            )
        )
    );

    // Footer Links Color.
    $wp_customize->add_setting(
        'footer_links_color',
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
            'footer_links_color',
            array(
                'label'    => esc_html__( 'Footer Links Color', 'shopkeeper' ),
                'section'  => 'footer',
                'priority' => 10,
            )
        )
    );

    // Copyright Footnote.
    $wp_customize->add_setting(
		'footer_copyright_text',
		array(
			'type'               => 'theme_mod',
			'capability'         => 'edit_theme_options',
            'sanitize_callback'  => 'shopkeeper_sanitize_html_text',
			'default'            => esc_html__('Powered by ', 'shopkeeper' ) . '<a href="'.SK_THEME_WEBSITE.'" title="eCommerce WordPress Theme for Woocommerce">' . esc_html__( 'Shopkeeper', 'shopkeeper' ) . '</a>.',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'footer_copyright_text',
			array(
				'type'        => 'textarea',
				'label'       => esc_html__( 'Copyright Footnote', 'shopkeeper' ),
                'description' => esc_html__( 'Allowed HTML tags: a, abbr, acronym, b, blockquote, cite, code, del, em, i, q, s, strike, strong', 'shopkeeper' ),
				'section'     => 'footer',
				'priority'    => 10,
			)
		)
	);

    // Collapsed Widget Area on Mobiles.
    $wp_customize->add_setting(
		'expandable_footer',
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
			'expandable_footer',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Collapsed Widget Area on Mobiles', 'shopkeeper' ),
				'section'  => 'footer',
				'priority' => 10,
			)
		)
	);

    // Back To Top Button.
    $wp_customize->add_setting(
		'back_to_top_button',
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
			'back_to_top_button',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Back To Top Button', 'shopkeeper' ),
				'section'  => 'footer',
				'priority' => 10,
			)
		)
	);
}
