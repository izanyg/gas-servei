<?php
/**
* The Header Search section options.
*
* @package shopkeeper
*/

/**
 * Checks if header search is enabled.
 */
function sk_is_header_search(){

    return Shopkeeper_Opt::getOption( 'predictive_search', true );
}

add_action( 'customize_register', 'shopkeeper_customizer_header_search_controls' );
/**
 * Adds controls for header search section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_header_search_controls( $wp_customize ) {

    // Predictive Search.
    $wp_customize->add_setting(
		'predictive_search',
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
			'predictive_search',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Predictive Search', 'shopkeeper' ),
				'section'  => 'search',
				'priority' => 10,
			)
		)
	);

    // Search Only in Product Titles.
    $wp_customize->add_setting(
		'search_in_titles',
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
			'search_in_titles',
			array(
				'type'     => 'checkbox',
				'label'    => esc_html__( 'Search Only in Product Titles', 'shopkeeper' ),
				'section'  => 'search',
				'priority' => 10,
                'active_callback' => 'sk_is_header_search',
			)
		)
	);
}
