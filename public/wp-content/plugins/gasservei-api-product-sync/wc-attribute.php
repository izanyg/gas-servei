<?php

if (!defined('ABSPATH'))
    exit;

// import_gs_attributes (needs to be called twice)
//     import_gs_attributes_get_parsed_api_data
//     import_gs_attribute
//          gs_register_attribute
//          process_add_attribute
//             valid_attribute_name
            
// import_gs_product_attributes
//     import_gs_product_attributes_get_parsed_api_data
//     get_attribute_id
//     get_variation_attributes
//         get_attribute_term

// delete_gs_attributes

function import_gs_attributes() {
    $tini = microtime(true);
    list($attributes, $translations) = import_gs_attributes_get_parsed_api_data();
    echo 'Parsed attribute data'.nl();
    $i=0;
    foreach($attributes as $attribute => $values){
        $i++;
        $taxonomy = import_gs_attribute($attribute, $values);
        if (isset($translations[$attribute]))
            create_gs_attribute_translations($translations[$attribute], $taxonomy);
        // if ($i>=3)
        //     break;
    }
    $tfin = microtime(true);
    $msg = "Imported $i attributes in ".number_format($tfin-$tini,2)." seconds";
    echo $msg.nl();
    error_log($msg);    
}

function import_gs_attributes_get_parsed_api_data() {
    global $gasserveiapi;
    $api_attributes_articles = $gasserveiapi->attributes_arti();

    $all_attributes = []; // Todos los atributos y valores
    $all_attributes['ean'] = [];
    $translations = [];
    $i=0;
    foreach($api_attributes_articles as $attr) { 
        
        if (!$attr['ean'])
            continue;
        if (!$variation = get_gs_arti($attr['ean']))
            continue;


        $label = $attr['label_es'];
        $label = str_replace('³', '3', $label);
        $value = $attr['valor'];
        if(empty($label) || empty($value)){
            continue;
        }
        if (!isset($translations[$label]))
            $translations[$label] = [
                'es' => $label,
                'en' => $attr['label_en'],
                'it' => $attr['label_it'],
                'pt-pt' => $attr['label_pt'],
                'fr' => $attr['label_fr'],
            ];
        if (!isset($all_attributes[$label])){
            $all_attributes[$label] = [];
        }
        array_push($all_attributes[$label], $value); // Array de atributos (label => [valores])

        if (!in_array($attr['ean'], $all_attributes['ean']))
            $all_attributes['ean'][] = $attr['ean'];
        // if ($i>10)
        //     break;
        $i++;
    }
    // fill products not present in attributes endpoint
    echo "filling products not present in attributes endpoint".nl();
    foreach(get_all_products() as $product) {
        $vars = $product->is_type( 'variable' ) ? $product->get_available_variations() : [];
        foreach($vars as $var) {
            $ean = get_post_meta($var['variation_id'], 'gsean', true);
            if (!$ean)
                continue;
            if (!in_array($ean, $all_attributes['ean'])) {
                $all_attributes['ean'][] = $ean;
                echo "prod: ".$product->get_id()."\tean: ".$ean.nl();
            }
        }
    }
    echo "finished: filling products not present in attributes endpoint".nl();    

    //Variaciones y valor de atributos
    return [$all_attributes, $translations];
}

function import_gs_attribute($attribute, $values) {
    $taxonomy = 'pa_' . gs_register_attribute($attribute); // 0. Create the attribute if it doesn't exist

    foreach ($values as $value){
        if( ! term_exists( $value, $taxonomy ) ){
            $term_data = wp_insert_term( $value, $taxonomy );
            if (is_wp_error($term_data)) { echo $term_data->get_error_message()." attributes_import \r\n" . $taxonomy . ' -> ' . $value."\r\n"; continue;}
            $term_id   = $term_data['term_id'];
        } else {
            $term = get_term_by( 'name', $value, $taxonomy );
            if (!$term) {
                echo 'Cant find term for: '.$value.' '.$taxonomy.nl();
                continue;
            }
            $term_id   = $term->term_id;
        }
    }
    return $taxonomy;
}

