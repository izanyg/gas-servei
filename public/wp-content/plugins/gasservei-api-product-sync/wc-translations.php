<?php

if (!defined('ABSPATH'))
    exit;

define( 'GS_DEFAULT_LANGUAGE_CODE', 'es' );
define( 'GS_TRANSLATION_LANGUAGE_CODES', implode(',', ['fr', 'it', 'en', 'pt-pt']) );
define( 'GS_LANGUAGE_CODES', implode(',', ['es', 'fr', 'it', 'en', 'pt-pt']) );

function create_gs_prod_translations($product, $translations) {
	foreach(explode(',', GS_TRANSLATION_LANGUAGE_CODES) as $lang) {
        $translation = !empty($translations) && isset($translations[$lang]) ? 
            $translations[$lang] : 
            null;
		create_gs_prod_translation($product, $translation, $lang);		
    }
}

function create_gs_prod_translation($product, $translation, $lang) {
	$trans_id = apply_filters( 'wpml_object_id', $product->get_id(), 'product', FALSE, $lang );
    if (!$tproduct = wc_get_product($trans_id)) {
        $tproduct = new WC_Product_Variable();
    }
    $tproduct->set_status("publish");
    $is_new = !((bool) $tproduct->get_id());

    $name = !empty($translation['Nombre']) ? 
        $translation['Nombre'] : 
        $product->get_name();

    $desc = !empty($translation['Descripcion']) ? 
        $translation['Descripcion'] : 
        $product->get_description();

    $tproduct->set_name($name);
    $tproduct->set_image_id($product->get_image_id());
    $tproduct->set_attributes($product->get_attributes());
    $tproduct->set_catalog_visibility('visible');
    $tproduct->set_description($desc);
    $tproduct->set_short_description($product->get_short_description());
    $tproduct->set_slug($product->get_slug());
    $tproduct->set_manage_stock($product->get_manage_stock());
    $tproduct->set_sold_individually($product->get_sold_individually());
    $tproduct->set_category_ids(translate_categories_array($product->get_category_ids(), $lang));
    $tproduct->set_gallery_image_ids($product->get_gallery_image_ids());
    $tproduct->save();
    gs_post_imported($tproduct->get_id());

    if ($is_new)
    	connect_product_translations($product->get_id(), 'product', $tproduct->get_id(), $lang);
}

function create_gs_arti_translations($product, $data) {
	foreach(explode(',', GS_TRANSLATION_LANGUAGE_CODES) as $lang)
		create_gs_arti_translation($product, $data, $lang);		
}

function create_gs_arti_translation($product, $data, $lang) {
	$trans_id = apply_filters( 'wpml_object_id', $product->get_id(), 'product_variation', FALSE, $lang );
	$parent_trans_id = apply_filters( 'wpml_object_id', $product->get_parent_id(), 'product', FALSE, $lang );
    if (!$tproduct = wc_get_product($trans_id)) {
        $tproduct = new WC_Product_Variation();
    }
    $is_new = !((bool) $tproduct->get_id());

    switch ($lang) {
    	case 'en':
    		$desc = $data['Des2'];
    		break;
    	case 'it':
    		$desc = $data['des_it'];
    		break;
    	case 'fr':
    		$desc = $data['des_fr'];
    		break;
    	case 'pt-pt':
    		$desc = $data['des_pt'];
    		break;
    }
    $tproduct->set_sku($product->get_sku().$lang);
    $tproduct->set_description($desc);
    $tproduct->set_regular_price($product->get_regular_price());
    $tproduct->set_price($product->get_price());
    $tproduct->set_sale_price($product->get_sale_price());
    $tproduct->set_stock_quantity($product->get_stock_quantity());
    $tproduct->set_manage_stock($product->get_manage_stock());
    $tproduct->set_stock_status($product->get_stock_status());
    $tproduct->set_stock_quantity($product->get_stock_quantity());
    $tproduct->set_parent_id($parent_trans_id);
    $variation_id = $tproduct->save();
    gs_post_imported($variation_id);

    if (isset($data["tipologia_des"]) && !empty($data["tipologia_des"]))
        update_post_meta($variation_id, 'gs_tipologia', $data['tipologia_des']);
    else
        delete_post_meta($variation_id, 'gs_tipologia');

    if ($is_new)
    	connect_product_translations($product->get_id(), 'product_variation', $tproduct->get_id(), $lang);
}

