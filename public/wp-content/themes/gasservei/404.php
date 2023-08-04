<?php get_header(); ?>

<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) { ?>

	<div id="primary" class="content-area">

	    <div class="row">
	        <div class="large-10 large-centered columns">
	            <div id="content" class="site-content" role="main">

	                <section class="error-404 not-found">
	                    <header class="page-header">
	                        <div class="error-banner"></div>
	                        <h1 class="page-title"><?php esc_html_e( "Oops 404 again! That page can't be found.", 'gasservei' ); ?></h1>

	                        <p class="error-404-text"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'gasservei' ); ?></p>

							<a href="javascript:history.back()"><?php _e('Go back', 'gasservei') ?></a>
							<div class="search-products-404">
								<?php get_product_search_form(); ?>
							</div>							
	                    </header><!-- .page-header -->

	                </section><!-- .error-404 -->

	            </div><!-- #content -->
	        </div><!-- .large-12 .columns -->
	    </div><!-- .row -->

	</div><!-- #primary -->

<?php } ?>

<?php get_footer(); ?>