function gs_register_attribute($taxonomy) {
    $slug = substr(sanitize_title( $taxonomy ),0,25);

    $insert = process_add_attribute(array('attribute_name' => $slug, 'attribute_label' => $taxonomy, 'attribute_type' => 'text', 'attribute_orderby' => 'menu_order', 'attribute_public' => false));
    if (is_wp_error($insert)) { echo $insert->get_error_message() ." gs_register_attribute \r\n"; }
    return $insert; //return attribute slug
}

function process_add_attribute($attribute) {
    global $wpdb;
    //      check_admin_referer( 'woocommerce-add-new_attribute' );

    if (empty($attribute['attribute_type'])) { $attribute['attribute_type'] = 'text';}
    if (empty($attribute['attribute_orderby'])) { $attribute['attribute_orderby'] = 'menu_order';}
    if (empty($attribute['attribute_public'])) { $attribute['attribute_public'] = 0;}

    if ( empty( $attribute['attribute_name'] ) || empty( $attribute['attribute_label'] ) ) {
            return new WP_Error( 'error', __( 'Please, provide an attribute name and slug.', 'woocommerce' ) );
    } elseif ( ( $valid_attribute_name = valid_attribute_name( $attribute['attribute_name'] ) ) && is_wp_error( $valid_attribute_name ) ) {
            return $valid_attribute_name;
    } elseif ( taxonomy_exists( wc_attribute_taxonomy_name( $attribute['attribute_name'] ) ) ) {
        // echo 'exists '.$attribute['attribute_name'].nl();
        return $attribute['attribute_name']; //return slug
    }
    echo 'new '.$attribute['attribute_name'].nl();

    $wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute );

    register_taxonomy('pa_'.$attribute['attribute_name'], ['product']);
    do_action( 'woocommerce_attribute_added', $wpdb->insert_id, $attribute );
    flush_rewrite_rules();
    delete_transient( 'wc_attribute_taxonomies' );

    return $attribute['attribute_name']; //return slug
}

function valid_attribute_name( $attribute_name ) {
    if ( strlen( $attribute_name ) >= 28 ) {
            return new WP_Error( 'error', sprintf( __( 'Slug "%s" is too long (28 characters max). Shorten it, please.', 'woocommerce' ), sanitize_title( $attribute_name ) ) );
    } elseif ( wc_check_if_attribute_name_is_reserved( $attribute_name ) ) {
            return new WP_Error( 'error', sprintf( __( 'Slug "%s" is not allowed because it is a reserved term. Change it, please.', 'woocommerce' ), sanitize_title( $attribute_name ) ) );
    }
    return true;
}

function import_gs_product_attributes() {
    $tini = microtime(true);
    echo "importing product attributes".nl();

    list($products, $variations, $ean_product) = import_gs_product_attributes_get_parsed_api_data();

    // Create wc product attribute data
    foreach($products as $product_id => $attrs) {
        $prod = wc_get_product($product_id);
        if (!$prod)
            continue;
        $prod_attrs = [];

        $pa = $prod->get_attributes();
        // Preserve maca attribute
        // Preserve filtros attribute
        foreach($pa as $key => $value)
            if (!$value->get_variation())
                $prod_attrs[$key] = $pa[$key];
        foreach($attrs as $label => $values) {
            if (!($id = get_attribute_id($label)))
                continue;
            $attribute = new WC_Product_Attribute();
            $attribute->set_name( wc_attribute_taxonomy_name($label) );
            $attribute->set_options( array_map('strval', array_keys($values)) );
            $attribute->set_visible( 1 );
            $attribute->set_id( $id );
            $attribute->set_variation(true);
            $prod_attrs[] = $attribute;
        }
        $prod->set_attributes( $prod_attrs );
        $prod->save();
        create_gs_product_attribute_translations($prod);
        echo "prod: ".$product_id.' - ('.implode(', ', array_keys($attrs)).') '.$prod->get_name().nl();
    }

    $i=0;
    foreach($variations as $ean => $attrs) {
        $variation = get_gs_arti($ean);
        $variation_attributes = get_variation_attributes($attrs);
        $variation->set_attributes($variation_attributes);
        $variation->save();
        create_gs_product_variation_attribute_translations($variation, $variation_attributes);
        echo "ean: ".$ean.' - '.$ean_product[$ean].' - '.line_print($attrs,true).nl();
        $i++;
    }
    $tfin = microtime(true);
    $msg = "Imported product attributes for $i articles in ".number_format($tfin-$tini,2)." seconds";
    echo $msg.nl();
    error_log($msg);
    wc_delete_product_transients();
    return;
}

