<?php

$titles = k2_theme_frame_get_page_titles();

ob_start();

if ( $titles['title'] )
{
    printf( '<h1 class="page-title ft-heading-b">%s</h1>', esc_attr($titles['title']) );
}

if ( ( is_page() && get_post_meta( get_the_ID(), 'breadcrumb_on', true ) ) || k2_theme_frame_get_opt( 'breadcrumb_on', false ) )
{
    k2_theme_frame_breadcrumb();
}

$titles_html = ob_get_clean();

/* Page for posts */
$page_for_posts = get_option( 'page_for_posts' );

/* Sub Title */
$sub_title = k2_theme_frame_get_page_opt( 'sub_title' );

/* Title Align */
$custom_pagetitle = k2_theme_frame_get_page_opt( 'custom_pagetitle', false);
$ptitle_content_align = k2_theme_frame_get_opt( 'ptitle_content_align', 'center');
$page_ptitle_content_align = k2_theme_frame_get_page_opt( 'ptitle_content_align', 'themeoption');
if($custom_pagetitle && $page_ptitle_content_align != 'themeoption') {
    $ptitle_content_align = $page_ptitle_content_align;
}

/* Title Description */
$ptitle_description = k2_theme_frame_get_page_opt( 'ptitle_description' );

/* Title Background Styles */
$ptitle_overlay_style = k2_theme_frame_get_opt( 'ptitle_overlay_style', 'secondary' );
$page_ptitle_overlay_style = k2_theme_frame_get_page_opt( 'ptitle_overlay_style', 'themeoption' );
if( $custom_pagetitle && $page_ptitle_overlay_style != 'themeoption' ) {
    $ptitle_overlay_style = $page_ptitle_overlay_style;
}

/* Title Button */
$pagetitle_button = k2_theme_frame_get_page_opt( 'pagetitle_button' );
$pagetitle_button_text = k2_theme_frame_get_page_opt( 'pagetitle_button_text' );
$pagetitle_button_size = k2_theme_frame_get_page_opt( 'pagetitle_button_size', 'size-lg' );
$pagetitle_button_link = k2_theme_frame_get_page_opt( 'pagetitle_button_link', 'page_link' );
$pagetitle_button_page_link = k2_theme_frame_get_page_opt( 'pagetitle_button_page_link' );
$pagetitle_button_custom_link = k2_theme_frame_get_page_opt( 'pagetitle_button_custom_link' );

$pagetitle_button_text2 = k2_theme_frame_get_page_opt( 'pagetitle_button_text2' );
$pagetitle_button_link2 = k2_theme_frame_get_page_opt( 'pagetitle_button_link2', 'page_link2' );
$pagetitle_button_page_link2 = k2_theme_frame_get_page_opt( 'pagetitle_button_page_link2' );
$pagetitle_button_custom_link2 = k2_theme_frame_get_page_opt( 'pagetitle_button_custom_link2' );

$pagetitle_button_text3 = k2_theme_frame_get_page_opt( 'pagetitle_button_text3' );
$pagetitle_button_link3 = k2_theme_frame_get_page_opt( 'pagetitle_button_link3', 'page_link3' );
$pagetitle_button_page_link3 = k2_theme_frame_get_page_opt( 'pagetitle_button_page_link3' );
$pagetitle_button_custom_link3 = k2_theme_frame_get_page_opt( 'pagetitle_button_custom_link3' );
$pagetitle_button_class3 = k2_theme_frame_get_page_opt( 'pagetitle_button_class3' );

$pagetitle_button_url = '';
if ( $pagetitle_button_link == 'page_link' && !empty($pagetitle_button_page_link) ) {
    $pagetitle_button_url = get_permalink($pagetitle_button_page_link);
} elseif ( $pagetitle_button_link == 'custom_link' && !empty($pagetitle_button_custom_link) ) {
    $pagetitle_button_url = $pagetitle_button_custom_link;
}
$pagetitle_button_url2 = '';
if ( $pagetitle_button_link2 == 'page_link2' && !empty($pagetitle_button_page_link2) ) {
    $pagetitle_button_url2 = get_permalink($pagetitle_button_page_link2);
} elseif ( $pagetitle_button_link2 == 'custom_link' && !empty($pagetitle_button_custom_link2) ) {
    $pagetitle_button_url2 = $pagetitle_button_custom_link2;
}
$pagetitle_button_url3 = '';
if ( $pagetitle_button_link3 == 'page_link3' && !empty($pagetitle_button_page_link3) ) {
    $pagetitle_button_url3 = get_permalink($pagetitle_button_page_link3);
} elseif ( $pagetitle_button_link3 == 'custom_link' && !empty($pagetitle_button_custom_link3) ) {
    $pagetitle_button_url3 = $pagetitle_button_custom_link3;
}

