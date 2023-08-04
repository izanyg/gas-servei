<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $animateCounter;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

// Actions and filters
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

add_action( 'woocommerce_shop_loop_item_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_shop_loop_item_sale_badge', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_shop_loop_item_sale_badge', 'shopkeeper_new_product_badge', 10 );

if( '1' == Shopkeeper_Opt::getOption( 'add_to_cart_display', '1' ) ) {
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
    add_action( 'woocommerce_shop_loop_item_price', 'woocommerce_template_loop_price', 10 );
}

if( !Shopkeeper_Opt::getOption( 'ratings_catalog_page', true ) ) {
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
}

// Product card classes
$sk_product_class = "";
if ( $animateCounter ) $sk_product_class .= ' delay-' . $animateCounter;
if ( !Shopkeeper_Opt::getOption( 'catalog_mode', false ) && Shopkeeper_Opt::getOption( 'add_to_cart_display', '1' ) == '0' ) $sk_product_class .= ' display_buttons';

// Second thumbnail
$style = '';
$class = '';
if( Shopkeeper_Opt::getOption( 'second_image_product_listing', true ) ) {
    $attachment_ids = $product->get_gallery_image_ids();
    if ( $attachment_ids && isset($attachment_ids[0]) ) {
        $product_thumbnail_second = wp_get_attachment_image_src($attachment_ids[0], 'woocommerce_thumbnail');
    }
    if( isset($product_thumbnail_second[0]) ) {
        $style = 'background-image:url(' . $product_thumbnail_second[0] . ')';
        $class = 'with_second_image';
    }
}

?>
<li <?php wc_product_class( $sk_product_class, $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

    ?>

    <div class="product_thumbnail_wrapper <?php echo ( !$product->is_in_stock() ) ? 'outofstock' : ''; ?>">

		<a href="<?php echo esc_url( apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product ) ); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">

	        <div class="product_thumbnail <?php echo esc_attr( $class ); ?>">
	            <span class="product_thumbnail_background" style="<?php echo esc_attr( $style ); ?>"></span>
	            <?php
	                if ( has_post_thumbnail( $product->get_id() ) ) {
	                    $image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );
	                    printf( '%s', $product->get_image( $image_size ));
	                } else {
	                    echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $product->get_id() );
	                }
	            ?>
	        </div><!--.product_thumbnail-->
		</a>

		<?php if( !Shopkeeper_Opt::getOption( 'catalog_mode', false ) ) : ?>
			<?php if ( !$product->is_in_stock() && !empty( Shopkeeper_Opt::getOption( 'out_of_stock_label', 'Out of stock' ) ) ) : ?>
				<div class="out_of_stock_badge_loop">
					<?php printf( __( '%s', 'woocommerce' ), Shopkeeper_Opt::getOption( 'out_of_stock_label', 'Out of stock' )); ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_shop_loop_item_sale_badge' ); ?>

		<?php do_action( 'woocommerce_shop_loop_item_icons' ); ?>

		<?php do_action( 'woocommerce_shop_loop_item_thumbnail' ); ?>

    </div><!--.product_thumbnail_wrapper-->

    <?php

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

	?>

	<h2 class="<?php echo esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ); ?>">
		<a href="<?php echo esc_url( apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product ) ); ?>"><?php echo get_the_title(); ?></a>
	</h2>

	<?php

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

    ?>

    <?php if( '1' == Shopkeeper_Opt::getOption( 'add_to_cart_display', '1' ) && !Shopkeeper_Opt::getOption( 'catalog_mode', false ) ) { ?>
    <div class="product_after_shop_loop">
        <div class="product_after_shop_loop_switcher">
    <?php } ?>

            <?php

            /**
        	 * Custom Hook: woocommerce_shop_loop_item_price.
        	 *
        	 * @hooked woocommerce_template_loop_price - 10
        	 */
            do_action( 'woocommerce_shop_loop_item_price' );

        	/**
        	 * Hook: woocommerce_after_shop_loop_item.
        	 *
        	 * @hooked woocommerce_template_loop_product_link_close - 5
        	 * @hooked woocommerce_template_loop_add_to_cart - 10
        	 */
			if( !Shopkeeper_Opt::getOption( 'catalog_mode', false ) ) {
        		do_action( 'woocommerce_shop_loop_item_add_to_cart' );
			}

            ?>

    <?php if( '1' == Shopkeeper_Opt::getOption( 'add_to_cart_display', '1' ) && !Shopkeeper_Opt::getOption( 'catalog_mode', false ) ) { ?>
        </div>
    </div>
    <?php } ?>

	<?php
	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>

</li>