function import_gs_product_attributes_get_parsed_api_data() {
    global $gasserveiapi;
    $api_attributes_articles = $gasserveiapi->attributes_arti();

    // Parse api variation data
    $i=0;
    $products = [];
    $variations = [];
    $ean_product = [];
    // In GasserveiAPI categoria_id means actually product_id
    foreach($api_attributes_articles as $attr) {
        if (!$attr['ean'])
            continue;
        if (!$variation = get_gs_arti($attr['ean']))
            continue;
        $ean = $attr['ean'];
        $product_id = $variation->get_parent_id();
        // $attr['valor'] = str_replace('\"', "\"", $attr['valor']);
        $label = $attr['label_es'];
        $label = str_replace('³', '3', $label);
        $value = $attr['valor'];

        // $products[producto_id][label_es] = [values => true]
        if (!isset($products[$product_id]))
            $products[$product_id] = [];
        if (!isset($products[$product_id][$label]))
            $products[$product_id][$label] = [];
        $products[$product_id][$label][$value] = true;
        $products[$product_id]['ean'][$ean] = true; // Default ean attribute

        // $variations[ean][label_es] = value;
        if (!isset($variations[$ean]))
            $variations[$ean] = [];
        if (isset($variations[$ean][$label]))
            die('error, atributo duplicado');
        $variations[$ean][$label] = $value;
        $variations[$ean]['ean'] = $ean; // Default ean attribute

        $ean_product[$ean] = $product_id;

        // $i++;
        // if ($i>10000)
        //     break;
    }
    // fill products not present in attributes endpoint
    echo "filling products not present in attributes endpoint".nl();
    foreach(get_all_products() as $product) {
        if (!isset($products[$product->get_id()])) {
            echo "prod: ".$product->get_id().nl();
            $products[$product->get_id()] = ['ean' => []];
            $vars = $product->is_type( 'variable' ) ? $product->get_available_variations() : [];
            foreach($vars as $var) {
                $ean = get_post_meta($var['variation_id'], 'gsean', true);
                if (!$ean)
                    continue;
                echo "\tean: ".$ean.nl();
                $variations[$ean] = ['ean' => $ean];
                $ean_product[$ean] = $product->get_id();
                $products[$product->get_id()]['ean'][$ean] = true;
            }
        }
    }
    echo "finished: filling products not present in attributes endpoint".nl();
    $default = '-';
    // Add default value to products
    foreach($products as &$product) {
        foreach($product as &$attribute) {
            $attribute[$default] = true;
        }
    }
    // Add default value to variations
    foreach($variations as $ean => &$values) {
        $product_id = $ean_product[$ean];
        foreach($products[$product_id] as $label => $attr_values) {
            if (!isset($values[$label])) {
                $values[$label] = $default;
            }
        }
    }
    // var_dump($variations); die();
    return [$products, $variations, $ean_product];
}

