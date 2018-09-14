<?php
/**
 * Template part for displaying posts in loop
 *
 * @package k2_prefix
 */
$all_portfolio_page = k2_theme_frame_get_opt('all_portfolio_page');
$portfolio_feature_img = k2_theme_frame_get_page_opt('portfolio_feature_img', 'show');
$portfolio_gallery = k2_theme_frame_get_page_opt('portfolio_gallery');
$portfolio_gallery_list = explode(',', $portfolio_gallery);
$portfolio_address = k2_theme_frame_get_page_opt('portfolio_address');
$url_brochure = k2_theme_frame_get_page_opt('url_brochure');
$project_start_date = k2_theme_frame_get_page_opt('project_start_date');
$project_end_date = k2_theme_frame_get_page_opt('project_end_date');
$project_property_value = k2_theme_frame_get_page_opt('project_property_value');
$project_property_type = k2_theme_frame_get_page_opt('project_property_type');
?>
<div class="container content-container">
    <div class="row">
        <div id="primary" class="content-area col-12">
            <main id="main" class="site-main">
                <div class="post-type-inner">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <div class="post-type-header">
                            <?php if(!empty($all_portfolio_page)) : ?>
                                <a class="all-portfolio-page" href="<?php echo esc_url(get_permalink($all_portfolio_page)); ?>">
                                    <i class="zmdi zmdi-chevron-left"></i>
                                    <?php echo esc_html( 'Back to Portfolio', 'k2_text_domain' ); ?>
                                </a>
                            <?php endif; ?>
                            <h2 class="post-type-title"><?php the_title(); ?></h2>
                            <?php if(!empty($portfolio_address)) : ?>
                                <div class="post-type-address text-heading"><?php echo esc_attr($portfolio_address); ?></div>
                            <?php endif; ?>
                            <?php if(!empty($project_start_date) || !empty($project_end_date) || !empty($project_property_value) || !empty($project_property_type)) : ?>
                                <ul class="post-type-meta">
                                    <?php if(!empty($project_start_date)) : ?>
                                        <li><label><?php echo esc_html__('Started Date', 'k2_text_domain')?></label><?php echo esc_attr($project_start_date); ?></li>
                                    <?php endif; ?>
                                    <?php if(!empty($project_end_date)) : ?>
                                        <li><label><?php echo esc_html__('Ended Date', 'k2_text_domain')?></label><?php echo esc_attr($project_end_date); ?></li>
                                    <?php endif; ?>
                                    <?php if(!empty($project_property_value)) : ?>
                                        <li><label><?php echo esc_html__('Property Value', 'k2_text_domain')?></label><?php echo esc_attr($project_property_value); ?></li>
                                    <?php endif; ?>
                                    <?php if(!empty($project_property_type)) : ?>
                                        <li><label><?php echo esc_html__('Property Type', 'k2_text_domain')?></label><?php echo esc_attr($project_property_type); ?></li>
                                    <?php endif; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <?php if ( has_post_thumbnail() && $portfolio_feature_img == 'show' ) : ?>
                            <div class="post-type-media">
                                <?php the_post_thumbnail('full'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($portfolio_gallery)) :
                            wp_enqueue_script( 'owl-carousel' );
                            wp_enqueue_script( 'k2_prefix-carousel' ); ?>
                            <div class="cms-gallery-slider-wrap">
                                <div class="cms-carousel owl-carousel gallery-carousel owl-arrows-middle-circle images-light-box" data-item-xs="1" data-item-sm="1" data-item-md="1" data-item-lg="1" data-margin="30" data-loop="true" data-autoplay="false" data-autoplaytimeout="5000" data-smartspeed="250" data-center="false" data-arrows="true" data-bullets="true" data-stagepadding="0" data-stagepaddingsm="0" data-rtl="false" data-dotscontainer="true">
                                    <?php foreach ($portfolio_gallery_list as $img_id): ?>
                                        <div class="post-type-gallery-item bg-overlay">
                                            <a class="light-box" href="<?php echo esc_url(wp_get_attachment_image_url($img_id, 'full'));?>">
                                                <img src="<?php echo esc_url(wp_get_attachment_image_url($img_id, 'k2_prefix-large'));?>" />
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="slider-nav clearfix">
                                    <span class="slider-button slider-close"><?php echo esc_html__('Hide Thumbnails', 'k2_text_domain'); ?><i class="zmdi zmdi-chevron-down"></i></span>
                                    <span class="slider-button slider-show"><?php echo esc_html__('Show Thumbnails', 'k2_text_domain'); ?><i class="zmdi zmdi-chevron-up"></i></span>
                                    <div class="thumbs">
                                        <?php foreach ($portfolio_gallery_list as $img_id): ?>
                                            <div class="thumb">
                                                <div class="thumb-inner" style="background-image: url(<?php echo esc_url(wp_get_attachment_image_url($img_id, 'full'));?>);"></div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <ul class="post-type-button">
                            <?php if(!empty($portfolio_gallery)) : ?>
                                <li class="button-gallery"><span class="btn btn-primary"><i class="zmdi zmdi-camera"></i><?php echo esc_html__('Gallery View', 'k2_text_domain'); ?></span></li>
                            <?php endif; ?>
                            <?php if(!empty($portfolio_address)) : ?>
                                <li class="button-location"><a href="http://maps.google.com/?q=<?php echo esc_attr( $portfolio_address ); ?>" target="_blank" class="btn btn-white"><i class="zmdi zmdi-pin"></i><?php echo esc_html__('Location View', 'k2_text_domain'); ?></a></li>
                            <?php endif; ?>
                            <?php if(!empty($url_brochure)) : ?>
                                <li class="button-download"><a class="btn btn-white" href="<?php echo esc_url($url_brochure); ?>" target="_blank"><i class="zmdi zmdi-download"></i><?php echo esc_html__('Download Brochure', 'k2_text_domain'); ?></a></li>
                            <?php endif; ?>
                            <li class="button-share">
                                <a class="btn btn-white"><i class="zmdi zmdi-share"></i><span><?php echo esc_html__('Share Project', 'k2_text_domain'); ?></span></a>
                                <ul>
                                    <li class="social-close"><i class="zmdi zmdi-close"></i></li>
                                    <li><a class="fb-social" title="Facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="zmdi zmdi-facebook"></i></a></li>
                                    <li><a class="tw-social" title="Twitter" target="_blank" href="https://twitter.com/home?status=<?php the_permalink(); ?>"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a class="tw-email" title="Email" href="mailto:contact@example.com?subject=<?php the_title(); ?>&body=Check out this site <?php the_permalink(); ?>"><i class="zmdi zmdi-email"></i></a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="post-type-content">
                            <?php the_content(); ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div>
</div>