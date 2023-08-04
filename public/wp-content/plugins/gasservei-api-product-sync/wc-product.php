<?php

if (!defined('ABSPATH'))
    exit;

function import_gs_products()
{
    $tini = microtime(true);
    global $gasserveiapi;
    $prods = $gasserveiapi->products();
    $images = $gasserveiapi->products_gallery_key_id();
    $categories = gs_get_product_categories($prods);
    $translations = $gasserveiapi->products_translations_id_keys();
    mark_all_products_unimported();

    $i=0;
    foreach($prods as $prod) {
        $id = $prod['id'];
        if (isset($images[$id]))
            $prod['gallery'] = $images[$id];
        // $ret = $gasserveiapi->attributes($prod['id']);
        // echo $prod['id'].' -> '.$ret.'</br>';
        // if ($id!=184)
        //     continue;
        $objProduct = create_gs_prod($prod, $categories[$id]);
        create_gs_prod_translations($objProduct, $translations[$prod['id']] ?? null);

        echo 'Imported product: '.$id.' ('.$prod['Nombre'].')'.nl();
        $i++;
        // if ($i>=1)
        // 	break;
    }
    gs_purge_unimported_products();
    $tfin = microtime(true);
    error_log("Imported $i products in ".number_format($tfin-$tini,2)." seconds");
}

// Assumes parent category exists
function create_gs_prod($prod, $category_ids)
{
    if (!$objProduct = get_gs_prod($prod['id'])) {
        $objProduct = new WC_Product_Variable();
    }
    $objProduct->set_status("publish");

    // update thumbnail when new object or image changed (set thumbnail)
    $product_id = $objProduct->get_id();
    $is_new = !((bool) $product_id);

    if ($prod['Imagen_destacada']!=null && 
        ($is_new || 
        get_post_meta($product_id, 'api_image', true)!=$prod['Imagen_destacada'])) {
        $id = media_sideload_image($prod['Imagen_destacada'], null, null, 'id');
        if ( is_wp_error($id) ){
            error_log( 'URL imagen: ' . $prod['Imagen_destacada'] );
            error_log( print_r( $id, true ) );
        }else{
            // update_post_meta($product_id, 'api_image', $prod['Imagen_destacada']);
            $objProduct->set_image_id($id);
        }
    }
    if (isset($prod['marca']) && !empty($prod['marca'])) {
        $label = $prod['marca'];
        import_gs_attribute('marca', [$label]);
        if ($id = get_attribute_id('marca')) {
            $attribute = new WC_Product_Attribute();
            $attribute->set_name( wc_attribute_taxonomy_name('marca') );
            $attribute->set_options( [$label] );
            $attribute->set_visible( 1 );
            $attribute->set_id( $id );
            $attribute->set_variation(false);
            $prod_attrs = $objProduct->get_attributes();
            $prod_attrs['pa_marca'] = $attribute;
            $prod_attrs = $objProduct->set_attributes( $prod_attrs );
        }
    }

    $objProduct->set_name($prod['Nombre']);
    $objProduct->set_catalog_visibility('visible'); // add the product visibility status
    $objProduct->set_description($prod['Descripcion']);
    if (isset($prod['short_description']))
        $objProduct->set_short_description($prod['short_description']);
    $objProduct->set_slug($prod['Slug']);
    $objProduct->set_manage_stock(false); // true or false
    $objProduct->set_sold_individually(false);
    $category_wp_ids = [];
    foreach($category_ids as $gs_id) {
        if ($c = get_gs_cat($gs_id))
            $category_wp_ids[] = $c->term_id;
    }
    $objProduct->set_category_ids($category_wp_ids);
    $product_id = $objProduct->save();
	update_post_meta($product_id, 'gsid', $prod['id']);

    gs_post_imported($product_id);

	// update thumbnail when new object or image changed (set meta)
    if ($prod['Imagen_destacada']!=null && 
        ($is_new || 
        get_post_meta($product_id, 'api_image', true)!=$prod['Imagen_destacada'])) {
        update_post_meta($product_id, 'api_image', $prod['Imagen_destacada']);
    }   

    if (isset($prod['gallery'])) {
        $ids = [];
        foreach($prod['gallery'] as $image) {
            if ($is_new || !in_array($image['fileimg'], get_post_meta($product_id, 'api_gallery'))) {
                add_post_meta($product_id, 'api_gallery', $image['fileimg']);
                $ids[] = media_sideload_image($image['fileimg'], null, null, 'id');
            }
        }
        if (count($ids)) {
            $old = $objProduct->get_gallery_image_ids();
            $objProduct->set_gallery_image_ids(array_merge($old, $ids));
            $objProduct->save();            
        }
    }
    return $objProduct;
}

