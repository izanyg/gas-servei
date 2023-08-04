<?php

$custom_styles .= '
	.st-content,
	.categories_grid .category_name,
	.cd-top,
	.product_socials_wrapper .product_socials_wrapper_inner a,
	.product_navigation #nav-below .product-nav-next a,
	.product_navigation #nav-below .product-nav-previous a
	{
		background-color: ' . Shopkeeper_Opt::getOption( 'main_background_color', '#FFFFFF' ) . ';
	}

	.categories_grid .category_item:hover .category_name
	{
		color: ' . Shopkeeper_Opt::getOption( 'main_background_color', '#FFFFFF' ) . ';
	}';

if( !empty( Shopkeeper_Opt::getOption( 'main_background_image', '' ) ) ) {
	$custom_styles .= '
		.st-content
		{
			background-image: url(' . esc_url( Shopkeeper_Opt::getOption( 'main_background_image', '' ) ) . ');
			background-repeat: ' . Shopkeeper_Opt::getOption( 'main_background_image_repeat', 'no-repeat' ) . ';
			background-position: ' . str_replace( '-', ' ', Shopkeeper_Opt::getOption( 'main_background_image_position', 'left-top' ) ) . ';
			background-size: ' . Shopkeeper_Opt::getOption( 'main_background_image_size', 'cover' ) . ';
			background-attachment: ' . Shopkeeper_Opt::getOption( 'main_background_image_attachment', 'scroll' ) . ';
		}';
}

if( is_user_logged_in() ) {
	$custom_styles .= '
		@media all and (min-width: 1024px) and (max-width: 1280px)
		{
			.position-left,
			.position-right
			{
				padding-top: 38px;
			}
		}';
}

if( !Shopkeeper_Opt::getOption( 'predictive_search', true ) ) {
	$custom_styles .= '
		@media all and (max-width: 767px) {
			.site-search {
			    min-height: 170px;
			    height: 170px;
			    -webkit-transform: translateY(-170px);
			    -ms-transform: translateY(-170px);
			    transform: translateY(-170px);
			}
		}';
}
