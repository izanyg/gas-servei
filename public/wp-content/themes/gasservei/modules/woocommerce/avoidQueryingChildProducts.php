<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
function gs_convert_array_to_ids(){
    $products = gs_get_grouped_product_children();
    $post_ids = array();
    foreach ($products as $product){
        foreach ($product as $id){
            array_push($post_ids,$id);
        }
    }
    return $post_ids;
}


function gs_get_grouped_product_children(){
    global $wpdb;
    $products = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM $wpdb->prefix" . "postmeta WHERE meta_key = %s", '_children'), ARRAY_A
    );
    $products_id = array();
    foreach($products as $product){
        array_push($products_id, unserialize($product['meta_value']));
    }
    return $products_id;
}

function gs_custom_get_posts( $query ) {
    if ( is_admin() || ! $query->is_main_query() )
        return;
    if ( $query->is_archive() || $query->is_shop()) {
        $query->set( 'post__not_in', gs_convert_array_to_ids() );
    }
}
add_action( 'pre_get_posts', 'gs_custom_get_posts', 1 ); 