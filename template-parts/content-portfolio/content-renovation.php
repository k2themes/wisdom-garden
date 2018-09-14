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
?>
<div class="portfolio-back-category">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php if(!empty($all_portfolio_page)) : ?>
					<h2>
		                <a href="<?php echo esc_url(get_permalink($all_portfolio_page)); ?>">
		                	<i class="zmdi zmdi-long-arrow-left"></i>
		                	<?php echo esc_html( 'Back to All Projects', 'k2_text_domain' ); ?>
		                </a>
		            </h2>
	            <?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php if(!empty($portfolio_gallery)) :
	wp_enqueue_script( 'owl-carousel' );
	wp_enqueue_script( 'k2_prefix-carousel' );
	?>
	<div class="portfolio-gallery">
		<div class="cms-carousel owl-carousel gallery-carousel-bg owl-arrows-hide bg-overlay" data-item-xs="1" data-item-sm="1" data-item-md="1" data-item-lg="1" data-margin="30" data-loop="true" data-autoplay="false" data-autoplaytimeout="5000" data-smartspeed="250" data-center="false" data-arrows="true" data-bullets="false" data-stagepadding="0" data-stagepaddingsm="0" data-rtl="false">
            <?php foreach ($portfolio_gallery_list as $img_id): ?>
                <div class="post-type-gallery-item" style="background-image: url(<?php echo esc_url(wp_get_attachment_image_url($img_id, 'full'));?>);"></div>
            <?php endforeach; ?>
        </div>
		<div class="container">
			<div class="row">
				<div class="col-12">
	                <div class="cms-carousel owl-carousel gallery-carousel owl-arrows-middle-big" data-item-xs="1" data-item-sm="1" data-item-md="1" data-item-lg="1" data-margin="30" data-loop="true" data-autoplay="false" data-autoplaytimeout="5000" data-smartspeed="250" data-center="false" data-arrows="true" data-bullets="false" data-stagepadding="0" data-stagepaddingsm="0" data-rtl="false">
	                    <?php foreach ($portfolio_gallery_list as $img_id): ?>
                            <div class="post-type-gallery-item">
                                <img src="<?php echo esc_url(wp_get_attachment_image_url($img_id, 'k2_prefix-large'));?>" />
                            </div>
                        <?php endforeach; ?>
	                </div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<div class="container content-container">
    <div class="row">
        <div id="primary" class="content-area col-12">
            <main id="main" class="site-main">
                <div class="post-type-inner">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php if ( has_post_thumbnail() && $portfolio_feature_img == 'show' ) : ?>
                            <div class="post-type-media">
                                <?php the_post_thumbnail('full'); ?>
                            </div>
                        <?php endif; ?>
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