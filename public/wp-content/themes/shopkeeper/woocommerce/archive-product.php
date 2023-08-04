<?php
/**
* The Template for displaying product archives, including the main shop page which is a post type archive
*
* This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
*
* @see https://docs.woocommerce.com/document/template-structure/
* @package WooCommerce/Templates
* @version 3.4.0
*/

defined( 'ABSPATH' ) || exit;

remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_no_products_found', 'wc_no_products_found', 10 );

add_action( 'woocommerce_before_main_content_breadcrumb', 'woocommerce_breadcrumb', 20 );
add_action( 'woocommerce_before_shop_loop_result_count', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_before_shop_loop_catalog_ordering', 'woocommerce_catalog_ordering', 30 );

// Category Header Image.
$category_header_src = !is_shop() ? apply_filters( 'getbowtied_get_category_header_image', '' ) : '';
// Shop Sidebar.
$shop_has_sidebar = ( is_active_sidebar( 'catalog-widget-area' ) && '0' === Shopkeeper_Opt::getOption( 'sidebar_style', '1' ) ) ? true : false;
$shop_sidebar_class = $shop_has_sidebar ? 'shop-has-sidebar' : '';
// Shop Header Image.
$page_header_src = ( has_post_thumbnail( get_option( 'woocommerce_shop_page_id' ) ) ) ? wp_get_attachment_url( get_post_thumbnail_id(get_option( 'woocommerce_shop_page_id' )), 'full' ) : '';
// Page Title Option.
$page_title_option = ( is_shop() && get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'page_title_meta_box_check', true ) ) ? get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'page_title_meta_box_check', true ) : 'on';
// Shop loop classes.
$shop_content_class = $shop_has_sidebar ? 'xlarge-10 large-9 columns' : 'large-12 columns';

$parent_id      = get_queried_object_id();
$categories     = get_terms( 'product_cat', array( 'hide_empty' => Shopkeeper_Opt::getOption( 'hide_empty_categories', false ), 'parent' => $parent_id ) );
$display_mode 	= woocommerce_get_loop_display_mode();

$shop_header = false;
if( !empty( $category_header_src ) || ( is_shop() && !empty( $page_header_src ) ) ||
	'on' === $page_title_option || !empty( $archive_description ) ||
	( 'both' === $display_mode && 'styled_grid' === Shopkeeper_Opt::getOption( 'category_style', 'styled_grid' ) ) ) {
	$shop_header = true;
}

get_header('shop');

ob_start();
do_action( 'woocommerce_archive_description' );
$archive_description = ob_get_contents();
ob_end_clean();

?>

