<?php

if (!defined('ABSPATH'))
    exit;

global $imported_ids;

function mark_all_products_unimported() {
    global $imported_ids;
    $imported_ids = [];
    gs_for_all_languages('mark_all_products_unimported_languages');
}

function mark_all_products_unimported_languages() {
    global $imported_ids;
    $args = array(
        'post_type' => 'product',
        'posts_per_page'=>-1,
    );
    $products = wc_get_products($args);
    foreach($products as $product)
        $imported_ids[$product->get_id()] = false;
}

function gs_post_imported($post_id) {
    global $imported_ids;
    $imported_ids[$post_id] = true;
}

function gs_purge_unimported_products() {
    global $imported_ids;
    foreach ($imported_ids as $product_id => $imported)
        if (!$imported) {
            $product = wc_get_product($product_id);
            echo 'Deleting product: '.$product->get_id().' - '.$product->get_name().nl();
            $image_id = $product->get_image_id();
            wc_delete_product($product_id, true);
            if ($image_id)
                // class-wpml-attachment-action.php:171 prevents from deleting
                wp_delete_attachment($image_id, true);            
        }
}

function mark_all_variations_unimported() {
    global $imported_ids;
    $imported_ids = [];
    gs_for_all_languages('mark_all_variations_unimported_languages');
}

function mark_all_variations_unimported_languages() {
    global $imported_ids;

    $args = array(
        'post_type' => 'product_variation',
        'posts_per_page'=>-1,
    );
    $query = new WP_Query( $args );
    $products = $query->posts;
    foreach($products as $product)
        $imported_ids[$product->ID] = false;
}

function gs_purge_unimported_variations() {
    global $imported_ids;
    foreach ($imported_ids as $product_id => $imported)
        if (!$imported) {
            $product = new WC_Product_Variation($product_id);
            echo 'Deleting product variation: '.$product->get_id().' - '.$product->get_name().nl();
            $product->delete(true);
        }
}

function mark_all_categories_unimported() {
    global $imported_ids;
    $imported_ids = [];
    gs_for_all_languages('mark_all_categories_unimported_languages');
}

function mark_all_categories_unimported_languages() {
    global $imported_ids;

    $args = array(
        'hide_empty' => false, // also retrieve terms which are not used yet
        'taxonomy'  => 'product_cat',
    );
    $terms = get_terms( $args );    
    foreach($terms as $term)
        $imported_ids[$term->term_id] = false;
}

function gs_term_imported($term_id) {
    global $imported_ids;
    $imported_ids[$term_id] = true;
}

function gs_purge_unimported_categories() {
    global $imported_ids;
    foreach ($imported_ids as $category_id => $imported)
        if (!$imported) {
            wp_delete_term($category_id, 'product_cat');
            echo 'Deleting category: '.$category_id.nl();
        }
}