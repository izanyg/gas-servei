<?php
/**
* The Header Elements section options.
*
* @package shopkeeper
*/

/**
 * Checks if minicart is enabled.
 */
function sk_minicart_enabled(){
   if( sk_shopping_cart_icon_enabled() && '1' === Shopkeeper_Opt::getOption( 'option_minicart', '1' ) ) {
       return true;
   }
   return false;
}

/**
 * Checks if wishlist icon is enabled.
 */
function sk_wishlist_icon_enabled(){

    return Shopkeeper_Opt::getOption( 'main_header_wishlist', true );
}

/**
 * Checks if shopping cart icon is enabled.
 */
function sk_shopping_cart_icon_enabled(){

    return Shopkeeper_Opt::getOption( 'main_header_shopping_bag', true );
}

/**
 * Checks if my account icon is enabled.
 */
function sk_account_icon_enabled(){

    return Shopkeeper_Opt::getOption( 'my_account_icon_state', true );
}

/**
 * Checks if search icon is enabled.
 */
function sk_search_icon_enabled(){

    return Shopkeeper_Opt::getOption( 'main_header_search_bar', true );
}

/**
 * Checks if offcanvas icon is enabled.
 */
function sk_offcanvas_icon_enabled(){

    return Shopkeeper_Opt::getOption( 'main_header_off_canvas', false );
}

