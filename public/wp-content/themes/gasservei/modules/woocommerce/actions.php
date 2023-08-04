<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Continue shopping button on cart page
 */

function mimotic_add_continue_shopping_button_to_checkout() {
	$shop_page_url = get_home_url();
	if ( !empty($shop_page_url) ) {
		echo '<div class="shopkeeper-continue-shopping">';
		echo ' <a href="'.$shop_page_url.'" class="button">'. esc_html__('Continue shopping', 'woocommerce') .'</a>';
		echo '</div>';
	}
}
add_action( 'woocommerce_after_cart', 'mimotic_add_continue_shopping_button_to_checkout');

add_action('init' , 'gss_remove_functions' , 15 );
function gss_remove_functions() {
  $priority = has_action('woocommerce_after_cart', 'shopkeeper_add_continue_shopping_button_to_cart');
  remove_action( 'woocommerce_after_cart', 'shopkeeper_add_continue_shopping_button_to_cart', $priority );
}



// define the woocommerce_grouped_product_columns callback 
function gss_woocommerce_grouped_product_columns( $array, $product ){     
   foreach($product->get_children() as $child){
     $prod = wc_get_product($child);
     $attrs = $prod->get_attributes();
     foreach($attrs as $name => $attr){
       $slug = $name;
       if (!in_array($slug, $array)){
         array_push( $array, $slug );
       }
     }
   }
    return $array;
} 

//add the action 
add_filter('woocommerce_grouped_product_columns', 'gss_woocommerce_grouped_product_columns', 10, 2);

function exclude_product_cat_children($wp_query) {
  if ( $wp_query->is_archive() && isset ( $wp_query->query_vars['product_cat'] ) && $wp_query->is_main_query() && is_array($wp_query->get( 'tax_query' ))) {
    $tax_query = $wp_query->get( 'tax_query' );
    $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
    $min_price = isset($_GET['min_price']) ? wc_clean($_GET['min_price']) : 0;
    $max_price = isset($_GET['max_price']) ? wc_clean($_GET['max_price']) : 0;
  
    
    $meta_query = array();

   array_push($tax_query, array(
          'taxonomy' => 'product_cat',
          'field' => 'slug',
          'terms' => $wp_query->query_vars['product_cat'],
          'include_children' => false
      ) 
    );
   
  
    if($min_price){
      array_push($meta_query, array(
          'key'     => '_price',
          'value'   => reset($min_price), // From price value
          'compare' => '>=',
          'type'    => 'NUMERIC'
        )
      );
    }
  
    if($max_price){
      array_push($meta_query, array(
          'key'     => '_price',
          'value'   => reset($max_price), // From price value
          'compare' => '<=',
          'type'    => 'NUMERIC'
        )
      );
    }
  
    foreach($_chosen_attributes as $taxonomy => $data){
      $tax_query[] = array(
        'taxonomy'         => $taxonomy,
        'field'            => 'slug',
        'terms'            => $data['terms'],
        'operator'         => 'and' === $data['query_type'] ? 'AND' : 'IN',
        'include_children' => false,
      );
    }
      $wp_query->set(
        'tax_query', 
        $tax_query
      );
    }
  }  
  add_filter('pre_get_posts', 'exclude_product_cat_children'); 


  remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price',10);

