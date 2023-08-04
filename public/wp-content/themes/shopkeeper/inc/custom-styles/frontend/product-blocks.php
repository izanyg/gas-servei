<?php

$custom_styles .= '
    .wp-block-getbowtied-carousel ul.products li.product .price
    {
        color: rgba(' . shopkeeper_hex2rgb(Shopkeeper_Opt::getOption( 'body_color', '#545454' )) . ',0.8) !important;
    }

    .wp-block-getbowtied-carousel ul.products li.product .onsale
	{
		font-family: ' . Shopkeeper_Fonts::get_main_font() . ';
	}

    .wp-block-getbowtied-carousel ul.products li.product .product_thumbnail_icons .product_quickview_button
	{
		color: rgba(' . shopkeeper_hex2rgb(Shopkeeper_Opt::getOption( 'body_color', '#545454' )) . ',0.8);
	}

    .wp-block-getbowtied-carousel ul.products li.product .product_thumbnail_icons .product_quickview_button:hover
	{
		color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . ';
	}

    .wp-block-getbowtied-carousel ul.products li.product .star-rating span:before
	{
		color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . ';
	}';
