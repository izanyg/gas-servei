<?php

$header_width = ( 'full' === Shopkeeper_Opt::getOption( 'header_width', 'custom' ) ) ? 'full-header-width' : 'custom-header-width';
$header_alignment = ( '1' === Shopkeeper_Opt::getOption( 'main_header_layout', '1' ) ) ? 'align_left' : 'align_right';

?>

<header id="masthead" class="site-header default <?php echo esc_attr($header_width); ?>" role="banner">
    <div class="row">
        <div class="site-header-wrapper">

            <div class="site-branding">
                <?php shopkeeper_get_logo(); ?>
            </div>

            <div class="menu-wrapper">
                <?php if( !wp_is_mobile() ) { ?>
                    <?php shopkeeper_get_menu( 'show-for-large main-navigation default-navigation ' . $header_alignment, 'main-navigation', 1 ); ?>
                <?php } ?>

                <div class="site-tools">
                    <?php echo mimotic_shopkeeper_get_header_tool_icons(); ?>
                </div>

                <div class="site-tools" id="menu-search-block">
                    <input type="search" id="wc-block-search__input-1" class="wc-block-product-search__field" placeholder="<?php _e('Search products...', 'gasservei'); ?>" name="s">
                    <div class="arrow"></div>
                </div>
            </div>

        </div>
    </div>
</header>
