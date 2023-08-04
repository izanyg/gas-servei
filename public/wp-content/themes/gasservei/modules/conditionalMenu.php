<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
if (function_exists('is_gs_distributor')) {

    function theme_wp_nav_menu_args($sorted_menu_items, $args)
    {
        foreach ($sorted_menu_items as $key => $item) {
            if (in_array('if-distributor', $item->classes) && !is_gs_distributor())
                unset($sorted_menu_items[$key]);
            if (in_array('if-not-distributor', $item->classes) && is_gs_distributor())
                unset($sorted_menu_items[$key]);
        }
        return $sorted_menu_items;
    }
    add_filter('wp_nav_menu_objects', 'theme_wp_nav_menu_args', 10, 2);
}
