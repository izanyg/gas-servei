<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}



/*
 * Get tool icons
 * Same but extended as shopkeeper_get_header_tool_icons
 */
function mimotic_shopkeeper_get_header_tool_icons() {
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
                <li class="my_account">
                    <a class="tools_button" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
                        <span class="tools_account_text">
                            <?php 
                            if ( is_user_logged_in() ) { 
                                _e('MY ACCOUNT', 'gasservei');
                            } else { 
                                _e('LOGIN/REGISTER', 'gasservei') ;
                            } 
                            ?>
                        </span>

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