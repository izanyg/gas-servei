<?php
/**
 * Custom styles
 *
 * @package shopkeeper
 */

/**
 * Frontend custom styles
 */
function shopkeeper_custom_theme_styles() {

	$custom_styles = '';
	$path = get_template_directory() . '/inc/custom-styles/frontend/';

	$custom_styles .= shopkeeper_load_default_fonts( array( 'Radnika', 'NeueEinstellung' ) );

	include( $path . 'body.php' );
	include( $path . 'fonts.php' );
	include( $path . 'colors.php' );
	include( $path . 'header.php' );
	include( $path . 'footer.php' );
	include( $path . 'gutenberg.php' );

	if ( SHOPKEEPER_DOKAN_MULTIVENDOR_IS_ACTIVE ) {
		include( $path . 'plugins/dokan.php' );
	}

	if ( SHOPKEEPER_WOOCOMMERCE_GERMANIZED_IS_ACTIVE || SHOPKEEPER_GERMAN_MARKET_IS_ACTIVE ) {
		include( $path . 'plugins/german-market.php' );
	}

	if( SHOPKEEPER_WOOCOMMERCE_IS_ACTIVE ) {
		include( $path . 'woocommerce.php' );
	}

	if( SHOPKEEPER_PRODUCT_BLOCKS_IS_ACTIVE ) {
		include( $path . 'product-blocks.php' );
	}

	$custom_styles = shopkeeper_compress_styles($custom_styles);

	wp_add_inline_style( 'shopkeeper-styles', $custom_styles );
}
add_action( 'wp_enqueue_scripts', 'shopkeeper_custom_theme_styles', 100 );

/**
 * Backend custom styles
 */
function shopkeeper_custom_gutenberg_editor_styles() {

    global $current_screen;

    $custom_gutenberg_styles = '';

    include( get_template_directory() . '/inc/custom-styles/backend/gutenberg.php' );

	$custom_gutenberg_styles = shopkeeper_compress_styles($custom_gutenberg_styles);

    $current_screen = get_current_screen();
	if ( method_exists($current_screen, 'is_block_editor') && $current_screen->is_block_editor() ) {
		wp_add_inline_style( 'shopkeeper_admin_styles', $custom_gutenberg_styles );
	}
}
add_action( 'admin_enqueue_scripts', 'shopkeeper_custom_gutenberg_editor_styles', 99 );

/**
 * Compress custom styles
 */
function shopkeeper_compress_styles( $minify ) {
	$minify = preg_replace('/\/\*((?!\*\/).)*\*\//','',$minify); // negative look ahead
	$minify = preg_replace('/\s{2,}/',' ',$minify);
	$minify = preg_replace('/\s*([:;{}])\s*/','$1',$minify);
	$minify = preg_replace('/;}/','}',$minify);

	return $minify;
}
