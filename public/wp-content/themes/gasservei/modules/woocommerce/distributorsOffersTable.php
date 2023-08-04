<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Enqueue scripts and styles
add_action('wp_enqueue_scripts', 'gs_variations_table_scripts');
function gs_variations_table_scripts()
{
	$file = ABSPATH.'wp-content/plugins/gassservei-variations-table/gassservei-variations-table.php';
    wp_enqueue_script('woo-variations-table-scripts', plugins_url('js/woo-variations-table-scripts.js', $file), array('jquery'), WOO_VARIATIONS_TABLE_VERSION, true);
    wp_enqueue_script('woo-variations-table-app', plugins_url('ui/public/build/woo-variations-table-app.js', $file), array('wc-add-to-cart'), WOO_VARIATIONS_TABLE_VERSION, true);
    wp_enqueue_style('woo-variations-table-style', plugins_url('ui/public/woo-variations-table.css', $file), array(), WOO_VARIATIONS_TABLE_VERSION);
    wp_enqueue_style('woo-variations-table-app-style', plugins_url('ui/public/build/woo-variations-table-app.css', $file), array(), WOO_VARIATIONS_TABLE_VERSION);
}

// Print variations table
function woo_distributors_offers_table_print_table()
{
    if (!is_gs_distributor())
        return;

    $args = array(
        'post_type' => 'product_variation',
	    'meta_key' => 'gs_distributor_offer',
	    'meta_value' => 'null', //'meta_value' => array('yes'),
	    'meta_compare' => '!=', //'meta_compare' => 'NOT IN'
        'posts_per_page'=>-1,
	);
    $query = new WP_Query( $args );
    $posts = $query->posts;
    $variations = [];

    foreach ($posts as $post) {
    	$variations[] = gs_get_available_variation( 
    		new WC_Product_Variation($post->ID) );
    }
    $variations = array_values( array_filter( $variations ) );
    $productImageURL = '';

    // Image link is no longer exist in WooCommerce 3.x so do this work around
    foreach ($variations as $key => $variation) {
        if (!isset($variation['image_link']) && isset($variation['image'])) {
            $variations[$key]['image_link'] = $variation['image']['src'];
        }
        // price_html is empty if all variations have the same price in WooCommerce 3.x so do this work around
        if (empty($variation['price_html'])) {
            $variations[$key]['price_html'] = $product->get_price_html();
        }
        $regular_price = $variations[$key]['display_regular_price'];
        $sale_price = $variations[$key]['display_price'];
        $variations[$key]['regular_price_html'] = ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price );
        $variations[$key]['sale_price_html'] = ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price );        

        // Distributors offer
        if (is_gs_distributor()) {
            $offer = get_post_meta($variation['variation_id'], 'gs_distributor_offer', true);
            if (!empty($offer) && $offer < $variation['display_price']) {
                $quantity = get_post_meta($variation['variation_id'], 'gs_distributor_min_quantity', true);
                // $variations[$key]['distributor_offer'] = $offer;
                $variations[$key]['offer'] = '<span class="discount">'.sprintf( __("<span class='highlight'>Descuento</span> a partir de %s uds.", 'gasservei'), 
                    $quantity
                ).'</span>';
            }                
        }
    }

    $product_attributes = [];
    $variation_attributes = [];
    $attrs = array();
    // foreach ($variation_attributes as $key => $name) {
    //     $correctkey = wc_sanitize_taxonomy_name(stripslashes($key));
    //     $options = array();
    //     for ($i = 0; count($name) > $i; $i++) {
    //         $terms = array_values($name);
    //         $term = get_term_by('slug', $terms[$i], $key);
    //         $slug = array_values($name);
    //         $slug = $slug[$i];
    //         if ($term) {
    //             array_push($options, array('name' => $term->name, 'slug' => $slug));
    //         } else {
    //             array_push($options, array('name' => $slug, 'slug' => $slug));
    //         }
    //     }
    //     array_push($attrs, array(
    //         "key" => $correctkey,
    //         "name" => wc_attribute_label($key),
    //         "visible" => $product_attributes[$correctkey]->get_visible(),
    //         "options" => $options,
    //     ));
    // }

    $activeColumns = array(
        'sku' => 'on',
        'variation_description' => 'on',
    	'regular_price_html' => 'on',
        'sale_price_html' => 'on',
    	'offer' => 'on',
        'link' => 'on',
    );
    $showFilters = get_option('woo_variations_table_show_filters', 'on');
    $showSpinner = get_option('woo_variations_table_show_spinner', 'on');
    $columnsText = woo_variations_table_get_columns_labels();
    $columnsOrder  = [
    	0 => 'sku',
    	1 => 'variation_description',
    	2 => 'regular_price_html',
        3 => 'sale_price_html',
    	4 => 'offer',
    	5 => 'link',
    ];

    $columnsText['link'] = 'PVP €';
    $columnsText['regular_price_html'] = 'PVP €';
    // var_dump(__('Offer', 'woo-variations-table')); die();
    $columnsText['offer'] = __('Offer', 'gasservei');
    $columnsText['sale_price_html'] = __('Final Price €', 'woo-variations-table');

    $woo_variations_table_data = array(
        "variations" => $variations,
        "attributes" => $attrs,
        "showFilters" => $showFilters,
        "activeColumns" => $activeColumns,
        "columnsOrder" => $columnsOrder,
        "imageURL" => $productImageURL,
        "showSpinner" => $showSpinner,
        "textVars" => array(
            "columnsText" => $columnsText,
            "link" => __("Ir al producto", 'gasservei'),
            "anyText" => __("Any", 'woo-variations-table'),
            "searchPlaceholderText" => __("Keywords", 'woo-variations-table'),
            "noResultsText" => __("No results!", 'woo-variations-table'),
        ),
    );

    wp_localize_script('woo-variations-table-app', 'wooVariationsTableData', $woo_variations_table_data);
    do_action( 'woo_variations_table_before_table' );
    ?>
    <div id='variations-table' class="variations-table">
      <h3 class="available-title"><?php echo esc_html_e('Available Options:', 'woo-variations-table'); ?></h3>
      <div id="woo-variations-table-component"></div>
    </div>
    <?php
    do_action( 'woo_variations_table_after_table' );
}


