<?php
/**
 * Customizer controls.
 *
 * @package shopkeeper
 */

/**
* Header.
*/
include_once( get_template_directory() . '/inc/customizer/backend/sections/header/header-styles.php' );
include_once( get_template_directory() . '/inc/customizer/backend/sections/header/header-colors.php' );
include_once( get_template_directory() . '/inc/customizer/backend/sections/header/header-transparency.php' );
include_once( get_template_directory() . '/inc/customizer/backend/sections/header/header-elements.php' );
include_once( get_template_directory() . '/inc/customizer/backend/sections/header/header-logo.php' );
include_once( get_template_directory() . '/inc/customizer/backend/sections/header/header-topbar.php' );
include_once( get_template_directory() . '/inc/customizer/backend/sections/header/header-sticky.php' );
include_once( get_template_directory() . '/inc/customizer/backend/sections/header/header-mobile.php' );
include_once( get_template_directory() . '/inc/customizer/backend/sections/header/header-search.php' );

/**
* Footer.
*/
include_once( get_template_directory() . '/inc/customizer/backend/sections/section-footer.php' );

/**
* Styling.
*/
include_once( get_template_directory() . '/inc/customizer/backend/sections/section-styling.php' );

/**
* Blog and Single Post.
*/
include_once( get_template_directory() . '/inc/customizer/backend/sections/section-blog.php' );

/**
* Fonts.
*/
include_once( get_template_directory() . '/inc/customizer/backend/sections/section-fonts.php' );

if( SHOPKEEPER_WOOCOMMERCE_IS_ACTIVE ) {

    /**
    * Shop Page.
    */
    include_once( get_template_directory() . '/inc/customizer/backend/sections/shop/shop-catalog-mode.php' );
    include_once( get_template_directory() . '/inc/customizer/backend/sections/shop/shop-layout.php' );
    include_once( get_template_directory() . '/inc/customizer/backend/sections/shop/shop-mobile.php' );
    include_once( get_template_directory() . '/inc/customizer/backend/sections/shop/shop-notifications.php' );
    include_once( get_template_directory() . '/inc/customizer/backend/sections/shop/shop-product-badges.php' );
    include_once( get_template_directory() . '/inc/customizer/backend/sections/shop/shop-product-card.php' );

    /**
    * Product Page.
    */
    include_once( get_template_directory() . '/inc/customizer/backend/sections/section-product.php' );
}
