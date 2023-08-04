<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

 
add_filter( 'woocommerce_variable_price_html', 'gss_variation_price_format', 10, 2 );
 
function gss_variation_price_format( $price, $product ) {
   $min_var_reg_price = $product->get_variation_regular_price( 'min', true );
   $max_var_reg_price = $product->get_variation_regular_price( 'max', true );

   if($min_var_reg_price !=  $max_var_reg_price){
       $price = '';
   }
   return $price;
}