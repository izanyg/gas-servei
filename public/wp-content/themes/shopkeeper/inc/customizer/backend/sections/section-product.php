<?php
/**
* Product options.
*
* @package shopkeeper
*/

/**
 * Checks if related products are enabled.
 */
function sk_is_related_products(){

    return Shopkeeper_Opt::getOption( 'related_products', true );
}

add_action( 'customize_register', 'shopkeeper_customizer_product_controls' );
/**
 * Adds controls for product section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_product_controls( $wp_customize ) {

    // Product Page Layout.
    $wp_customize->add_setting(
        'product_layout',
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
            'product_layout',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Product Page Layout', 'shopkeeper' ),
                'section'  => 'product',
                'priority' => 10,
                'choices'  => array(
                    'default'    => esc_html__( 'Layout 1', 'shopkeeper' ),
                    'style_2'    => esc_html__( 'Layout 2', 'shopkeeper' ),
                    'style_3'    => esc_html__( 'Layout 3', 'shopkeeper' ),
                    'style_4'    => esc_html__( 'Layout 4', 'shopkeeper' ),
                ),
            )
        )
    );

    // Product Quantity Style.
    $wp_customize->add_setting(
        'product_quantity_style',
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
            'product_quantity_style',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Product Quantity Style', 'shopkeeper' ),
                'section'  => 'product',
                'priority' => 10,
                'choices'  => array(
                    'default' => esc_html__( 'Style 1 — Numeric Field', 'shopkeeper' ),
                    'custom'  => esc_html__( 'Style 2 — Increment -/+', 'shopkeeper' ),
                ),
            )
        )
    );

    // Product Gallery Zoom.
    $wp_customize->add_setting(
		'product_gallery_zoom',
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
			'product_gallery_zoom',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Product Gallery Zoom', 'shopkeeper' ),
				'section'  => 'product',
				'priority' => 10,
			)
		)
	);

    // Product Gallery Lightbox.
    $wp_customize->add_setting(
		'product_gallery_lightbox',
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
			'product_gallery_lightbox',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Product Gallery Lightbox', 'shopkeeper' ),
				'section'  => 'product',
				'priority' => 10,
			)
		)
	);

    // Related Products.
    $wp_customize->add_setting(
		'related_products',
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
			'related_products',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Related Products', 'shopkeeper' ),
				'section'  => 'product',
				'priority' => 10,
			)
		)
	);

    // Number of Related Products.
    $wp_customize->add_setting(
        'related_products_number',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
            'default'    => 4,
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'related_products_number',
            array(
                'type'        => 'number',
                'label'       => esc_html__( 'Number of Related Products', 'shopkeeper' ),
                'description' => esc_html__( "(2 - 6)", 'shopkeeper' ),
                'section'     => 'product',
                'priority'    => 10,
                'input_attrs' => array(
                    'min'  => 2,
                    'max'  => 6,
                    'step' => 1,
                ),
                'active_callback' => 'sk_is_related_products'
            )
        )
    );

    // Next/Prev Product.
    $wp_customize->add_setting(
		'product_navigation',
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
			'product_navigation',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Next/Prev Product', 'shopkeeper' ),
				'section'  => 'product',
				'priority' => 10,
			)
		)
	);

    // Review Tab.
    $wp_customize->add_setting(
		'review_tab',
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
			'review_tab',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Review Tab', 'shopkeeper' ),
				'section'  => 'product',
				'priority' => 10,
			)
		)
	);

    // AJAX Add to Cart.
    $wp_customize->add_setting(
		'ajax_add_to_cart',
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
			'ajax_add_to_cart',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'AJAX Add to Cart', 'shopkeeper' ),
				'section'  => 'product',
				'priority' => 10,
                'description' => wp_kses_post( __('<div class="ajax_add_to_cart_description"><span class="dashicons dashicons-editor-help"></span>The option is available ONLY for simple products.</div><div class="ajax-error"><span class="dashicons dashicons-warning"></span>Functionality turned off automatically due to incompatibility with one of the following plugins:<ul><li class="woo-bundles">WooCommerce Product Bundles</li><li class="woo-addons">WooCommerce Product Add-Ons</li><li class="m-price-calculator">WooCommerce Measurement Price Calculator</li><li class="fields-factory">WooCommerce Fields Factory</li><li class="gift-card">WooCommerce Gift Card</li><li class="gift-wrapper">WooCommerce Gift Wrapper</li></ul></div>', 'shopkeeper') ),
			)
		)
	);

    // Disable Out of Stock Variations.
    $wp_customize->add_setting(
		'disabled_outofstock_variations',
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
			'disabled_outofstock_variations',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Disable Out of Stock Variations', 'shopkeeper' ),
				'section'  => 'product',
				'priority' => 10,
                'description' => wp_kses_post( __("<span class='dashicons dashicons-editor-help'></span>The variations will be disabled in the attribute's options list.", 'shopkeeper') ),
			)
		)
	);
}
