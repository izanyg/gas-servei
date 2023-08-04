<?php

define( 'SK_THEME_WEBSITE', 			'https://shopkeeper.getbowtied.com' );
define( 'SK_GOOGLE_FONTS_WEBSITE', 		'https://fonts.google.com' );
define( 'SK_SAFE_FONTS_WEBSITE', 		'https://www.w3schools.com/cssref/css_websafe_fonts.asp' );

define( 'SHOPKEEPER_WOOCOMMERCE_IS_ACTIVE',                 class_exists( 'WooCommerce' ) );
define( 'SHOPKEEPER_GERMAN_MARKET_IS_ACTIVE',               class_exists( 'Woocommerce_German_Market' ) );
define( 'SHOPKEEPER_WOOCOMMERCE_GERMANIZED_IS_ACTIVE',      class_exists( 'WooCommerce_Germanized' ) );
define( 'SHOPKEEPER_DOKAN_MULTIVENDOR_IS_ACTIVE',           class_exists( 'WeDevs_Dokan' ) );
define( 'SHOPKEEPER_WOOCOMMERCE_PRODUCT_ADDONS_IS_ACTIVE',  class_exists( 'WC_Product_Addons' ) );
define( 'SHOPKEEPER_WISHLIST_IS_ACTIVE',                    class_exists( 'YITH_WCWL' ) );
define( 'SHOPKEEPER_WOOCOMMERCE_SALE_FLASH_PRO_IS_ACTIVE',  class_exists( 'WC_Sale_Flash_Pro' ) );
define( 'SHOPKEEPER_ELEMENTOR_IS_ACTIVE',                   defined( 'ELEMENTOR_VERSION' ) );
define( 'SHOPKEEPER_WPBAKERY_IS_ACTIVE', 					defined( 'WPB_VC_VERSION' ) );
define( 'SHOPKEEPER_WOO_SWATCHES_IS_ACTIVE', 				class_exists( 'wcva_swatch_form_fields' ) );
define( 'SHOPKEEPER_PRODUCT_BLOCKS_IS_ACTIVE', 				defined( 'PBFW_VERSION' ) );
define( 'SHOPKEEPER_CALL_TO_ACTION_IS_ACTIVE', 				class_exists( 'Getbowtied_Call_To_Action' ) );

// -----------------------------------------------------------------------------
// String to Slug
// -----------------------------------------------------------------------------
function shopkeeper_string_to_slug($str) {
	$str = strtolower(trim($str));
	$str = preg_replace('/[^a-z0-9-]/', '_', $str);
	$str = preg_replace('/-+/', "_", $str);
	return $str;
}

// -----------------------------------------------------------------------------
// Theme Name
// -----------------------------------------------------------------------------
function shopkeeper_theme_name() {
	$getbowtied_theme = wp_get_theme();
	return $getbowtied_theme->get('Name');
}

// -----------------------------------------------------------------------------
// Theme Name
// -----------------------------------------------------------------------------
function shopkeeper_parent_theme_name() {
	$theme = wp_get_theme();
	if ($theme->parent()):
		$theme_name = $theme->parent()->get('Name');
	else:
		$theme_name = $theme->get('Name');
	endif;

	return $theme_name;
}

// -----------------------------------------------------------------------------
// Theme Slug
// -----------------------------------------------------------------------------
function shopkeeper_theme_slug() {
	$getbowtied_theme = wp_get_theme();
	return shopkeeper_string_to_slug( $getbowtied_theme->get('Name') );
}

// -----------------------------------------------------------------------------
// Theme Author
// -----------------------------------------------------------------------------
function shopkeeper_theme_author() {
	$getbowtied_theme = wp_get_theme();
	return $getbowtied_theme->get('Author');
}

// -----------------------------------------------------------------------------
// Theme Description
// -----------------------------------------------------------------------------
function shopkeeper_theme_description() {
	$getbowtied_theme = wp_get_theme();
	return $getbowtied_theme->get('Description');
}

// -----------------------------------------------------------------------------
// Theme Version
// -----------------------------------------------------------------------------
function shopkeeper_theme_version() {
	$getbowtied_theme = wp_get_theme(get_template());
	return $getbowtied_theme->get('Version');
}

function shopkeeper_get_page_id() {
	$page_id = '';
    if ( is_single() || is_page() ) {
        $page_id = get_the_ID();
    } else if ( is_home() ) {
        $page_id = get_option('page_for_posts');
    } else if( SHOPKEEPER_WOOCOMMERCE_IS_ACTIVE && is_shop() ) {
        $page_id = get_option( 'woocommerce_shop_page_id' );
    }

	return $page_id;
}

// -----------------------------------------------------------------------------
// Converts HEX to RGB
// -----------------------------------------------------------------------------
function shopkeeper_hex2rgb($hex) {

	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);

	return implode(",", $rgb); // returns the rgb values separated by commas
}

/**
 * Converts string to bool
 *
 * @param string $string [the input].
 *
 * @return boolean
 */
function shopkeeper_string_to_bool( $string ) {
    return is_bool( $string ) ? $string : ( 'yes' === $string || 1 === $string || 'true' === $string || '1' === $string );
}

/**
 * Converts bool to string
 *
 * @param bool $bool [the input].
 *
 * @return boolean
 */
function shopkeeper_bool_to_string( $bool ) {
	$bool = is_bool( $bool ) ? $bool : ( 'yes' === $bool || 1 === $bool || 'true' === $bool || '1' === $bool );

	return true === $bool ? 'yes' : 'no';
}

/**
 * Sanitizes select controls
 *
 * @param string $input [the input].
 * @param string $setting [the settings].
 *
 * @return string
 */
