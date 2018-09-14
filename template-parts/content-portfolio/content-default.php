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

$project_info_title = k2_theme_frame_get_page_opt('project_info_title');
$project_info_list = k2_theme_frame_get_page_opt('project_info_list');
$project_info_result = count($project_info_list);

$layout_class = '';
if(!empty($project_info_list)) {
    $layout_class = 'col-xl-8 col-lg-8 col-md-12 col-sm-12';
} else {
    $layout_class = 'col-12';
}
?>
<div class="container content-container">
    <div class="row content-row">
        <div id="primary" class="content-area col-12">
            <main id="main" class="site-main">
                <div class="post-type-inner">
                    <?php while ( have_posts() ) : the_post(); ?>

                        <div class="post-type-holder">
                            <?php if(!empty($all_portfolio_page)) : ?>
                                <a href="<?php echo esc_url(get_permalink($all_portfolio_page)); ?>"><?php echo esc_html( 'Back to All Projects', 'k2_text_domain' ); ?></a>
                                <h3 class="post-type-title"><?php the_title(); ?></h3>
                            <?php endif; ?>
                        </div>
                        <?php if ( has_post_thumbnail() && $portfolio_feature_img == 'show' ) : ?>
                            <div class="post-type-media">
                                <?php the_post_thumbnail('full'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="post-type-content">
                            <div class="row">
                                <div class="<?php echo esc_attr( $layout_class ); ?>">
                                    <div class="post-type-content-inner">
                                        <?php the_content(); ?>
                                    </div>
                                    <?php if(!empty($portfolio_gallery)) : ?>
                                        <div class="post-type-gallery images-light-box">
                                            <h4><?php echo esc_html( 'Gallery', 'k2_text_domain' )?></h4>
                                            <div class="post-type-gallery-inner row">
                                                <?php foreach ($portfolio_gallery_list as $img_id): ?>
                                                    <div class="post-type-gallery-item col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6">
                                                        <a class="light-box" href="<?php echo esc_url(wp_get_attachment_image_url($img_id, 'full'));?>">
                                                            <img src="<?php echo esc_url(wp_get_attachment_image_url($img_id, 'thumbnail'));?>" />
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($project_info_list)) : ?>
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                        <div class="post-type-sidebar">
                                            <?php if(!empty($project_info_title)) : ?>
                                                <h3><?php echo esc_attr($project_info_title); ?></h3>
                                            <?php endif; ?>
                                            <ul>
                                                <?php for($i=0; $i<$project_info_result; $i+=2) { ?>
                                                    <li>
                                                        <?php echo isset($project_info_list[$i]) ? esc_html( $project_info_list[$i] ):''; ?>
                                                        <span><?php echo isset($project_info_list[$i+1]) ? esc_html( $project_info_list[$i+1] ):''; ?></span>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                            <?php if(!empty($portfolio_gallery)) : ?>
                                                <span class="btn btn-outline trigger-gallery"><?php echo esc_html__('View Gallery', 'k2_text_domain')?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php endwhile; ?>
                </div>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div>
</div>