function create_gs_category_translations($original_id, $translations) {
    foreach(explode(',', GS_TRANSLATION_LANGUAGE_CODES) as $lang) {
        do_action( 'wpml_switch_language', $lang );
        $translation = !empty($translations) && isset($translations[$lang]) ? 
            $translations[$lang] : 
            null;
        create_gs_category_translation($original_id, $translation, $lang);     
    }
    do_action( 'wpml_switch_language', ICL_LANGUAGE_CODE );
}

function create_gs_category_translation($original_id, $translation, $lang) {
    $original = get_term_original_language($original_id, '', ARRAY_A);
    $gsid = get_term_meta($original_id, 'gsid', true);

    $name = !empty($translation['nombre']) ? 
        $translation['nombre'] : 
        $original['name'];

    $desc = !empty($translation['descripcion']) ? 
        $translation['descripcion'] : 
        $original['description'];

    $tparent = $original['parent']==0 ? 0 : 
        apply_filters( 'wpml_object_id', $original['parent'], 'product_cat', FALSE, $lang );

    $translation = [
        'name' => $name,
        'description' => $desc,
        'parent' => $tparent,
        'taxonomy' => 'tax_product_cat',
    ];
    
    $slug = wp_unique_term_slug( sanitize_title( $lang.'-'.$name ), (object) $translation );
    $translation['slug'] = $slug;

    $term = term_exists($translation['slug'], 'product_cat');
    // Prevent two translations have same slug
    if ($term && get_term_meta($term['term_id'], 'trans_gsid', true)!=$gsid) {
        $translation['slug'] .= '2';
        $term = term_exists($translation['slug'], 'product_cat');
    }
    if ($term) {
        $is_new=false;
        $ret = wp_update_term($term['term_id'], 'product_cat', $translation);
    } else {
        $is_new=true;
        $ret = wp_insert_term( $translation['name'], 'product_cat', $translation);
    }
    if ($ret instanceof WP_Error) {
        var_dump($translation['name']);
        var_dump($translation['slug']);
        var_dump($is_new);
        var_dump($ret);
        die();
    }


    $translation_id = $ret['term_id'];
    gs_post_imported($translation_id);

    $torder = get_term_meta($original_id, 'order', true);
    update_term_meta($translation_id, 'order', $torder);
    $thumbnail_id = get_term_meta($original_id, 'thumbnail_id', true);
    update_term_meta($translation_id, 'thumbnail_id', $thumbnail_id);
    update_term_meta($translation_id, 'trans_gsid', $gsid);

    $connected_id = apply_filters( 'wpml_object_id', $original_id, 'product_cat', FALSE, $lang );

    if ($translation_id!=$connected_id)
        connect_product_translations($original_id, 'tax_product_cat', $translation_id, $lang);
}

function translate_categories_array($categories_ids, $lang) {
    $categories_ids = array_map(function($id) use ($lang) {
        return apply_filters( 'wpml_object_id', $id, 'product_cat', FALSE, $lang );
    }, $categories_ids);
    return array_filter($categories_ids, function($id) {
        return !empty($id);
    });
}

function connect_product_translations($original_id, $type, $translation_id, $lang) {
    // https://wpml.org/wpml-hook/wpml_element_type/
    $wpml_element_type = apply_filters( 'wpml_element_type', $type );
          
    //https://wpml.org/wpml-hook/wpml_element_language_details/
    $get_language_args = array('element_id' => $original_id, 'element_type' => $type );
    $original_post_language_info = apply_filters( 'wpml_element_language_details', null, $get_language_args );
              
    $set_language_args = array(
        'element_id'    => $translation_id,
        'element_type'  => $wpml_element_type,
        'trid'   => $original_post_language_info->trid,
        'language_code'   => $lang, //language code of secondary language
        'source_language_code' => $original_post_language_info->language_code
    );
      
    do_action( 'wpml_set_element_language_details', $set_language_args );   
}

