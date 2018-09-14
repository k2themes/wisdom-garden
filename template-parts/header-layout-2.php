<?php
/**
 * Template part for displaying default header layout
 */
$sticky_on = k2_theme_frame_get_opt( 'sticky_on', false );
$top_bar_phone_label = k2_theme_frame_get_opt( 'top_bar_phone_label' );
$top_bar_phone = k2_theme_frame_get_opt( 'top_bar_phone' );
$top_bar_time_label = k2_theme_frame_get_opt( 'top_bar_time_label' );
$top_bar_time = k2_theme_frame_get_opt( 'top_bar_time' );

$h_btn_text = k2_theme_frame_get_opt( 'h_btn_text' );
$h_btn_link_type = k2_theme_frame_get_opt( 'h_btn_link_type', 'page_link' );
$h_btn_page_link = k2_theme_frame_get_opt( 'h_btn_page_link' );
$h_btn_custom_link = k2_theme_frame_get_opt( 'h_btn_custom_link' );
$h_btn_target = k2_theme_frame_get_opt( 'h_btn_target', '_self' );

$menu_fixed = k2_theme_frame_get_page_opt( 'menu_fixed', false );
?>
<header id="masthead" class="site-header">
    <div id="site-header-wrap" class="header-layout2 fixed-height <?php if($menu_fixed) { echo 'menu-fixed'; } ?> <?php if($sticky_on == 1) { echo 'is-sticky'; } ?>">
        <div id="headroom">
            <div class="site-header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-12 col-text-left">
                           <div class="site-branding">
                               <?php get_template_part( 'template-parts/header-branding' ); ?>
                           </div>
                        </div>
                        <?php if(!empty($top_bar_phone) || !empty($top_bar_time)) : ?>
                            <div class="col-xl-8 col-lg-8 col-md-12 col-text-right">
                               <div class="site-contact-top float-right d-none d-lg-block">
                                    <?php if(!empty($top_bar_phone)) : ?>
                                        <div class="site-contact-item inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#233151" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                            <label><?php echo esc_attr( $top_bar_phone_label ); ?></label> 
                                            <a href="tel:<?php echo esc_attr( $top_bar_phone ); ?>"><?php echo esc_attr( $top_bar_phone ); ?></a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(!empty($top_bar_time)) : ?>
                                        <div class="site-contact-item inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#233151" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                            <label><?php echo esc_attr( $top_bar_time_label ); ?></label> 
                                            <span><?php echo esc_attr( $top_bar_time ); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(!empty($h_btn_text)) : ?>
                                        <div class="site-button inline-block">
                                            <?php 
                                                switch ( $h_btn_link_type ) {
                                                    case 'contact_form': ?>
                                                        <span class="btn h-btn-form"><?php echo esc_attr( $h_btn_text ); ?></span>
                                                        <?php break;

                                                    case 'custom_link': ?>
                                                        <a href="<?php echo get_permalink($h_btn_custom_link); ?>" target="<?php echo esc_attr($h_btn_target); ?>" class="btn"><?php echo esc_attr( $h_btn_text ); ?></a>
                                                        <?php break;

                                                    default: ?>
                                                        <a href="<?php echo get_permalink($h_btn_page_link); ?>" target="<?php echo esc_attr($h_btn_target); ?>" class="btn"><?php echo esc_attr( $h_btn_text ); ?></a>
                                                        <?php break;
                                                }
                                            ?>
                                        </div>
                                    <?php endif; ?>
                               </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="site-header-main">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <nav id="site-navigation" class="main-navigation">
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