<?php

$headings_base_size = Shopkeeper_Opt::getOption( 'headings_font_size', 23 );
$h0_size = $headings_base_size * 3.157;
$h1_size = $headings_base_size * 2.369;
$h2_size = $headings_base_size * 1.777;
$h3_size = $headings_base_size * 1.333;
$h4_size = $headings_base_size * 1;
$h5_size = $headings_base_size * 0.75;
$mobile_base_size = 13;
$h0_size_mobile = $mobile_base_size * 3.157;
$h1_size_mobile = $mobile_base_size * 2.369;
$h2_size_mobile = $mobile_base_size * 1.777;
$h3_size_mobile = $mobile_base_size * 1.333;
$h4_size_mobile = $mobile_base_size * 1;
$h5_size_mobile = $mobile_base_size * 0.75;

$custom_gutenberg_styles = '
	.post-type-post .edit-post-visual-editor .wp-block,
	.post-type-post .edit-post-visual-editor .block-editor-block-list__block,
	.post-type-post .edit-post-visual-editor .wp-block .block-editor-block-list__block
	{
		max-width:' . Shopkeeper_Opt::getOption( 'single_post_width', 708 ) . 'px;
	}

	.gbt_18_sk_categories_grid .gbt_18_sk_editor_categories_grid .gbt_18_sk_category_name
	{
		background-color: ' . Shopkeeper_Opt::getOption( 'main_background_color', '#FFFFFF' ) . ';
		color: ' . Shopkeeper_Opt::getOption( 'headings_color', '#000000' ) . ';
	}

	.gbt_18_sk_categories_grid .gbt_18_sk_editor_categories_grid .gbt_18_sk_editor_category_item:hover .gbt_18_sk_category_name
	{
		background-color: ' . Shopkeeper_Opt::getOption( 'headings_color', '#000000' ) . ';
		color: ' . Shopkeeper_Opt::getOption( 'main_background_color', '#FFFFFF' ) . ';
	}

	.edit-post-visual-editor h1.block-editor-block-list__block,
	.edit-post-visual-editor .block-editor-block-list__block h1,
	.edit-post-visual-editor h2.block-editor-block-list__block,
    .edit-post-visual-editor .block-editor-block-list__block h2,
	.edit-post-visual-editor h3.block-editor-block-list__block,
    .edit-post-visual-editor .block-editor-block-list__block h3,
	.edit-post-visual-editor h4.block-editor-block-list__block,
    .edit-post-visual-editor .block-editor-block-list__block h4,
	.edit-post-visual-editor h5.block-editor-block-list__block,
    .edit-post-visual-editor .block-editor-block-list__block h5,
	.edit-post-visual-editor h6.block-editor-block-list__block,
    .edit-post-visual-editor .block-editor-block-list__block h6,
	.edit-post-visual-editor .block-editor-block-list__block label:not(.components-placeholder__label),
	.edit-post-visual-editor .block-editor-block-list__block table thead tr th,
	.edit-post-visual-editor .block-editor-block-list__block input[type="reset"],
	.edit-post-visual-editor .block-editor-block-list__block input[type="submit"],
	.wp-block-latest-posts a,
	.wp-block-button,
	.wp-block-cover .wp-block-cover-text,
	.wp-block-subhead,
	.wp-block-image	figcaption,
	.block-editor-block-list__block .wp-block-pullquote .editor-rich-text p,
	.block-editor-block-list__block .wp-block-quote .editor-rich-text p,
	.block-editor-block-list__block .wp-block-pullquote .wp-block-pullquote__citation,
	.block-editor-block-list__block .wp-block-quote .wp-block-quote__citation,
	.gbt_18_sk_latest_posts_title,
	.gbt_18_sk_editor_banner_title,
	.gbt_18_sk_editor_slide_title_input,
	.gbt_18_sk_editor_slide_button_input,
	.gbt_18_sk_slider_wrapper .gbt_18_sk_slide_button,
	.gbt_18_sk_posts_grid .gbt_18_sk_posts_grid_title,
	.gbt_18_sk_editor_portfolio_item_title,
	.editor-post-title .editor-post-title__input,
	.wc-products-block-preview .product-title,
	.wc-products-block-preview .product-add-to-cart,
	.wc-block-products-category .wc-product-preview__title,
	.wc-block-products-category .wc-product-preview__add-to-cart,
	.wp-block-media-text .editor-inner-blocks .editor-rich-text p,
	.edit-post-visual-editor p.has-drop-cap:first-letter,
	.wc-block-products-grid .wc-product-preview__title,
	.wc-block-grid__product-onsale,
	.wc-block-featured-product__price,
	.wc-block-grid__product-price,
	.wc-block-review-list-item__text__read_more,
	.wc-block-review-list-item__product a,
	.wp-block-search .wp-block-search__button,
	.gbt_18_sk_posts_grid_more_link,
	.gbt_18_carousel_product_button,
	.editor-styles-wrapper .block-editor-block-list__block[data-type="woocommerce/active-filters"] .wc-block-component-title,
	.editor-styles-wrapper .block-editor-block-list__block[data-type="woocommerce/attribute-filter"] .wc-block-component-title,
	.editor-styles-wrapper .block-editor-block-list__block[data-type="woocommerce/price-filter"] .wc-block-component-title,
	.block-editor-block-list__block[data-type="woocommerce/active-filters"] ul.wc-block-active-filters-list li .wc-block-active-filters-list-item__type,
	.block-editor-block-list__block[data-type="woocommerce/active-filters"] .wc-block-active-filters__clear-all,
	.gbt_18_sk_categories_grid .gbt_18_sk_editor_categories_grid .gbt_18_sk_category_name,
	.block-editor-block-list__block[data-type="woocommerce/attribute-filter"] ul.wc-block-checkbox-list li.show-more button
	{
		font-family: ' . Shopkeeper_Fonts::get_main_font() . ';
	}

	.wc-block-product-search__label,
	.wp-block-search__label
	{
		font-family: ' . Shopkeeper_Fonts::get_main_font() . '!important;
	}

	.edit-post-visual-editor .block-editor-block-list__block
	{
		font-family: ' . Shopkeeper_Fonts::get_secondary_font() . ';
	}

	.edit-post-visual-editor .block-editor-block-list__block input
	{
		font-family: ' . Shopkeeper_Fonts::get_secondary_font() . ' !important;
	}

	.edit-post-visual-editor .block-editor-block-list__block p,
	.edit-post-visual-editor .block-editor-block-list__block textarea:not(.editor-post-title__input),
	.gbt_18_sk_editor_banner_subtitle,
	.gbt_18_sk_editor_slide_description_input,
	.edit-post-visual-editor .block-editor-block-list__block select,
	.wc-block-grid .wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-link .wc-block-grid__product-title,
	.wc-block-grid__product-title,
	.wc-block-grid .wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-title a,
	.block-editor-block-list__block[data-type="woocommerce/attribute-filter"] ul.wc-block-checkbox-list li label
	{
		font-family: ' . Shopkeeper_Fonts::get_secondary_font() . ';
	}

	.block-editor-block-list__block input[type="radio"]:after,
	.block-editor-block-list__block .input-radio:after,
	.block-editor-block-list__block input[type="checkbox"]:after,
	.block-editor-block-list__block .input-checkbox:after
	{
		border: 2px solid rgba(' . shopkeeper_hex2rgb( Shopkeeper_Opt::getOption( 'body_color', '#545454' ) ) . ',0.8);
	}

	.editor-styles-wrapper .block-editor-block-list__block[data-type="woocommerce/attribute-filter"] ul.wc-block-checkbox-list li input[type=checkbox]:after
	{
		border-color: rgba(' . shopkeeper_hex2rgb( Shopkeeper_Opt::getOption( 'body_color', '#545454' ) ) . ',0.8);
	}

	.block-editor-block-list__block input[type="radio"]:checked:after,
	.block-editor-block-list__block .input-radio:checked:after,
	.block-editor-block-list__block input[type="checkbox"]:checked:after,
	.block-editor-block-list__block .input-checkbox:checked:after
	{
		border-color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . '!important;
	}

	.block-editor-block-list__block input[type="checkbox"]:checked:after,
	.block-editor-block-list__block .input-checkbox:checked:after,
	.wc-block-featured-product .wp-block-button__link,
	.wc-block-featured-category .wp-block-button__link
	{
		background-color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . ';
	}

	.block-editor-block-list__block input[type="radio"]:checked:before,
	.block-editor-block-list__block .input-radio:checked:before,
	.wp-block-search .wp-block-search__button
	{
		background-color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . '!important;
	}

	.block-editor-block-list__block input,
	.block-editor-block-list__block textarea:not(.editor-post-title__input),
	.block-editor-block-list__block select,
	.editor-styles-wrapper .gbt_18_editor_slide_content .gbt_18_editor_slide_content_left .gbt_18_editor_slide_content_left_inner .gbt_18_editor_slide_link
	{
		border-color: rgba(' . shopkeeper_hex2rgb( Shopkeeper_Opt::getOption( 'body_color', '#545454' ) ) . ',0.1) !important;
	}

	.wc-block-featured-product .wp-block-button__link,
	.wc-block-featured-category .wp-block-button__link,
	.edit-post-visual-editor .wc-block-featured-product h2.wc-block-featured-category__title,
	.edit-post-visual-editor .wc-block-featured-category h2.wc-block-featured-category__title,
	.wc-block-featured-product .wc-block-featured-product__wrapper,
	.edit-post-visual-editor .block-editor-block-list__block .wc-block-featured-product h3
	{
		color: ' . Shopkeeper_Opt::getOption( 'main_background', array('background-color' => '#FFFFFF') )['background-color'] . ';
	}

	.edit-post-visual-editor
	{
		background-color:' . Shopkeeper_Opt::getOption( 'main_background', array('background-color' => '#FFFFFF') )['background-color'] . ';
	}

	.gbt_18_sk_latest_posts_title,
	.edit-post-visual-editor .wp-block-quote p,
	.edit-post-visual-editor .wp-block-pullquote p,
	.edit-post-visual-editor .wp-block-pullquote__citation,
	.wp-block-media-text .editor-inner-blocks .editor-rich-text p,
	.wc-block-grid .wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-link .wc-block-grid__product-title,
	.wc-block-order-select .wc-block-order-select__select,
	.wc-block-review-list-item__product a,
	.gbt_18_sk_posts_grid_title,
	.gbt_18_sk_posts_grid_more_link,
	.wc-block-grid .wc-block-pagination button.wc-block-pagination-page--active
	{
		color: ' . Shopkeeper_Opt::getOption( 'headings_color', '#000000' ) . ';
	}

	.gbt_18_sk_posts_grid_more_link:before
	{
		background-color: ' . Shopkeeper_Opt::getOption( 'headings_color', '#000000' ) . ';
	}

	.gbt_18_sk_latest_posts_title:hover,
	.edit-post-visual-editor .wp-block-latest-posts a,
	.edit-post-visual-editor .wp-block-archives a,
	.edit-post-visual-editor .wp-block-categories a,
	.gbt_18_sk_posts_grid_title:hover,
	.wc-block-products-grid .wc-product-preview__add-to-cart,
	.wc-product-preview .star-rating span:before,
	.wc-block-grid .wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-rating .star-rating span::before,
	.wc-block-grid .wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-add-to-cart .wp-block-button__link,
	.wc-block-product-categories.is-list ul li a,
	.wc-block-review-list-item__text__read_more,
	.gbt_18_editor_slide_content_left .gbt_18_editor_slide_content_left_inner .gbt_18_editor_slide_price,
	.gbt_18_sk_posts_grid_more_link:hover,
	.wc-block-grid .wc-block-pagination button,
	.block-editor-block-list__block[data-type="woocommerce/active-filters"] .wc-block-active-filters__clear-all,
	.block-editor-block-list__block[data-type="woocommerce/attribute-filter"] ul.wc-block-checkbox-list li.show-more button
	{
		color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . ';
	}

	.wc-block-review-list-item__rating__stars span:before
	{
		color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . '!important;
	}

	.gbt_18_sk_posts_grid_more_link:hover:before,
	.block-editor-block-list__block[data-type="woocommerce/active-filters"] .wc-block-active-filters-list button:before
	{
		background-color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . ';
	}

	.editor-styles-wrapper,
	.edit-post-visual-editor,
	.edit-post-visual-editor .wp-block-quote__citation,
	.edit-post-visual-editor .block-editor-block-list__block p,
	.edit-post-visual-editor .block-editor-block-list__block table tr th,
	.edit-post-visual-editor .block-editor-block-list__block table tr td,
	.edit-post-visual-editor .block-editor-block-list__block table thead tr th,
	.edit-post-visual-editor .block-editor-block-list__block pre,
	.edit-post-visual-editor .block-editor-block-list__block li,
	.edit-post-visual-editor .block-editor-block-list__block label:not(.components-placeholder__label),
	.wp-block-latest-posts__post-date,
	.wp-block-gallery .blocks-gallery-item figcaption,
	.wp-block-audio figcaption,
	.wp-block-image figcaption,
	.wp-block-video figcaption,
	.wc-block-grid__product-price.price del,
	.editor-styles-wrapper .block-editor-block-list__block textarea:not(.editor-post-title__input).block-editor-default-block-appender__content
	{
		color: ' . Shopkeeper_Opt::getOption( 'body_color', '#545454' ) . ';
	}

	.editor-styles-wrapper .wc-block-grid .wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-onsale
	{
		background:  ' . Shopkeeper_Opt::getOption( 'sale_badge_color', '#93af76' ) . ';
	}

	.editor-post-title__block .editor-post-title__input,
	.edit-post-visual-editor .block-editor-block-list__block blockquote:not(.has-text-color) p,
	.edit-post-visual-editor h1.block-editor-block-list__block,
	.edit-post-visual-editor .block-editor-block-list__block h1,
	.edit-post-visual-editor h2.block-editor-block-list__block,
    .edit-post-visual-editor .block-editor-block-list__block h2,
	.edit-post-visual-editor h3.block-editor-block-list__block,
    .edit-post-visual-editor .block-editor-block-list__block h3,
	.edit-post-visual-editor h4.block-editor-block-list__block,
    .edit-post-visual-editor .block-editor-block-list__block h4,
	.edit-post-visual-editor h5.block-editor-block-list__block,
    .edit-post-visual-editor .block-editor-block-list__block h5,
	.edit-post-visual-editor h6.block-editor-block-list__block,
    .edit-post-visual-editor .block-editor-block-list__block h6,
	.block-editor-block-list__block[data-type="woocommerce/attribute-filter"] ul.wc-block-checkbox-list li label
	{
		color: ' . Shopkeeper_Opt::getOption( 'headings_color', '#000000' ) . ';
	}

	.wp-block-quote:not(.is-large):not(.is-style-large),
	.wp-block-quote
	{
		border-left-color: ' . Shopkeeper_Opt::getOption( 'headings_color', '#000000' ) . ';
	}

	.wp-block-pullquote
	{
		border-top-color: ' . Shopkeeper_Opt::getOption( 'headings_color', '#000000' ) . ';
		border-bottom-color: ' . Shopkeeper_Opt::getOption( 'headings_color', '#000000' ) . ';
	}

	.gbt_18_sk_latest_posts_item_link:hover .gbt_18_sk_latest_posts_img_overlay
	{
		background: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . ';
	}

	.wc-block-products-grid .wc-product-preview__price,
	.wc-block-grid__product-price.price
	{
		color: rgba(' . shopkeeper_hex2rgb( Shopkeeper_Opt::getOption( 'body_color', '#545454' ) ) . ',0.8);
	}

	@media only screen and (min-width: 1024px)
	{
		.editor-styles-wrapper .block-editor-block-list__block p,
		.editor-styles-wrapper .block-editor-block-list__block ul li ul,
		.editor-styles-wrapper .block-editor-block-list__block ul li ol,
		.editor-styles-wrapper .block-editor-block-list__block ul,
		.editor-styles-wrapper .block-editor-block-list__block ol,
		.editor-styles-wrapper .block-editor-block-list__block dl
		{
			font-size: ' . Shopkeeper_Opt::getOption( 'body_font_size', 16 ) . 'px;
		}
	}

	.edit-post-visual-editor h1.block-editor-block-list__block,
	.edit-post-visual-editor .block-editor-block-list__block h1
	{
		font-size: ' . esc_html( $h1_size_mobile ) . 'px;
	}

	.edit-post-visual-editor h2.block-editor-block-list__block,
    .edit-post-visual-editor .block-editor-block-list__block h2
	{
		font-size: ' . esc_html( $h2_size_mobile ) . 'px;
	}

	.edit-post-visual-editor h3.block-editor-block-list__block,
    .edit-post-visual-editor .block-editor-block-list__block h3,
	.wp-block-latest-posts li > a
	{
		font-size: ' . esc_html( $h3_size_mobile ) . 'px;
	}

	.edit-post-visual-editor h4.block-editor-block-list__block,
    .edit-post-visual-editor .block-editor-block-list__block h4
	{
		font-size: ' . esc_html( $h4_size_mobile ) . 'px;
	}

	.edit-post-visual-editor h5.block-editor-block-list__block,
    .edit-post-visual-editor .block-editor-block-list__block h5
	{
		font-size: ' . esc_html( $h5_size_mobile ) . 'px;
	}

	.edit-post-visual-editor .block-editor-block-list__block p.has-drop-cap:first-letter,
	.editor-post-title__input
	{
		font-size: ' . esc_html( $h0_size_mobile ) . 'px !important;
	}

	@media only screen and (min-width: 768px) {

		.edit-post-visual-editor h1.block-editor-block-list__block,
		.edit-post-visual-editor .block-editor-block-list__block h1
		{
			font-size: ' . esc_html( $h1_size ) . 'px;
		}

		.edit-post-visual-editor h2.block-editor-block-list__block,
	    .edit-post-visual-editor .block-editor-block-list__block h2
		{
			font-size: ' . esc_html( $h2_size ) . 'px;
		}

		.edit-post-visual-editor h3.block-editor-block-list__block,
	    .edit-post-visual-editor .block-editor-block-list__block h3,
		.wp-block-latest-posts li > a
		{
			font-size: ' . esc_html( $h3_size ) . 'px;
		}

		.edit-post-visual-editor h4.block-editor-block-list__block,
	    .edit-post-visual-editor .block-editor-block-list__block h4
		{
			font-size: ' . esc_html( $h4_size ) . 'px;
		}

		.edit-post-visual-editor h5.block-editor-block-list__block,
	    .edit-post-visual-editor .block-editor-block-list__block h5
		{
			font-size: ' . esc_html( $h5_size ) . 'px;
		}

		.edit-post-visual-editor .block-editor-block-list__block p.has-drop-cap:first-letter,
		.editor-post-title__input
		{
			font-size: ' . esc_html( $h0_size_mobile ) . 'px !important;
		}

		.edit-post-visual-editor .block-editor-block-list__block p.has-drop-cap:first-letter,
		.editor-post-title__input
		{
			font-size: ' . esc_html( $h0_size ) . 'px !important;
		}
	}

	@media only screen and (min-width: 768px)
	{
		.wc-block-products-grid .wc-product-preview__title
		{
			font-size: ' . Shopkeeper_Opt::getOption( 'product_title_font_size', 13 ) . 'px !important;
		}
	}';

if( SHOPKEEPER_PRODUCT_BLOCKS_IS_ACTIVE ) {
	$custom_gutenberg_styles .= '
		.editor-styles-wrapper .gbt_18_editor_slide_content .gbt_18_editor_slide_content_left .gbt_18_editor_slide_content_left_inner .gbt_18_editor_add_to_cart
		{
			background-color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . ';
		}

		.editor-styles-wrapper .gbt_18_editor_lookbook_sts_product_content ul.gbt_18_lookbook_sts_products li.gbt_18_lookbook_sts_product .gbt_18_lookbook_sts_product_title
		{
			font-family: ' . Shopkeeper_Fonts::get_secondary_font() . ';
		}

		.gbt_18_editor_slide_content_left .gbt_18_editor_slide_content_left_inner .gbt_18_editor_slide_price,
		.gbt_18_editor_slide_content_left .gbt_18_editor_slide_content_left_inner .gbt_18_editor_slide_link,
		.editor-block-list__block[data-type="getbowtied/lookbook-reveal"] .gbt_18_lookbook_reveal_product_wrapper .gbt_18_editor_lookbook_product_content .gbt_18_editor_lookbook_product_content_left .gbt_18_editor_lookbook_product_content_left_inner_bottom .gbt_18_editor_lookbook_product_price,
		.editor-styles-wrapper .editor-block-list__block[data-type="getbowtied/lookbook-reveal"] .gbt_18_lookbook_reveal_product_wrapper .gbt_18_editor_lookbook_product_content .gbt_18_editor_lookbook_product_content_left .gbt_18_editor_lookbook_product_content_left_inner_bottom .gbt_18_editor_lookbook_product_button,
		.editor-block-list__block[data-type="getbowtied/lookbook-shop-by-outfit"] .gbt_18_hero_section_text .gbt_18_hero_section_subtitle
		{
			font-family: ' . Shopkeeper_Fonts::get_main_font() . ';
		}

		.gbt_18_product_carousel ul.gbt_18_carousel_products li.gbt_18_carousel_product .gbt_18_carousel_product_title,
		.gbt_18_editor_lookbook_sts_product_content ul.gbt_18_lookbook_sts_products li.gbt_18_lookbook_sts_product .gbt_18_lookbook_sts_product_title,
		.gbt_18_editor_slide_content_left .gbt_18_editor_slide_content_left_inner .gbt_18_editor_slide_title,
		.wc-block-grid .wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-title a,
		.editor-styles-wrapper .block-editor-block-list__block[data-type="woocommerce/active-filters"] .wc-block-component-title,
		.editor-styles-wrapper .block-editor-block-list__block[data-type="woocommerce/attribute-filter"] .wc-block-component-title,
		.editor-styles-wrapper .block-editor-block-list__block[data-type="woocommerce/price-filter"] .wc-block-component-title
		{
			color: ' . Shopkeeper_Opt::getOption( 'headings_color', '#000000' ) . ';
		}

		.gbt_18_product_carousel ul.gbt_18_carousel_products li.gbt_18_carousel_product .gbt_18_carousel_product_price span,
		.gbt_18_editor_lookbook_sts_product_content ul.gbt_18_lookbook_sts_products li.gbt_18_lookbook_sts_product .gbt_18_lookbook_sts_product_price span,
		.wc-block-grid .wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-price span
		{
			color: rgba(' . shopkeeper_hex2rgb( Shopkeeper_Opt::getOption( 'body_color', '#545454' ) ) . ',0.8);
		}

		.gbt_18_product_carousel .gbt_18_product_carousel_wrapper ul.gbt_18_carousel_products li.gbt_18_carousel_product .gbt_18_carousel_product_button,
		.gbt_18_editor_lookbook_sts_product_content .gbt_18_lookbook_sts_products_wrapper ul.gbt_18_lookbook_sts_products .gbt_18_lookbook_sts_product .gbt_18_lookbook_sts_product_button
		{
			color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . ';
		}

		.editor-block-list__block[data-type="getbowtied/scattered-product-list"] .gbt_18_grid_product_content_wrapper:hover .gbt_18_grid_product_title
		{
			color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . ' !important;
		}

		.gbt_18_expanding_grid_products .gbt_18_grid_product_price *
		{
			color: rgba(' . shopkeeper_hex2rgb( Shopkeeper_Opt::getOption( 'body_color', '#545454' ) ) . ',0.8);
		}

		.gbt_18_expanding_grid_products .gbt_18_grid_product_title
		{
			font-size: ' . esc_html( $h2_size ) . 'px !important;
		}

		.editor-block-list__block[data-type="getbowtied/lookbook-reveal"][data-align=full] .gbt_18_lookbook_reveal_product_wrapper .gbt_18_editor_lookbook_product_content .gbt_18_editor_lookbook_product_content_left .gbt_18_editor_lookbook_product_content_left_inner_top .gbt_18_editor_lookbook_product_text,
		.editor-block-list__block[data-type="getbowtied/lookbook-reveal"][data-align=full] .gbt_18_lookbook_reveal_product_wrapper .gbt_18_editor_lookbook_product_content .gbt_18_editor_lookbook_product_content_left .gbt_18_editor_lookbook_product_content_left_inner_top .gbt_18_editor_lookbook_product_text *,
		.editor-block-list__block[data-type="getbowtied/lookbook-reveal"][data-align=full] .gbt_18_lookbook_reveal_product_wrapper .gbt_18_editor_lookbook_product_content .gbt_18_editor_lookbook_product_content_left .gbt_18_editor_lookbook_product_content_left_inner_top .gbt_18_editor_lookbook_product_text p
		{
			font-size: ' . Shopkeeper_Opt::getOption( 'body_font_size', 16 ) . 'px;
		}

		.editor-styles-wrapper .gbt_18_editor_slide_content .gbt_18_editor_slide_content_left .gbt_18_editor_slide_content_left_inner .gbt_18_editor_slide_title,
		.editor-block-list__block[data-type="getbowtied/lookbook-reveal"][data-align=full] .gbt_18_lookbook_reveal_product_wrapper .gbt_18_editor_lookbook_product_content .gbt_18_editor_lookbook_product_content_left .gbt_18_editor_lookbook_product_content_left_inner_top .gbt_18_editor_lookbook_product_title
		{
			font-size: ' . esc_html( $h2_size_mobile ) . 'px;
		}

		@media only screen and (min-width: 1200px) {
			.editor-styles-wrapper .gbt_18_editor_slide_content .gbt_18_editor_slide_content_left .gbt_18_editor_slide_content_left_inner .gbt_18_editor_slide_title,
			.editor-block-list__block[data-type="getbowtied/lookbook-reveal"][data-align=full] .gbt_18_lookbook_reveal_product_wrapper .gbt_18_editor_lookbook_product_content .gbt_18_editor_lookbook_product_content_left .gbt_18_editor_lookbook_product_content_left_inner_top .gbt_18_editor_lookbook_product_title
			{
				font-size: ' . esc_html( $h3_size ) . 'px;
			}

			.editor-block-list__block[data-type="getbowtied/lookbook-shop-by-outfit"] .gbt_18_hero_section_title
			{
				font-size: ' . esc_html( $h0_size ) . 'px;
			}
		}';
}
