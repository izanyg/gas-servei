<div id="site-top-bar" class="<?php echo Shopkeeper_Opt::getOption( 'top_bar_mobile', false ) ? 'show-on-mobile' : ''; ?> <?php echo Shopkeeper_Opt::getOption( 'sticky_top_bar', false ) ? 'sticky-topbar' : ''; ?> <?php echo Shopkeeper_Opt::getOption( 'mobile_sticky_top_bar', false ) ? 'mobile-sticky-topbar' : ''; ?> <?php echo ('full' === Shopkeeper_Opt::getOption( 'header_width', 'custom' ) ) ? 'full-topbar' : ''; ?>">

    <?php if( Shopkeeper_Opt::getOption( 'header_width', 'custom' ) == 'custom' ) : ?>
        <div class="row">
            <div class="large-12 columns">
            <?php endif; ?>

            <div class="site-top-bar-inner">

                <div class="site-top-message">
                    <?php if( !empty( Shopkeeper_Opt::getOption( 'top_bar_text', 'Free Shipping on All Orders Over $75!' ) ) ) {
                        printf( wp_kses_post(__( '%s', 'shopkeeper' )), Shopkeeper_Opt::getOption( 'top_bar_text', 'Free Shipping on All Orders Over $75!' ));
                    } ?>
                </div>

                <?php do_action( 'header_socials'); ?>

                <div class="topbar-menu">
                    <?php if( !wp_is_mobile() ) { ?>
                        <?php shopkeeper_get_menu( 'site-navigation-top-bar main-navigation', 'top-bar-navigation', 1 ); ?>

                        <?php if ( is_user_logged_in() && SHOPKEEPER_WOOCOMMERCE_IS_ACTIVE ) { ?>
                            <nav class="logout-menu-nav main-navigation" role="navigation" aria-label="Topbar Logout Menu">
                                <ul class="logout-menu">
                                    <li>
                                        <a href="<?php echo wc_logout_url(); ?>" class="logout_link"><?php esc_html_e('Logout', 'woocommerce'); ?></a>
                                    </li>
                                </ul>
                            </nav>
                        <?php } ?>
                    <?php } ?>
                </div>

            </div><!-- .site-top-bar-inner -->

            <?php if( Shopkeeper_Opt::getOption( 'header_width', 'custom' ) == 'custom' ) : ?>
            </div><!-- .columns -->
        </div><!-- .row -->
    <?php endif; ?>

</div><!-- #site-top-bar -->
