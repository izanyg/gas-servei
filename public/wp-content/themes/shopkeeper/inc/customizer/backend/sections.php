<?php
/**
 * Customizer sections
 *
 * @package shopkeeper
 */

 /**
  * Sets the customizer sections
  *
  * @param  [object] $wp_customize [customizer object].
  */
function shopkeeper_customizer_sections( $wp_customize ) {

	// Panels.
	$wp_customize->add_panel( 'panel_header', array(
		'title'          => esc_html__( 'Header', 'shopkeeper' ),
		'priority'       => 1,
		'capability'     => 'edit_theme_options',
	) );

	$wp_customize->add_section( 'footer', array(
		'title'          => esc_attr__( 'Footer', 'shopkeeper' ),
		'priority'       => 2,
		'capability'     => 'edit_theme_options',
	) );

	$wp_customize->add_section( 'styling', array(
		'title'          => esc_attr__( 'Styling', 'shopkeeper' ),
		'priority'       => 3,
		'capability'     => 'edit_theme_options',
	) );

	$wp_customize->add_section( 'fonts', array(
	    'title'          => esc_attr__( 'Fonts', 'shopkeeper' ),
	    'priority'       => 4,
	    'capability'     => 'edit_theme_options',
	) );

	$wp_customize->add_panel( 'panel_blog', array(
		'title'          => esc_html__( 'Blog', 'shopkeeper' ),
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
	) );

	$wp_customize->add_panel( 'panel_shop', array(
		'title'          => esc_html__( 'Shop', 'shopkeeper' ),
		'priority'       => 6,
		'capability'     => 'edit_theme_options',
	) );

	$wp_customize->add_section( 'product', array(
		'title'          => esc_attr__( 'Product Page', 'shopkeeper' ),
		'priority'       => 7,
		'capability'     => 'edit_theme_options',
	) );

	$wp_customize->add_section( 'header_style', array(
	    'title'          => esc_attr__('Header Styles', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'panel'          => 'panel_header',
	) );

	$wp_customize->add_section( 'header_colors', array(
	    'title'          => esc_attr__('Header Colors', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'panel'          => 'panel_header',
	) );

	$wp_customize->add_section( 'header_transparency', array(
	    'title'          => esc_attr__('Header Transparency', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'panel'          => 'panel_header',
	) );

	$wp_customize->add_section( 'header_elements', array(
	    'title'          => esc_attr__( 'Header Elements', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'panel'          => 'panel_header',
	) );

	$wp_customize->add_section( 'header_logo', array(
	    'title'          => esc_attr__( 'Logo', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'panel'          => 'panel_header',
	) );

	$wp_customize->add_section( 'top_bar', array(
	    'title'          => esc_attr__( 'Top Bar', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'panel'          => 'panel_header',
	) );

	$wp_customize->add_section( 'sticky_header', array(
	    'title'          => esc_attr__( 'Sticky Header', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'panel'          => 'panel_header',
	) );

	$wp_customize->add_section( 'search', array(
	    'title'          => esc_attr__( 'Search', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'panel'          => 'panel_header',
	) );

	$wp_customize->add_section( 'mobile_header', array(
	    'title'          => esc_attr__( 'Mobile Header', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'panel'          => 'panel_header',
	) );

	// Blog Sections.
	$wp_customize->add_section( 'blog_archive', array(
	    'title'          => esc_attr__( 'Blog Posts Archive', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'panel'			 => 'panel_blog'
	) );

	$wp_customize->add_section( 'single_post', array(
	    'title'          => esc_attr__( 'Single Post', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'panel'			 => 'panel_blog'
	) );

	// Shop Sections.

	$wp_customize->add_section( 'product_card', array(
	    'title'          => esc_attr__( 'Product Card', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'panel'			 => 'panel_shop'
	) );

	$wp_customize->add_section( 'shop_notifications', array(
	    'title'          => esc_attr__( 'Shop Notifications', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'panel'			 => 'panel_shop'
	) );

	$wp_customize->add_section( 'product_badges', array(
	    'title'          => esc_attr__( 'Product Badges', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'panel'			 => 'panel_shop'
	) );

	$wp_customize->add_section( 'catalog_mode', array(
	    'title'          => esc_attr__( 'Catalog Mode', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'panel'			 => 'panel_shop'
	) );

	$wp_customize->add_section( 'custom_code', array(
	    'title'          => esc_attr__( 'Custom Code', 'shopkeeper' ),
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	) );
}
add_action( 'customize_register','shopkeeper_customizer_sections' );
