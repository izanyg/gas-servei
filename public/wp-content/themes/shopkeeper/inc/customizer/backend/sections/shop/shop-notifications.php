<?php
/**
* The Shop Notifications section options.
*
* @package shopkeeper
*/

/**
 * Checks if custom notification is enabled.
 */
function sk_is_shop_custom_notification(){
   if( '1' === Shopkeeper_Opt::getOption( 'notification_mode', '1' ) ) {
       return true;
   }
   return false;
}

add_action( 'customize_register', 'shopkeeper_customizer_shop_notifications_controls' );
/**
 * Adds controls for shop notifications section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_shop_notifications_controls( $wp_customize ) {

    // Notification Style.
    $wp_customize->add_setting(
        'notification_mode',
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
            'notification_mode',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Notification Style', 'shopkeeper' ),
                'section'  => 'shop_notifications',
                'priority' => 10,
                'choices'  => array(
                    '1' => esc_html__( 'Animated', 'shopkeeper' ),
                    '0' => esc_html__( 'Classic', 'shopkeeper' ),
                ),
            )
        )
    );

    // Animation.
    $wp_customize->add_setting(
        'notification_style',
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
            'notification_style',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Animation', 'shopkeeper' ),
                'section'  => 'shop_notifications',
                'priority' => 10,
                'choices'  => array(
                    '1' => esc_html__( 'Slide Out', 'shopkeeper' ),
                    '0' => esc_html__( 'Always Visible', 'shopkeeper' ),
                ),
                'active_callback' => 'sk_is_shop_custom_notification',
            )
        )
    );
}
