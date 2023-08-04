<?php
/**
* The Blog section options.
*
* @package shopkeeper
*/

/**
 * Checks if blog layout is 1 or 2.
 */
function sk_is_blog_sidebar_layout(){
   if( ( 'layout-1' === Shopkeeper_Opt::getOption( 'layout_blog', 'layout-3' ) ) || ( 'layout-2' === Shopkeeper_Opt::getOption( 'layout_blog', 'layout-3' ) ) ) {
       return true;
   }
   return false;
}

/**
 * Checks if post sidebar is enabled.
 */
function sk_is_post_sidebar_not_enabled(){

    return !Shopkeeper_Opt::getOption( 'single_post_sidebar', false );
}

add_action( 'customize_register', 'shopkeeper_customizer_blog_controls' );
/**
 * Adds controls for blog section.
 *
 * @param  [object] $wp_customize [customizer object].
 */
function shopkeeper_customizer_blog_controls( $wp_customize ) {

    /* Blog Archive. */

    // Blog Layout.
    $wp_customize->add_setting(
        'layout_blog',
        array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'shopkeeper_sanitize_select',
            'default'           => 'layout-3',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'layout_blog',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Blog Layout', 'shopkeeper' ),
                'section'  => 'blog_archive',
                'priority' => 10,
                'choices'  => array(
                    'layout-1' => esc_html__( '3 Columns Grid', 'shopkeeper' ),
                    'layout-2' => esc_html__( 'One Column', 'shopkeeper' ),
                    'layout-3' => esc_html__( 'Masonry Grid', 'shopkeeper' ),
                ),
            )
        )
    );

    // Blog Sidebar.
    $wp_customize->add_setting(
        'sidebar_blog_listing',
        array(
            'type'                 => 'theme_mod',
            'capability'           => 'edit_theme_options',
            'sanitize_callback'    => 'shopkeeper_sanitize_checkbox',
            'default'              => false,
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'sidebar_blog_listing',
            array(
                'type'     => 'checkbox',
                'label'    => esc_html__( 'Blog Sidebar', 'shopkeeper' ),
                'section'  => 'blog_archive',
                'priority' => 10,
                'active_callback' => 'sk_is_blog_sidebar_layout',
            )
        )
    );

    // Blog Pagination Style.
    $wp_customize->add_setting(
        'pagination_blog',
        array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'shopkeeper_sanitize_select',
            'default'           => 'infinite_scroll',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'pagination_blog',
            array(
                'type'     => 'select',
                'label'    => esc_html__( 'Blog Pagination Style', 'shopkeeper' ),
                'section'  => 'blog_archive',
                'priority' => 10,
                'choices'  => array(
                    'classic'           => esc_html__( 'Classic', 'shopkeeper' ),
                    'load_more_button'  => esc_html__( 'Load More', 'shopkeeper' ),
                    'infinite_scroll'   => esc_html__( 'Infinite', 'shopkeeper' ),
                ),
            )
        )
    );

   /* Single Post. */

   // Post Sidebar.
   $wp_customize->add_setting(
       'single_post_sidebar',
       array(
           'type'                 => 'theme_mod',
           'capability'           => 'edit_theme_options',
           'sanitize_callback'    => 'shopkeeper_sanitize_checkbox',
           'default'              => false,
       )
   );

   $wp_customize->add_control(
       new WP_Customize_Control(
           $wp_customize,
           'single_post_sidebar',
           array(
               'type'     => 'checkbox',
               'label'    => esc_html__( 'Post Sidebar', 'shopkeeper' ),
               'section'  => 'single_post',
               'priority' => 10,
           )
       )
   );

   // Content Width.
   $wp_customize->add_setting(
       'single_post_width',
       array(
           'type'       => 'theme_mod',
           'capability' => 'edit_theme_options',
           'sanitize_callback' => 'absint',
           'default'    => 708,
       )
   );

   $wp_customize->add_control(
       new WP_Customize_Control(
           $wp_customize,
           'single_post_width',
           array(
               'type'        => 'number',
               'label'       => esc_html__( 'Content Width', 'shopkeeper' ),
               'description' => esc_html__( "(708px - 960px)", 'shopkeeper' ),
               'section'     => 'single_post',
               'priority'    => 10,
               'input_attrs' => array(
                   'min'  => 708,
                   'max'  => 960,
                   'step' => 1,
               ),
               'active_callback' => 'sk_is_post_sidebar_not_enabled',
           )
       )
   );

   // Author.
   $wp_customize->add_setting(
       'post_meta_author',
       array(
           'type'                 => 'theme_mod',
           'capability'           => 'edit_theme_options',
           'sanitize_callback'    => 'shopkeeper_sanitize_checkbox',
           'default'              => true,
       )
   );

   $wp_customize->add_control(
       new WP_Customize_Control(
           $wp_customize,
           'post_meta_author',
           array(
               'type'     => 'checkbox',
               'label'    => esc_html__( 'Author', 'shopkeeper' ),
               'section'  => 'single_post',
               'priority' => 10,
           )
       )
   );

   // Date.
   $wp_customize->add_setting(
       'post_meta_date',
       array(
           'type'                 => 'theme_mod',
           'capability'           => 'edit_theme_options',
           'sanitize_callback'    => 'shopkeeper_sanitize_checkbox',
           'default'              => true,
       )
   );

   $wp_customize->add_control(
       new WP_Customize_Control(
           $wp_customize,
           'post_meta_date',
           array(
               'type'     => 'checkbox',
               'label'    => esc_html__( 'Date', 'shopkeeper' ),
               'section'  => 'single_post',
               'priority' => 10,
           )
       )
   );

   // Categories.
   $wp_customize->add_setting(
       'post_meta_categories',
       array(
           'type'                 => 'theme_mod',
           'capability'           => 'edit_theme_options',
           'sanitize_callback'    => 'shopkeeper_sanitize_checkbox',
           'default'              => true,
       )
   );

   $wp_customize->add_control(
       new WP_Customize_Control(
           $wp_customize,
           'post_meta_categories',
           array(
               'type'     => 'checkbox',
               'label'    => esc_html__( 'Categories', 'shopkeeper' ),
               'section'  => 'single_post',
               'priority' => 10,
           )
       )
   );
}
