<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

function gs_categories_tree(){
    $terms = false;
    if( is_shop() ) :
        $terms = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => true, 
            'parent' => 0
        ]);
    else:
        $terms = get_terms([
            'taxonomy' => get_queried_object()->taxonomy,
            'hide_empty' => true, 
            'parent'   => get_queried_object_id(),
        ]);    
    endif; 

    if(!empty($terms)){
        echo '<div id="categories-tree">';
        foreach ( $terms as $term) {
            echo '<p class="subcategory"><a href="' . get_term_link( $term ) . '">' . $term->name . '</a></p>';  
        }
        echo '</div>';
    }
}


add_shortcode('categories_tree', 'gs_categories_tree');