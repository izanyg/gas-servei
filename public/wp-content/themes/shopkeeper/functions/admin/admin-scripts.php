<?php
/**
 * Admin scripts
 *
 * @package shopkeeper
 */

/**
 * Admin scripts
 */
function shopkeeper_admin_scripts() {

    $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

    // Enqueue Adobe TypeKit Fonts
    if( 'adobe' === Shopkeeper_Opt::getOption( 'main_font_source', 'default' ) ||
        'adobe' === Shopkeeper_Opt::getOption( 'secondary_font_source', 'default' ) ) {
        wp_enqueue_script(
            'shopkeeper-adobe_typekit',
            '//use.typekit.net/' . Shopkeeper_Opt::getOption( 'adobe_typekit_kit_id', '' ) . '.js',
            array(),
            shopkeeper_theme_version(),
            FALSE
        );
        wp_enqueue_script(
            'shopkeeper-adobe_typekit-exec',
            get_template_directory_uri() . '/js/misc/adobe-typekit.js',
            array( 'jquery' ),
            shopkeeper_theme_version(),
            FALSE
        );
    }

    if ( is_admin() ) {
        wp_enqueue_script( 'shopkeeper-customizer', get_template_directory_uri() . '/js/admin/wp-customizer'.$suffix.'.js', array( 'jquery' ), shopkeeper_theme_version(), TRUE );
        wp_enqueue_script( 'shopkeeper-notices',    get_template_directory_uri() . '/js/admin/admin-notices'.$suffix.'.js', array( 'jquery' ), shopkeeper_theme_version(), TRUE );
    }
}
add_action( 'admin_enqueue_scripts', 'shopkeeper_admin_scripts' );

/**
 * Deactivate AJAX Add to Cart when incompatible plugin is active
 */
function shopkeeper_customizer_deactivate_ajax_add_to_cart() {

	$active_option['active_option'] = '1';
	$active_option['plugin'] = '';

	if( class_exists('WC_Product_Addons') ) {
		$active_option['active_option'] = '0';
		$active_option['plugin'] .= 'incompatible-woo-addons ';
	}

	if( class_exists('Wcff') ) {
		$active_option['active_option'] = '0';
		$active_option['plugin'] .= 'incompatible-fields-factory ';
	}

    if( class_exists('WC_Bundles') ) {
		$active_option['active_option'] = '0';
		$active_option['plugin'] .= 'incompatible-woo-bundles ';
	}

    if( class_exists('WC_Measurement_Price_Calculator_Loader') ) {
		$active_option['active_option'] = '0';
		$active_option['plugin'] .= 'incompatible-price-calculator ';
	}

    if( defined('GIFTCARD_TEXT_DOMAIN') ) {
        $active_option['active_option'] = '0';
		$active_option['plugin'] .= 'incompatible-gift-card ';
    }

    if( defined('WCGWP_VERSION') ) {
        $active_option['active_option'] = '0';
		$active_option['plugin'] .= 'incompatible-gift-wrapper ';
    }

	wp_localize_script( 'shopkeeper-customizer', 'getbowtied_woo_customizer_vars', $active_option );
}
if( SHOPKEEPER_WOOCOMMERCE_IS_ACTIVE ) {
    add_action( 'admin_enqueue_scripts', 'shopkeeper_customizer_deactivate_ajax_add_to_cart' );
}
