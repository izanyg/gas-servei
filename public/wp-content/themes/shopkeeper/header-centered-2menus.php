<?php

$header_width       = ( 'full' === Shopkeeper_Opt::getOption( 'header_width', 'custom' ) ) ? 'full-header-width' : 'custom-header-width';
$left_menu_align    = ( '22' === Shopkeeper_Opt::getOption( 'main_header_layout', '1' ) ) ? 'align-left' : 'align-right';
$right_menu_align   = ( '22' === Shopkeeper_Opt::getOption( 'main_header_layout', '1' ) ) ? 'align-right' : 'align-left';

?>

<header id="masthead" class="site-header centered <?php echo esc_attr($header_width); ?>" role="banner">
    <div class="row">
        <div class="site-header-wrapper">

            <?php if( !wp_is_mobile() ) { ?>
                <div class="menu-wrapper menu-left">
                    <?php shopkeeper_get_menu( 'main-navigation default-navigation left-navigation show-for-large ' . $left_menu_align, 'centered_header_left_navigation', 1, true ); ?>
                </div>
            <?php } ?>

            <div class="site-branding">
                <?php shopkeeper_get_logo(); ?>
            </div>

            <div class="menu-wrapper">
                <?php if( !wp_is_mobile() ) { ?>
                    <?php shopkeeper_get_menu( 'main-navigation default-navigation right-navigation show-for-large ' . $right_menu_align, 'centered_header_right_navigation', 1, true ); ?>
                <?php } ?>

                <div class="site-tools">
                    <?php echo shopkeeper_get_header_tool_icons(); ?>
                </div>
            </div>

        </div>
    </div>
</header>
