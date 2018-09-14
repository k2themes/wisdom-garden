<?php
$footer_top_custom_width = k2_theme_frame_get_opt( 'footer_top_custom_width' );
$footer_copyright = k2_theme_frame_get_opt( 'footer_copyright' );
?>
<footer id="colophon" class="site-footer footer-layout2 light">
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
        <div class="bf-gap"></div>
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