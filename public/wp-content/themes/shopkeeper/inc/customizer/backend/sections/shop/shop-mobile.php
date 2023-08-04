<?php
/**
* The Shop Mobile Settings section options.
*
* @package shopkeeper
*/

add_action( 'customize_register', 'shopkeeper_customizer_shop_mobile_controls' );
/**
 * Adds controls for shop mobile settings section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_shop_mobile_controls( $wp_customize ) {

    // Number of Columns on Mobile.
    $wp_customize->add_setting(
        'mobile_columns',
        array(
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
            'default'    => 2,
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'mobile_columns',
            array(
                'type'        => 'number',
                'label'       => esc_html__( 'Mobile products per row', 'shopkeeper' ),
                'description' => esc_html__( "Choose between 1 or 2.", 'shopkeeper' ),
                'section'     => 'woocommerce_product_catalog',
                'priority'    => 10,
                'input_attrs' => array(
                    'min'  => 1,
                    'max'  => 2,
                    'step' => 1,
                ),
            )
        )
    );
}
