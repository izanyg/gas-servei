<?php
/*
Plugin Name: Gas Servei API Product Sync
Description: Syncs products from gasservei API to Woocommerce products.
Text Domain: gasservei-api-product-sync
Domain Path: /languages/
Version: 2.2.12
Requires at least: 4.7.0
Requires PHP: 5.6.20
WC requires at least: 3.0.0
WC tested up to: 4.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

define('GS_TRANSIENT_EXPIRATION', 60*60);
define('GS_ENTITIES_PURGE_TIME', 24*60*60);

include 'classes/includes.php';
include 'helpers.php';
include 'wc-product.php';
include 'wc-category.php';
include 'wc-variation.php';
include 'wc-user.php';
include 'wc-attribute.php';
include 'wc-addresses.php';
include 'wc-order.php';
include 'wc-translations.php';
include 'gs-stats.php';
include 'gs-purge.php';

global $gasserveiapi;
global $gasserveiapifake;
$gasserveiapi = new GasserveiApiCache(); 
// $gasserveiapi = new GasserveiApiFake();

if ( is_admin() ) {
    add_action( 'admin_menu', 'add_products_sync_menu_entry', 100 );
}

function add_products_sync_menu_entry() {
    add_submenu_page(
        'edit.php?post_type=product',
        __( 'Product Sync' ),
        __( 'Product Sync' ),
        'manage_woocommerce', // Required user capability
        'product-sync',
        'gasservei_api_product_sync'
    );
}

function gasservei_api_product_sync() {
    global $gasserveiapi;

    if (isset($_GET['delete_gs_categories']) && $_GET['delete_gs_categories']=='true') {
        delete_gs_categories();
        echo 'deleted cats';
        return;
    }

    if (isset($_GET['delete_gs_products']) && $_GET['delete_gs_products']=='true') {
        delete_gs_products();
        echo 'deleted prods';
        return;
    }

    if (isset($_GET['import_prods']) && $_GET['import_prods']=='true') {
        import_gs_products();
        echo 'imported prods';
        return;
    }

    if (isset($_GET['import_cats']) && $_GET['import_cats']=='true') {
        import_gs_categories();
        echo 'imported cats';
        return;
    }

    if (isset($_GET['import_artis']) && $_GET['import_artis']=='true') {
        import_gs_articles();
        echo 'imported articles';
        return;
    }

    if (isset($_GET['import_gs_attributes']) && $_GET['import_gs_attributes']=='true') {
        import_gs_attributes();
        echo 'imported attrs';
        return;
    }

    if (isset($_GET['delete_gs_attributes']) && $_GET['delete_gs_attributes']=='true') {
        delete_gs_attributes();
        echo 'imported attrs (reset)';
        return;
    }

    if (isset($_GET['import_gs_product_attributes']) && $_GET['import_gs_product_attributes']=='true') {
        import_gs_product_attributes();
        echo 'imported product attrs';
        return;
    }

    return;
}

function gs_purge_old_entities() {
    gs_purge_old_categories();
    gs_purge_old_products();
    gs_purge_old_variations();
}

add_filter( 'http_request_host_is_external', 'allow_my_custom_host', 10, 3 );
function allow_my_custom_host( $allow, $host, $url ) {
    if ( $host == 'gas-servei.shop' )
       $allow = true;
    return $allow;
}

// Fix WpSecurityAuditLog plugin errors wrapping hook calls
add_action( 'wp_loaded', function() {
    if (!class_exists('WpSecurityAuditLog') || !WpSecurityAuditLog::GetInstance()->sensors)
        return;
    foreach(WpSecurityAuditLog::GetInstance()->sensors->get_sensors() as $sensor) {
        if ($sensor instanceof WSAL_Sensors_WooCommerce) {
            remove_action( 'added_user_meta', array( $sensor, 'wc_user_meta_updated' ), 10, 4 );
            add_action( 'added_user_meta', function( $meta_id, $user_id, $meta_key, $meta_value ) use ($sensor) {
                @$sensor->wc_user_meta_updated( $meta_id, $user_id, $meta_key, $meta_value );
            }, 10, 4 );
            remove_action( 'updated_user_meta', array( $sensor, 'wc_user_meta_updated' ), 10, 4 );
            add_action( 'updated_user_meta', function( $meta_id, $user_id, $meta_key, $meta_value ) use ($sensor) {
                @$sensor->wc_user_meta_updated( $meta_id, $user_id, $meta_key, $meta_value );
            }, 10, 4 );
            remove_action( 'woocommerce_after_product_object_save', array( $sensor, 'check_product_changes_after_save' ), 10, 1 );
            add_action( 'woocommerce_after_product_object_save', function( $product ) use ($sensor) {
                @$sensor->check_product_changes_after_save( $product );
            }, 10, 1 );
        }
    }
}, 10, 4 );

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    WP_CLI::add_command( 'import_gs_categories', 'import_gs_categories' );
    WP_CLI::add_command( 'delete_gs_categories', 'delete_gs_categories' );
    WP_CLI::add_command( 'import_gs_products', 'import_gs_products' );
    WP_CLI::add_command( 'delete_gs_products', 'delete_gs_products' );
    WP_CLI::add_command( 'import_gs_articles', 'import_gs_articles' );
    WP_CLI::add_command( 'import_gs_attributes', 'import_gs_attributes' );
    WP_CLI::add_command( 'delete_gs_attributes', 'delete_gs_attributes' );
    WP_CLI::add_command( 'import_gs_product_attributes', 'import_gs_product_attributes' );
    WP_CLI::add_command( 'gs_purge_old_entities', 'gs_purge_old_entities' );
    WP_CLI::add_command( 'gs_database_stats', 'gs_database_stats' );
    WP_CLI::add_command( 'gs_database_stats_no_update', 'gs_database_stats_no_update' );
}