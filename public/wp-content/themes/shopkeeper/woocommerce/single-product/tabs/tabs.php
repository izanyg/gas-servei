<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 	3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>

	<?php if ( getbowtied_product_layout(get_the_ID()) === 'default' ) : ?>

		<div class="woocommerce-tabs">

			<div class="row">
				<div class="large-12 large-centered columns">

					<ul class="tabs">

						<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
							<li class="<?php echo esc_attr( $key ); ?>_tab">
								<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>

				</div>
			</div>

			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>

				<div class="panel entry-content" id="tab-<?php echo esc_attr( $key ); ?>">
	                <div class="row">
	                    <div class="large-8 xlarge-6 large-centered xlarge-centered columns">
	                        <?php call_user_func( $product_tab['callback'], $key, $product_tab ) ?>
	                    </div>
	                </div>
	            </div>

			<?php endforeach; ?>
		</div>


	<?php else: ?>

		<div class="woocommerce-tabs">

			<ul class="tabs">

				<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>_tab">
						<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>

			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>

				<div class="panel entry-content" id="tab-<?php echo esc_attr( $key ); ?>">
                    <?php call_user_func( $product_tab['callback'], $key, $product_tab ) ?>
	            </div>

			<?php endforeach; ?>
		</div>


	<?php endif; ?>

	<?php do_action( 'woocommerce_product_after_tabs' ); ?>

<?php endif; ?>