add_action( 'customize_register', 'shopkeeper_customizer_header_elements_controls' );
/**
 * Adds controls for header elements section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_header_elements_controls( $wp_customize ) {

    if( SHOPKEEPER_WISHLIST_IS_ACTIVE ) {
        // Wishlist Heading
        $wp_customize->add_setting(
            'main_header_wishlist_heading',
            array(
                'type'       => 'theme_mod',
                'sanitize_callback' => 'wp_filter_nohtml_kses',
                'capability' => 'edit_theme_options',
            )
        );

        $wp_customize->add_control(
            new SK_Customize_Heading_Control(
                $wp_customize,
                'main_header_wishlist_heading',
                array(
                    'label'    => esc_html__( 'Wishlist', 'shopkeeper' ),
                    'section'  => 'header_elements',
                    'priority' => 10,
                )
            )
        );

        // Wishlist icon.
        $wp_customize->add_setting(
    		'main_header_wishlist',
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
    			'main_header_wishlist',
    			array(
    				'type'     => 'checkbox',
    				'label'    => esc_html__( 'Wishlist Icon', 'shopkeeper' ),
    				'section'  => 'header_elements',
    				'priority' => 10,
    			)
    		)
    	);

        // Custom Wishlist Icon.
        $wp_customize->add_setting(
            'main_header_wishlist_icon',
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
                'main_header_wishlist_icon',
                array(
                    'type'        => 'image',
                    'label'       => esc_html__( 'Custom Wishlist Icon', 'shopkeeper' ),
                    'section'     => 'header_elements',
                    'priority'    => 10,
                    'active_callback' => 'sk_wishlist_icon_enabled',
                )
            )
        );
    }

    if( SHOPKEEPER_WOOCOMMERCE_IS_ACTIVE ) {
        // Shopping Cart Heading
        $wp_customize->add_setting(
            'main_header_shopping_cart_heading',
            array(
                'type'       => 'theme_mod',
                'sanitize_callback' => 'wp_filter_nohtml_kses',
                'capability' => 'edit_theme_options',
            )
        );

        $wp_customize->add_control(
            new SK_Customize_Heading_Control(
                $wp_customize,
                'main_header_shopping_cart_heading',
                array(
                    'label'    => esc_html__( 'Shopping Cart', 'shopkeeper' ),
                    'section'  => 'header_elements',
                    'priority' => 10,
                )
            )
        );

        // Shopping Cart Icon.
        $wp_customize->add_setting(
    		'main_header_shopping_bag',
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
    			'main_header_shopping_bag',
    			array(
    				'type'     => 'checkbox',
    				'label'    => esc_html__( 'Shopping Cart Icon', 'shopkeeper' ),
    				'section'  => 'header_elements',
    				'priority' => 10,
    			)
    		)
    	);

        // Custom Shopping Cart Icon.
        $wp_customize->add_setting(
            'main_header_shopping_bag_icon',
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
                'main_header_shopping_bag_icon',
                array(
                    'type'        => 'image',
                    'label'       => esc_html__( 'Custom Shopping Cart Icon', 'shopkeeper' ),
                    'section'     => 'header_elements',
                    'priority'    => 10,
                    'active_callback' => 'sk_shopping_cart_icon_enabled',
                )
            )
        );

        // Cart Icon Function.
        $wp_customize->add_setting(
            'option_minicart',
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
                'option_minicart',
                array(
                    'type'     => 'select',
                    'label'    => esc_html__( 'Cart Icon Function', 'shopkeeper' ),
                    'section'  => 'header_elements',
                    'priority' => 10,
                    'choices'  => array(
                        '1'     => esc_html__( 'Mini Cart', 'shopkeeper' ),
                        '2'     => esc_html__( 'Link to Cart', 'shopkeeper' ),
                    ),
                    'active_callback' => 'sk_shopping_cart_icon_enabled',
                )
            )
        );

        // Open Mini Cart On.
        $wp_customize->add_setting(
            'option_minicart_open',
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
                'option_minicart_open',
                array(
                    'type'     => 'select',
                    'label'    => esc_html__( 'Open Mini Cart on', 'shopkeeper' ),
                    'section'  => 'header_elements',
                    'priority' => 10,
                    'choices'  => array(
                        '1'     => esc_html__( 'Click', 'shopkeeper' ),
                        '2'     => esc_html__( 'Hover', 'shopkeeper' ),
                    ),
                    'active_callback' => 'sk_minicart_enabled',
                )
            )
        );

        // Mini Cart Message.
        $wp_customize->add_setting(
    		'main_header_minicart_message',
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
    			'main_header_minicart_message',
    			array(
    				'type'        => 'text',
    				'label'       => esc_attr__( 'Mini Cart Message', 'shopkeeper' ),
    				'section'     => 'header_elements',
    				'priority'    => 10,
                    'active_callback' => 'sk_minicart_enabled',
    			)
    		)
    	);

        // My Account Heading
        $wp_customize->add_setting(
            'main_header_my_account_heading',
            array(
                'type'       => 'theme_mod',
                'sanitize_callback' => 'wp_filter_nohtml_kses',
                'capability' => 'edit_theme_options',
            )
        );

        $wp_customize->add_control(
            new SK_Customize_Heading_Control(
                $wp_customize,
                'main_header_my_account_heading',
                array(
                    'label'    => esc_html__( 'My Account', 'shopkeeper' ),
                    'section'  => 'header_elements',
                    'priority' => 10,
                )
            )
        );

        // My Account Icon.
        $wp_customize->add_setting(
    		'my_account_icon_state',
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
    			'my_account_icon_state',
    			array(
    				'type'     => 'checkbox',
    				'label'    => esc_html__( 'My Account Icon', 'shopkeeper' ),
    				'section'  => 'header_elements',
    				'priority' => 10,
    			)
    		)
    	);

        // Custom My Account Icon.
        $wp_customize->add_setting(
            'custom_my_account_icon',
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
                'custom_my_account_icon',
                array(
                    'type'        => 'image',
                    'label'       => esc_html__( 'Custom My Account Icon', 'shopkeeper' ),
                    'section'     => 'header_elements',
                    'priority'    => 10,
                    'active_callback' => 'sk_account_icon_enabled',
                )
            )
        );
    }

    // Search Heading
    $wp_customize->add_setting(
        'main_header_search_heading',
        array(
            'type'       => 'theme_mod',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'capability' => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new SK_Customize_Heading_Control(
            $wp_customize,
            'main_header_search_heading',
            array(
                'label'    => esc_html__( 'Search', 'shopkeeper' ),
                'section'  => 'header_elements',
                'priority' => 10,
            )
        )
    );

    // Search Icon.
    $wp_customize->add_setting(
		'main_header_search_bar',
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
			'main_header_search_bar',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Search Icon', 'shopkeeper' ),
				'section'  => 'header_elements',
				'priority' => 10,
			)
		)
	);

    // Custom Search Icon.
    $wp_customize->add_setting(
        'main_header_search_bar_icon',
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
            'main_header_search_bar_icon',
            array(
                'type'        => 'image',
                'label'       => esc_html__( 'Custom Search Icon', 'shopkeeper' ),
                'section'     => 'header_elements',
                'priority'    => 10,
                'active_callback' => 'sk_search_icon_enabled',
            )
        )
    );

    // Off-Canvas Drawer Heading
    $wp_customize->add_setting(
        'main_header_offcanvas_heading',
        array(
            'type'       => 'theme_mod',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'capability' => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new SK_Customize_Heading_Control(
            $wp_customize,
            'main_header_offcanvas_heading',
            array(
                'label'    => esc_html__( 'Off-Canvas Drawer', 'shopkeeper' ),
                'section'  => 'header_elements',
                'priority' => 10,
            )
        )
    );

    // Off-Canvas Drawer.
    $wp_customize->add_setting(
		'main_header_off_canvas',
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
			'main_header_off_canvas',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Off-Canvas Drawer Icon', 'shopkeeper' ),
				'section'  => 'header_elements',
				'priority' => 10,
			)
		)
	);

    // Custom Off-Canvas Icon.
    $wp_customize->add_setting(
        'main_header_off_canvas_icon',
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
            'main_header_off_canvas_icon',
            array(
                'type'        => 'image',
                'label'       => esc_html__( 'Custom Off-Canvas Icon', 'shopkeeper' ),
                'section'     => 'header_elements',
                'priority'    => 10,
                'active_callback' => 'sk_offcanvas_icon_enabled',
            )
        )
    );

    // Abort if selective refresh is not available.
    if ( ! isset( $wp_customize->selective_refresh ) ) {
        return;
    }

    $wp_customize->selective_refresh->add_partial( 'main_header_wishlist_heading', array(
        'selector' => '.site-header .site-tools',
        'settings' => 'main_header_wishlist_heading',
        'render_callback' => function() {
            echo shopkeeper_get_header_tool_icons();
        },
    ) );
}
