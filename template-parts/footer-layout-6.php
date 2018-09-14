<?php
$footer_top_custom_width_f6 = k2_theme_frame_get_opt( 'footer_top_custom_width_f6' );
$footer_copyright = k2_theme_frame_get_opt( 'footer_copyright' );
$quick_contact_text1 = k2_theme_frame_get_opt( 'quick_contact_text1' );
$quick_contact_text2 = k2_theme_frame_get_opt( 'quick_contact_text2' );
?>
<footer id="colophon" class="site-footer footer-layout6 ft-main-r">
    <?php if(!empty($quick_contact_text1)) : ?>
        <div class="top-bar-footer">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php echo wp_kses_post($quick_contact_text1); ?>
                    </div>
                </div>
                <div class="line-gap"></div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ( is_active_sidebar( 'sidebar-footer-1' ) || is_active_sidebar( 'sidebar-footer-2' ) || is_active_sidebar( 'sidebar-footer-3' ) || is_active_sidebar( 'sidebar-footer-4' ) ) : ?>
        <div class="top-footer bg-overlay <?php echo esc_attr( $footer_top_custom_width_f6 ); ?>">
            <div class="container">
                <div class="row">
                    <?php k2_theme_frame_footer_top(); ?>
                </div>
                <?php if(!empty($quick_contact_text2)) : ?>
                    <div class="row">
                        <div class="cms-footer-item col-xl-4 col-lg-4 col-md-12 col-sm-12"></div>
                        <div class="cms-footer-item col-xl-8 col-lg-8 col-md-12 col-sm-12"><?php echo wp_kses_post($quick_contact_text2); ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="bottom-footer">
        <div class="container">
            <div class="line-gap"></div>
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