function create_gs_attribute_translations($translations, $taxonomy_name) {
    foreach(explode(',', GS_LANGUAGE_CODES) as $lang) {
        $translation = empty($translations[$lang]) ? $translations['es'] : $translations[$lang];
        create_gs_attribute_translation($translation, $taxonomy_name, $lang);
    }
}

function create_gs_attribute_translation($translation, $taxonomy_name, $language) {
    // Code based on class-wpml-st-taxonomy-labels-translation-factory.php:14 (create)
    // Code based on class-wpml-st-taxonomy-labels-translation.php:144 (save_label_translations)
    // $translation .= $language;
    $records_factory  = new WPML_Slug_Translation_Records_Factory();
    $taxonomy_strings = new WPML_ST_Taxonomy_Strings(
        $records_factory->create( WPML_Slug_Translation_Factory::TAX ),
        WPML\Container\make( WPML_ST_String_Factory::class )
    );    

    if ( $translation && $taxonomy_name && $language ) {
        list( $general, $singular, $slug ) = $taxonomy_strings->get_taxonomy_strings( $taxonomy_name );

        if ( $general && $singular && $slug ) {
            if (gs_get_translation($general, $language)!=$translation)
                $general->set_translation( $language, $translation, ICL_STRING_TRANSLATION_COMPLETE );
            if (gs_get_translation($singular, $language)!=$translation)
                $singular->set_translation( $language, $translation, ICL_STRING_TRANSLATION_COMPLETE );
        }
    }
    return;
}

/**
 * @param WPML_ST_String $string
 *
 * @return array
 */
// Code based on class-wpml-st-taxonomy-labels-translation.php:114 (get_translations)
function gs_get_translation( WPML_ST_String $string, $lang=null ) {
    $translations = array();

    foreach ( $string->get_translations() as $translation ) {
        $translations[ $translation->language ] = $translation;
    }

    if ($lang && isset($translations[$lang]))
        return $translations[$lang]->value; 
    return null;
}

function get_term_original_language($term_id, $taxonomy, $output) {
    $my_current_lang = apply_filters( 'wpml_current_language', NULL );
    do_action( 'wpml_switch_language', GS_DEFAULT_LANGUAGE_CODE );
    $term = get_term($term_id, $taxonomy, $output);
    do_action( 'wpml_switch_language', $my_current_lang );
    return $term;
}

function create_gs_product_attribute_translations($product) {
    foreach(explode(',', GS_TRANSLATION_LANGUAGE_CODES) as $lang) {
        create_gs_product_attribute_translation($product, $lang);
    }
}

function create_gs_product_attribute_translation($product, $lang) {
    $trans_id = apply_filters( 'wpml_object_id', $product->get_id(), 'product', FALSE, $lang );
    if (!$tproduct = wc_get_product($trans_id))
        return;
    $tproduct->set_attributes($product->get_attributes());
    $tproduct->save();
}

function create_gs_product_variation_attribute_translations($variation, $attributes) {
    foreach(explode(',', GS_TRANSLATION_LANGUAGE_CODES) as $lang) {
        create_gs_product_variation_attribute_translation($variation, $attributes, $lang);
    }
}

function create_gs_product_variation_attribute_translation($variation, $attributes, $lang) {
    $trans_id = apply_filters( 'wpml_object_id', $variation->get_id(), 'product_variation', FALSE, $lang );
    $tvariation = new WC_Product_Variation($trans_id);
    $tvariation->set_attributes($attributes);
    $tvariation->save();
}

function gs_for_all_languages($callback) {
    foreach(explode(',', GS_LANGUAGE_CODES) as $lang) {
        do_action( 'wpml_switch_language', $lang );
        echo 'Switched to '.$lang.nl();
        $callback();
        do_action( 'wpml_switch_language', ICL_LANGUAGE_CODE );
    }
}