<?php

function gss_register_custom_post_distribuidores() {

	/**
	 * Post Type: Distribuidors.
	 */

	$labels = array(
		"name" => __( "Distribuidors", "custom-post-type-ui" ),
		"singular_name" => __( "Distribuidor", "custom-post-type-ui" ),
	);

	$args = array(
		"label" => __( "Distribuidors", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "distribuidores", "with_front" => true ),
		"query_var" => true,
		"menu_icon" => "https://gas-servei.com/wp-content/uploads/2017/11/truck.png",
		"supports" => array( "title", "editor", "thumbnail" ),
	);

	register_post_type( "distribuidores", $args );
}

add_action( 'init', 'gss_register_custom_post_distribuidores' );



