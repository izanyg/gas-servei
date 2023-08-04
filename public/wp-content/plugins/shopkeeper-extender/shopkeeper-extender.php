<?php

/**
 * Plugin Name:       		Shopkeeper Extender
 * Plugin URI:        		https://shopkeeper.wp-theme.design/
 * Description:       		Extends the functionality of Shopkeeper with theme specific features.
 * Version:           		1.6.9
 * Author:            		GetBowtied
 * Author URI:				https://getbowtied.com
 * Text Domain:				shopkeeper-extender
 * Domain Path:				/languages/
 * Requires at least: 		5.0
 * Tested up to: 			5.6
 *
 * @package  Shopkeeper Extender
 * @author   GetBowtied
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

// Plugin Updater
require 'core/updater/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/getbowtied/shopkeeper-extender/master/core/updater/assets/plugin.json',
	__FILE__,
	'shopkeeper-extender'
);

if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

define( 'SK_EXT_ENQUEUE_SUFFIX', SCRIPT_DEBUG ? '' : '.min' );

$version = ( isset(get_plugin_data( __FILE__ )['Version']) && !empty(get_plugin_data( __FILE__ )['Version']) ) ? get_plugin_data( __FILE__ )['Version'] : '1.0';
define ( 'SK_EXT_VERSION', $version );

if ( ! class_exists( 'ShopkeeperExtender' ) ) :

	/**
	 * ShopkeeperExtender class.
	*/
	class ShopkeeperExtender {

		/**
		 * The single instance of the class.
		 *
		 * @var ShopkeeperExtender
		*/
		protected static $_instance = null;

		/**
		 * ShopkeeperExtender constructor.
		 *
		*/
		public function __construct() {

			// Helpers
			include_once( dirname( __FILE__ ) . '/includes/helpers/helpers.php' );

			// Vendor
			include_once( dirname( __FILE__ ) . '/includes/vendor/enqueue.php' );

            // Customizer
			include_once( dirname( __FILE__ ) . '/includes/customizer/repeater/class-sk-ext-repeater-control.php' );

			// Shortcodes
			include_once( dirname( __FILE__ ) . '/includes/shortcodes/index.php' );

			// Social Media
			include_once( dirname( __FILE__ ) . '/includes/social-media/class-social-media.php' );

			// Widgets
			include_once( 'includes/widgets/social-media.php' );

			// Gutenberg Blocks
			include_once( dirname( __FILE__ ) . '/includes/gbt-blocks/index.php' );

            // Shopkeeper Dependent Components
			if( function_exists('shopkeeper_theme_slug') ) {

				//Custom Menu
				include_once( dirname( __FILE__ ) . '/includes/custom-menu/index.php' );

                // Custom Code Section
				include_once( dirname( __FILE__ ) . '/includes/custom-code/class-custom-code.php' );

				// Social Sharing Buttons
				if ( is_plugin_active( 'woocommerce/woocommerce.php') ) {
					include_once( dirname( __FILE__ ) . '/includes/social-sharing/class-social-sharing.php' );
				}

                // Addons
    			if ( is_plugin_active( 'woocommerce/woocommerce.php') ) {
    				include_once( dirname( __FILE__ ) . '/includes/addons/class-wc-category-header-image.php' );
    			}
			}
		}

		/**
		 * Ensures only one instance of ShopkeeperExtender is loaded or can be loaded.
		 *
		 * @return ShopkeeperExtender
		*/
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
	}
endif;

add_action( 'after_setup_theme', function() {
    $shopkeeper_extender = new ShopkeeperExtender;
} );
