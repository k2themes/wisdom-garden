<?php
/**
 * Template part for displaying default header layout
 */
$sticky_on = k2_theme_frame_get_opt( 'sticky_on', false );
?>
<header id="masthead" class="site-header">
    <div id="site-header-wrap" class="header-layout6 fixed-height <?php if($sticky_on == 1) { echo 'is-sticky'; } ?>">
        <div id="headroom">
            <div class="site-header-main">
                <div class="container">
                    <div class="row">
                        <div class="site-branding">
                            <?php get_template_part( 'template-parts/header-branding' ); ?>
                        </div>
                        <nav id="site-navigation" class="main-navigation">
                            <?php get_template_part( 'template-parts/header-menu' ); ?>
                        </nav>
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