function shopkeeper_sanitize_select( $input, $setting ) {
	$input   = sanitize_key( $input );
	$choices = isset($setting->manager->get_control( $setting->id )->choices) ? $setting->manager->get_control( $setting->id )->choices : '';

	return ( $choices && array_key_exists( $input, $choices ) ) ? $input : $setting->default;
}

/**
 * Sanitizes checkbox controls
 * Returns true if checkbox is checked
 *
 * @param string $input [the input].
 *
 * @return boolean
 */
function shopkeeper_sanitize_checkbox( $input ){

	return shopkeeper_string_to_bool($input);
}

/**
 * Sanitizes image upload.
 *
 * @param string $input potentially dangerous data.
 */
function shopkeeper_sanitize_image( $input ) {
	$filetype = wp_check_filetype( $input );
	if ( $filetype['ext'] && ( wp_ext2type( $filetype['ext'] ) === 'image' || $filetype['ext'] === 'svg' ) ) {
		return esc_url( $input );
	}
	return '';
}

/**
 * Checks if current page is post archive
 */
function shopkeeper_is_blog () {
    return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
}

/**
 * Checks if topbar is activated
 */
function shopkeeper_is_topbar_enabled() {
	$page_id = shopkeeper_get_page_id();
	$page_topbar_option = Shopkeeper_Opt::getOption( 'top_bar_switch', false );
	if( get_post_meta($page_id, 'page_topbar_display', true) ) {
		if( get_post_meta($page_id, 'page_topbar_display', true) === "show" ) {
			$page_topbar_option = true;
		}
		if( get_post_meta($page_id, 'page_topbar_display', true) === "hide" ) {
			$page_topbar_option = false;
		}
	}

	return $page_topbar_option;
}

/**
 * Checks if theme default font needs to be loaded
 */
function shopkeeper_preload_default_fonts( $fonts = array() ) {
	if( empty($fonts) ) return;

	foreach( $fonts as $font ) {
		$preload = false;
		if( 'default' === Shopkeeper_Opt::getOption( 'main_font_source', 'default' ) ) {
			if( $font === Shopkeeper_Opt::getOption( 'main_font_default', 'NeueEinstellung' ) ) {
				$preload = true;
			}
		}
		if( 'default' === Shopkeeper_Opt::getOption( 'secondary_font_source', 'default' ) ) {
			if( $font === Shopkeeper_Opt::getOption( 'secondary_font_default', 'Radnika' ) ) {
				$preload = true;
			}
		}

		if( $preload ) {
			printf( '<link rel="preload" as="font" href="%s" type="font/woff2" crossorigin>
	<link rel="preload" as="font" href="%s" type="font/woff2" crossorigin>
	',
				get_template_directory_uri() . '/inc/fonts/theme/'.$font.'-Regular.woff2',
				get_template_directory_uri() . '/inc/fonts/theme/'.$font.'-Bold.woff2'
			);
		}
	}

	return;
}

/**
 * Loads theme default fonts if they are used.
 */
function shopkeeper_load_default_fonts( $fonts = array() ) {
	if( empty($fonts) ) return;

	$font_face = '';
	foreach( $fonts as $font ) {
		$preload = false;
		if( 'default' === Shopkeeper_Opt::getOption( 'main_font_source', 'default' ) ) {
			if( $font === Shopkeeper_Opt::getOption( 'main_font_default', 'NeueEinstellung' ) ) {
				$preload = true;
			}
		}
		if( 'default' === Shopkeeper_Opt::getOption( 'secondary_font_source', 'default' ) ) {
			if( $font === Shopkeeper_Opt::getOption( 'secondary_font_default', 'Radnika' ) ) {
				$preload = true;
			}
		}

		if( $preload ) {
			$font_face .= shopkeeper_load_font( $font, $font.'-Regular', 500 );
			$font_face .= shopkeeper_load_font( $font, $font.'-Bold', 700 );
		}
	}

	return $font_face;
}

/**
 * Sanitizes html text controls
 *
 * @param string $input [the input].
 *
 * @return boolean
 */
 function shopkeeper_sanitize_html_text( $input ) {
 	$allowedtags = wp_kses_allowed_html();
 	$allowedtags['a']['data-*'] = true;
 	$allowedtags['a']['target'] = true;
 	$allowedtags['a']['rel'] = true;
 	$allowedtags['br'] = true;
 	$allowedtags['img']['alt'] = true;
 	$allowedtags['img']['src'] = true;
 	$allowedtags['img']['title'] = true;
 	$allowedtags['img']['width'] = true;
 	$allowedtags['img']['height'] = true;
 	$allowedtags['img']['referrerpolicy'] = true;
 	$allowedtags['img']['crossorigin'] = true;

 	return wp_kses( $input, $allowedtags );
 }

/**
 * Creates font-face for default font.
 */
function shopkeeper_load_font( $font_name, $font, $font_weight ) {
	return '@font-face {
		font-family: '.$font_name.';
		font-display: '.Shopkeeper_Opt::getOption( 'default_fonts_fontface_display', 'swap' ).';
		font-style: normal;
		font-weight: '.$font_weight.';
		src: url("'.get_template_directory_uri().'/inc/fonts/theme/'.$font.'.eot");
		src: url("'.get_template_directory_uri().'/inc/fonts/theme/'.$font.'.eot?#iefix") format("embedded-opentype"),
		url("'.get_template_directory_uri().'/inc/fonts/theme/'.$font.'.woff2") format("woff2"),
		url("'.get_template_directory_uri().'/inc/fonts/theme/'.$font.'.woff") format("woff");
	}';
}
