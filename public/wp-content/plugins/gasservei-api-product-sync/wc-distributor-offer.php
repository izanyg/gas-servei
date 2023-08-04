<?php

if (!defined('ABSPATH'))
    exit;

// Based on https://www.tychesoftwares.com/how-to-offer-discounts-based-on-quantity-in-woocommerce/

function import_gs_distributor_offers()
{
    global $gasserveiapi;
    delete_metadata('post', 0, 'gs_distributor_offer', false, true);
    delete_metadata('post', 0, 'gs_distributor_min_quantity', false, true);
    $offers = $gasserveiapi->offers();
    foreach ($offers as $offer) {
        $id = wc_get_product_id_by_sku($offer['art']);
        foreach (explode(',', GS_LANGUAGE_CODES) as $lang) {
            $trans_id = apply_filters('wpml_object_id', $id, 'product_variation', FALSE, $lang);
            update_post_meta($trans_id, 'gs_distributor_offer', $offer['pvp']);
            update_post_meta($trans_id, 'gs_distributor_min_quantity', $offer['uni']);
        }
    }
}

add_filter('woocommerce_add_cart_item_data', 'gs_add_default_price_as_custom', 20, 3);
function gs_add_default_price_as_custom($cart_item_data, $product_id, $variation_id)
{

    if (function_exists('is_gs_distributor') && !is_gs_distributor())
        return $cart_item_data;

    $offer = get_post_meta($variation_id, 'gs_distributor_offer', true);

    ## ----- SET THE DISCOUNT HERE ----- ##
    // $discount_percentage = 5; // Discount (5%)
    // The WC_Product Object
    $product = wc_get_product($variation_id);
    $price = (float) $product->get_price();
    if ($offer !== '' && $offer < $price) {
        // Set the Product default base price as custom cart item data
        $cart_item_data['base_price'] = $price;
        // Set the Product discounted price as custom cart item data
        $cart_item_data['new_price'] = $offer;
        // Set the percentage as custom cart item data
        // $cart_item_data['percentage'] = $discount_percentage;        
    }
    return $cart_item_data;
}
// Display the product original price
add_filter('woocommerce_cart_item_price', 'gs_display_cart_items_default_price', 20, 3);
function gs_display_cart_items_default_price($product_price, $cart_item, $cart_item_key)
{
    if (isset($cart_item['base_price'])) {
        $product        = $cart_item['data'];
        $product_price  = wc_price(wc_get_price_to_display($product, array('price' => $cart_item['base_price'])));
    }
    return $product_price;
}
// Display the product name with the discount percentage
add_filter('woocommerce_cart_item_name', 'gs_add_percentage_to_item_name', 20, 3);
function gs_add_percentage_to_item_name($product_name, $cart_item, $cart_item_key)
{
    // if( isset($cart_item['percentage']) && isset($cart_item['base_price']) ) {
    if (isset($cart_item['base_price'])) {
        if ($cart_item['data']->get_price() != $cart_item['base_price'])
            $product_name .= ' <em>(' . __('Oferta distribuidor', 'gasservei') . ' ' . $cart_item['new_price'] . '€)</em>';
    }
    return $product_name;
}
add_action('woocommerce_before_calculate_totals', 'gs_custom_discounted_cart_item_price', 20, 1);
function gs_custom_discounted_cart_item_price($cart)
{
    if (is_admin() && !defined('DOING_AJAX'))
        return;
    if (did_action('woocommerce_before_calculate_totals') >= 2)
        return;

    // Loop through cart items
    foreach ($cart->get_cart() as $cart_item) {
        $quantity = get_post_meta($cart_item['variation_id'], 'gs_distributor_min_quantity', true);

        // For item quantity of 2 or more
        if ($quantity !== '' && $cart_item['quantity'] >= $quantity && isset($cart_item['new_price'])) {
            // Set cart item discounted price
            $cart_item['data']->set_price($cart_item['new_price']);
            $cart_item['data']->has_distributor_offer = true;
        }
    }
}
