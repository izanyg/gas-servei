<?php
/**
* Fonts section options.
*
* @package shopkeeper
*/

/**
 * Checks if Adobe Typekit fonts is enabled.
 */
function sk_typekit_is_adobe_font(){
    return ( 'adobe' === Shopkeeper_Opt::getOption( 'main_font_source', 'default' ) ||
        'adobe' === Shopkeeper_Opt::getOption( 'secondary_font_source', 'default' ) );
}

/**
 * Checks if main font source is theme defaults.
 */
function sk_main_font_source_theme_font() {
    return ( 'default' === Shopkeeper_Opt::getOption( 'main_font_source', 'default' ) );
}

/**
 * Checks if main font source is google fonts.
 */
function sk_main_font_source_google_font() {
    return ( 'google' === Shopkeeper_Opt::getOption( 'main_font_source', 'default' ) );
}

/**
 * Checks if main font source is web safe fonts.
 */
function sk_main_font_source_web_font() {
    return ( 'web-safe' === Shopkeeper_Opt::getOption( 'main_font_source', 'default' ) );
}

/**
 * Checks if main font source is custom fonts.
 */
function sk_main_font_source_custom_font() {
    return ( 'custom' === Shopkeeper_Opt::getOption( 'main_font_source', 'default' ) );
}

/**
 * Checks if main font source is adobe typekit fonts.
 */
function sk_main_font_source_adobe_font() {
    return ( 'adobe' === Shopkeeper_Opt::getOption( 'main_font_source', 'default' ) );
}

/**
 * Checks if secondary font source is theme defaults.
 */
function sk_secondary_font_source_theme_font() {
    return ( 'default' === Shopkeeper_Opt::getOption( 'secondary_font_source', 'default' ) );
}

/**
 * Checks if secondary font source is google fonts.
 */
function sk_secondary_font_source_google_font() {
    return ( 'google' === Shopkeeper_Opt::getOption( 'secondary_font_source', 'default' ) );
}

/**
 * Checks if secondary font source is web safe fonts.
 */
function sk_secondary_font_source_web_font() {
    return ( 'web-safe' === Shopkeeper_Opt::getOption( 'secondary_font_source', 'default' ) );
}

/**
 * Checks if secondary font source is custom fonts.
 */
function sk_secondary_font_source_custom_font() {
    return ( 'custom' === Shopkeeper_Opt::getOption( 'secondary_font_source', 'default' ) );
}

/**
 * Checks if secondary font source is adobe typekit fonts.
 */
function sk_secondary_font_source_adobe_font() {
    return ( 'adobe' === Shopkeeper_Opt::getOption( 'secondary_font_source', 'default' ) );
}

