<?php
/**
 * Template part for displaying posts in loop
 *
 * @package k2_prefix
 */
$all_portfolio_page = k2_theme_frame_get_opt('all_portfolio_page');
$portfolio_related_on = k2_theme_frame_get_opt('portfolio_related_on', true);
?>
<div class="container content-container">
    <div class="row">
        <div id="primary" class="content-area col-12">
            <main id="main" class="site-main">
                <div class="post-type-inner">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <div class="post-type-content">
                            <div class="post-type-content-inner">
                                <?php the_content(); ?>
                            </div>
                        </div>

                    <?php endwhile; ?>
                </div>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div>
</div>
<?php
    global $post;
    $PortfolioTaxonomyTerms = wp_get_object_terms( $post->ID, 'portfolio-category', array('fields' => 'ids') );
    $args = array(
        'post_type' => 'portfolio',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'orderby' => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'portfolio-category',
                'field' => 'id',
                'terms' => $PortfolioTaxonomyTerms
            )
        ),
        'post__not_in' => array ($post->ID),
    );
    $relatedPost = new WP_Query( $args ); ?>
    <?php if($relatedPost->have_posts()) { ?>
        <div class="post-type-related bg-overlay overlay-dotted cms-grid-portfolio-layout7">
            <h3 class="cms-portfolio-heading arrow-divider-width">
                <div class="arrow-divider"></div>
                <span><?php esc_html_e('Related Projects', 'k2_text_domain'); ?></span>
            </h3>
            <div class="container">
                <div class="row">
                    <?php while($relatedPost->have_posts() && $portfolio_related_on) { 
                        $relatedPost->the_post(); ?>
                        <div class="grid-item col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <div class="grid-item-inner">
                                <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) : 
                                    $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large', false);
                                    $thumbnail_url_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
                                    ?>
                                    <div class="item-featured">
                                        <a class="bg-image" href="<?php echo esc_url(get_permalink()); ?>" style="background-image: url(<?php echo esc_url($thumbnail_url[0]); ?>);"></a>
                                    </div>
                                    <div class="item-holder">
                                        <div class="item-holder-inner">
                                            <h3 class="item-title">
                                                <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
                                            </h3>
                                            <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) { ?>
                                                <div class="item-zoom image-light-box">
                                                    <a class="light-box" href="<?php echo esc_url($thumbnail_url_full[0]); ?>"><i class="zmdi zmdi-search"></i></a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php if(!empty($all_portfolio_page)) : ?>
                <div class="portfolio-back-category arrow-divider-width">
                    <div class="arrow-divider"></div>
                    <a href="<?php echo esc_url(get_permalink($all_portfolio_page)); ?>">
                        <i class="zmdi zmdi-long-arrow-left"></i>
                        <?php echo esc_html( 'Back to Projects', 'k2_text_domain' ); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php } ?>
<?php wp_reset_postdata(); ?>