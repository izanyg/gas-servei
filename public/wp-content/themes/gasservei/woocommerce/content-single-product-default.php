<?php

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    global $post, $product;

    //woocommerce_before_single_product
	//nothing changed

	//woocommerce_before_single_product_summary
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

	add_action( 'woocommerce_before_single_product_summary_sale_flash', 'woocommerce_show_product_sale_flash', 10 );
	add_action( 'woocommerce_before_single_product_summary_product_images', 'woocommerce_show_product_images', 20 );

	//woocommerce_single_product_summary
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

	add_action( 'woocommerce_single_product_summary_single_title', 'woocommerce_template_single_title', 5 );
	add_action( 'woocommerce_single_product_summary_single_rating', 'woocommerce_template_single_rating', 10 );
	add_action( 'woocommerce_single_product_summary_single_price', 'woocommerce_template_single_price', 10 );
	// add_action( 'woocommerce_single_product_summary_single_excerpt', 'woocommerce_template_single_excerpt', 20 );
	add_action( 'woocommerce_single_product_summary_single_add_to_cart', 'woocommerce_template_single_add_to_cart', 30 );
	add_action( 'woocommerce_single_product_summary_single_meta', 'woocommerce_template_single_meta', 40 );
	add_action( 'woocommerce_single_product_summary_single_sharing', 'woocommerce_template_single_sharing', 50 );

	//woocommerce_after_single_product_summary
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

	add_action( 'woocommerce_after_single_product_summary_data_tabs', 'woocommerce_output_product_data_tabs', 10 );
	add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_excerpt', 25 );

	//woocommerce_after_single_product
	//nothing changed

	//custom actions
	add_action( 'woocommerce_before_main_content_breadcrumb', 'woocommerce_breadcrumb', 20, 0 );

	if(class_exists('WC_Wishlists_Plugin')) {
		remove_action('woocommerce_single_product_summary', array($GLOBALS['wishlists'], 'bind_wishlist_button'), 0);
		add_action('woocommerce_single_product_summary_single_add_to_cart', array($GLOBALS['wishlists'], 'bind_wishlist_button'), 0);
	}

?>

