<?php
/**
 * Functions and definitions
 *
 * @package k2_prefix
 */

if (!function_exists('k2_theme_frame_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function k2_theme_frame_setup()
    {
        // Make theme available for translation.
        load_theme_textdomain('k2_text_domain', get_template_directory() . '/languages');

        // Custom Header
        add_theme_support("custom-header");

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        // Let WordPress manage the document title.
        add_theme_support('title-tag');

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary', 'k2_text_domain'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('k2_theme_frame_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        // Add support for core custom logo.
        add_theme_support('custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ));
        add_theme_support('post-formats', array(
            'gallery',
            'video',
        ));

        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');

        /* Change default image thumbnail sizes in wordpress */
        update_option('thumbnail_size_w', 300);
        update_option('thumbnail_size_h', 300);
        update_option('thumbnail_crop', 1);
        update_option('medium_size_w', 600);
        update_option('medium_size_h', 600);
        update_option('medium_crop', 1);
        update_option('large_size_w', 980);
        update_option('large_size_h', 650);
        update_option('large_crop', 1);

        add_image_size('k2_prefix-medium', 600, 430, true);
        add_image_size('k2_prefix-large', 1170, 700, true);

    }
endif;
add_action('after_setup_theme', 'k2_theme_frame_setup');

add_action('cms_locations', function ($cms_locations){
//    $cms_locations['cms-test'] ='Test Menu';
    return $cms_locations;
});

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function k2_theme_frame_content_width()
{
    $GLOBALS['content_width'] = apply_filters('k2_theme_frame_content_width', 640);
}

add_action('after_setup_theme', 'k2_theme_frame_content_width', 0);

/**
 * Register widget area.
 */
function k2_theme_frame_widgets_init()
{
    register_sidebar(array(
        'name'          => esc_html__('Blog Sidebar', 'k2_text_domain'),
        'id'            => 'sidebar-blog',
        'description'   => esc_html__('Add widgets here.', 'k2_text_domain'),
        'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-content">',
        'after_widget'  => '</div></section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Page Sidebar', 'k2_text_domain'),
        'id'            => 'sidebar-page',
        'description'   => esc_html__('Add widgets here.', 'k2_text_domain'),
        'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-content">',
        'after_widget'  => '</div></section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    $footer_top_column = k2_theme_frame_get_opt( 'footer_top_column', '5' );
    if(isset($footer_top_column) && $footer_top_column) {

        for($i = 1 ; $i <= $footer_top_column ; $i++){
            register_sidebar(array(
                'name' => sprintf(esc_html__('Footer Top %s', 'k2_text_domain'), $i),
                'id'            => 'sidebar-footer-' . $i,
                'description'   => esc_html__('Add widgets here.', 'k2_text_domain'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="footer-widget-title">',
                'after_title'   => '</h2>',
            ));
        }
    }
}

add_action('widgets_init', 'k2_theme_frame_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function k2_theme_frame_scripts()
{
    $theme = wp_get_theme(get_template());

    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '4.0.0');
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.7.0');
    wp_enqueue_style('font-material-icon', get_template_directory_uri() . '/assets/css/material-design-iconic-font.min.css', array(), '2.2.0');
    wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css', array(), '1.0.0');
    wp_enqueue_style('k2_prefix-theme', get_template_directory_uri() . '/assets/css/theme.css', array(), $theme->get('Version'));
    wp_enqueue_style('k2_prefix-menu', get_template_directory_uri() . '/assets/css/menu.css', array(), $theme->get('Version'));
    wp_enqueue_style('k2_prefix-style', get_stylesheet_uri());
    wp_enqueue_style('k2_prefix-google-fonts', k2_theme_frame_fonts_url());
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '4.0.0', true);
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    $sticky_on = k2_theme_frame_get_opt('sticky_on', false);
    $header_layout = k2_theme_frame_get_opt( 'header_layout', '1' );
    $custom_header = k2_theme_frame_get_page_opt( 'custom_header', '0' );
    if ( is_page() && $custom_header == '1' )
    {
        $page_header_layout = k2_theme_frame_get_page_opt('header_layout');
        $header_layout = $page_header_layout;
    }
    if ($sticky_on == 1 && $header_layout != '0') {
        wp_enqueue_script('headroom', get_template_directory_uri() . '/assets/js/headroom.min.js', array('jquery'), $theme->get('Version'), true);
        wp_enqueue_script('k2_prefix-headroom', get_template_directory_uri() . '/assets/js/headroom.js', array('jquery'), $theme->get('Version'), true);
    }
    wp_enqueue_script('nice-select', get_template_directory_uri() . '/assets/js/nice-select.min.js', array( 'jquery' ), 'all', true);
    wp_enqueue_script('enscroll', get_template_directory_uri() . '/assets/js/enscroll.js', array( 'jquery' ), 'all', true);
    wp_enqueue_script('match-height', get_template_directory_uri() . '/assets/js/match-height-min.js', array( 'jquery' ), '1.0.0', true);
    wp_enqueue_script('k2_prefix-sidebar-fixed', get_template_directory_uri() . '/assets/js/sidebar-scroll-fixed.js', array( 'jquery' ), '1.0.0', true);
    wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/assets/js/magnific-popup.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('k2_prefix-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), $theme->get('Version'), true);
    wp_register_script('k2_prefix-carousel', get_template_directory_uri() . '/assets/js/cms-carousel.js', array('jquery'), $theme->get('Version'), true);
    wp_register_script('k2_prefix-carousel-filter', get_template_directory_uri() . '/assets/js/owl-filter.js', array('jquery'), $theme->get('Version'), true);
    wp_register_script('k2_prefix-counter-lib', get_template_directory_uri() . '/assets/js/counter.min.js', array('jquery'), $theme->get('Version'), true);
    wp_register_script('k2_prefix-counter', get_template_directory_uri() . '/assets/js/cms-counter.js', array('jquery'), $theme->get('Version'), true);
    wp_register_script('k2_prefix-parallax', get_template_directory_uri() . '/assets/js/cms-parallax.js', array( 'jquery'), $theme->get('Version'), true);
    $smoothscroll = k2_theme_frame_get_opt( 'smoothscroll', false );
    if(isset($smoothscroll) && $smoothscroll) {
        wp_enqueue_script('smoothscroll', get_template_directory_uri() . '/assets/js/smoothscroll.min.js', array( 'jquery' ), 'all', true);
    }
    $parallaxscroll = k2_theme_frame_get_opt( 'parallaxscroll', false );
    if(isset($parallaxscroll) && $parallaxscroll) {
        wp_enqueue_script('k2_prefix-parallax');
    }
    wp_localize_script('k2_prefix-main','main_data',array('ajax_url'=>admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'k2_theme_frame_scripts');

/* add editor styles */
function k2_theme_frame_add_editor_styles()
{
    add_editor_style('editor-style.css');
}

add_action('admin_init', 'k2_theme_frame_add_editor_styles');

/* add admin styles */
function k2_theme_frame_admin_style()
{
    $theme = wp_get_theme(get_template());
    wp_enqueue_style('k2_prefix-admin-style', get_template_directory_uri() . '/assets/css/admin.css');
    wp_enqueue_style('font-material-icon', get_template_directory_uri() . '/assets/css/material-design-iconic-font.min.css', array(), '2.2.0');
}

add_action('admin_enqueue_scripts', 'k2_theme_frame_admin_style');

/**
 * Helper functions for this theme.
 */
require_once get_template_directory() . '/inc/template-functions.php';

/**
 * Theme options
 */
require_once get_template_directory() . '/inc/theme-options.php';

/**
 * Page options
 */
require_once get_template_directory() . '/inc/page-options.php';

/**
 * CSS Generator.
 */
if (!class_exists('CSS_Generator')) {
    require_once get_template_directory() . '/inc/classes/class-css-generator.php';
}

/**
 * Breadcrumb.
 */
require_once get_template_directory() . '/inc/classes/class-breadcrumb.php';

/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/inc/template-tags.php';

/* Load list require plugins */
require_once( get_template_directory() . '/inc/require.plugins.php' );

/* Load lib Font */
require_once get_template_directory() . '/inc/libs/fontawesome.php';
require_once get_template_directory() . '/inc/libs/materialdesign.php';

/**
 * Custom params & remove VC Elements.
 */

function k2_theme_frame_vc_after_init()
{

}

add_action('vc_after_init', 'k2_theme_frame_vc_after_init');

/**
 * Add new elements for VC
 */
function k2_theme_frame_vc_elements()
{

    if (class_exists('k2ShortCode')) {

        k2_require_folder('vc_elements', get_template_directory());
    }
}

add_action('vc_before_init', 'k2_theme_frame_vc_elements');

/**
 * Additional widgets for the theme
 */
 if (class_exists('k2ShortCode')) {

        k2_require_folder('widgets',get_template_directory());
    }
/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once get_template_directory() . '/inc/extends.php';


/**
 * Tutorials snippet functions. You should add those to extends.php
 * and remove the file.
 */
require_once get_template_directory() . '/inc/snippets.php';

/**
 * Add custom class in Row Visual Composer
 */
function k2_theme_frame_vc_shortcode_css_class( $classes, $settings_base, $atts )
{
    $classes_arr = explode( ' ', $classes );

    if ( 'vc_row' == $settings_base ) {
        if ( $atts['cms_row_class'] ) {
            $classes_arr[] = $atts['cms_row_class'];
        }
    }

    if ( 'vc_row_inner' == $settings_base ) {
        if ( $atts['row_border_box'] ) {
            $classes_arr[] = $atts['row_border_box'];
        }
    }

    if ( 'vc_column' == $settings_base ) {
        if ( $atts['cms_column_class'] ) {
            $classes_arr[] = $atts['cms_column_class'];
        }
    }

    if ( 'vc_column' == $settings_base ) {
        if ( $atts['cms_column_offset'] ) {
            $classes_arr[] = $atts['cms_column_offset'];
        }
    }

    if ( isset($atts['animation_column']) && $atts['animation_column'] ) {
        wp_enqueue_script( 'waypoints' );
        wp_enqueue_style( 'animate-css' );
        $classes_arr[] = 'wpb_animate_when_almost_visible '.' wpb_'.$atts['animation_column'].' '.$atts['animation_column'];
    }

    if ( 'vc_column_inner' == $settings_base ) {
        if ( $atts['cms_column_inner_class'] ) {
            $classes_arr[] = $atts['cms_column_inner_class'];
        }
    }

    if ( 'vc_single_image' == $settings_base ) {
        if ( $atts['cms_image_align'] ) {
            $classes_arr[] = $atts['cms_image_align'];
        }
    }

    return implode( ' ', $classes_arr );
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'k2_theme_frame_vc_shortcode_css_class', 10, 3 );
}


if ( ! function_exists( 'k2_theme_frame_fonts_url' ) ) :
    /**
     * Register Google fonts.
     *
     * Create your own k2_theme_frame_fonts_url() function to override in a child theme.
     *
     * @since league 1.1
     *
     * @return string Google fonts URL for the theme.
     */
    function k2_theme_frame_fonts_url()
    {
        $fonts_url = '';
        $fonts     = array();
        $subsets   = 'latin,latin-ext';

        if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'k2_text_domain' ) )
        {
            $fonts[] = 'Roboto:300,400,400i,500,500i,700,700i,900';
        }

        if ( 'off' !== _x( 'on', 'Cabin font: on or off', 'k2_text_domain' ) )
        {
            $fonts[] = 'Cabin:400,700';
        }

        if ( 'off' !== _x( 'on', 'Poppins font: on or off', 'k2_text_domain' ) )
        {
            $fonts[] = 'Poppins:400,700';
        }

        if ( 'off' !== _x( 'on', 'Playfair Display font: on or off', 'k2_text_domain' ) )
        {
            $fonts[] = 'Playfair Display:400';
        }

        if ( $fonts ) {
            $fonts_url = add_query_arg( array(
                'family' => urlencode( implode( '|', $fonts ) ),
                'subset' => urlencode( $subsets ),
            ), 'https://fonts.googleapis.com/css' );
        }

        return $fonts_url;
    }
endif;

/**
 * Commnet Form
 */
function k2_theme_frame_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter( 'comment_form_fields', 'k2_theme_frame_comment_field_to_bottom' );

/* Optimize Images */
add_filter( 'jpeg_quality', create_function( '', 'return 60;' ) );