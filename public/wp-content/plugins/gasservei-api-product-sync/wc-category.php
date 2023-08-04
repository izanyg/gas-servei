<?php

if (!defined('ABSPATH'))
    exit;

function import_gs_categories()
{
    $tini = microtime(true);
    global $gasserveiapi;
    $cats = $gasserveiapi->categories();
    $translations = $gasserveiapi->categories_translations_id_keys();
    $last_inserted = [0];
    $now_inserted = [];
	mark_all_categories_unimported();

    $n=0;
    for($i=0;$i<100;$i++) {
        foreach($cats as $cat) {
            if (in_array($cat['Padre'], $last_inserted)) {
                $term_id = create_gs_cat($cat);
				create_gs_category_translations($term_id, $translations[$cat['id']] ?? null);
				echo str_repeat(' ',$i).'Imported category: '.$cat['id'].' ('.$cat['Nombre'].')'.nl();
		        $n++;
                $now_inserted[] = $cat['id'];
            }
            // if ($n>1)
            // 	break;
        }
        if (empty($now_inserted))
        	break;
        // echo implode(',', $now_inserted).'</br>';
        $last_inserted = $now_inserted;
        $now_inserted = [];
	    // if ($n>1)
	    // 	break;
    }
    gs_purge_unimported_categories();
    $tfin = microtime(true);
    error_log("Imported $n categories ".number_format($tfin-$tini,2)." seconds");
}

function get_gs_cat($id)
{

	$args = array(
	'hide_empty' => false, // also retrieve terms which are not used yet
	'meta_query' => array(
	    array(
	       'key'       => 'gsid',
	       'value'     => $id,
	       'compare'   => '='
	    )
	),
	'taxonomy'  => 'product_cat',
	);
	$terms = get_terms( $args );

	if (empty( $terms ))
		return null;
	if (is_wp_error( $terms ))
		throw new Exception("Can't find category", 1);
	return $terms[0];
}

// Assumes parent category exists
function create_gs_cat($cat)
{
    do_action( 'wpml_switch_language', GS_DEFAULT_LANGUAGE_CODE );
	if ($cat['Nombre']=='No Categoria')
		$cat['Slug'] = 'no-categoria';

	if ($cat['Padre']!=0)
		$cat['Padre'] = get_gs_cat($cat['Padre'])->term_id;
		
	if ($term = term_exists($cat['Slug'], 'product_cat')) {
		$ret = wp_update_term($term['term_id'], 'product_cat', [
			'name' => $cat['Nombre'],
			'description' => $cat['Descripcion'],
			'parent' => $cat['Padre'],
			'slug' => $cat['Slug'],
		]);
	} else {
		$ret = wp_insert_term( $cat['Nombre'], 'product_cat', [
			'description' => $cat['Descripcion'],
		    'parent' => $cat['Padre'],
		    'slug' => $cat['Slug'],
		]);		
	}
    if ($ret instanceof WP_Error) {
		echo ($term ? 'Updated' : 'Inserted').nl();
        var_dump($ret);
        die();
    }	
	$term_id = $ret['term_id'];
	gs_term_imported($term_id);

	update_term_meta($term_id, 'order', $cat['Orden']);
	update_term_meta($term_id, 'gsid', $cat['id']);
	if (get_term_meta($term_id, 'api_image', true)!=$cat['Imagen_destacada'] && 
		$cat['Imagen_destacada']!=null) {
    	$id = @media_sideload_image($cat['Imagen_destacada'], null, null, 'id');
    	if (is_wp_error($id))
    		var_dump($id);
    	if (!empty($id) && !is_wp_error($id)) {
			update_term_meta($term_id, 'api_image', $cat['Imagen_destacada']);
        	update_term_meta( $term_id, 'thumbnail_id', $id );
    	}
	}
    do_action( 'wpml_switch_language', ICL_LANGUAGE_CODE );

    return $term_id;
}

function delete_gs_categories() {
	gs_for_all_languages('delete_gs_categories_languages');
}

function delete_gs_categories_languages() {
	$args = array(
		'hide_empty' => false, // also retrieve terms which are not used yet
		// 'meta_query' => array(
		//     array(
		//        'key'       => 'gsid',
		// 	   'value'   => array(''),
		// 	   'compare' => 'NOT IN'
		//     )
		// ),
		'taxonomy'  => 'product_cat',
	);
	$terms = get_terms( $args );
	if (is_wp_error( $terms ))
		throw new Exception("Can't find category", 1);
	echo 'About to delete '.count($terms).' product categories'.nl();
	foreach($terms as $term) {
		wp_delete_term($term->term_id, 'product_cat');
		echo 'Deleted product category: '.$term->term_id.nl();
	}
}

add_filter('manage_edit-product_cat_columns', function($columns) {
	return array_merge($columns, ['gsid' => __('Gasservei ID', 'textdomain')]);
});
 
add_action('manage_product_cat_custom_column', function($content, $column, $id) {
	if ($column == 'gsid') {
		return get_term_meta($id, 'gsid', true);
	}
}, 10, 3);