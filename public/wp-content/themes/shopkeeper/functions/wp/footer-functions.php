<?php

/*
 * Footer Components
 */
add_action( 'wp_footer_components', 'shopkeeper_after_footer_components' );
function shopkeeper_after_footer_components() { ?>

    <!-- Filters Offcanvas -->
    <?php if (class_exists('WooCommerce') && (is_shop() || is_product_category() || is_product_tag() || (is_tax() && is_woocommerce() ))) : ?>
        <div class="off-canvas-wrapper">
            <div class="off-canvas <?php echo is_rtl() ? 'position-right' : 'position-left' ?> <?php echo ( is_active_sidebar( 'catalog-widget-area' ) && ( Shopkeeper_Opt::getOption( 'sidebar_style', '1' ) == '0' ) ) ? 'hide-for-large':''; ?> <?php echo ( is_active_sidebar( 'catalog-widget-area' ) ) ? 'shop-has-sidebar':''; ?>" id="offCanvasLeft1" data-off-canvas>

                <div class="menu-close hide-for-medium">
                    <button class="close-button" aria-label="Close menu" type="button" data-close>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="offcanvas_content_left wpb_widgetised_column">
                    <div id="filters-offcanvas">
                        <?php if ( is_active_sidebar( 'catalog-widget-area' ) ) : ?>
                            <?php dynamic_sidebar( 'catalog-widget-area' ); ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    <?php endif; ?>

    <!-- Back To Top Button -->
    <?php if( Shopkeeper_Opt::getOption( 'back_to_top_button', false ) ) : ?>
        <a href="#0" class="cd-top progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
            </svg>
        </a>
    <?php endif; ?>

    <!-- Product Quick View -->
    <div class="cd-quick-view woocommerce"></div>

    <?php

    return;
}
