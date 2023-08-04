<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

function mimotic_get_product_terms( $term_id ) {    
    $html = '';    
    $args = array( 'hide_empty' => 1, 'parent' => $term_id );    
    $terms = get_terms('product_cat', $args);
    $current = get_queried_object_id();
    foreach ($terms as $term) {   
        $html .= '<li';  
        
        $classes = '';

        if( $term_id == 0 ) {    
            $classes .= ' top_li';    
        }

        if( $term->term_id == $current ) {    
            $classes .= ' current-item';    
        }
        $parents = get_ancestors($current, 'product_cat');

        if( in_array($term->term_id, $parents) ) {    
            $classes .= ' current-parent';    
        }
        $subitems = mimotic_get_product_terms( $term->term_id );

        if( $subitems ) {    
            $classes .= ' has-children';    
        }
        

        $html .= ' class="'. $classes .'">';
        
        $html .= '<div class="link-container">';
        
        $html .= '<a href="'.get_term_link($term->slug, 'product_cat').'">' . $term->name . '</a>';   

        if( $subitems ) {    
            $html .= '<div class="arrow-container"><svg class="arrow" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.5 15.3332C11.3739 15.3339 11.2489 15.3097 11.1321 15.262C11.0153 15.2144 10.9091 15.1441 10.8196 15.0553L5.06959 9.30527C4.88913 9.12481 4.78775 8.88006 4.78775 8.62485C4.78775 8.36965 4.88913 8.12489 5.06959 7.94444C5.25005 7.76398 5.4948 7.6626 5.75 7.6626C6.00521 7.6626 6.24996 7.76398 6.43042 7.94444L11.5 13.0236L16.5696 7.95402C16.7529 7.79702 16.9887 7.71498 17.2299 7.7243C17.4711 7.73361 17.6999 7.8336 17.8706 8.00427C18.0413 8.17494 18.1412 8.40374 18.1506 8.64493C18.1599 8.88612 18.0778 9.12194 17.9208 9.30527L12.1708 15.0553C11.9923 15.2323 11.7514 15.3321 11.5 15.3332Z" fill="#021433"/>
            </svg></div>';    
        }
        $html .= '</div>';

        if( $subitems ) {    
            $html .= '<ul class="submenu">'.$subitems.'</ul>';    
        }

        $html .= '</li>';    
    }    
    return $html;    
}

// add_action('woocommerce_sidebar', 'mimotic_print_product_terms', 0);

function mimotic_print_product_terms(){    
    $current = get_queried_object_id();
    $ancestors = get_ancestors( $current, 'product_cat');
    $ancestor_id = 0;
    if(is_array($ancestors) || !empty($ancestors)){
        $ancestor_id = end($ancestors);
    }
    if( $list = mimotic_get_product_terms( $ancestor_id )) {
        echo '<ul id="gss_sidebar_categories">' . $list . '</ul>';
    }
}
add_shortcode( 'gss_shop_categories', 'mimotic_print_product_terms' );