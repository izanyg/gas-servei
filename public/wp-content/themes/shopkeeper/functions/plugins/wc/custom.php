<?php
/**
 * WC custom functions
 *
 * @package shopkeeper
 */

/**
 * Woocommerce Product Page Get Caption Text
 */
function wp_get_attachment( $attachment_id ) {
    $attachment = get_post( $attachment_id );

    return array(
        'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href' => get_permalink( $attachment->ID ),
        'src' => $attachment->guid,
        'title' => $attachment->post_title
    );
}

/**
 * Custom WooCommerce related products
 */
function shopkeeper_custom_related_products() {

	if ( Shopkeeper_Opt::getOption( 'related_products', true ) ) {

		$related_products_number = (string)(Shopkeeper_Opt::getOption( 'related_products_number', 4 ));

		echo '<div class="row">';
			echo '<div class="large-12 large-centered columns">';
		    $atts = array(
				'columns'		 => $related_products_number,
				'posts_per_page' => $related_products_number,
				'orderby'        => 'rand'
			);
			woocommerce_related_products($atts); // Display 3 products in rows of 3
	    	echo '</div>';
	    echo '</div>';
	}
}

/**
 * Custom WooCommerce upsells
 */
function shopkeeper_custom_upsell_products() {

	echo '<div class="row">';
		echo '<div class="large-12 large-centered columns">';

		$related_products_number = (string)(Shopkeeper_Opt::getOption( 'related_products_number', 4 ));
		woocommerce_upsell_display( $related_products_number, $related_products_number ); // Display 3 products in rows of 3
    	echo '</div>';
    echo '</div>';
}

/**
 * Deactivate AJAX Add to Cart when incompatible plugin is active
 */
function shopkeeper_deactivate_ajax_add_to_cart() {

	if( class_exists('WC_Product_Addons') || class_exists('Wcff') || class_exists('WC_Bundles') || class_exists('WC_Measurement_Price_Calculator_Loader') || defined('GIFTCARD_TEXT_DOMAIN') ) {

		set_theme_mod( 'ajax_add_to_cart', false );
	}
}
add_action( 'init', 'shopkeeper_deactivate_ajax_add_to_cart' );

/**
 * Generate product categories grid
 */
function shopkeeper_get_categories_grid( $categories ) {
    $cat_counter = 0;
    ?>

    <div class="categories_grid">

        <?php foreach( $categories as $category ) :

            $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );

            if( 'styled_grid' === Shopkeeper_Opt::getOption( 'category_style', 'styled_grid' ) ) :
                $cat_counter++;

                switch( count( $categories ) ) {
                    case 1:
                        $cat_class = "one_cat_" . $cat_counter;
                        break;
                    case 2:
                        $cat_class = "two_cat_" . $cat_counter;
                        break;
                    case 3:
                        $cat_class = "three_cat_" . $cat_counter;
                        break;
                    case 4:
                        $cat_class = "four_cat_" . $cat_counter;
                        break;
                    case 5:
                        $cat_class = "five_cat_" . $cat_counter;
                        break;
                    default:
                        $cat_class = ($cat_counter < 7) ? $cat_counter : 'more_than_6';
                        break;
                }
            endif;
            ?>

            <div class="category_<?php echo esc_attr( $cat_class ); ?>">
                <div class="category_grid_box">
                    <span class="category_item_bkg" style="background-image:url(<?php echo wp_get_attachment_url( $thumbnail_id ); ?>)"></span>
                    <a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>" class="category_item">
                        <span class="category_name"><?php echo esc_html($category->name); ?>

                            <?php if( Shopkeeper_Opt::getOption( 'categories_grid_count', true ) ) : ?>
                                <span class="category_count"><?php echo esc_html($category->count); ?></span>
                            <?php endif; ?>
                        </span>
                    </a>
                </div>
            </div>

        <?php endforeach; ?>

        <div class="clearfix"></div>
    </div>
<?php
}
