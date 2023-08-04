<?php

if (!defined('ABSPATH'))
    exit;

function import_gs_articles()
{
    $tini = microtime(true);
    global $gasserveiapi;
    $artis = $gasserveiapi->stock();
    mark_all_variations_unimported();

    $i=0;
    foreach($artis as $arti) {
        if ($arti['producto_id']==0)
            continue;
        if (empty($arti['ean']))
            continue;
        // if ($arti['ean']!='8435604111753')
        //     continue;
        // if ($arti['producto_id']!=221)
        //     continue;
        $arti['Arti'] = trim($arti['Arti']);
        echo 'Importing: '.$arti['Arti'].nl();

        try {            
            if (create_gs_arti($arti)) {
                echo 'Imported article: '.$arti['ean'].nl();
                $i++;
            }
        } catch (Exception $e) {
            echo "Exception: ".$e->getMessage().nl();
        }
        // if ($i>=3)
        //     break;
    }
    gs_purge_unimported_variations();
    import_gs_distributor_offers();
    $tfin = microtime(true);
    error_log("Imported $i articles ".number_format($tfin-$tini,2)." seconds");
}

function create_gs_arti($arti)
{
    if (!$objVariation = get_gs_arti($arti['ean'])) {
        $objVariation = new WC_Product_Variation();
    }

    if (!$objProduct = get_gs_prod($arti['producto_id'])) {
        // No existe el padre
        return null;
    }    

    $objVariation->set_sku($arti['Arti']);
    $objVariation->set_description($arti['Descripcio']);    
    $objVariation->set_regular_price($arti["PVP"]);
    $objVariation->set_price($arti["pvpe"]);
    $objVariation->set_sale_price($arti["pvpe"]);
    $objVariation->set_stock_quantity($arti["StkAct"]);
    $objVariation->set_manage_stock(true);
    $objVariation->set_stock_status('');    
    $objVariation->set_parent_id($objProduct->get_id());
    $variation_id = $objVariation->save();
    update_post_meta($variation_id, 'gsean', $arti['ean']);
    gs_post_imported($variation_id);

    if (isset($arti["tipologia_des"]) && !empty($arti["tipologia_des"]))
        update_post_meta($variation_id, 'gs_tipologia', $arti['tipologia_des']);
    else
        delete_post_meta($variation_id, 'gs_tipologia');

    create_gs_arti_translations($objVariation, $arti);
    return $variation_id;
}

function get_gs_arti($ean)
{
    do_action( 'wpml_switch_language', GS_DEFAULT_LANGUAGE_CODE );
    $args = array(
        'post_type' => 'product_variation',
        'meta_key' => 'gsean',
        'meta_value' => $ean, //'meta_value' => array('yes'),
        'meta_compare' => '=' //'meta_compare' => 'NOT IN'
    );
    $query = new WP_Query( $args );
    $products = $query->posts;
    do_action( 'wpml_switch_language', ICL_LANGUAGE_CODE );

    if (empty( $products ))
        return null;
    if (is_wp_error( $products ))
        throw new Exception("Can't find product", 1);
    return new WC_Product_Variation($products[0]->ID);
}

add_action( 'woocommerce_before_single_product_summary' , 'gs_check_price', 5 );
function gs_check_price() {
    global $product;
    global $gasserveiapi;
    global $custom_variation_values;
    global $getting_custom_variation_values;
    $getting_custom_variation_values = true;
    wc_delete_product_transients( $product->get_id() );
    $variations = $product->is_type( 'variable' ) ? $product->get_available_variations() : [];

    $custom_variation_values = [];
    if (!is_user_logged_in() || !is_gs_client())
        return;
    $eans = [];
    foreach ($variations as $variation) {
        $eans[] = get_post_meta($variation['variation_id'], 'gsean', true);
    }
    try {
        $gasserveiapi->articles(get_cif(), $eans);
    } catch(Exception $e) {
        return;
    }
    $getting_custom_variation_values = false;
}

add_filter('woocommerce_variation_prices_price', 'gs_variation_get_price', 99, 3 );
add_filter( 'woocommerce_product_variation_get_price', 'gs_variation_get_price', 0, 2 );
function gs_variation_get_price( $regular_price, $variation ) {
    global $gasserveiapi;
    global $getting_custom_variation_values;
    if ($getting_custom_variation_values || !is_user_logged_in() || !is_gs_client() || $variation->has_distributor_offer)
        return $regular_price;

    $ean = get_post_meta($variation->get_id(), 'gsean')[0];
    $articles = $gasserveiapi->articles(get_cif(), [$ean]);
    
    return isset($articles[$ean]) ? 
        $articles[$ean]['pvpe'] : 
        $regular_price;
}

// variation is not purchasable if price is 0
add_filter( 'woocommerce_variation_is_purchasable', 'gs_variation_is_purchasable', 0, 2 );
function gs_variation_is_purchasable( $value, $variation ) {
    global $gasserveiapi;
    global $getting_custom_variation_values;
    if ($getting_custom_variation_values || !is_user_logged_in() || !is_gs_client())
        return $value;

    $ean = get_post_meta($variation->get_id(), 'gsean')[0];
    $articles = $gasserveiapi->articles(get_cif(), [$ean]);
    
    return $value && (!isset($articles[$ean]) || $articles[$ean]['pvpe']!=0);
}

add_filter('woocommerce_product_variation_get_stock_quantity', function($quantity, $variation) {
    global $gasserveiapi;
    global $getting_custom_variation_values;
    if ($getting_custom_variation_values || !is_user_logged_in() || !is_gs_client())
        return $quantity;

    $ean = get_post_meta($variation->get_id(), 'gsean')[0];
    $articles = $gasserveiapi->articles(get_cif(), [$ean]);
    return isset($articles[$ean]) ? 
        $articles[$ean]['stkact'] : 
        $quantity;
}, 99, 2 );

add_filter('woocommerce_product_is_in_stock', function($status, $variation) {
    if ($variation->get_type()!='variation')
        return $status;
    global $gasserveiapi;
    global $getting_custom_variation_values;
    if ($getting_custom_variation_values || !is_user_logged_in() || !is_gs_client())
        return $status;

    $ean = get_post_meta($variation->get_id(), 'gsean')[0];
    $articles = $gasserveiapi->articles(get_cif(), [$ean]);
    
    return isset($articles[$ean]) ? 
        $articles[$ean]['stkact']!=0 : 
        $status;
}, 99, 2);

add_action('init', function() {
    remove_action( 'woocommerce_checkout_order_created', 'wc_reserve_stock_for_order' );
});
