<?php
/**
* The Shop Catalog Mode section options.
*
* @package shopkeeper
*/

add_action( 'customize_register', 'shopkeeper_customizer_shop_catalog_mode_controls' );
/**
 * Adds controls for shop catalog mode section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_shop_catalog_mode_controls( $wp_customize ) {

    // Catalog Mode.
    $wp_customize->add_setting(
        'catalog_mode',
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
            'catalog_mode',
            array(
                'type'     => 'checkbox',
                'label'    => esc_html__( 'Catalog Mode', 'shopkeeper' ),
                'section'  => 'catalog_mode',
                'priority' => 10,
                'description' => wp_kses_post( __('<span class="dashicons dashicons-editor-help"></span>When enabled, the feature turns off the shopping functionality of WooCommerce.', 'shopkeeper') ),
            )
        )
    );
}
