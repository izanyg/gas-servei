<?php
/**
* The Shop Layout section options.
*
* @package shopkeeper
*/

/**
 * Checks if category style is grid.
 */
function sk_category_is_grid_style(){
   if( 'styled_grid' === Shopkeeper_Opt::getOption( 'category_style', 'styled_grid' ) ) {
       return true;
   }
   return false;
}

add_action( 'customize_register', 'shopkeeper_customizer_shop_layout_controls' );
/**
 * Adds controls for shop layout section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_shop_layout_controls( $wp_customize ) {

    // Breadcrumbs.
    $wp_customize->add_setting(
        'breadcrumbs',
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
            'breadcrumbs',
            array(
                'type'     => 'checkbox',
                'label'    => esc_html__( 'Breadcrumbs', 'shopkeeper' ),
                'section'  => 'woocommerce_product_catalog',
                'priority' => 11,
            )
        )
    );

    // Product Count.
    $wp_customize->add_setting(
        'archive_product_count',
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
            'archive_product_count',
            array(
                'type'     => 'checkbox',
                'label'    => esc_html__( 'Product Count', 'shopkeeper' ),
                'section'  => 'woocommerce_product_catalog',
                'priority' => 11,
            )
        )
    );

    // Sidebar Style.
    $wp_customize->add_setting(
        'sidebar_style',
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
            'sidebar_style',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Sidebar Style', 'shopkeeper' ),
                'section'  => 'woocommerce_product_catalog',
                'priority' => 11,
                'choices'  => array(
                    '0'     => esc_html__( 'On Page', 'shopkeeper' ),
                    '1'     => esc_html__( 'Off-Canvas', 'shopkeeper' ),
                ),
            )
        )
    );

    // Pagination Style.
    $wp_customize->add_setting(
        'pagination_shop',
        array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'shopkeeper_sanitize_select',
            'default'           => 'infinite_scroll',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'pagination_shop',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Pagination Style', 'shopkeeper' ),
                'section'  => 'woocommerce_product_catalog',
                'priority' => 11,
                'choices'  => array(
                    'classic'           => esc_html__( 'Classic', 'shopkeeper' ),
                    'load_more_button'  => esc_html__( 'Load More', 'shopkeeper' ),
                    'infinite_scroll'   => esc_html__( 'Infinite', 'shopkeeper' ),
                ),
            )
        )
    );

    // Category Display Style.
    $wp_customize->add_setting(
        'category_style',
        array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'shopkeeper_sanitize_select',
            'default'           => 'styled_grid',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'category_style',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Category Display Style', 'shopkeeper' ),
                'section'  => 'woocommerce_product_catalog',
                'priority' => 11,
                'choices'  => array(
                    'styled_grid'   => esc_html__( 'Categories Grid', 'shopkeeper' ),
                    'original_grid' => esc_html__( 'Thumbs', 'shopkeeper' ),
                ),
            )
        )
    );

    // Display Number of Products on Categories Grid.
    $wp_customize->add_setting(
        'categories_grid_count',
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
            'categories_grid_count',
            array(
                'type'     => 'checkbox',
                'label'    => esc_html__( 'Display Number of Products on Categories Grid', 'shopkeeper' ),
                'section'  => 'woocommerce_product_catalog',
                'priority' => 11,
                'active_callback' => 'sk_category_is_grid_style'
            )
        )
    );

    // Hide empty categories.
    $wp_customize->add_setting(
        'hide_empty_categories',
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
            'hide_empty_categories',
            array(
                'type'     => 'checkbox',
                'label'    => esc_html__( 'Hide empty categories', 'shopkeeper' ),
                'section'  => 'woocommerce_product_catalog',
                'priority' => 11,
            )
        )
    );
}