function get_attribute_id($name) {
   //Look for existing attribute:
    $existingTaxes = wc_get_attribute_taxonomies();

    //attribute_labels is in the format: array("slug" => "label / name")
    $attribute_labels = wp_list_pluck( $existingTaxes, 'attribute_label', 'attribute_name' );
    $slug = array_search( $name, $attribute_labels, true );

    // shouldnt happend
    if (!$slug)
    {
        return null;
        //Not found, so create it:
        $slug = wc_sanitize_taxonomy_name($name);
        $attribute_id = create_global_attribute($name, $slug);
    }
    else
    {
        //Otherwise find it's ID
        //Taxonomies are in the format: array("slug" => 12, "slug" => 14)
        $taxonomies = wp_list_pluck($existingTaxes, 'attribute_id', 'attribute_name');

        if (!isset($taxonomies[$slug]))
        {
            //logg("Could not get wc attribute ID for attribute ".$name. " (slug: ".$slug.") which should have existed!");
            return null;
        }

        $attribute_id = (int)$taxonomies[$slug];
    }

    return $attribute_id;
}

function get_variation_attributes($theseAttributes) {
    //This is the final list of attributes that we are calculating below.
    $theseAttributesCalculated = array();

    //logg("Want to add these attributes to the variation: ".print_r($theseAttributes, true));

    $existingTax = wc_get_attribute_taxonomies();

    foreach ($theseAttributes as $name => $value)
    {
        if (strlen($name) == 0 || strlen($value) == 0)
        {
            //logg("Attribute array had a blank value for product variant ".$sku.': '.print_r($theseAttributes, true));
            return "Attribute array had a blank value.";
        }

        $tax = '';
        $slug = '';

        //Look for an existing taxonomy to match this attribute's $name
        //$thistax->attribute_name = slug of the taxonomy
        //$thistax->attribute_label = name of the taxonomy

        foreach ($existingTax as $thistax)
        {
            if ($thistax->attribute_label == $name)
            {
                $slug = $thistax->attribute_name;
                $tax = wc_attribute_taxonomy_name($slug);
                break;
            }
        }

        // shouldnt happend
        if (false && empty($tax))
        {
            $slug = wc_sanitize_taxonomy_name($name);
            //Taxonomy not found, so create it...
            if (create_global_attribute($name, $slug) > 0)
            {
                $tax = wc_attribute_taxonomy_name($slug);
            }
            else
            {
                //logg("Unable to create new attribute taxonomy ".$slug." for attribute ".$name."found in variable product ".$sku);
                continue;
            }
        }


        //logg("Want to add attribute ".$name. " value ".$value. " which is term ".$term_slug." (".$termId.") to post ".$parentID);

        $term = get_attribute_term($value, $tax);


        if ($term['id'])
        {
            // Set/save the attribute data in the product variation
            $theseAttributesCalculated[$tax] = $term['slug'];
        }
        else
        {
            //logg("Warning! Unable to create / get the attribute ".$value." in Taxonomy ".$tax);
        }
    }
    return $theseAttributesCalculated;
}

function get_attribute_term($value, $taxonomy) {
    //Look if there is already a term for this attribute?
    $term = get_term_by('name', $value, $taxonomy);

    if (!$term)
    {
        //No, create new term.
        $term = wp_insert_term($value, $taxonomy);
        if (is_wp_error($term))
        {
            //logg("Unable to create new attribute term for ".$value." in tax ".$taxonomy."! ".$term->get_error_message());
            return array('id'=>false, 'slug'=>false);
        }
        $termId = $term['term_id'];
        $term_slug = get_term($termId, $taxonomy)->slug; // Get the term slug
    }
    else
    {
        //Yes, grab it's id and slug
        $termId = $term->term_id;
        $term_slug = $term->slug;
    }

    return array('id'=>$termId, 'slug'=>$term_slug);
}

function delete_gs_attributes() {
    $tini = microtime(true);
    $attributes = json_decode(json_encode(wc_get_attribute_taxonomies()),true);
    sort($attributes);

    $i=0;    
    foreach ($attributes as $key => $attribute) {
        if (str_starts_with($attribute['attribute_name'], 'filtro-'))
            continue;
        $deleted = wc_delete_attribute( $attribute['attribute_id'] );
        print_r(sprintf("Deleting %s - Result %s \r\n",$attribute['attribute_label'], $deleted));
        $i++;
    }
    $tfin = microtime(true);
    $msg = "Deleted $i attributes in ".number_format($tfin-$tini,2)." seconds";
    echo $msg.nl();
    error_log($msg);
}