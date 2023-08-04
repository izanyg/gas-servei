<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}

function search_by_sku($search, $query_vars)
{
  global $wpdb;

  if (isset($query_vars->query['s']) && !empty($query_vars->query['s'])) {
    $search_terms = $query_vars->query['s'];

    $product_ids = $wpdb->get_col($wpdb->prepare(
      "SELECT DISTINCT p.ID
      FROM {$wpdb->posts} AS p
      LEFT JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
      WHERE 
        p.post_type = 'product'
      
      AND p.post_status = 'publish'
      AND (
        (pm.meta_key = '_sku' AND pm.meta_value LIKE '%" . $wpdb->esc_like($search_terms) . "%')
        OR p.post_title LIKE '%" . $wpdb->esc_like($search_terms) . "%'
      )"
    ));

    $subproduct_ids = $wpdb->get_col($wpdb->prepare(
      "SELECT DISTINCT p.post_parent
      FROM {$wpdb->posts} AS p
      LEFT JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
      WHERE 
        p.post_type = 'product_variation'
      
      AND p.post_status = 'publish'
      AND (
        (pm.meta_key = '_sku' AND pm.meta_value LIKE '%" . $wpdb->esc_like($search_terms) . "%')
        OR p.post_title LIKE '%" . $wpdb->esc_like($search_terms) . "%'
      )",
    ));

    $final_ids = array_merge($product_ids, $subproduct_ids);

    if (!empty($final_ids)) {
      $product_ids_string = implode(',', $final_ids);
      $search = " AND ({$wpdb->posts}.ID IN ({$product_ids_string}) OR {$wpdb->posts}.post_parent IN ({$product_ids_string}))";
    }
  }

  return $search;
}
add_filter('posts_search', 'search_by_sku', 10, 2);
