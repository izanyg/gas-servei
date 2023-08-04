<?php

function shopkeeper_get_image_by_url( $image = '', $class = '', $alt = '' ) {

    $image_attr = array(
        'class' => $class,
        'alt' => $alt,
        'loading' => false
    );

    $image_id = attachment_url_to_postid($image);

    if( !empty($image_id) && is_int($image_id) ) {
        printf(
            '%2$s',
            esc_url(home_url('/')),
            wp_get_attachment_image( $image_id, 'full', false, $image_attr )
        );
    } else if( !empty($image) && filter_var($image, FILTER_VALIDATE_URL) ) {
        //then it must be the theme placeholder.
        printf(
            '<img class="%s" src="%s" alt="%s" />',
            $class,
            $image,
            $alt
        );
    }

    return;
}

/*
 * Get header logos
 */
function shopkeeper_get_logo() {

    $logo_class = '';

    $transparency = shopkeeper_get_transparency_options();
    $site_logo    = ( '' != Shopkeeper_Opt::getOption( 'site_logo' ) ) ? Shopkeeper_Opt::getOption( 'site_logo' ) : '';
    $sticky_logo  = ( '' != Shopkeeper_Opt::getOption( 'sticky_header_logo' ) ) ? Shopkeeper_Opt::getOption( 'sticky_header_logo' ) : '';
    $mobile_logo  = ( '' != Shopkeeper_Opt::getOption( 'mobile_header_logo' ) ) ? Shopkeeper_Opt::getOption( 'mobile_header_logo' ) : '';

    if( 'transparent_header' === $transparency['transparency_class'] ) {
        if( ( 'transparency_light' === $transparency['transparency_scheme'] ) && ( '' != Shopkeeper_Opt::getOption( 'light_transparent_header_logo', '' ) ) ) {
            $site_logo = Shopkeeper_Opt::getOption( 'light_transparent_header_logo', '' );
        }
        if ( ( 'transparency_dark' === $transparency['transparency_scheme'] ) && ( '' != Shopkeeper_Opt::getOption( 'dark_transparent_header_logo', '' ) ) ) {
            $site_logo = Shopkeeper_Opt::getOption( 'dark_transparent_header_logo', '' );
        }
    }

    if (is_ssl()) {
        $site_logo = str_replace("http://", "https://", $site_logo);
        $sticky_logo = str_replace("http://", "https://", $sticky_logo);
        $mobile_logo = str_replace("http://", "https://", $mobile_logo);
    }

    if( !empty($site_logo) ) {
        if ( empty($sticky_logo) ) {
            $sticky_logo = $site_logo;
        }

        if ( empty($mobile_logo) ) {
            $mobile_logo = $site_logo;
        }
    }

    ?>

    <div class="site-logo">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <?php if ( !empty($site_logo) ) { ?>
                <?php shopkeeper_get_image_by_url( $site_logo, 'site-logo-img', get_bloginfo( 'name' ) ); ?>
            <?php } else { ?>
                <div class="site-title"><?php bloginfo( 'name' ); ?></div>
            <?php } ?>
        </a>
    </div>

    <?php if( Shopkeeper_Opt::getOption( 'sticky_header', true ) ) { ?>
        <div class="sticky-logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <?php if ( !empty($sticky_logo) ) { ?>
                    <?php shopkeeper_get_image_by_url( $sticky_logo, 'sticky-logo-img', get_bloginfo( 'name' ) ); ?>
                <?php } else { ?>
                    <div class="site-title"><?php bloginfo( 'name' ); ?></div>
                <?php } ?>
            </a>
        </div>
    <?php } ?>

    <div class="mobile-logo">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <?php if ( !empty($mobile_logo) ) { ?>
                <?php shopkeeper_get_image_by_url( $mobile_logo, 'mobile-logo-img', get_bloginfo( 'name' ) ); ?>
            <?php } else { ?>
                <div class="site-title"><?php bloginfo( 'name' ); ?></div>
            <?php } ?>
        </a>
    </div>

    <?php

    return;
}

/*
 * Get header transparency info
 */
