<?php
/**
 * The template for displaying all single posts
 *
 * @package k2_prefix
 */

get_header();

if ( is_singular('product')  ) :
    $sidebar_pos = k2_theme_frame_get_opt( 'sidebar_shop', 'right' );
else :
    $sidebar_pos = k2_theme_frame_get_opt( 'post_sidebar_pos', 'right' );
endif;
$page_for_posts = get_option( 'page_for_posts' );
$single_post_layout = k2_theme_frame_get_opt( 'single_post_layout', 'default' );
$post_navigation_link_on = k2_theme_frame_get_opt( 'post_navigation_link_on', true );
$post_navigation_link_on_industrial = k2_theme_frame_get_opt( 'post_navigation_link_on_industrial', true );
?>
<div class="container content-container">
    <div class="row content-row">
        <div id="primary" <?php k2_theme_frame_primary_class( $sidebar_pos, 'content-area' ); ?>>
            <main id="main" class="site-main">
                <?php

                    while ( have_posts() )
                    {
                        the_post();
                        get_template_part( 'template-parts/content-single/content', $single_post_layout );
                        if($single_post_layout != 'construction-company') :
                            if ( comments_open() || get_comments_number() )
                            {
                                comments_template();
                            }
                        endif;
                    }
                    if($post_navigation_link_on && $single_post_layout == 'renovation') {
                        k2_theme_frame_post_nav_default();
                    }
                    if($post_navigation_link_on_industrial && $single_post_layout == 'industrial') {
                        k2_theme_frame_post_nav_industrial();
                    }

                ?>
            </main><!-- #main -->
        </div><!-- #primary -->

        <?php if ( 'left' == $sidebar_pos || 'right' == $sidebar_pos ) : ?>
        <aside id="secondary" <?php k2_theme_frame_secondary_class( $sidebar_pos, 'widget-area' ); ?>>
            <?php get_sidebar(); ?>
        </aside>
        <?php endif; ?>
    </div>
</div>
<?php
k2_theme_frame_set_post_views(get_the_ID());
get_footer();
