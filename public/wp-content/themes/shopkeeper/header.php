<!DOCTYPE html>

<!--[if IE 9]>
<html class="ie ie9" <?php language_attributes(); ?>>
<![endif]-->

<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php shopkeeper_preload_default_fonts( array('Radnika', 'NeueEinstellung') ); ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>

    <?php if ( !function_exists( 'elementor_theme_do_location' ) || !elementor_theme_do_location( 'header' ) ) { ?>

        <?php
        global $page_id;
        $page_header_option = "on";

        if (get_post_meta( $page_id, 'header_meta_box_check', true )) {
            $page_header_option = get_post_meta( $page_id, 'header_meta_box_check', true );
        }

        if ( SHOPKEEPER_WOOCOMMERCE_IS_ACTIVE ) {
            if (is_shop() && get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'header_meta_box_check', true )) {
                $page_header_option = get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'header_meta_box_check', true );
            }
        }
        ?>

        <?php do_action( 'wp_header_components' ); ?>

    	<?php if( Shopkeeper_Opt::getOption( 'smooth_transition_between_pages', false ) ) { ?>
    		<div id="header-loader">
    		    <div id="header-loader-under-bar"></div>
    		</div>
    	<?php }	?>

    	<div id="st-container" class="st-container">

            <div class="st-content">

                <?php $transparency = shopkeeper_get_transparency_options(); ?>
                <div id="page_wrapper" class="<?php echo esc_attr( $transparency['transparency_class'] ); ?> <?php echo esc_attr( $transparency['transparency_scheme'] ); ?>">

                    <?php if ( $page_header_option == "on" ) { ?>

                        <?php do_action( 'before' ); ?>

                        <div class="top-headers-wrapper <?php echo Shopkeeper_Opt::getOption( 'sticky_header', true ) ? 'site-header-sticky' : ''; ?>">

                            <?php

        					if( shopkeeper_is_topbar_enabled() ) {
        						include( get_theme_file_path('header-topbar.php') );
        					} else {
        					?>
        						<div class="top-clear"></div>
        					<?php
        					}

                            $header_layout = Shopkeeper_Opt::getOption( 'main_header_layout', '1' );
                            if ( $header_layout == "1" || $header_layout == "11" ) :
                                include( get_theme_file_path('header-default.php') );
                            elseif ( $header_layout == "2" || $header_layout == "22" ) :
                                include( get_theme_file_path('header-centered-2menus.php') );
                            elseif ( $header_layout == "3" ) :
                                include( get_theme_file_path('header-centered-menu-under.php') );
                            endif;

        					?>

                        </div>
                    <?php } ?>
    <?php } ?>
