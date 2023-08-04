<?php
/**
* The Shop Product Badges section options.
*
* @package shopkeeper
*/

/**
 * Checks if new products badge is enabled.
 */
function sk_is_new_products_badge_enabled(){

   return Shopkeeper_Opt::getOption( 'new_products_badge', false );
}

/**
 * Checks if new products badge is enabled and show by day added.
 */
function sk_is_new_products_badge_enabled_and_days() {

    return sk_is_new_products_badge_enabled() && ( 'day' === Shopkeeper_Opt::getOption( 'new_product_badge_show_by', 'day' ) );
}

/**
 * Checks if new products badge is enabled and show by last added.
 */
function sk_is_new_products_badge_enabled_and_last() {

    return sk_is_new_products_badge_enabled() && ( 'latest' === Shopkeeper_Opt::getOption( 'new_product_badge_show_by', 'day' ) );
}

add_action( 'customize_register', 'shopkeeper_customizer_shop_product_badges_controls' );
/**
 * Adds controls for shop product badges settings section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_shop_product_badges_controls( $wp_customize ) {

    // Out of Stock Badge Heading
    $wp_customize->add_setting(
        'out_of_stock_heading',
        array(
            'type'       => 'theme_mod',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'capability' => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new SK_Customize_Heading_Control(
            $wp_customize,
            'out_of_stock_heading',
            array(
                'label'    => esc_html__( 'Out of Stock Badge', 'shopkeeper' ),
                'section'  => 'product_badges',
                'priority' => 10,
            )
        )
    );

    // Out of Stock Badge Text.
    $wp_customize->add_setting(
		'out_of_stock_label',
		array(
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
			'default'    => esc_html__( 'Out of stock', 'shopkeeper' ),
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'out_of_stock_label',
			array(
				'type'        => 'text',
				'label'       => esc_attr__( '\'Out of Stock\' Badge Text', 'shopkeeper' ),
				'section'     => 'product_badges',
				'priority'    => 10,
			)
		)
	);

    // Sale Badge Heading
    $wp_customize->add_setting(
        'sale_badge_heading',
        array(
            'type'       => 'theme_mod',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'capability' => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new SK_Customize_Heading_Control(
            $wp_customize,
            'sale_badge_heading',
            array(
                'label'    => esc_html__( 'Sale Badge', 'shopkeeper' ),
                'section'  => 'product_badges',
                'priority' => 10,
            )
        )
    );

    // Sale Badge Text.
    $wp_customize->add_setting(
		'sale_label',
		array(
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
			'default'    => esc_html__( 'Sale!', 'shopkeeper' ),
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'sale_label',
			array(
				'type'        => 'text',
				'label'       => esc_attr__( '\'Sale\' Badge Text', 'shopkeeper' ),
				'section'     => 'product_badges',
				'priority'    => 10,
			)
		)
	);

    // Sale Badge Color.
    $wp_customize->add_setting(
        'sale_badge_color',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'default'    => '#93af76',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sale_badge_color',
            array(
                'label'    => esc_html__( '\'Sale\' Badge Color', 'shopkeeper' ),
                'section'  => 'product_badges',
                'priority' => 10,
            )
        )
    );

    // Sale Badge Percentage.
    $wp_customize->add_setting(
		'sale_badge_percentage',
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
			'sale_badge_percentage',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Sale Badge Percentage', 'shopkeeper' ),
				'section'  => 'product_badges',
				'priority' => 10,
			)
		)
	);

    // New Products Badge Heading
    $wp_customize->add_setting(
        'new_products_heading',
        array(
            'type'       => 'theme_mod',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'capability' => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new SK_Customize_Heading_Control(
            $wp_customize,
            'new_products_heading',
            array(
                'label'    => esc_html__( 'New Products Badge', 'shopkeeper' ),
                'section'  => 'product_badges',
                'priority' => 10,
            )
        )
    );

    // New Products Badge.
    $wp_customize->add_setting(
		'new_products_badge',
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
			'new_products_badge',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( '\'New Products\' Badge', 'shopkeeper' ),
				'section'  => 'product_badges',
				'priority' => 10,
			)
		)
	);

    // New Badge Text.
    $wp_customize->add_setting(
		'new_products_badge_label',
		array(
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
			'default'    => esc_html__( 'New!', 'shopkeeper' ),
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'new_products_badge_label',
			array(
				'type'        => 'text',
				'label'       => esc_attr__( '\'New Products\' Badge Text', 'shopkeeper' ),
				'section'     => 'product_badges',
				'priority'    => 10,
                'active_callback' => 'sk_is_new_products_badge_enabled',
			)
		)
	);

    // New Products Badge Color.
    $wp_customize->add_setting(
        'new_product_badge_color',
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
            'new_product_badge_color',
            array(
                'label'    => esc_html__( '\'New Products\' Badge Color', 'shopkeeper' ),
                'section'  => 'product_badges',
                'priority' => 10,
                'active_callback' => 'sk_is_new_products_badge_enabled',
            )
        )
    );

    // Show New Products By.
    $wp_customize->add_setting(
        'new_product_badge_show_by',
        array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'shopkeeper_sanitize_select',
            'default'           => 'day',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'new_product_badge_show_by',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Show New Products By', 'shopkeeper' ),
                'section'  => 'product_badges',
                'priority' => 10,
                'choices'  => array(
                    'day'       => esc_html__( 'Day Added', 'shopkeeper' ),
                    'latest'    => esc_html__( 'Last Added', 'shopkeeper' ),
                ),
                'active_callback' => 'sk_is_new_products_badge_enabled',
            )
        )
    );

    // Show products added in the past x days.
    $wp_customize->add_setting(
        'new_product_badge_x_days',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
            'default'    => 8,
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'new_product_badge_x_days',
            array(
                'type'        => 'number',
                'label'       => esc_html__( 'Show Products Added In The Past x Days:', 'shopkeeper' ),
                'section'     => 'product_badges',
                'priority'    => 10,
                'input_attrs' => array(
                    'min'  => 1,
                    'max'  => 60,
                    'step' => 1,
                ),
                'active_callback' => 'sk_is_new_products_badge_enabled_and_days',
            )
        )
    );

    // Show products added in the past x days.
    $wp_customize->add_setting(
        'new_product_badge_x_last',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
            'default'    => 8,
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'new_product_badge_x_last',
            array(
                'type'        => 'number',
                'label'       => esc_html__( 'Show Last x Products:', 'shopkeeper' ),
                'section'     => 'product_badges',
                'priority'    => 10,
                'input_attrs' => array(
                    'min'  => 1,
                    'max'  => 60,
                    'step' => 1,
                ),
                'active_callback' => 'sk_is_new_products_badge_enabled_and_last',
            )
        )
    );
}
