<?php
/**
* The Styling section options.
*
* @package shopkeeper
*/

/**
 * Checks if body background image is set.
 */
function sk_body_background_image(){
   if( '' != Shopkeeper_Opt::getOption( 'main_background_image', '' ) ) {
       return true;
   }
   return false;
}

add_action( 'customize_register', 'shopkeeper_customizer_styling_controls' );
/**
 * Adds controls for styling section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_styling_controls( $wp_customize ) {

    // Smooth Transition Between Pages.
    $wp_customize->add_setting(
		'smooth_transition_between_pages',
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
			'smooth_transition_between_pages',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Smooth Transition Between Pages', 'shopkeeper' ),
				'section'  => 'styling',
				'priority' => 10,
			)
		)
	);

    // Body Text Color.
    $wp_customize->add_setting(
        'body_color',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'default'    => '#545454',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'body_color',
            array(
                'label'    => esc_html__( 'Body Text Color', 'shopkeeper' ),
                'section'  => 'styling',
                'priority' => 10,
            )
        )
    );

    // Headings Color.
    $wp_customize->add_setting(
        'headings_color',
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
            'headings_color',
            array(
                'label'    => esc_html__( 'Headings Color', 'shopkeeper' ),
                'section'  => 'styling',
                'priority' => 10,
            )
        )
    );

    // Accent Color.
    $wp_customize->add_setting(
        'main_color',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'default'    => '#EC7A5C',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'main_color',
            array(
                'label'    => esc_html__( 'Accent Color', 'shopkeeper' ),
                'section'  => 'styling',
                'priority' => 10,
            )
        )
    );

    // Body Background Color.
    $wp_customize->add_setting(
        'main_background_color',
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
            'main_background_color',
            array(
                'label'    => esc_html__( 'Body Background Color', 'shopkeeper' ),
                'section'  => 'styling',
                'priority' => 10,
            )
        )
    );

    // Body Background Image.
    $wp_customize->add_setting(
        'main_background_image',
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
            'main_background_image',
            array(
                'type'        => 'image',
                'label'       => esc_html__( 'Body Background', 'shopkeeper' ),
                'section'     => 'styling',
                'priority'    => 10,
            )
        )
    );

    // Header Background Image Repeat.
    $wp_customize->add_setting(
        'main_background_image_repeat',
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
            'main_background_image_repeat',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Background Repeat', 'shopkeeper' ),
                'section'  => 'styling',
                'priority' => 10,
                'choices'  => array(
                    'no-repeat'  => esc_html__( 'No Repeat', 'shopkeeper' ),
                    'repeat'     => esc_html__( 'Repeat All', 'shopkeeper' ),
                    'repeat-x'   => esc_html__( 'Repeat Horizontally', 'shopkeeper' ),
                    'repeat-y'   => esc_html__( 'Repeat Vertically', 'shopkeeper' ),
                ),
                'active_callback' => 'sk_body_background_image',
            )
        )
    );

    // Header Background Image Position.
    $wp_customize->add_setting(
        'main_background_image_position',
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
            'main_background_image_position',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Background Position', 'shopkeeper' ),
                'section'  => 'styling',
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
                'active_callback' => 'sk_body_background_image',
            )
        )
    );

    // Header Background Image Size.
    $wp_customize->add_setting(
        'main_background_image_size',
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
            'main_background_image_size',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Background Size', 'shopkeeper' ),
                'section'  => 'styling',
                'priority' => 10,
                'choices'  => array(
                    'cover'      => esc_html__( 'Cover', 'shopkeeper' ),
                    'contain'    => esc_html__( 'Contain', 'shopkeeper' ),
                    'auto'       => esc_html__( 'Auto', 'shopkeeper' ),
                ),
                'active_callback' => 'sk_body_background_image',
            )
        )
    );

    // Header Background Image Attachment.
    $wp_customize->add_setting(
        'main_background_image_attachment',
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
            'main_background_image_attachment',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Background Attachment', 'shopkeeper' ),
                'section'  => 'styling',
                'priority' => 10,
                'choices'  => array(
                    'scroll'   => esc_html__( 'Scroll', 'shopkeeper' ),
                    'fixed'    => esc_html__( 'Fixed', 'shopkeeper' ),
                ),
                'active_callback' => 'sk_body_background_image',
            )
        )
    );

    // Off-Canvas Background Color.
    $wp_customize->add_setting(
        'offcanvas_bg_color',
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
            'offcanvas_bg_color',
            array(
                'label'    => esc_html__( 'Off-Canvas Background Color', 'shopkeeper' ),
                'section'  => 'styling',
                'priority' => 10,
            )
        )
    );

    // Off-Canvas Headings Color.
    $wp_customize->add_setting(
        'offcanvas_headings_color',
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
            'offcanvas_headings_color',
            array(
                'label'    => esc_html__( 'Off-Canvas Headings Color', 'shopkeeper' ),
                'section'  => 'styling',
                'priority' => 10,
            )
        )
    );

    // Off-Canvas Text Color.
    $wp_customize->add_setting(
        'offcanvas_text_color',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'default'    => '#545454',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'offcanvas_text_color',
            array(
                'label'    => esc_html__( 'Off-Canvas Text Color', 'shopkeeper' ),
                'section'  => 'styling',
                'priority' => 10,
            )
        )
    );
}
