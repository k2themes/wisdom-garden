<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package k2_prefix
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="row">
                <div class="col-12">
                    <section class="error-404 text-center">
                        <header>
                            <h1><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'k2_text_domain' ); ?></h1>
                        </header><!-- .page-title -->

                        <div class="page-content">
                            <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'k2_text_domain' ); ?></p>
                            <a class="btn" href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html__('Return To Homepage', 'k2_text_domain'); ?></a>
                        </div><!-- .page-content -->
                    </section><!-- .error-404 -->
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
