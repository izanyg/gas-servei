<?php

$header_width = ( 'full' === Shopkeeper_Opt::getOption( 'header_width', 'custom' ) ) ? 'full-header-width' : 'custom-header-width';
$mobile_class = wp_is_mobile() ? 'is-mobile' : '';
?>

<header id="masthead" class="site-header menu-under <?php echo esc_attr($header_width); ?>" role="banner">
    <div class="row">
        <div class="site-header-wrapper <?php echo esc_attr($mobile_class); ?>">

            <div class="site-branding">
                <?php shopkeeper_get_logo(); ?>
            </div>

            <div class="menu-wrapper <?php echo esc_attr($mobile_class); ?>">
                <?php if( !wp_is_mobile() ) { ?>
                    <?php shopkeeper_get_menu( 'show-for-large main-navigation default-navigation', 'main-navigation', 1 ); ?>
                <?php } ?>

                <div class="site-tools">
                    <?php echo shopkeeper_get_header_tool_icons(); ?>
                </div>
            </div>

        </div>
    </div>
</header>