// from class-wc-product-variable.php
/**
 * Returns an array of data for a variation. Used in the add to cart form.
 *
 * @since  2.4.0
 * @param  WC_Product $variation Variation product object or ID.
 * @return array|bool
 */
function gs_get_available_variation( $variation ) {
	if ( is_numeric( $variation ) ) {
		$variation = wc_get_product( $variation );
	}
	if ( ! $variation instanceof WC_Product_Variation ) {
		return false;
	}
	// See if prices should be shown for each variation after selection.
	// $show_variation_price = apply_filters( 'woocommerce_show_variation_price', $variation->get_price() === '' || $this->get_variation_sale_price( 'min' ) !== $this->get_variation_sale_price( 'max' ) || $this->get_variation_regular_price( 'min' ) !== $this->get_variation_regular_price( 'max' ), $this, $variation );
	$show_variation_price = true;

	// return apply_filters(
		// 'woocommerce_available_variation',
	return 
		array(
			'attributes'            => $variation->get_variation_attributes(),
			'availability_html'     => wc_get_stock_html( $variation ),
			'backorders_allowed'    => $variation->backorders_allowed(),
			'dimensions'            => $variation->get_dimensions( false ),
			'dimensions_html'       => wc_format_dimensions( $variation->get_dimensions( false ) ),
			'display_price'         => wc_get_price_to_display( $variation ),
			'display_regular_price' => wc_get_price_to_display( $variation, array( 'price' => $variation->get_regular_price() ) ),
			'image'                 => wc_get_product_attachment_props( $variation->get_image_id() ),
			'image_id'              => $variation->get_image_id(),
			'is_downloadable'       => $variation->is_downloadable(),
			'is_in_stock'           => $variation->is_in_stock(),
			'is_purchasable'        => $variation->is_purchasable(),
			'is_sold_individually'  => $variation->is_sold_individually() ? 'yes' : 'no',
			'is_virtual'            => $variation->is_virtual(),
			'max_qty'               => 0 < $variation->get_max_purchase_quantity() ? $variation->get_max_purchase_quantity() : '',
			'min_qty'               => $variation->get_min_purchase_quantity(),
			'price_html'            => $show_variation_price ? '<span class="price">' . $variation->get_price_html() . '</span>' : '',
			'sku'                   => $variation->get_sku(),
			'variation_description' => wc_format_content( $variation->get_description() ),
			'variation_id'          => $variation->get_id(),
			'variation_is_active'   => $variation->variation_is_active(),
			'variation_is_visible'  => $variation->variation_is_visible(),
			'weight'                => $variation->get_weight(),
			'weight_html'           => wc_format_weight( $variation->get_weight() ),
			'product_url'			=> get_permalink( $variation->get_parent_id() ),
		);
	// 	null, //$this,
	// 	$variation
	// );
}