/* Single Post */
$single_post_layout = k2_theme_frame_get_opt( 'single_post_layout', 'default');
$singe_portfolio_layout = k2_theme_frame_get_opt( 'singe_portfolio_layout', 'default');
$post_social_share_on_conversion = k2_theme_frame_get_opt( 'post_social_share_on_conversion', false );
if(is_singular('post') && $single_post_layout == 'conversion') {
    while ( have_posts() )
    {
        the_post();
        $thumbnail_url = '';
        if (has_post_thumbnail(get_the_ID()) && wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), false)) :
            $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
        endif; ?>
        <div id="pagetitle-post" class="bg-overlay cms-bgimage" <?php if(!empty($thumbnail_url)) : ?> style="background-image: url(<?php echo esc_url($thumbnail_url[0]); ?>);" <?php endif; ?>>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-post-inner">
                            <h2><?php echo get_the_title(); ?></h2>
                            <?php k2_theme_frame_post_meta(); ?>
                            <?php if(isset($post_social_share_on_conversion) && $post_social_share_on_conversion) : ?>
                                <div class="entry-social-share clearfix">
                                    <?php k2_theme_frame_socials_share_conversion(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    return;
}
?>
<div id="pagetitle" class="page-title page-title-layout1 bg-overlay align-<?php echo esc_attr( $ptitle_content_align ); ?> overlay-<?php echo esc_attr( $ptitle_overlay_style ); ?>">
    <div class="container">
        <div class="page-title-inner">
            <div class="page-title-content clearfix">
                <?php if($page_for_posts != '0' && is_singular('post') && $single_post_layout == 'default') : ?>
                    <div class="cms-back-blog">
                        <a href="<?php echo get_permalink($page_for_posts); ?>">
                            <?php echo esc_html__('Back to All News', 'k2_text_domain')?>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if(is_singular('post') && $single_post_layout == 'industrial') : ?>
                    <div class="cms-post-date">
                        <?php while ( have_posts() ) : the_post();
                            echo get_the_date();
                        endwhile; ?>
                    </div>
                <?php endif; ?>
                <?php if(is_singular('portfolio') && $singe_portfolio_layout == 'industrial') : ?>
                    <?php while ( have_posts() ) : the_post();
                        $address = get_post_meta($post->ID, 'portfolio_address', true);
                        $flag = get_post_meta($post->ID, 'portfolio_flag', true);
                        if(!empty($address)) : ?>
                            <div class="cms-post-address">
                                <?php if(!empty($flag)) : ?>
                                    <img src="<?php echo esc_url($flag['url']); ?>" />
                                <?php endif; ?>
                                <span><?php echo esc_attr($address); ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
                <?php if($custom_pagetitle && !empty($sub_title)) : ?>
                    <div class="page-sub-title">
                        <?php echo wp_kses_post( $sub_title ); ?>
                    </div>
                <?php endif; ?>
                <?php printf( '%s', wp_kses_post($titles_html)); ?>
                <?php if($custom_pagetitle && !empty($ptitle_description)) : ?>
                    <div class="page-title-desc">
                        <?php echo wp_kses_post( $ptitle_description ); ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if($custom_pagetitle && $pagetitle_button && !empty($pagetitle_button_text) || $custom_pagetitle && $pagetitle_button && !empty($pagetitle_button_text2)) : ?>
    	        <div class="page-title-button">
                    <?php if(!empty($pagetitle_button_text)) : ?>
                        <a href="<?php echo esc_url($pagetitle_button_url); ?>" class="btn btn-modern <?php echo esc_attr( $pagetitle_button_size ); ?>"><?php echo esc_attr( $pagetitle_button_text ); ?></a>
                    <?php endif; ?>
                    <?php if(!empty($pagetitle_button_text2)) : ?>
                        <a href="<?php echo esc_url($pagetitle_button_url2); ?>" class="btn btn-primary-outline <?php echo esc_attr( $pagetitle_button_size ); ?>"><?php echo esc_attr( $pagetitle_button_text2 ); ?></a>
                    <?php endif; ?>
                </div>
    	    <?php endif; ?>
        </div>
    </div>
    <?php if($custom_pagetitle && $pagetitle_button && !empty($pagetitle_button_text3)) : ?>
        <div class="page-title-button-abs arrow-divider-width arrow-divider-left">
            <div class="arrow-divider"></div>
            <?php if($pagetitle_button_link3 == 'none') { ?>
                <span class="<?php echo esc_attr($pagetitle_button_class3); ?>"><?php echo esc_attr( $pagetitle_button_text3 ); ?><i class="zmdi zmdi-long-arrow-right"></i></span>
            <?php } else { ?>
                <a class="<?php echo esc_attr($pagetitle_button_class3); ?>" href="<?php echo esc_url($pagetitle_button_url3); ?>"><?php echo esc_attr( $pagetitle_button_text3 ); ?><i class="zmdi zmdi-long-arrow-right"></i></a>
            <?php } ?>
        </div>
    <?php endif; ?>
</div>