add_action( 'customize_register', 'shopkeeper_customizer_fonts_controls' );
/**
 * Adds controls for fonts section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_fonts_controls( $wp_customize ) {

    // Display swap.
    $wp_customize->add_setting(
        'default_fonts_fontface_display',
        array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'shopkeeper_sanitize_select',
            'default'           => 'swap',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'default_fonts_fontface_display',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Font Display', 'shopkeeper' ),
                'section'  => 'fonts',
                'description' => '<ul><li>'.esc_html__( 'Swap - uses fallback font until the fonts area loaded', 'shopkeeper' ).'</li><li>'.esc_html__( 'Block - briefly hides the text until the font is fully loaded', 'shopkeeper' ).'</li></ul>',
                'priority' => 10,
                'choices'  => array(
                    'swap'       => esc_html__( 'Use fallback font (swap)', 'shopkeeper' ),
                    'block'        => esc_html__( 'Hide text while loading (block)', 'shopkeeper' ),
                ),
            )
        )
    );

    // Typekit Kit ID.
    $wp_customize->add_setting(
        'adobe_typekit_kit_id',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'default'    => '',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'adobe_typekit_kit_id',
            array(
                'type'     => 'text',
                'label'    => esc_html__( 'Adobe Typekit Kit ID', 'shopkeeper' ),
                'description'   => esc_html__( 'Paste the provided Adobe Typekit Kit ID.', 'shopkeeper'),
                'section'  => 'fonts',
                'priority' => 10,
                'active_callback' => 'sk_typekit_is_adobe_font'
            )
        )
    );

	// Headings Font Heading
    $wp_customize->add_setting(
        'main_font_heading',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
        )
    );

    $wp_customize->add_control(
        new SK_Customize_Heading_Control(
            $wp_customize,
            'main_font_heading',
            array(
                'label'    => esc_html__( 'Titles & Headings', 'shopkeeper' ),
                'section'  => 'fonts',
                'priority' => 10,
            )
        )
    );

    // Main Font Source
    $wp_customize->add_setting(
        'main_font_source',
        array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'shopkeeper_sanitize_select',
            'default'           => 'default',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'main_font_source',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Headings Font Source', 'shopkeeper' ),
                'section'  => 'fonts',
                'priority' => 10,
                'choices'  => array(
                    'default'       => esc_html__( 'Theme Defaults', 'shopkeeper' ),
                    'google'        => esc_html__( 'Google Fonts', 'shopkeeper' ),
                    'web-safe'      => esc_html__( 'Web Safe Fonts', 'shopkeeper' ),
                    'custom'        => esc_html__( 'Custom Fonts', 'shopkeeper' ),
                    'adobe'         => esc_html__( 'Adobe TypeKit Fonts', 'shopkeeper' ),
                ),
            )
        )
    );

    // Theme Default Main Font.
	$wp_customize->add_setting(
		'main_font_default',
		array(
			'default' 			=> 'NeueEinstellung',
			'capability' 		=> 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'type'				=> 'theme_mod',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'main_font_default',
			array(
				'type'			=> 'text',
				'label' 		=> __( 'Headings Font', 'shopkeeper' ),
				'description'	=> Shopkeeper_Fonts::get_defaults_suggested_fonts_list(),
				'section' 		=> 'fonts',
				'input_attrs' 	=> array(
					'placeholder' 		=> __( 'Enter the font name', 'shopkeeper' ),
					'class'				=> 'shopkeeper-font-suggestions',
					'list'  			=> 'shopkeeper-suggested-default-fonts',
					'autocapitalize'	=> 'off',
					'autocomplete'		=> 'off',
					'autocorrect'		=> 'off',
					'spellcheck'		=> 'false',
				),
                'active_callback' => 'sk_main_font_source_theme_font',
			)
		)
	);

    // Google Main Font.
	$wp_customize->add_setting(
		'main_font_google',
		array(
			'default' 			=> 'Roboto',
			'capability' 		=> 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'type'				=> 'theme_mod',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'main_font_google',
			array(
				'type'			=> 'text',
				'label' 		=> __( 'Headings Font', 'shopkeeper' ),
				'description'	=> Shopkeeper_Fonts::get_google_suggested_fonts_list() . 'Shopkeeper supports all fonts on <a href="'.SK_GOOGLE_FONTS_WEBSITE.'" target="_blank">Google Fonts</a>.',
				'section' 		=> 'fonts',
				'input_attrs' 	=> array(
					'placeholder' 		=> __( 'Enter the font name', 'shopkeeper' ),
					'class'				=> 'shopkeeper-font-suggestions',
					'list'  			=> 'shopkeeper-suggested-google-fonts',
					'autocapitalize'	=> 'off',
					'autocomplete'		=> 'off',
					'autocorrect'		=> 'off',
					'spellcheck'		=> 'false',
				),
                'active_callback' => 'sk_main_font_source_google_font',
			)
		)
	);

    // Web Safe Main Font.
    $wp_customize->add_setting(
        'main_font_web_safe',
        array(
            'default' 			=> 'Arial',
            'capability' 		=> 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'type'				=> 'theme_mod',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'main_font_web_safe',
            array(
                'type'			=> 'text',
                'label' 		=> __( 'Headings Font', 'shopkeeper' ),
                'description'	=> Shopkeeper_Fonts::get_web_safe_suggested_fonts_list() . 'Shopkeeper supports all <a href="'.SK_SAFE_FONTS_WEBSITE.'" target="_blank">web safe fonts</a>.',
                'section' 		=> 'fonts',
                'input_attrs' 	=> array(
                    'placeholder' 		=> __( 'Enter the font name', 'shopkeeper' ),
                    'class'				=> 'shopkeeper-font-suggestions',
                    'list'  			=> 'shopkeeper-suggested-web-fonts',
                    'autocapitalize'	=> 'off',
                    'autocomplete'		=> 'off',
                    'autocorrect'		=> 'off',
                    'spellcheck'		=> 'false',
                ),
                'active_callback' => 'sk_main_font_source_web_font',
            )
        )
    );

    // Custom Main Font.
    $wp_customize->add_setting(
        'main_font_custom',
        array(
            'default' 			=> '',
            'capability' 		=> 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'type'				=> 'theme_mod',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'main_font_custom',
            array(
                'type'			=> 'text',
                'label' 		=> __( 'Headings Font', 'shopkeeper' ),
                'section' 		=> 'fonts',
                'input_attrs' 	=> array(
                    'placeholder' 		=> __( 'Enter the font name', 'shopkeeper' ),
                    'autocapitalize'	=> 'off',
                    'autocomplete'		=> 'off',
                    'autocorrect'		=> 'off',
                    'spellcheck'		=> 'false',
                ),
                'active_callback' => 'sk_main_font_source_custom_font',
            )
        )
    );

    // Adobe Main Font.
    $wp_customize->add_setting(
        'main_font_adobe',
        array(
            'default' 			=> '',
            'capability' 		=> 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'type'				=> 'theme_mod',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'main_font_adobe',
            array(
                'type'			=> 'text',
                'label' 		=> __( 'Headings Font', 'shopkeeper' ),
                'section' 		=> 'fonts',
                'input_attrs' 	=> array(
                    'placeholder' 		=> __( 'Enter the font name', 'shopkeeper' ),
                    'autocapitalize'	=> 'off',
                    'autocomplete'		=> 'off',
                    'autocorrect'		=> 'off',
                    'spellcheck'		=> 'false',
                ),
                'active_callback' => 'sk_main_font_source_adobe_font',
            )
        )
    );

    // Headings Font Size (px).
    $wp_customize->add_setting(
        'headings_font_size',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
            'default'    => 23,
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'headings_font_size',
            array(
                'type'        => 'number',
                'label'       => esc_html__( 'Headings Font Size', 'shopkeeper' ),
				'description' => esc_html__( "(16px - 40px)", 'shopkeeper' ),
                'section'     => 'fonts',
                'priority'    => 10,
                'input_attrs' => array(
                    'min'  => 16,
                    'max'  => 40,
                    'step' => 1,
                ),
            )
        )
    );

	// Body Font Heading
    $wp_customize->add_setting(
        'secondary_font_heading',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
        )
    );

    $wp_customize->add_control(
        new SK_Customize_Heading_Control(
            $wp_customize,
            'secondary_font_heading',
            array(
                'label'    => esc_html__( 'Body Font', 'shopkeeper' ),
                'section'  => 'fonts',
                'priority' => 10,
            )
        )
    );

    // Secondary Font Source
    $wp_customize->add_setting(
        'secondary_font_source',
        array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'shopkeeper_sanitize_select',
            'default'           => 'default',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'secondary_font_source',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Body Font Source', 'shopkeeper' ),
                'section'  => 'fonts',
                'priority' => 10,
                'choices'  => array(
                    'default'       => esc_html__( 'Theme Defaults', 'shopkeeper' ),
                    'google'        => esc_html__( 'Google Fonts', 'shopkeeper' ),
                    'web-safe'      => esc_html__( 'Web Safe Fonts', 'shopkeeper' ),
                    'custom'        => esc_html__( 'Custom Fonts', 'shopkeeper' ),
                    'adobe'         => esc_html__( 'Adobe TypeKit Fonts', 'shopkeeper' ),
                ),
            )
        )
    );

    // Theme Default Secondary Font.
	$wp_customize->add_setting(
		'secondary_font_default',
		array(
			'default' 			=> 'Radnika',
			'capability' 		=> 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'type'				=> 'theme_mod',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'secondary_font_default',
			array(
				'type'			=> 'text',
				'label' 		=> __( 'Body Font', 'shopkeeper' ),
				'description'	=> Shopkeeper_Fonts::get_defaults_suggested_fonts_list(),
				'section' 		=> 'fonts',
				'input_attrs' 	=> array(
					'placeholder' 		=> __( 'Enter the font name', 'shopkeeper' ),
					'class'				=> 'shopkeeper-font-suggestions',
					'list'  			=> 'shopkeeper-suggested-default-fonts',
					'autocapitalize'	=> 'off',
					'autocomplete'		=> 'off',
					'autocorrect'		=> 'off',
					'spellcheck'		=> 'false',
				),
                'active_callback' => 'sk_secondary_font_source_theme_font',
			)
		)
	);

    // Google Secondary Font.
	$wp_customize->add_setting(
		'secondary_font_google',
		array(
			'default' 			=> 'Roboto',
			'capability' 		=> 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'type'				=> 'theme_mod',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'secondary_font_google',
			array(
				'type'			=> 'text',
				'label' 		=> __( 'Body Font', 'shopkeeper' ),
				'description'	=> Shopkeeper_Fonts::get_google_suggested_fonts_list() . 'Shopkeeper supports all fonts on <a href="'.SK_GOOGLE_FONTS_WEBSITE.'" target="_blank">Google Fonts</a>.',
				'section' 		=> 'fonts',
				'input_attrs' 	=> array(
					'placeholder' 		=> __( 'Enter the font name', 'shopkeeper' ),
					'class'				=> 'shopkeeper-font-suggestions',
					'list'  			=> 'shopkeeper-suggested-google-fonts',
					'autocapitalize'	=> 'off',
					'autocomplete'		=> 'off',
					'autocorrect'		=> 'off',
					'spellcheck'		=> 'false',
				),
                'active_callback' => 'sk_secondary_font_source_google_font',
			)
		)
	);

    // Web Safe Secondary Font.
    $wp_customize->add_setting(
        'secondary_font_web_safe',
        array(
            'default' 			=> 'Arial',
            'capability' 		=> 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'type'				=> 'theme_mod',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'secondary_font_web_safe',
            array(
                'type'			=> 'text',
                'label' 		=> __( 'Body Font', 'shopkeeper' ),
                'description'	=> Shopkeeper_Fonts::get_web_safe_suggested_fonts_list() . 'Shopkeeper supports all <a href="'.SK_SAFE_FONTS_WEBSITE.'" target="_blank">web safe fonts</a>.',
                'section' 		=> 'fonts',
                'input_attrs' 	=> array(
                    'placeholder' 		=> __( 'Enter the font name', 'shopkeeper' ),
                    'class'				=> 'shopkeeper-font-suggestions',
                    'list'  			=> 'shopkeeper-suggested-web-fonts',
                    'autocapitalize'	=> 'off',
                    'autocomplete'		=> 'off',
                    'autocorrect'		=> 'off',
                    'spellcheck'		=> 'false',
                ),
                'active_callback' => 'sk_secondary_font_source_web_font',
            )
        )
    );

    // Custom Secondary Font.
    $wp_customize->add_setting(
        'secondary_font_custom',
        array(
            'default' 			=> '',
            'capability' 		=> 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'type'				=> 'theme_mod',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'secondary_font_custom',
            array(
                'type'			=> 'text',
                'label' 		=> __( 'Body Font', 'shopkeeper' ),
                'section' 		=> 'fonts',
                'input_attrs' 	=> array(
                    'placeholder' 		=> __( 'Enter the font name', 'shopkeeper' ),
                    'autocapitalize'	=> 'off',
                    'autocomplete'		=> 'off',
                    'autocorrect'		=> 'off',
                    'spellcheck'		=> 'false',
                ),
                'active_callback' => 'sk_secondary_font_source_custom_font',
            )
        )
    );

    // Adobe Secondary Font.
    $wp_customize->add_setting(
        'secondary_font_adobe',
        array(
            'default' 			=> '',
            'capability' 		=> 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'type'				=> 'theme_mod',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'secondary_font_adobe',
            array(
                'type'			=> 'text',
                'label' 		=> __( 'Body Font', 'shopkeeper' ),
                'section' 		=> 'fonts',
                'input_attrs' 	=> array(
                    'placeholder' 		=> __( 'Enter the font name', 'shopkeeper' ),
                    'autocapitalize'	=> 'off',
                    'autocomplete'		=> 'off',
                    'autocorrect'		=> 'off',
                    'spellcheck'		=> 'false',
                ),
                'active_callback' => 'sk_secondary_font_source_adobe_font',
            )
        )
    );

    // Body Font Size (px).
    $wp_customize->add_setting(
        'body_font_size',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
            'default'    => 16,
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'body_font_size',
            array(
                'type'        => 'number',
                'label'       => esc_html__( 'Body Font Size', 'shopkeeper' ),
				'description' => esc_html__( "(12px - 20px)", 'shopkeeper' ),
                'section'     => 'fonts',
                'priority'    => 10,
                'input_attrs' => array(
                    'min'  => 12,
                    'max'  => 20,
                    'step' => 1,
                ),
            )
        )
    );
}