<div class="product_layout_classic default-layout">

	<?php if ( !post_password_required() ) : ?>

		<div class="row">
			<div class="columns">
				<?php do_action( 'woocommerce_before_single_product' ); ?>
			</div>
		</div>

		<div id="product-<?php the_ID(); ?>" <?php function_exists('wc_product_class')? wc_product_class( '', $product ) : post_class(); ?>>
			<div class="row">
		        <div class="columns">
					<div class="product_content_wrapper">

						<div class="row breadcrumbs-row">
							<div class="columns">
								<div>
									<?php do_action('woocommerce_before_main_content_breadcrumb');	?>
								</div>
							</div>
						</div>
						

						<div class="row only-mobile">
							<div class="columns">
								<div class="product_summary_mobile">
									<?php

										do_action( 'woocommerce_single_product_summary_single_title' );

										if ( post_password_required() ) {
											echo get_the_password_form();
											return;
										}
									?>
									<?php do_action( 'woocommerce_single_product_summary_single_price' ); ?>
								</div><!--.product_summary_top-->

							</div>
						</div>
						<div class="row">

							<div class="large-4 medium-6 xs-12 columns">
								<div class="product-images-wrapper">

									<?php
										do_action( 'woocommerce_before_single_product_summary_product_images' );
										do_action( 'woocommerce_before_single_product_summary' );
									?>
									<?php 
										$gallery_image_ids = $product->get_gallery_image_ids();
										$has_gallery = '';
										if ( ! empty($gallery_image_ids) ) {
											$has_gallery = 'has_gallery';
										}
									?>
									<div class="product-badges <?php echo $has_gallery; ?>">
										<!-- sale -->
										<div class="product-sale">
												<?php
												do_action( 'woocommerce_before_single_product_summary_sale_flash' ); 
												?>
										</div>

									</div>

								</div>



							</div><!-- .columns -->

							<?php

							$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
							$viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

							?>


							<div class="large-8 medium-6 xs-12 columns">

								<div class="product_infos">

									 <div class="product_summary_middle except-mobile">
										<?php

											do_action( 'woocommerce_single_product_summary_single_title' );

											if ( post_password_required() ) {
												echo get_the_password_form();
												return;
											}
										?>
									</div><!--.product_summary_top-->
									<div class="except-mobile">
										<?php do_action( 'woocommerce_single_product_summary_single_price' ); ?>
									</div>

										<?php if( SHOPKEEPER_GERMAN_MARKET_IS_ACTIVE ) : ?>
											<div class="german-market-info">
												<?php do_action( 'woocommerce_single_product_german_market_info' ); ?>
											</div>
										<?php elseif( SHOPKEEPER_WOOCOMMERCE_GERMANIZED_IS_ACTIVE ) : ?>
											<div class="germanized-active">
												<?php do_action( 'woocommerce_single_product_germanized_info' ); ?>
											</div>
										<?php endif; ?>

									

										 

										<?php
										do_action( 'woocommerce_single_product_summary_single_add_to_cart' );
										do_action( 'woocommerce_single_product_summary' );
										do_action( 'getbowtied_woocommerce_before_single_product_summary_data_tabs' );
										do_action( 'woocommerce_single_product_summary_single_meta' );
										do_action( 'woocommerce_single_product_summary_single_excerpt' ); 
										?>

										<div class="product_attributes">
											<?php 											
												$product_attributes = $product->get_attributes();
												foreach ($product_attributes as $key => $attribute){
													if(!$attribute->get_variation() && $attribute->get_visible()){
														echo '<div class="product_attribute">';
															$taxonomy = $attribute->get_taxonomy();
															echo '<span>' . ucfirst(wc_attribute_label($taxonomy)) . '</span>: ';
															$comma = false;
															foreach($attribute->get_options() as $term){
																$term_obj = get_term($term, $taxonomy);
																if($comma) echo ', ';
																echo $term_obj->name;
																$comma = true;
															}
														echo '</div>';
													}
												}
											?>
										</div>
									<?php if( Shopkeeper_Opt::getOption( 'product_navigation', true ) ) { ?>
										<div class="product_navigation">
											<?php shopkeeper_product_nav( 'nav-below' ); ?>
										</div>
									<?php } ?>

								</div>
								<!-- End product infos -->

							</div><!-- .columns -->


						</div><!-- .row -->
						<div class="row">
							<div class="columns">
								<?php 
									if(has_excerpt()){
										$excerpt = get_the_excerpt();

										if (!empty($excerpt) && strlen($excerpt)):
											?>
											
											<div class="product-description"><!-- Product description -->
												<h3><?php _e('Description', 'gasservei'); ?></h3>
												<div class="product-description-content"><?php echo $excerpt; ?></div>
											</div><!-- .product description -->
											<?php
										endif;
									}
								
								?>

								
								
							</div><!-- .columns -->
						</div><!-- .row 231 -->

					</div><!--.product_content_wrapper-->

					<?php
			
			
						do_action( 'woocommerce_template_single_excerpt' ); 
						do_action( 'woocommerce_after_single_product_summary_data_tabs' ); 
						
						?>
			   </div><!--large-9-->
		    </div><!-- .row 236 -->


		    <div class="row">
		        <div class="large-9 large-centered columns">
		            <?php
						do_action( 'woocommerce_single_product_summary_single_sharing' );
					?>

		        </div><!-- .columns 252 -->
		    </div><!-- .row 253 -->

		    <meta itemprop="url" content="<?php the_permalink(); ?>" />

		</div><!-- #product-<?php the_ID(); ?> -->

		<div class="row">
		    <div class="xlarge-9 xlarge-centered columns">

				<?php do_action( 'woocommerce_after_single_product' ); ?>

		    </div><!-- .columns 264 -->
		</div><!-- .row 265 -->

		<?php if ( $product->get_upsell_ids() ) : ?>
			<div class="single_product_summary_upsell">
			    <div class="row">
					<div class="xlarge-9 xlarge-centered columns">
						<?php do_action( 'woocommerce_after_single_product_summary_upsell_display' ); ?>
					</div><!--.large-9-->
			    </div><!-- .row -->
			</div><!-- .single_product_summary_upsell -->
		<?php endif; ?>


		<div class="single_product_summary_related">
		    <div class="row">
				<div class="xlarge-9 xlarge-centered columns">
					<?php do_action( 'woocommerce_after_single_product_summary_related_products' ); ?>
				</div><!--.large-9-->
		    </div><!-- .row -->
		</div><!-- .single_product_summary_related -->


	<?php else: ?>

		<div class="row">
		    <div class="large-9 large-centered columns">
		    <br/><br/><br/><br/>
				<?php echo get_the_password_form(); ?>
			</div>
		</div>

	<?php endif; ?>



</div>
