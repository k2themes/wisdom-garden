<?php
/**
 * Template part for displaying results in search pages
 *
 * @package k2_prefix
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-hentry' ); ?>>

    <div class="entry-featured">
        <?php
            if (has_post_thumbnail()) {
                echo '<div class="post-image">'; ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_post_thumbnail('large'); ?></a>
                <?php echo '</div>';
            }
        ?>
    </div><!-- .entry-featured -->
    <div class="entry-holder">
        <?php k2_theme_frame_archive_meta(); ?>
        <h2 class="entry-title">
            <a href="<?php echo esc_url( get_permalink()); ?>" rel="bookmark">
                <?php the_title(); ?>
            </a>
        </h2>
        <div class="entry-content">
            <?php
                k2_theme_frame_entry_excerpt();
                wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'k2_text_domain' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                ) );
            ?>
        </div>
        <div class="entry-more">
            <a class="btn" href="<?php echo esc_url( get_permalink()); ?>"><?php echo esc_html__('Read More', 'k2_text_domain')?></a>
        </div>
    </div>
</article><!-- #post -->