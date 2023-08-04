<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

add_filter( 'woocommerce_get_filtered_term_product_counts_query', function ( $query ) {
    global $wpdb, $wp;
   
    $qvars = $wp->query_vars;
   
    // Check if wpml is enabled
    if( class_exists( 'WPML_String_Translation' ) ) {
        $query['select'] = "SELECT COUNT( DISTINCT translations.trid ) AS term_count, terms.term_id AS term_count_id";
        $query['join'] .= "INNER JOIN gss_icl_translations translations ON gss_posts.ID = translations.element_id";
    }
   
    if(isset($qvars['s'])) {
    
        // vies wp-content/themes/gasservei/modules/woocommerce/addCategoriesToSearchQuery.php
        $taxonomy = 'pa_marca'; // WooCommerce product tag
    
        // tax_query use operator like
        $termIds = get_terms([
            'name__like' => esc_attr($qvars['s']),
            'fields' => 'ids'
        ]);
    
        $ids = get_posts(
            array(
                'posts_per_page' => -1,
                'post_type' => 'product',
                'post_status' => 'publish',
                'fields' => 'ids',
                'tax_query' => 
                    array(
                        array(
                            'taxonomy' => $taxonomy,
                            'field' => 'id',
                            'terms' => $termIds,
                        )
                    ),
            )
        );
    
        $query['where'] = str_replace(
            'gss_posts.post_title LIKE',
            ' ( gss_posts.ID IN ( '.implode(',', $ids).' )) OR gss_posts.post_title LIKE',
            $query['where']
        );
    }
   
    return $query; 
}, 10, 1 );



