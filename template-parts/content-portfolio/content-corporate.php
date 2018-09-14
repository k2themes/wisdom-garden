<?php
/**
 * Template part for displaying posts in loop
 *
 * @package k2_prefix
 */
$all_portfolio_page = k2_theme_frame_get_opt('all_portfolio_page');
$portfolio_feature_img = k2_theme_frame_get_page_opt('portfolio_feature_img', 'show');
$portfolio_gallery = k2_theme_frame_get_page_opt('portfolio_gallery');
$project_info_list = k2_theme_frame_get_page_opt('project_info_list_corporate');
$project_info_result = count($project_info_list);
?>
<div class="container content-container">
    <div class="row">
        <div id="primary" class="content-area col-12">
            <main id="main" class="site-main">
                <div class="post-type-inner">
                    <?php while ( have_posts() ) : the_post(); ?>
                    	<?php if(!empty($all_portfolio_page)) : ?>
                    		<div class="portfolio-back-category ft-sui-b">
								<a href="<?php echo esc_url(get_permalink($all_portfolio_page)); ?>">
						        	<?php echo esc_html( 'Back to Portfolio', 'k2_text_domain' ); ?>
						        </a>
							</div>
						<?php endif; ?>
                        <?php if ( has_post_thumbnail() && $portfolio_feature_img == 'show' ) : ?>
                            <div class="post-type-media">
                                <?php the_post_thumbnail('full'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="post-type-holder row">
                        	<div class="post-type-topleft ft-sui-b col-xl-7 col-lg-7 col-md-12 col-sm-12">
                        		<div class="post-type-category">
                        			<?php the_terms( get_the_ID(), 'portfolio-category', '', ', ' ); ?>
                        		</div>
                        		<h3 class="post-type-title"><?php the_title(); ?></h3>
                        	</div>
                        	<div class="post-type-topright col-xl-5 col-lg-5 col-md-12 col-sm-12 col-text-right">
                        		<ul>
	                                <?php for($i=0; $i<$project_info_result; $i+=2) { ?>
	                                    <li>
	                                        <span class="ft-sui-b"><?php echo isset($project_info_list[$i]) ? esc_html( $project_info_list[$i] ):''; ?></span>
	                                        <?php echo isset($project_info_list[$i+1]) ? esc_html( $project_info_list[$i+1] ):''; ?>
	                                    </li>
	                                <?php } ?>
	                            </ul>
                        	</div>
                        	<div class="line-gap"></div>
                        </div>
                        <div class="post-type-content">
                            <div class="post-type-content-inner">
                                <div class="portfolio-tab row">
                                    <div class="portfolio-nav-tabs col-xl-3 col-lg-3 col-md-12 col-sm-12">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-hover="tab" data-toggle="tab" href="#sg-project-description" role="tab" aria-controls="description" aria-selected="true">
                                                    <?php echo esc_html__('Project Description', 'k2_text_domain'); ?>
                                                </a>
                                            </li>
                                            <?php if(!empty($portfolio_gallery)) : ?>
                                                <li class="nav-item nav-gallery">
                                                    <a class="nav-link" data-hover="tab" data-toggle="tab" href="#sg-project-gallery" role="tab" aria-controls="gallery" aria-selected="true">
                                                        <?php echo esc_html__('Gallery', 'k2_text_domain'); ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                    <div class="portfolio-content-tabs col-xl-9 col-lg-9 col-md-12 col-sm-12">
                                        <div class="tab-content">
                                            <div id="sg-project-description" class="tab-pane fade show active"  role="tabpanel" aria-labelledby="sg-project-description">
                                                <?php the_content(); ?>
                                                <?php k2_theme_frame_post_nav_corporate(); ?>
                                            </div>
                                            <?php if(!empty($portfolio_gallery)) : ?>
                                                <div id="sg-project-gallery" class="tab-pane fade"  role="tabpanel" aria-labelledby="sg-project-gallery">
                                                    <?php echo do_shortcode('[cms_image_gallery images="'.$portfolio_gallery.'" img_size="600x464" col_xs="1" col_sm="2" col_md="2" col_lg="2"]'); ?>
                                                    <?php k2_theme_frame_post_nav_corporate(); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                </div>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div>
</div>