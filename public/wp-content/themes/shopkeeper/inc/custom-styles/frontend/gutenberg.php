<?php

$mobile_base_size = 13;
$headings_base_size = Shopkeeper_Opt::getOption( 'headings_font_size', 23 );
$h0_size = $headings_base_size * 3.157;
$h0_size_mobile = $mobile_base_size * 3.157;
$h2_size = $headings_base_size * 1.777;
$h2_size_mobile = $mobile_base_size * 1.777;

$custom_styles .= '

	.wp-block-latest-posts a,
	.wp-block-button,
	.wp-block-cover .wp-block-cover-text,
	.wp-block-subhead,
	.wp-block-image	figcaption,
	.wp-block-quote p,
	.wp-block-quote cite,
	.wp-block-quote .editor-rich-text,
	.wp-block-pullquote p,
	.wp-block-pullquote cite,
	.wp-block-pullquote .editor-rich-text,
	.gbt_18_sk_latest_posts_title,
	.gbt_18_sk_editor_banner_title,
	.gbt_18_sk_editor_slide_title_input,
	.gbt_18_sk_editor_slide_button_input,
	.wp-block-media-text .wp-block-media-text__content p,
	.wp-block-getbowtied-vertical-slider .gbt_18_current_slide,
    .wp-block-getbowtied-vertical-slider .gbt_18_number_of_items,
	.wp-block-woocommerce-all-reviews .wc-block-review-list-item__product a,
	.wc-block-grid__product-price,
	.wc-block-order-select__select,
	.gbt_18_sk_slider_wrapper .gbt_18_sk_slide_button,
	.gbt_18_sk_posts_grid .gbt_18_sk_posts_grid_title,
	.gbt_18_sk_editor_portfolio_item_title,
	.editor-post-title .editor-post-title__input,
	.wc-products-block-preview .product-title,
	.wc-products-block-preview .product-add-to-cart,
	.wc-block-products-category .wc-product-preview__title,
	.wc-block-products-category .wc-product-preview__add-to-cart,
	.wc-block-grid__product-onsale,
	.wc-block-featured-product__price .woocommerce-Price-amount,
	.wp-block-getbowtied-vertical-slider a.added_to_cart,
	.wp-block-getbowtied-vertical-slider .gbt_18_slide_link a,
	.wp-block-getbowtied-vertical-slider .price,
	.wp-block-getbowtied-lookbook-reveal .gbt_18_product_price *,
	.gbt_18_pagination a,
	.gbt_18_snap_look_book .gbt_18_hero_section_content .gbt_18_hero_subtitle,
	.gbt_18_snap_look_book .gbt_18_look_book_item .gbt_18_shop_this_book .gbt_18_current_book,
	.wp-block-getbowtied-scattered-product-list .gbt_18_product_price,
	.wc-block-grid__product-price span
	{
		font-family: ' . Shopkeeper_Fonts::get_main_font() . ';
	}

	.gbt_18_sk_latest_posts_title,
	.wp-block-quote p,
	.wp-block-pullquote p,
	.wp-block-quote cite,
	.wp-block-pullquote cite,
	.wp-block-media-text p,
	.wc-block-order-select__select,
	.wp-block-getbowtied-vertical-slider .gbt_18_slide_title a,
	.wp-block-getbowtied-vertical-slider .gbt_18_slide_link a,
	.gbt_18_sk_posts_grid_title
	{
		color: ' . Shopkeeper_Opt::getOption( 'headings_color', '#000000' ) . ';
	}

	.gbt_18_sk_latest_posts_title:hover,
	.gbt_18_sk_posts_grid_title:hover,
	.wp-block-getbowtied-vertical-slider .price,
	.wp-block-getbowtied-scattered-product-list a:hover .gbt_18_product_title
	{
		color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . ';
	}

	.wp-block-latest-posts__post-date,
	.wp-block-audio figcaption,
	.wp-block-video figcaption
	{
		color: ' . Shopkeeper_Opt::getOption( 'body_color', '#545454' ) . ';
	}

	.wp-block-getbowtied-vertical-slider .gbt_18_slide_link
	{
		border-top-color: rgba(' . shopkeeper_hex2rgb(Shopkeeper_Opt::getOption( 'body_color', '#545454' )) . ',0.1) !important;
	}

	.wp-block-quote:not(.is-large):not(.is-style-large),
	.wp-block-quote
	{
		border-left-color: ' . Shopkeeper_Opt::getOption( 'headings_color', '#000000' ) . ';
	}

	.gbt_18_default_slider .gbt_18_content .gbt_18_content_wrapper .gbt_18_next_slide,
	.gbt_18_default_slider .gbt_18_content .gbt_18_content_wrapper .gbt_18_prev_slide
	{
		border: 2px solid ' . Shopkeeper_Opt::getOption( 'headings_color', '#000000' ) . ' !important;
	}

	.wp-block-pullquote
	{
		border-top-color: ' . Shopkeeper_Opt::getOption( 'headings_color', '#000000' ) . ';
		border-bottom-color: ' . Shopkeeper_Opt::getOption( 'headings_color', '#000000' ) . ';
	}

	.gbt_18_sk_latest_posts_item_link:hover .gbt_18_sk_latest_posts_img_overlay,
	.wp-block-getbowtied-vertical-slider a.added_to_cart
	{
		background: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . ';
	}

	p.has-drop-cap:first-letter
	{
		font-size: ' . esc_html( $h0_size_mobile ) . 'px !important;
	}

	@media only screen and (min-width: 768px) {

		p.has-drop-cap:first-letter
		{
			font-size: ' . esc_html( $h0_size ) . 'px !important;
		}
	}

	.gbt_18_snap_look_book .gbt_18_hero_section_content .gbt_18_hero_title
	{
		font-size: ' . esc_html( $h0_size_mobile ) . 'px;
	}

	@media only screen and (min-width: 768px) {

		.gbt_18_snap_look_book .gbt_18_hero_section_content .gbt_18_hero_title
		{
			font-size: ' . esc_html( $h0_size ) . 'px;
		}
	}

	.wp-block-getbowtied-vertical-slider .gbt_18_slide_title a
	{
		font-size: ' . esc_html( $h2_size ) . 'px;
	}

	@media only screen and (max-width: 1024px) {

		.wp-block-getbowtied-vertical-slider .gbt_18_slide_title a
		{
			font-size: ' . esc_html( $h2_size_mobile ) . 'px;
		}
	}

	@media only screen and (min-width: 1024px) {
		.gbt_18_lookbook_reveal_wrapper .gbt_18_distorsion_lookbook_content .gbt_18_text_wrapper .gbt_18_description,
		.gbt_18_lookbook_reveal_wrapper .gbt_18_distorsion_lookbook_content .gbt_18_text_wrapper .gbt_18_description *
		{
			font-size: ' . Shopkeeper_Opt::getOption( 'body_font_size', 16 ) . 'px;
		}
	}';
