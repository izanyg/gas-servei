<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
if (!is_admin()) {
    add_filter('posts_search', 'woocommerce_search_product_tag_extended', 999, 2);
    function woocommerce_search_product_tag_extended($search, $query)
    {
        global $wpdb, $wp;

        $qvars = $wp->query_vars;


        // Here set your custom taxonomy
        $taxonomy = 'pa_marca'; // WooCommerce product tag

        $termIds = get_terms([
            'name__like' => empty($qvars['s']) ? '' : esc_attr($qvars['s']),
            'fields' => 'ids'
        ]);

        $ids = get_posts(array(
            'posts_per_page' => -1,
            'post_type' => 'product',
            'post_status' => 'publish',
            'fields' => 'ids',
            'tax_query' => array(array(
                'taxonomy' => $taxonomy,
                'field' => 'id',
                'terms' => $termIds,
            )),
        ));

        if (count($ids) > 0) {
            $search = str_replace('AND (((', "AND ((({$wpdb->posts}.ID IN (" . implode(',', $ids) . ")) OR (", $search);
        }
        return $search;
    }
}
