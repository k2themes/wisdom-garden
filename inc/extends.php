<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package k2_prefix
 */

/**
 * Setup default image sizes after the theme has been activated
 */
function k2_theme_frame_after_setup_theme()
{

}
add_action( 'after_setup_theme', 'k2_theme_frame_after_setup_theme' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function k2_theme_frame_body_classes( $classes )
{
    // Adds a class for single post type extra
    $singe_service_layout = k2_theme_frame_get_opt( 'singe_service_layout', 'default' );
    $singe_portfolio_layout = k2_theme_frame_get_opt( 'singe_portfolio_layout', 'default' );
    if ( is_singular('service') ) {
        $classes[] = 'single-service-'.$singe_service_layout;
    }
    if ( is_singular('portfolio') ) {
        $classes[] = 'single-portfolio-'.$singe_portfolio_layout;
    }

    /* Sidebar Style */
    $sidebar_style = k2_theme_frame_get_opt( 'sidebar_style', 'default' );
    if(isset($sidebar_style) && $sidebar_style) {
        $classes[] = 'sidebar-style-'.$sidebar_style;
    }

    // Adds a class of group-blog to blogs with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    if (k2_theme_frame_get_opt( 'site_boxed', false )) {
        $classes[] = 'site-boxed';
    }

    if ( class_exists('WPBakeryVisualComposerAbstract') ) {
        $classes[] = 'visual-composer';
    }

    return $classes;
}
add_filter( 'body_class', 'k2_theme_frame_body_classes' );


/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function k2_theme_frame_pingback_header()
{
    if ( is_singular() && pings_open() )
    {
        echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
}
add_action( 'wp_head', 'k2_theme_frame_pingback_header' );