function gs_get_product_categories($products) {
    $categories = [];
    foreach($products as $product) {
        $id = $product['id'];
        if (!isset($categories[$id]))
            $categories[$id] = [];
        $categories[$id][] = $product['Padre'];
    }
    return $categories;
}

function get_gs_prod($gsid)
{
    do_action( 'wpml_switch_language', GS_DEFAULT_LANGUAGE_CODE );

	$args = array(
        'post_type' => 'product',
        'meta_key' => 'gsid',
        'meta_value' => $gsid, //'meta_value' => array('yes'),
        'meta_compare' => '=' //'meta_compare' => 'NOT IN'
    );
    $products = wc_get_products($args);
    if (count($products)>1) {
        echo "\tproduct duplicated with gsid: ".$gsid.nl();
        foreach($products as $product)
            echo "\tid: ".$product->get_id()." - ".get_permalink( $product->get_id() ).nl();
    }
    do_action( 'wpml_switch_language', ICL_LANGUAGE_CODE );

    if (empty( $products ))
        return null;
    if (is_wp_error( $products ))
        throw new Exception("Can't find product", 1);
    return $products[0];
}

function delete_gs_products() {
    gs_for_all_languages('delete_gs_products_languages');
}

function delete_gs_products_languages() {
    remove_action( 'wp_delete_file', array( 'WPML_Attachment_Action', 'delete_file_filter' ) );

    $args = array(
        'post_type' => 'product',
	    // 'meta_key' => 'gsid',
	    // 'meta_value' => 'null', //'meta_value' => array('yes'),
	    // 'meta_compare' => '!=' //'meta_compare' => 'NOT IN'
        'posts_per_page'=>-1,
	);
	$products = wc_get_products($args);
    // $products = get_all_products();
	if (is_wp_error( $products ))
		throw new Exception("Can't find product", 1);
    echo 'About to delete '.count($products).' products'.nl();
	foreach($products as $product) {
		wc_delete_product($product->get_id(), true);
		$image_id = $product->get_image_id();
		if ($image_id) {
			// class-wpml-attachment-action.php:171 prevents from deleting
			wp_delete_attachment($image_id, true);
		}
        echo 'Deleted product: '.$product->get_id().' - '.$product->get_name().nl();
	}
}

/**
 * Method to delete Woo Product
 * 
 * @param int $id the product ID.
 * @param bool $force true to permanently delete product, false to move to trash.
 * @return \WP_Error|boolean
 */
function wc_delete_product($id, $force = FALSE)
{
    $product = wc_get_product($id);

    if(empty($product))
        return new WP_Error(999, sprintf(__('No %s is associated with #%d', 'woocommerce'), 'product', $id));

    // If we're forcing, then delete permanently.
    if ($force)
    {
        if ($product->is_type('variable'))
        {
            foreach ($product->get_children() as $child_id)
            {
                $child = wc_get_product($child_id);
                if ($child)
                    $child->delete(true);
            }
        }
        elseif ($product->is_type('grouped'))
        {
            foreach ($product->get_children() as $child_id)
            {
                $child = wc_get_product($child_id);
                $child->set_parent_id(0);
                $child->save();
            }
        }

        $product->delete(true);
        $result = $product->get_id() > 0 ? false : true;
    }
    else
    {
        $product->delete();
        $result = 'trash' === $product->get_status();
    }

    if (!$result)
    {
        return new WP_Error(999, sprintf(__('This %s cannot be deleted', 'woocommerce'), 'product'));
    }

    // Delete parent product transients.
    if ($parent_id = wp_get_post_parent_id($id))
    {
        wc_delete_product_transients($parent_id);
    }
    return true;
}


function get_all_products() {
    $args = array(
        'post_type' => 'product',
        'posts_per_page'=>-1,
    );
    return wc_get_products($args);
}