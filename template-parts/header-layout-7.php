<?php
/**
 * Template part for displaying default header layout
 */
$sticky_on = k2_theme_frame_get_opt( 'sticky_on', false );
$top_bar_phone_label = k2_theme_frame_get_opt( 'top_bar_phone_label' );
$top_bar_phone = k2_theme_frame_get_opt( 'top_bar_phone' );
$top_bar_email_label = k2_theme_frame_get_opt( 'top_bar_email_label' );
$top_bar_email = k2_theme_frame_get_opt( 'top_bar_email' );
$top_bar_time_label = k2_theme_frame_get_opt( 'top_bar_time_label' );
$top_bar_time = k2_theme_frame_get_opt( 'top_bar_time' );
?>
<header id="masthead" class="site-header">
    <div id="site-header-wrap" class="header-layout7 fixed-height <?php if($sticky_on == 1) { echo 'is-sticky'; } ?>">
        <div id="headroom">
            <div class="site-header-main">
                <div class="container">
                    <div class="row">
                        <div class="site-branding">
                            <?php get_template_part( 'template-parts/header-branding' ); ?>
                        </div>
                        <div class="site-header-holder">
                            <ul class="site-header-top">
                                <li><label><?php echo esc_attr( $top_bar_time_label ); ?></label><span><?php echo ' '.esc_attr( $top_bar_time ); ?></span></li>
                                <li><label><?php echo esc_attr( $top_bar_email_label ); ?></label><a href="mailto:<?php echo esc_attr( $top_bar_email ); ?>"><?php echo ' '.esc_attr( $top_bar_email ); ?></a></li>
                                <li><label><?php echo esc_attr( $top_bar_phone_label ); ?></label><a href="tel:<?php echo esc_attr( $top_bar_phone ); ?>"><?php echo ' '.esc_attr( $top_bar_phone ); ?></a></li>
                            </ul>
                            <nav id="site-navigation" class="main-navigation arrow-divider-width arrow-divider-left">
                                <div class="arrow-divider"></div>
                                <?php get_template_part( 'template-parts/header-menu' ); ?>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="main-menu-mobile">
            <span class="btn-nav-mobile open-menu">
                <span></span>
            </span>
        </div>
    </div>
</header>