<div id="primary" class="content-area shop-page <?php echo esc_attr($shop_sidebar_class); ?>">

	<?php if( $shop_header ) : ?>

		<div class="woocommerce-products-header shop_header <?php if ($category_header_src != '' || (is_shop() && $page_header_src != "")) : ?>with_featured_img<?php endif; ?>">

			<?php if( !empty( $category_header_src ) ) : ?>
				<div class="shop_header_bkg" style="background-image:url(<?php echo esc_url( $category_header_src ); ?>)"></div>
			<?php endif; ?>

			<?php if( is_shop() && !empty( $page_header_src ) ) : ?>
				<div class="shop_header_bkg" style="background-image:url(<?php echo esc_url( $page_header_src ); ?>)"></div>
			<?php endif; ?>

			<div class="shop_header_overlay"></div>

			<div class="row">
				<div class="large-12 large-centered columns">
					<?php if( 'on' === $page_title_option ) : ?>
						<h1 class="woocommerce-products-header__title page-title on-shop"><?php woocommerce_page_title(); ?></h1>
					<?php endif; ?>

					<div class="row">
						<div class="large-6 large-centered columns">
							<div class="term-description">
								<?php
								/**
								 * Hook: woocommerce_archive_description.
								 *
								 * @hooked woocommerce_taxonomy_archive_description - 10
								 * @hooked woocommerce_product_archive_description - 10
								 */
								 do_action( 'woocommerce_archive_description' );
								 ?>
							</div>
						</div>
					</div>

					<?php if( 'both' === $display_mode && 'styled_grid' === Shopkeeper_Opt::getOption( 'category_style', 'styled_grid' ) && $categories ) : ?>
						<ul class="list_shop_categories list-centered">
							<?php foreach($categories as $category) : ?>
								<li class="category_item">
									<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>" class="category_item_link">
										<span class="category_name"><?php echo esc_html($category->name); ?></span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="row">
		<div class="large-12 columns">
			<div class="before_main_content">
				<?php
				/**
				* Hook: woocommerce_before_main_content.
				*
				* @hooked WC_Structured_Data::generate_website_data() - 30
				*/
				do_action( 'woocommerce_before_main_content');
				?>
			</div>

			<div id="content" class="site-content" role="main">
				<div class="row">

					<div class="large-12 columns">
						<div class="catalog_top">
							<?php
							/**
							 * Hook: woocommerce_before_shop_loop.
							 *
							 * @hooked woocommerce_output_all_notices - 10
							 */
							 do_action( 'woocommerce_before_shop_loop' );
							 ?>
						</div>
					</div>

					<?php if ( $shop_has_sidebar ) : ?>

						<div class="xlarge-2 large-3 columns show-for-large">
							<div class="shop_sidebar wpb_widgetised_column">
								<?php
								/**
								 * Hook: woocommerce_sidebar.
								 *
								 * @hooked woocommerce_get_sidebar - 10
								 */
								 do_action( 'woocommerce_sidebar' );
								 ?>
							</div>
						</div>

					<?php endif; ?>

					<div class="<?php echo esc_attr( $shop_content_class ); ?>">

						<div class="tob_bar_shop">
							<div class="small-5 medium-7 large-6 xlarge-8 columns text-left">
								<?php if( is_active_sidebar( 'catalog-widget-area') ) : ?>
									<div id="button_offcanvas_sidebar_left"  data-toggle="offCanvasLeft1">
										<span class="filters-text">
											<i class="spk-icon spk-icon-menu-filters"></i>
											<?php echo esc_html_e( 'Filter', 'woocommerce' ); ?>
										</span>
									</div>
								<?php endif; ?>

								<?php
								/**
								 * Hook: woocommerce_before_main_content_breadcrumb.
								 *
								 * @hooked woocommerce_breadcrumb - 20
								 */
								do_action('woocommerce_before_main_content_breadcrumb');
								?>
							</div>
							<?php if( 'subcategories' != $display_mode ): ?>
								<div class="small-7 medium-5 large-6 xlarge-4 columns text-right">
									<div class="catalog-ordering <?php echo (!Shopkeeper_Opt::getOption( 'archive_product_count', false )) ? 'hide-results' : ''; ?>">
										<?php
										/**
										 * Hook: woocommerce_before_shop_loop_catalog_ordering.
										 *
										 * @hooked woocommerce_catalog_ordering - 30
										 */
										 do_action( 'woocommerce_before_shop_loop_catalog_ordering' );
										/**
										 * Hook: woocommerce_before_shop_loop_result_count.
										 *
										 * @hooked woocommerce_result_count - 20
										 */
										 do_action( 'woocommerce_before_shop_loop_result_count' );
										 ?>
									</div>
								</div>
							<?php endif; ?>
						</div>

						<?php if( $categories && 'subcategories' === $display_mode && 'styled_grid' === Shopkeeper_Opt::getOption( 'category_style', 'styled_grid' ) ) : ?>
							<?php shopkeeper_get_categories_grid( $categories ); ?>
						<?php elseif( 'subcategories' != $display_mode || ( 'subcategories' === $display_mode && 'original_grid' === Shopkeeper_Opt::getOption( 'category_style', 'styled_grid' ) ) ) : ?>

							<?php if( woocommerce_product_loop() || have_posts() ) : ?>
								<div class="large-12 mobile-columns-<?php echo Shopkeeper_Opt::getOption( 'mobile_columns', 2 ); ?> ">
									<?php

									if ( 'products' != $display_mode && !( 'both' === $display_mode && 'styled_grid' === Shopkeeper_Opt::getOption( 'category_style', 'styled_grid' ) ) ) {
									?>
										<ul class="product-categories products columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?>">
											<?php echo woocommerce_maybe_show_product_subcategories(); ?>
										</ul>
									<?php
									}

									if( have_posts() ) {

										woocommerce_product_loop_start();

										if ( wc_get_loop_prop( 'total' ) ) {
											while ( have_posts() ) {
												the_post();

												/**
												 * Hook: woocommerce_shop_loop.
												 */
												do_action( 'woocommerce_shop_loop' );

												wc_get_template_part( 'content', 'product' );
											}
										}

										woocommerce_product_loop_end();
									}

									?>

								</div>

								<div class="woocommerce-after-shop-loop-wrapper">
									<?php
									/**
									 * Hook: woocommerce_after_shop_loop.
									 *
									 * @hooked woocommerce_pagination - 10
									 */
									do_action( 'woocommerce_after_shop_loop' );
									?>
								</div>

							<?php else : ?>

								<div class="no-products-info">
									<p class="woocommerce-no-products">
										<?php esc_html_e( 'No products were found matching your selection.', 'woocommerce' ); ?>
									</p>
								</div>

								<?php
								/**
								 * Hook: woocommerce_no_products_found.
								 */
								do_action( 'woocommerce_no_products_found' );
								?>

							<?php endif; ?>
						<?php endif; ?>

						<?php
						/**
						 * Hook: woocommerce_after_main_content.
						 *
						 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
						 */
						do_action('woocommerce_after_main_content');
						?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer('shop'); ?>
