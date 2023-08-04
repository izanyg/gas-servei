<?php

defined( 'ABSPATH' ) || exit;

global $post, $product;

$modal_class = "gallery_image_link";
$zoom_class = "";
$img_class = "";

if( Shopkeeper_Opt::getOption( 'product_gallery_lightbox', true ) ) {
	$modal_class .= " fresco";
	$img_class .= "fresco-img";
}

if( Shopkeeper_Opt::getOption( 'product_gallery_zoom', true ) ) {
	$zoom_class = "easyzoom el_zoom";
	$modal_class .= " zoom";
}

//Featured
$image_id 					= $product->get_image_id();
$featured_image_title 		= $image_id ? esc_html( get_the_title( $image_id ) ) : '';
$featured_image_data_src	= $image_id ? wp_get_attachment_image_src( $image_id, 'shop_single' )[0] : wc_placeholder_img_src( 'woocommerce_single' );
$featured_image_thumb_src	= $image_id ? wp_get_attachment_image_src( $image_id, 'woocommerce_thumbnail' )[0] : wc_placeholder_img_src( 'woocommerce_single' );
$featured_image_link  		= $image_id ? wp_get_attachment_url( $image_id ) : wc_placeholder_img_src( 'woocommerce_single' );
$featured_attachment_meta 	= $image_id ? wp_get_attachment( $image_id ) : array( 'caption' => '');

$post_custom_values 	= get_post_custom( $post->ID );
$page_product_youtube 	= isset($post_custom_values['page_product_youtube']) ? esc_attr( $post_custom_values['page_product_youtube'][0]) : '';

?>

<div class="product-images-style-4 woocommerce-product-gallery__wrapper images">

	<div class="product_images">

		<?php //Featured ?>

		<div class="product-image featured woocommerce-product-gallery__image">
			<div class="<?php echo esc_attr( $zoom_class ); ?>">

				<?php if( Shopkeeper_Opt::getOption( 'product_gallery_lightbox', true ) ) { ?>
					<a
					data-fresco-group="product-gallery"
					data-fresco-options="ui: 'outside', thumbnail: '<?php echo esc_url($featured_image_thumb_src); ?>'"
					data-fresco-group-options="overflow: true, thumbnails: 'vertical', onClick: 'close'"
					data-fresco-caption="<?php echo esc_html($featured_attachment_meta['caption']); ?>"
					class="<?php echo esc_attr( $modal_class ); ?>"
					href="<?php echo esc_url($featured_image_link); ?>"
					>
				<?php } else if( Shopkeeper_Opt::getOption( 'product_gallery_zoom', true ) ) { ?>
					<a class="<?php echo esc_attr( $modal_class ); ?>" href="<?php echo esc_url($featured_image_link); ?>" >
				<?php } ?>

					<?php if ( $product->get_image_id() ) { ?>
						<img src="<?php echo esc_url($featured_image_data_src); ?>" data-src="<?php echo esc_url($featured_image_data_src); ?>" alt="<?php echo esc_attr( $featured_image_title ); ?>" class="wp-post-image <?php echo esc_attr( $img_class ); ?>">
					<?php } else { ?>
						<img src="<?php echo esc_url(wc_placeholder_img_src( 'woocommerce_single' )); ?>" data-src="<?php echo esc_url(wc_placeholder_img_src( 'woocommerce_single' )); ?>" class="<?php echo esc_attr( $img_class ); ?>">
					<?php } ?>

				<?php if( Shopkeeper_Opt::getOption( 'product_gallery_zoom', true ) || Shopkeeper_Opt::getOption( 'product_gallery_lightbox', true ) ) { ?>
					</a>
				<?php } ?>

		</div>

	</div> <!-- / product-image featured -->

	<?php

	$attachment_ids = $product->get_gallery_image_ids();

	if ( $attachment_ids && count( $attachment_ids ) >= 1 ) : ?>


	<?php

	foreach ( $attachment_ids as $attachment_id ) {

		$gallery_image_title       			= esc_attr( get_the_title( $attachment_id ) );
		$gallery_image_data_src    			= wp_get_attachment_image_src( $attachment_id, 'shop_single' )[0];
		$gallery_image_thumb_src    		= wp_get_attachment_image_src( $attachment_id, 'woocommerce_thumbnail' )[0];
		$gallery_image_link        			= wp_get_attachment_url( $attachment_id );
		$gallery_attachment_meta			= wp_get_attachment($attachment_id);
		?>

		<div class="product-image">
			<div class="<?php echo esc_attr( $zoom_class ); ?>">

				<?php if( Shopkeeper_Opt::getOption( 'product_gallery_lightbox', true ) ) { ?>
					<a
					data-fresco-group="product-gallery"
					data-fresco-options="thumbnail: '<?php echo esc_url($gallery_image_thumb_src); ?>'"
					data-fresco-caption="<?php echo esc_html($gallery_attachment_meta['caption']); ?>"
					class="<?php echo esc_attr( $modal_class ); ?>"
					href="<?php echo esc_url($gallery_image_link); ?>"
					>
				<?php } else if( Shopkeeper_Opt::getOption( 'product_gallery_zoom', true ) ) { ?>
					<a class="<?php echo esc_attr( $modal_class ); ?>" href="<?php echo esc_url($gallery_image_link); ?>" >
				<?php } ?>

					<img class="desktop-image <?php echo esc_attr( $img_class ); ?>" src="<?php echo esc_url($gallery_image_data_src); ?>" alt="<?php echo esc_html($gallery_image_title); ?>">

				<?php if( Shopkeeper_Opt::getOption( 'product_gallery_zoom', true ) || Shopkeeper_Opt::getOption( 'product_gallery_lightbox', true ) ) { ?>
					</a>
				<?php } ?>
		</div>
	</div>

<?php } ?>

<?php endif; ?>

<!--  Video -->

<?php if ( $page_product_youtube ) : ?>

	<?php

	$embed_code = wp_oembed_get( $page_product_youtube );
	echo '<div class="video "> ' .$embed_code .'</div>';

	echo '<div class="product-video-icon">

	<a data-fresco-group="product-gallery" class="'.$modal_class.'" href="'.esc_url($page_product_youtube).'"><i class="spk-icon spk-icon-video-player"></i></a>
	</div>';

	?>

<?php endif; ?>

</div><!-- /.product_images -->

</div> <!-- / product-images-style-4 -->
