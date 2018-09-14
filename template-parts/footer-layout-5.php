<?php
$footer_top_custom_width_f5 = k2_theme_frame_get_opt( 'footer_top_custom_width_f5' );
$footer_copyright = k2_theme_frame_get_opt( 'footer_copyright' );
?>
<footer id="colophon" class="site-footer footer-layout5 ft-main-r">
    <?php if ( is_active_sidebar( 'sidebar-footer-1' ) || is_active_sidebar( 'sidebar-footer-2' ) || is_active_sidebar( 'sidebar-footer-3' ) || is_active_sidebar( 'sidebar-footer-4' ) ) : ?>
        <div class="top-footer bg-overlay <?php echo esc_attr( $footer_top_custom_width_f5 ); ?>">
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
                <div class="bottom-col1 col-12 text-left-lg text-center">
                    <?php
                    if ($footer_copyright) {
                        echo wp_kses_post($footer_copyright);
                    } else {
                        echo wp_kses_post('&copy; '.esc_attr(date("Y")).' <a target="_blank" href="https://cmssuperheroes.com/">CMSSuperheroes</a>. All Rights Reserved');
                    } ?>
                </div>
            </div>
        </div>
    </div>

</footer>