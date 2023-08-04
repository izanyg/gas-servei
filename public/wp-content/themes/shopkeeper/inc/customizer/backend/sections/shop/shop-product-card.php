<?php
/**
* The Shop Product Card section options.
*
* @package shopkeeper
*/

add_action( 'customize_register', 'shopkeeper_customizer_shop_product_card_controls' );
/**
 * Adds controls for shop product card section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_shop_product_card_controls( $wp_customize ) {

    // Second Product Image on Hover.
    $wp_customize->add_setting(
		'second_image_product_listing',
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
			'second_image_product_listing',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Second Product Image on Hover', 'shopkeeper' ),
				'section'  => 'product_card',
				'priority' => 10,
			)
		)
	);

    // Rating Stars.
    $wp_customize->add_setting(
		'ratings_catalog_page',
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
			'ratings_catalog_page',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Rating Stars', 'shopkeeper' ),
				'section'  => 'product_card',
				'priority' => 10,
			)
		)
	);

    // Quick View.
    $wp_customize->add_setting(
		'quick_view',
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
			'quick_view',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Quick View', 'shopkeeper' ),
				'section'  => 'product_card',
				'priority' => 10,
			)
		)
	);

    // Product Title Font Size (px).
    $wp_customize->add_setting(
        'product_title_font_size',
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
            'product_title_font_size',
            array(
                'type'        => 'number',
                'label'       => esc_html__( 'Product Title Font Size', 'shopkeeper' ),
                'description' => esc_html__( "(10px - 24px)", 'shopkeeper' ),
                'section'     => 'product_card',
                'priority'    => 10,
                'input_attrs' => array(
                    'min'  => 10,
                    'max'  => 24,
                    'step' => 1,
                ),
            )
        )
    );

    // Add to Cart Button Display.
    $wp_customize->add_setting(
        'add_to_cart_display',
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
            'add_to_cart_display',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Add to Cart Button Display', 'shopkeeper' ),
                'section'  => 'product_card',
                'priority' => 10,
                'choices'  => array(
                    '1' => esc_html__( 'When Hovering', 'shopkeeper' ),
                    '0' => esc_html__( 'At all Times', 'shopkeeper' ),
                ),
            )
        )
    );
}