function shopkeeper_get_transparency_options() {

    $transparency_class  = ( Shopkeeper_Opt::getOption( 'main_header_transparency', false ) ) ? 'transparent_header' : '';
    $transparency_scheme = Shopkeeper_Opt::getOption( 'main_header_transparency_scheme', 'transparency_light' );

    $page_id = shopkeeper_get_page_id();

    if( (get_post_meta($page_id, 'page_header_transparency', true)) && (get_post_meta($page_id, 'page_header_transparency', true) != "inherit") ) {
        $transparency_class  = 'transparent_header';
        $transparency_scheme = get_post_meta( $page_id, 'page_header_transparency', true );
    }

    if( (get_post_meta($page_id, 'page_header_transparency', true)) && (get_post_meta($page_id, 'page_header_transparency', true) == "no_transparency") ) {
        $transparency_class = '';
        $transparency_scheme = '';
    }

    if( SHOPKEEPER_WOOCOMMERCE_IS_ACTIVE ) {
        if ( is_product_category() && is_woocommerce() ) {
            if ( 'inherit' === Shopkeeper_Opt::getOption( 'shop_category_header_transparency_scheme', 'no_transparency' ) ) {
                // do nothing, inherit
            }
            else if( 'no_transparency' === Shopkeeper_Opt::getOption( 'shop_category_header_transparency_scheme', 'no_transparency' ) ) {
                $transparency_class = '';
                $transparency_scheme = '';
            }
            else {
                $transparency_class = 'transparent_header';
                $transparency_scheme = Shopkeeper_Opt::getOption( 'shop_category_header_transparency_scheme', 'no_transparency' );
            }
        }

        if ( is_product() && is_woocommerce() ) {
            if ( 'inherit' === Shopkeeper_Opt::getOption( 'shop_product_header_transparency_scheme', 'no_transparency' ) ) {
                // do nothing, inherit
            }
            else if( 'no_transparency' === Shopkeeper_Opt::getOption( 'shop_product_header_transparency_scheme', 'no_transparency' ) ) {
                $transparency_class = '';
                $transparency_scheme = '';
            }
            else {
                $transparency_class = 'transparent_header';
                $transparency_scheme = Shopkeeper_Opt::getOption( 'shop_product_header_transparency_scheme', 'no_transparency' );
            }

            if( (get_post_meta($page_id, 'product_header_transparency', true)) && (get_post_meta($page_id, 'product_header_transparency', true) != "inherit") ) {
                $transparency_class  = 'transparent_header';
                $transparency_scheme = get_post_meta( $page_id, 'product_header_transparency', true );
            }

            if( (get_post_meta($page_id, 'product_header_transparency', true)) && (get_post_meta($page_id, 'product_header_transparency', true) == "no_transparency") ) {
                $transparency_class = '';
                $transparency_scheme = '';
            }
        }
    }

    return array( 'transparency_class' => $transparency_class, 'transparency_scheme' => $transparency_scheme );
}

/*
 * Get tool icons
 */
