<?php
/**
 * Template part for displaying default header layout
 */
$sticky_on = k2_theme_frame_get_opt( 'sticky_on', false );
$top_bar_phone_label = k2_theme_frame_get_opt( 'top_bar_phone_label' );
$top_bar_phone = k2_theme_frame_get_opt( 'top_bar_phone' );
$top_bar_email_label = k2_theme_frame_get_opt( 'top_bar_email_label' );
$top_bar_email = k2_theme_frame_get_opt( 'top_bar_email' );

$h_btn_text = k2_theme_frame_get_opt( 'h_btn_text' );
$h_btn_link_type = k2_theme_frame_get_opt( 'h_btn_link_type', 'page_link' );
$h_btn_page_link = k2_theme_frame_get_opt( 'h_btn_page_link' );
$h_btn_custom_link = k2_theme_frame_get_opt( 'h_btn_custom_link' );
$h_btn_target = k2_theme_frame_get_opt( 'h_btn_target', '_self' );

$menu_fixed = k2_theme_frame_get_page_opt( 'menu_fixed', false );
?>
<header id="masthead" class="site-header">
    <div id="site-header-wrap" class="header-layout5 fixed-height <?php if($menu_fixed) { echo 'menu-fixed'; } ?> <?php if($sticky_on == 1) { echo 'is-sticky'; } ?>">
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
                                    <?php if(!empty($h_btn_text)) : ?>
                                        <div class="header-button inline-block">
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
                                    <?php if(!empty($top_bar_phone) || !empty($top_bar_email)) : ?>
                                        <div class="header-contact-group inline-block">
                                            <?php if(!empty($top_bar_phone)) : ?>
                                                <div class="header-contact-item">
                                                    <label><?php echo esc_attr( $top_bar_phone_label ); ?></label>
                                                    <a class="ft-heading-b" href="tel:<?php echo esc_attr( $top_bar_phone ); ?>"><?php echo esc_attr( $top_bar_phone ); ?></a>
                                                </div>
                                            <?php endif; ?>
                                            <?php if(!empty($top_bar_email)) : ?>
                                                <div class="header-contact-item">
                                                    <label><?php echo esc_attr( $top_bar_email_label ); ?></label>
                                                    <a class="ft-heading-b" href="mailto:<?php echo esc_attr( $top_bar_email ); ?>"><?php echo esc_attr( $top_bar_email ); ?></a>
                                                </div>
                                            <?php endif; ?>
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