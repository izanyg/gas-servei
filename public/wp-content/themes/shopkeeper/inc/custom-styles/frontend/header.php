<?php

$header_max_width = ( 'custom' === Shopkeeper_Opt::getOption( 'header_width', 'custom' ) ) ? Shopkeeper_Opt::getOption( 'header_max_width', 1680 ) . 'px' : '100%';
$page_id 		  = shopkeeper_get_page_id();
$content_margin   = 0;

if ( Shopkeeper_Opt::getOption( 'sticky_header', true ) || Shopkeeper_Opt::getOption( 'main_header_transparency', false ) ||
((get_post_meta($page_id, 'page_header_transparency', true)) && (get_post_meta($page_id, 'page_header_transparency', true) != "inherit"))
) {
	$content_margin = Shopkeeper_Opt::getOption( 'logo_height', 50 ) + Shopkeeper_Opt::getOption( 'spacing_above_logo', 20 ) + Shopkeeper_Opt::getOption( 'spacing_below_logo', 20 ) + 85;

	if ( '3' === Shopkeeper_Opt::getOption( 'main_header_layout', '1' ) ) {
		$content_margin += 50;
	}
}

$custom_styles .= '

	#site-top-bar,
	.site-navigation-top-bar .sf-menu ul
	{
		background: ' . Shopkeeper_Opt::getOption( 'top_bar_background_color', '#333333' ) . ';
	}

	#site-top-bar,
	#site-top-bar a,
	#site-top-bar .main-navigation > ul > li:after,
	.language-and-currency .wcml_currency_switcher > ul > li.wcml-cs-active-currency > a
	{
		color: ' . Shopkeeper_Opt::getOption( 'top_bar_typography', '#fff' ) . ';
	}

	#site-top-bar ul.sk_social_icons_list li svg
	{
		fill: ' . Shopkeeper_Opt::getOption( 'top_bar_typography', '#fff' ) . ';
	}

	.top-headers-wrapper .site-header .site-header-wrapper,
	#site-top-bar .site-top-bar-inner
	{
		max-width: ' . $header_max_width . ';
	}

	.top-headers-wrapper.sticky .site-header
	{
		background-color: ' . Shopkeeper_Opt::getOption( 'sticky_header_background_color', '#fff' ) . ';
	}

	.site-header,
	.default-navigation,
	.main-navigation .mega-menu > ul > li > a
	{
		font-size: ' . Shopkeeper_Opt::getOption( 'main_header_font_size', 13 ) . 'px;
	}

	.top-headers-wrapper .site-header .main-navigation > ul > li ul,
	#site-top-bar .main-navigation > ul > li ul
	{
		background-color: ' . Shopkeeper_Opt::getOption( 'main_header_dropdown_background_color', '#ffffff' ) . ';
	}

	.top-headers-wrapper .site-header .main-navigation > ul > li ul li a,
	#site-top-bar .main-navigation > ul > li ul li a,
	.main-navigation > ul ul li.menu-item-has-children:after
	{
		color: ' . Shopkeeper_Opt::getOption( 'main_header_dropdown_font_color', '#000000' ) . ';
	}

	.main-navigation ul ul li a,
	#site-top-bar .main-navigation ul ul li a
	{
	    background-image: linear-gradient(transparent calc(100% - 2px), rgba(' . shopkeeper_hex2rgb(Shopkeeper_Opt::getOption( 'main_header_dropdown_font_color', '#000000' )) . ',1) 2px);
	}

	.site-header,
	.main-navigation a,
	.main-navigation > ul > li:after,
	.site-tools > ul > li > a > span,
	.shopping_bag_items_number,
	.wishlist_items_number,
	.site-title a,
	.widget_product_search .search-but-added,
	.widget_search .search-but-added,
	.site-header .site-header-wrapper .site-title
	{
		color: ' . Shopkeeper_Opt::getOption( 'main_header_font_color', '#000' ) . ';
	}

	.site-header-sticky.sticky .site-header,
	.site-header-sticky.sticky .main-navigation a,
	.site-header-sticky.sticky .main-navigation > ul > li:after,
	.site-header-sticky.sticky .site-tools > ul > li > a > span,
	.site-header-sticky.sticky .shopping_bag_items_number,
	.site-header-sticky.sticky .wishlist_items_number,
	.site-header-sticky.sticky .site-title a,
	.site-header-sticky.sticky .widget_product_search .search-but-added,
	.site-header-sticky.sticky .widget_search .search-but-added,
	.site-header-sticky.sticky .site-header .site-header-wrapper .site-title,
	#page_wrapper.transparent_header .site-header-sticky.sticky .site-header .site-header-wrapper .site-title
	{
		color: ' . Shopkeeper_Opt::getOption( 'sticky_header_color', '#000' ) . ';
	}

	.site-branding
	{
		border-color: ' . Shopkeeper_Opt::getOption( 'main_header_font_color', '#000' ) . ';
	}

	.site-header
	{
		background-color: ' . Shopkeeper_Opt::getOption( 'main_header_background_color', '#FFFFFF' ) . ';
	}

	@media only screen and (max-width: 1024px)
	{
		.top-headers-wrapper .site-header .site-branding img.mobile-logo-img
		{
			max-height: ' . Shopkeeper_Opt::getOption( 'mobile_logo_height', 33 ) . 'px;
		}

		.off-canvas .mobile-navigation
		{
			border-color: rgba(' . shopkeeper_hex2rgb(Shopkeeper_Opt::getOption( 'offcanvas_text_color', '#545454' )) . ',0.1) !important;
		}
	}

	@media only screen and (min-width: 1024px)
	{
		.transparent_header .content-area
		{
			padding-top: ' . $content_margin . 'px;
		}

		.transparent_header .single-post-header.with-thumb,
		.transparent_header .page-title-hidden:not(.boxed-page),
		.transparent_header .entry-header-page.with-featured-img,
		.transparent_header .shop_header.with_featured_img,
		.transparent_header .entry-header.with_featured_img
		{
			margin-top: -' . $content_margin . 'px;
		}

		.top-headers-wrapper:not(.sticky) .site-header .site-branding img.site-logo-img
		{
			max-height: ' . Shopkeeper_Opt::getOption( 'logo_height', 50 ) . 'px;
		}

		.top-headers-wrapper.sticky .site-header .site-branding img.sticky-logo-img
		{
			max-height: ' . Shopkeeper_Opt::getOption( 'sticky_logo_height', 33 ) . 'px;
		}

		.top-headers-wrapper:not(.sticky) .site-header
		{
			padding-top: ' . Shopkeeper_Opt::getOption( 'spacing_above_logo', 20 ) . 'px;
			padding-bottom: ' . Shopkeeper_Opt::getOption( 'spacing_below_logo', 20 ) . 'px;
		}

		.top-headers-wrapper.sticky .site-header
		{
			padding-top: ' . Shopkeeper_Opt::getOption( 'sticky_spacing_above_logo', 15 ) . 'px;
			padding-bottom: ' . Shopkeeper_Opt::getOption( 'sticky_spacing_below_logo', 15 ) . 'px;
		}

		.site-header,
		.main-navigation a,
		.site-tools ul li a,
		.shopping_bag_items_number,
		.wishlist_items_number,
		.site-title a,
		.widget_product_search .search-but-added,
		.widget_search .search-but-added
		{
			color: ' . Shopkeeper_Opt::getOption( 'main_header_font_color', '#000' ) . ';
		}

		.site-branding
		{
			border-color: ' . Shopkeeper_Opt::getOption( 'main_header_font_color', '#000' ) . ';
		}

		#page_wrapper.transparent_header.transparency_light .top-headers-wrapper:not(.sticky) .site-header,
		#page_wrapper.transparent_header.transparency_light .top-headers-wrapper:not(.sticky) .site-header .main-navigation > ul > li > a,
		#page_wrapper.transparent_header.transparency_light .top-headers-wrapper:not(.sticky) .site-header .main-navigation > ul > li:after,
		#page_wrapper.transparent_header.transparency_light .top-headers-wrapper:not(.sticky) .site-header .site-tools > ul > li > a > span,
		#page_wrapper.transparent_header.transparency_light .top-headers-wrapper:not(.sticky) .site-header .shopping_bag_items_number,
		#page_wrapper.transparent_header.transparency_light .top-headers-wrapper:not(.sticky) .site-header .wishlist_items_number,
		#page_wrapper.transparent_header.transparency_light .top-headers-wrapper:not(.sticky) .site-header .site-title a,
		#page_wrapper.transparent_header.transparency_light .top-headers-wrapper:not(.sticky) .site-header .widget_product_search .search-but-added,
		#page_wrapper.transparent_header.transparency_light .top-headers-wrapper:not(.sticky) .site-header .widget_search .search-but-added,
		#page_wrapper.transparent_header.transparency_light .site-header .site-header-wrapper .site-title
		{
			color: ' . Shopkeeper_Opt::getOption( 'main_header_transparent_light_color', '#fff' ) . ';
		}

		#page_wrapper.transparent_header.transparency_dark .top-headers-wrapper:not(.sticky) .site-header,
		#page_wrapper.transparent_header.transparency_dark .top-headers-wrapper:not(.sticky) .site-header .main-navigation > ul > li > a,
		#page_wrapper.transparent_header.transparency_dark .top-headers-wrapper:not(.sticky) .site-header .main-navigation > ul > li:after,
		#page_wrapper.transparent_header.transparency_dark .top-headers-wrapper:not(.sticky) .site-header .site-tools > ul > li > a > span,
		#page_wrapper.transparent_header.transparency_dark .top-headers-wrapper:not(.sticky) .site-header .shopping_bag_items_number,
		#page_wrapper.transparent_header.transparency_dark .top-headers-wrapper:not(.sticky) .site-header .wishlist_items_number,
		#page_wrapper.transparent_header.transparency_dark .top-headers-wrapper:not(.sticky) .site-header .site-title a,
		#page_wrapper.transparent_header.transparency_dark .top-headers-wrapper:not(.sticky) .site-header .widget_product_search .search-but-added,
		#page_wrapper.transparent_header.transparency_dark .top-headers-wrapper:not(.sticky) .site-header .widget_search .search-but-added,
		#page_wrapper.transparent_header.transparency_dark .site-header .site-header-wrapper .site-title
		{
			color: ' . Shopkeeper_Opt::getOption( 'main_header_transparent_dark_color', '#000' ) . ';
		}

		.site-header.sticky,
		#page_wrapper.transparent_header .top-headers-wrapper.sticky .site-header
		{
			background: ' . Shopkeeper_Opt::getOption( 'sticky_header_background_color', '#fff' ) . ';
		}

		.site-header.sticky,
		.site-header.sticky .main-navigation a,
		.site-header.sticky .site-tools ul li a,
		.site-header.sticky .shopping_bag_items_number,
		.site-header.sticky .wishlist_items_number,
		.site-header.sticky .site-title a,
		.site-header.sticky .widget_product_search .search-but-added,
		.site-header.sticky .widget_search .search-but-added,
		#page_wrapper.transparent_header .top-headers-wrapper.sticky .site-header,
		#page_wrapper.transparent_header .top-headers-wrapper.sticky .site-header .main-navigation > ul > li > a,
		#page_wrapper.transparent_header .top-headers-wrapper.sticky .site-header .main-navigation > ul > li:after,
		#page_wrapper.transparent_header .top-headers-wrapper.sticky .site-header .site-tools > ul > li > a > span,
		#page_wrapper.transparent_header .top-headers-wrapper.sticky .site-header .shopping_bag_items_number,
		#page_wrapper.transparent_header .top-headers-wrapper.sticky .site-header .wishlist_items_number,
		#page_wrapper.transparent_header .top-headers-wrapper.sticky .site-header .site-title a,
		#page_wrapper.transparent_header .top-headers-wrapper.sticky .site-header .widget_product_search .search-but-added,
		#page_wrapper.transparent_header .top-headers-wrapper.sticky .site-header .widget_search .search-but-added
		{
			color: ' . Shopkeeper_Opt::getOption( 'sticky_header_color', '#000' ) . ';
		}

		.top-headers-wrapper.sticky .site-header .site-branding
		{
			border-color: ' . Shopkeeper_Opt::getOption( 'sticky_header_color', '#000' ) . ';
		}
	}
';

if( !empty( Shopkeeper_Opt::getOption( 'main_header_background_image', '' ) ) ) {
	$custom_styles .= '
		@media only screen and (min-width: 63.9375em)
		{
			.site-header
			{
				background-image: url(' . esc_url( Shopkeeper_Opt::getOption( 'main_header_background_image', '' ) ) . ');
				background-repeat: ' . Shopkeeper_Opt::getOption( 'main_header_background_image_repeat', 'no-repeat' ) . ';
				background-position: ' . str_replace( '-', ' ', Shopkeeper_Opt::getOption( 'main_header_background_image_position', 'left-top' ) ) . ';
				background-size: ' . Shopkeeper_Opt::getOption( 'main_header_background_image_size', 'cover' ) . ';
				background-attachment: ' . Shopkeeper_Opt::getOption( 'main_header_background_image_attachment', 'scroll' ) . ';
			}
		}
	';
}

if ( !empty( Shopkeeper_Opt::getOption( 'main_header_shopping_bag_icon', '' ) ) ) {
	$custom_styles .= '
		.shopkeeper-mini-cart .widget.woocommerce.widget_shopping_cart .widget_shopping_cart_content .woocommerce-mini-cart__empty-message:before,
		.woocommerce-cart .cart-empty:before,
		.cart-empty:before
		{
			content: "";
			background-image: url( ' . Shopkeeper_Opt::getOption( 'main_header_shopping_bag_icon', '' ) . ' );
			background-repeat: no-repeat;
			background-size: contain;
			margin: 0 auto 25px;
			padding: 0;
			height: 128px;
			width: 128px;
		}
	';
}

if( 'left' === Shopkeeper_Opt::getOption( 'top_bar_navigation_position', 'right' ) ) {
	$custom_styles .= '
		#site-top-bar .topbar-menu
		{
			float: left !important;
		}';
}