function shopkeeper_get_header_tool_icons() {
    ?>
    <ul>
        <?php if( SHOPKEEPER_WISHLIST_IS_ACTIVE && Shopkeeper_Opt::getOption( 'main_header_wishlist', true ) ) { ?>
            <li class="wishlist-button">
                <a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>" class="tools_button">
                    <span class="tools_button_icon">
                        <?php if( !empty( Shopkeeper_Opt::getOption( 'main_header_wishlist_icon', '' ) ) ) { ?>
                            <?php shopkeeper_get_image_by_url( Shopkeeper_Opt::getOption( 'main_header_wishlist_icon', '' ), '', 'Wishlist Custom Icon' ); ?>
                        <?php } else { ?>
                            <i class="spk-icon spk-icon-heart"></i>
                        <?php } ?>
                    </span>
                    <span class="wishlist_items_number"><?php echo yith_wcwl_count_products(); ?></span>
                </a>
            </li>
        <?php } ?>

        <?php if( SHOPKEEPER_WOOCOMMERCE_IS_ACTIVE ) { ?>
            <?php if( Shopkeeper_Opt::getOption( 'main_header_shopping_bag', true ) && !Shopkeeper_Opt::getOption( 'catalog_mode', false ) ) { ?>
                <li class="shopping-bag-button">
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="tools_button">
                        <span class="tools_button_icon">
                            <?php if( !empty( Shopkeeper_Opt::getOption( 'main_header_shopping_bag_icon', '' ) ) ) { ?>
                                <?php shopkeeper_get_image_by_url( Shopkeeper_Opt::getOption( 'main_header_shopping_bag_icon', '' ), '', 'Shopping Bag Custom Icon' ); ?>
                            <?php } else { ?>
                                <i class="spk-icon spk-icon-cart-shopkeeper"></i>
                            <?php } ?>
                        </span>
                        <span class="shopping_bag_items_number"><?php echo is_object( WC()->cart ) ? WC()->cart->get_cart_contents_count() : ''; ?></span>
                    </a>

                    <!-- Mini Cart -->
                    <div class="shopkeeper-mini-cart">
                        <?php if ( class_exists( 'WC_Widget_Cart' ) ) { the_widget( 'WC_Widget_Cart' ); } ?>

                        <?php
                        if( !empty( Shopkeeper_Opt::getOption( 'main_header_minicart_message', '' ) ) ):
                            echo '<div class="minicart-message">';
                            printf( esc_html__( '%s', 'shopkeeper' ), Shopkeeper_Opt::getOption( 'main_header_minicart_message', '' ));
                            echo '</div>';
                        endif;
                        ?>
                    </div>
                </li>
            <?php } ?>

            <?php if( Shopkeeper_Opt::getOption( 'my_account_icon_state', true ) ) { ?>
                <li class="my_account_icon">
                    <a class="tools_button" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
                        <span class="tools_button_icon">
                            <?php if( !empty( Shopkeeper_Opt::getOption( 'custom_my_account_icon', '' ) ) ) { ?>
                                <?php shopkeeper_get_image_by_url( Shopkeeper_Opt::getOption( 'custom_my_account_icon', '' ), '', 'Account Custom Icon' ); ?>
                            <?php } else { ?>
                                <i class="spk-icon spk-icon-user-account"></i>
                            <?php } ?>
                        </span>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>

        <?php if( Shopkeeper_Opt::getOption( 'main_header_search_bar', true ) ) { ?>
            <li class="offcanvas-menu-button search-button">
                <a class="tools_button" data-toggle="offCanvasTop1">
                    <span class="tools_button_icon">
                        <?php if ( !empty( Shopkeeper_Opt::getOption( 'main_header_search_bar_icon', '' ) ) ) { ?>
                            <?php shopkeeper_get_image_by_url( Shopkeeper_Opt::getOption( 'main_header_search_bar_icon', '' ), '', 'Search Custom Icon' ); ?>
                        <?php } else { ?>
                            <i class="spk-icon spk-icon-search"></i>
                        <?php } ?>
                    </span>
                </a>
            </li>
        <?php } ?>

        <?php $icon_display_class = ( !wp_is_mobile() && !Shopkeeper_Opt::getOption( 'main_header_off_canvas', false ) ) ? 'hide-for-large' : ''; ?>
        <li class="offcanvas-menu-button <?php echo esc_attr($icon_display_class); ?>">
            <a class="tools_button" data-toggle="offCanvasRight1">
                <span class="tools_button_icon">
                    <?php if( !empty( Shopkeeper_Opt::getOption( 'main_header_off_canvas_icon', '' ) ) ) { ?>
                        <?php shopkeeper_get_image_by_url( Shopkeeper_Opt::getOption( 'main_header_off_canvas_icon', '' ), '', 'Offcanvas Menu Custom Icon' ); ?>
                    <?php } else { ?>
                        <i class="spk-icon spk-icon-menu"></i>
                    <?php } ?>
                </span>
            </a>
        </li>
    </ul>
    <?php

    return;
}

/*
 * Get header menu
 */
function shopkeeper_get_menu( $menu_classes = 'main-navigation', $location = 'main-navigation', $walker = 0, $check_nav = false ) {

    if($check_nav) shopkeeper_custom_nav_menus();

    if( has_nav_menu( $location ) ) {
        ?>
        <nav class="<?php echo esc_html($menu_classes); ?>" role="navigation" aria-label="Main Menu">
            <?php
                $args = array(
                    'theme_location'  => $location,
                    'fallback_cb'     => false,
                    'container'       => false,
                    'items_wrap'      => '<ul class="%1$s">%3$s</ul>'
                );

                if( $walker && class_exists('SK_Extender_Custom_Menu_Output') ) {
                    $args['walker'] = new SK_Extender_Custom_Menu_Output;
                }

                wp_nav_menu( $args );
            ?>
        </nav>
        <?php
    }

    return;
}

/*
 * Header Components
 */
add_action( 'wp_header_components', 'shopkeeper_after_header_components' );
function shopkeeper_after_header_components() { ?>

    <!-- Mobile Menu Offcanvas -->
    <div class="off-canvas menu-offcanvas <?php echo is_rtl() ? 'position-left' : 'position-right' ?> " id="offCanvasRight1" data-off-canvas>

        <div class="menu-close hide-for-medium">
            <button class="close-button" aria-label="Close menu" type="button" data-close>
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div id="mobiles-menu-offcanvas">

            <?php

            $display_class = !wp_is_mobile() ? 'hide-for-large' : '';

            $header_layout = Shopkeeper_Opt::getOption( 'main_header_layout', '1' );
            $header_layout_style = ('2' === $header_layout) || ('22' === $header_layout) ? 'centered' : 'default';

            if( 'centered' != $header_layout_style ) {
                shopkeeper_get_menu( 'mobile-navigation primary-navigation ' . $display_class, 'main-navigation', 0 );
            } else {
                shopkeeper_get_menu( 'mobile-navigation ' . $display_class, 'centered_header_left_navigation', 0 );
                shopkeeper_get_menu( 'mobile-navigation ' . $display_class, 'centered_header_right_navigation', 0 );
            }

            if( Shopkeeper_Opt::getOption( 'main_header_off_canvas', false ) ) {
                shopkeeper_get_menu( 'mobile-navigation', 'secondary_navigation', 0 );
            }

            if( Shopkeeper_Opt::getOption( 'top_bar_switch', false ) ) {
                shopkeeper_get_menu( 'mobile-navigation ' . $display_class, 'top-bar-navigation', 0 );
            }

            $theme_locations  = get_nav_menu_locations();
            if (isset($theme_locations['top-bar-navigation'])) {
                $menu_obj = get_term($theme_locations['top-bar-navigation'], 'nav_menu');
            }

            if ( is_user_logged_in() ) {
                echo '<nav class="mobile-navigation ' . $display_class . '" role="navigation" aria-label="Mobile Menu">';
                echo '<ul><li class="menu-item"><a href="' . get_home_url() . '/?' . get_option('woocommerce_logout_endpoint') . '=true" class="logout_link">' . esc_html__('Logout', 'woocommerce') . '</a></li></ul>';
                echo '</nav>';
            }

            ?>

        </div>

        <?php if ( is_active_sidebar( 'offcanvas-widget-area' ) ) : ?>
            <div class="shop_sidebar wpb_widgetised_column">
                <?php dynamic_sidebar( 'offcanvas-widget-area' ); ?>
            </div>
        <?php endif; ?>

    </div>

    <!-- Site Search -->
    <div class="off-canvas-wrapper">
        <div class="site-search off-canvas position-top is-transition-overlap" id="offCanvasTop1" data-off-canvas>
            <div class="row has-scrollbar">
                <div class="site-search-close">
                    <button class="close-button" aria-label="Close menu" type="button" data-close>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <p class="search-text">
                    <?php esc_html_e('What are you looking for?', 'shopkeeper'); ?>
                </p>
                <?php
                if ( SHOPKEEPER_WOOCOMMERCE_IS_ACTIVE ) {
                    if ( Shopkeeper_Opt::getOption( 'predictive_search', true ) ) {
                        do_action( 'getbowtied_product_search' );
                    } else {
                        the_widget( 'WC_Widget_Product_Search', 'title=' );
                    }
                } else {
                    the_widget( 'WP_Widget_Search', 'title=' );
                }
                ?>
            </div>
        </div>
    </div><!-- .site-search -->

    <?php

    return;
}
