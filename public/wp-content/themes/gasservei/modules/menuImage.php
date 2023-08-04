<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}


add_filter('wp_nav_menu_objects', 'gss_nav_menu_objects', 10, 2);

function gss_nav_menu_objects( $items, $args ) {
	
	// loop
	foreach( $items as &$item ) {
		
		// vars
		$image = get_field('imagen', $item);
		$item->title = '<span>' . $item->title . '</span>';
		// append icon
		if( $image ) {
		
            // Image variables.
            $alt = $image['alt'];
            $size = 'thumbnail';
            $thumb = $image['sizes'][ $size ];

            $item->title .= '<img src="' . esc_url($thumb) . '" alt="' . esc_attr($alt) . '" />';
			
		}
		
	}
	
	
	// return
	return $items;
	
}