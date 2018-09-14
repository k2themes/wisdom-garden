<?php
/**
 * Template part for displaying posts in loop
 *
 * @package k2_prefix
 */
$post_tags_on = k2_theme_frame_get_opt( 'post_tags_on', true );
$post_navigation_link_on = k2_theme_frame_get_opt( 'post_navigation_link_on', false );
$post_feature_image_on = k2_theme_frame_get_opt( 'post_feature_image_on', false );
$post_social_share_on_conversion = k2_theme_frame_get_opt( 'post_social_share_on_conversion', false );
$post_related_on_conversion = k2_theme_frame_get_opt( 'post_related_on_conversion', true );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('single-hentry single-post-conversion'); ?>>

    <div class="entry-featured">
        <?php if (has_post_format('gallery')) : ?>
            <?php
            $light_box = k2_theme_frame_get_post_format_value('post-gallery-lightbox', '0');
            $gallery_list = explode(',', k2_theme_frame_get_post_format_value('post-gallery-images', ''));
            wp_enqueue_script( 'owl-carousel' );
            wp_enqueue_script( 'k2_prefix-carousel' );
            ?>
            <div class="cms-carousel owl-carousel featured-active <?php if($light_box) {echo 'images-light-box';} ?>" data-item-xs="1" data-item-sm="1" data-item-md="1" data-item-lg="1" data-margin="30" data-loop="true" data-autoplay="true" data-autoplaytimeout="5000" data-smartspeed="250" data-center="false" data-arrows="true" data-bullets="false" data-stagepadding="0" data-stagepaddingsm="0" data-rtl="false">
                <?php
                foreach ($gallery_list as $img_id):
                    ?>
                    <div class="cms-carousel-item">
                        <a class="light-box" href="<?php echo esc_url(wp_get_attachment_image_url($img_id, 'full'));?>"><img src="<?php echo esc_url(wp_get_attachment_image_url($img_id, 'large'));?>" alt="<?php echo esc_attr(get_post_meta( $img_id, '_wp_attachment_image_alt', true )) ?>"></a>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
        <?php elseif (has_post_format('quote')) : ?>
            <?php
            $quote_text = k2_theme_frame_get_post_format_value('post-quote-cite', ''); //Value is string
            echo esc_attr($quote_text);
            ?>
        <?php elseif (has_post_format('link')) : ?>
            <?php
            $link_pf = k2_theme_frame_get_post_format_value('post-link-url', '#');// Value is url
            echo esc_url($link_pf);
            ?>
        <?php elseif (has_post_format('video')) : ?>
            <div class="entry-video featured-active">
                <?php
                $video_url = k2_theme_frame_get_post_format_value('post-video-url', '#');
                $video_file = k2_theme_frame_get_post_format_value('post-video-file', '');
                $video_html = k2_theme_frame_get_post_format_value('post-video-html', '');
                $video = '';
                if (!empty($video_url)) {
                    global $wp_embed;
                    echo esc_html($wp_embed->run_shortcode('[embed]' . $video_url . '[/embed]'));
                } elseif (!empty($video_file)) {
                    if (strpos('[embed', $video_file)) {
                        global $wp_embed;
                        echo esc_html($wp_embed->run_shortcode($video_file));
                    } else {
                        echo do_shortcode($video_file);
                    }
                } else {
                    if ('' != $video_html) {
                        echo esc_html($video_html);
                    }
                }
                ?>
            </div>
            <?php elseif (has_post_format('audio')) : ?>
                <?php
                $audio_url = k2_theme_frame_get_post_format_value('post-audio-url', '#');
                echo esc_url($audio_url);
                ?>
            <?php else : ?>

            <?php
                if (has_post_thumbnail() && $post_feature_image_on ) {
                    echo '<div class="post-image">'; ?>
                        <?php the_post_thumbnail('large'); ?>
                    <?php echo '</div>';
                }
            ?>
        <?php endif; ?>
    </div><!-- .entry-featured -->

    <div class="entry-holder">
        <div class="entry-content">
            <?php
                the_content();
                wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'k2_text_domain' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                ) );
            ?>
        </div><!-- .entry-content -->
        <div class="entry-content-bottom clearfix">
            <?php k2_theme_frame_post_meta(); ?>
            <?php if(isset($post_social_share_on_conversion) && $post_social_share_on_conversion) : ?>
                <div class="entry-social-share clearfix">
                    <?php k2_theme_frame_socials_share_conversion(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</article><!-- #post -->
<?php if($post_related_on_conversion) { k2_theme_frame_related_post(); } ?>