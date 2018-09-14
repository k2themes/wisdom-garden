<?php
$footer_top_custom_width = k2_theme_frame_get_opt( 'footer_top_custom_width' );
$footer_copyright = k2_theme_frame_get_opt( 'footer_copyright' );
$footer_cta_title = k2_theme_frame_get_opt( 'footer_cta_title' );
$footer_cta_email = k2_theme_frame_get_opt( 'footer_cta_email' );
$footer_cta_phone = k2_theme_frame_get_opt( 'footer_cta_phone' );
?>
<footer id="colophon" class="site-footer footer-layout1 ft-main-r">
    <?php if(!empty($footer_cta_title)) : ?>
        <div class="cta-footer">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="cta-footer-inner">
                            <h3><?php echo esc_attr( $footer_cta_title ); ?></h3>
                            <div class="cta-footer-meta">
                                <?php if(!empty($footer_cta_email)) : ?>
                                    <a href="mailto:<?php echo esc_url($footer_cta_email); ?>"><?php echo esc_html( 'Email Us', 'k2_text_domain' )?></a>
                                <?php endif; ?>
                                <?php if(!empty($footer_cta_phone)) : ?>
                                    <a href="tel:<?php echo esc_attr($footer_cta_phone); ?>"><span><?php echo esc_html( 'or', 'k2_text_domain' ); ?></span><?php echo ' '. esc_html( 'Call Us', 'k2_text_domain' )?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ( is_active_sidebar( 'sidebar-footer-1' ) || is_active_sidebar( 'sidebar-footer-2' ) || is_active_sidebar( 'sidebar-footer-3' ) || is_active_sidebar( 'sidebar-footer-4' ) ) : ?>
        <div class="top-footer bg-overlay <?php echo esc_attr( $footer_top_custom_width ); ?>">
            <div class="container">
                <div class="row">
                    <?php k2_theme_frame_footer_top(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="bottom-footer">
        <div class="container">
            <div class="row">
                <div class="bottom-col1 col-xl-6 col-lg-6 col-md-6 text-left-lg text-center">
                    <?php
                    if ($footer_copyright) {
                        echo wp_kses_post($footer_copyright);
                    } else {
                        echo wp_kses_post('&copy; '.esc_attr(date("Y")).' <a target="_blank" href="https://cmssuperheroes.com/">CMSSuperheroes</a>. All Rights Reserved');
                    } ?>
                </div>
                <div class="bottom-col2 col-xl-6 col-lg-6 col-md-6 text-right-lg text-center">
                    <div class="bottom-footer-social">
                        <?php k2_theme_frame_footer_social(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>