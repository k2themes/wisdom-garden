<?php
if ( ! class_exists( 'ReduxFrameworkInstances' ) )
{
    return;
}

class CSS_Generator
{
    /**
     * scssc class instance
     *
     * @access protected
     * @var scssc
     */
    protected $scssc = null;

    /**
     * ReduxFramework class instance
     *
     * @access protected
     * @var ReduxFramework
     */
    protected $redux = null;

    /**
     * Debug mode is turn on or not
     *
     * @access protected
     * @var boolean
     */
    protected $dev_mode = true;

    /**
     * opt_name of ReduxFramework
     *
     * @access protected
     * @var string
     */
    protected $opt_name = '';


    /**
     * Constructor
     */
    function __construct()
    {
        $this->opt_name = k2_theme_frame_get_opt_name();

        if ( empty( $this->opt_name ) )
        {
            return;
        }
        add_filter( 'k2_scssc_on', '__return_true' );
        add_action( 'init', array( $this, 'init' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 20 );
    }

    /**
     * init hook - 10
     */
    function init()
    {
        if ( ! class_exists( 'scssc' ) )
        {
            return;
        }

        $this->redux = ReduxFrameworkInstances::get_instance( $this->opt_name );

        if ( empty( $this->redux ) || ! $this->redux instanceof ReduxFramework )
        {
            return;
        }

        $this->dev_mode = true;
        if ( $this->dev_mode === true )
        {
            $this->generate_file();
        }
        else
        {
            add_action( "redux/options/{$this->opt_name}/saved", array( $this, 'generate_file' ) );
        }
    }

    /**
     * Generate options and css files
     */
    function generate_file()
    {
        $scss_dir = get_template_directory() . '/assets/scss/';
        $css_dir  = get_template_directory() . '/assets/css/';

        $this->scssc = new scssc();
        $this->scssc->setImportPaths( $scss_dir );

        $_options = $scss_dir . 'variables.scss';

        $this->redux->filesystem->execute( 'put_contents', $_options, array(
            'content' => $this->options_output()
        ) );
        $css_file = $css_dir . 'theme.css';
        if ( ! $this->dev_mode )
        {
            $this->scssc->setFormatter( 'scss_formatter_compressed' );
            $css_file = $css_dir . 'theme.min.css';
        }else{
            $this->scssc->setFormatter( 'scss_formatter' );
        }
        $this->redux->filesystem->execute( 'put_contents', $css_file, array(
            'content' => $this->scssc->compile( '@import "theme.scss"' )
        ) );
    }

    /**
     * Output options to _variables.scss
     *
     * @access protected
     * @return string
     */
    protected function options_output()
    {
        ob_start();

        $primary_color = k2_theme_frame_get_opt( 'primary_color', '#ffc916' );
        if ( ! k2_theme_frame_is_valid_color( $primary_color ) )
        {
            $primary_color = '#ffc916';
        }
        printf( '$primary_color: %s;', esc_attr( $primary_color ) );

        $secondary_color = k2_theme_frame_get_opt( 'secondary_color', '#233151' );
        if ( ! k2_theme_frame_is_valid_color( $secondary_color ) )
        {
            $secondary_color = '#233151';
        }
        printf( '$secondary_color: %s;', esc_attr( $secondary_color ) );

        $link_color = k2_theme_frame_get_opt( 'link_color', '#ffc916' );
        if ( !empty($link_color['regular']) && isset($link_color['regular']) )
        {
            printf( '$link_color: %s;', esc_attr( $link_color['regular'] ) );
        } else {
            echo '$link_color: #ffc916;';
        }

        $link_color_hover = k2_theme_frame_get_opt( 'link_color', '#f3bc0b' );
        if ( !empty($link_color['hover']) && isset($link_color['hover']) )
        {
            printf( '$link_color_hover: %s;', esc_attr( $link_color['hover'] ) );
        } else {
            echo '$link_color_hover: #f3bc0b;';
        }

        $link_color_active = k2_theme_frame_get_opt( 'link_color', '#f3bc0b' );
        if ( !empty($link_color['active']) && isset($link_color['active']) )
        {
            printf( '$link_color_active: %s;', esc_attr( $link_color['active'] ) );
        } else {
            echo '$link_color_active: #f3bc0b;';
        }

        /* Font */
        $body_default_font = k2_theme_frame_get_opt( 'body_default_font', 'GT-Walsheim-Regular' );
        if (!empty($body_default_font) && $body_default_font != 'inherit') {
            echo '
                $body_default_font: '.esc_attr( $body_default_font ).';
            ';
        }

        $heading_default_font_medium = k2_theme_frame_get_opt( 'heading_default_font_medium', '' );
        if (!empty($heading_default_font_medium) && $heading_default_font_medium != 'inherit') {
            echo '
                $heading_default_font_medium: '.esc_attr( $heading_default_font_medium ).';
            ';
        }

        $heading_default_font_bold = k2_theme_frame_get_opt( 'heading_default_font_bold', 'GT-Walsheim-Bold' );
        if (!empty($heading_default_font_bold) && $heading_default_font_bold != 'inherit') {
            echo '
                $heading_default_font_bold: '.esc_attr( $heading_default_font_bold ).';
            ';
        }

        $menu_default_font = k2_theme_frame_get_opt( 'menu_default_font', 'Cabin' );
        if (!empty($menu_default_font)) {
            printf( '$menu_default_font: %s;', esc_attr( $menu_default_font ) );
        }

        return ob_get_clean();
    }

    /**
     * Hooked wp_enqueue_scripts - 20
     * Make sure that the handle is enqueued from earlier wp_enqueue_scripts hook.
     */
    function enqueue()
    {
        $css = $this->inline_css();
        if ( !empty($css) )
        {
            wp_add_inline_style( 'k2_prefix-theme', $this->dev_mode ? $css : k2_theme_frame_css_minifier( $css ) );
        }
    }

    /**
     * Generate inline css based on theme options
     */
    protected function inline_css()
    {
        ob_start();
        /* Font */
        $body_default_font = k2_theme_frame_get_opt( 'body_default_font', '' );
        if ($body_default_font != 'inherit') {
            echo ".ft-main-r, body {
                font-weight: normal !important;
            }";
        }

        $heading_default_font_medium = k2_theme_frame_get_opt( 'heading_default_font_medium', 'GT-Walsheim-Medium' );
        if ($heading_default_font_medium != 'inherit') {
            echo ".ft-heading-m, h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
                font-weight: normal !important;
            }";
        }

        $heading_default_font_bold = k2_theme_frame_get_opt( 'heading_default_font_bold', '' );
        if ($heading_default_font_bold != 'inherit') {
            echo ".ft-heading-b {
                font-weight: normal !important;
            }";
        }
        /* General */
        $custom_pagetitle = k2_theme_frame_get_page_opt( 'custom_pagetitle', false );
        $ptitle_paddings = k2_theme_frame_get_page_opt( 'ptitle_paddings' );
        if (is_home() && !is_front_page()) {
            if ( isset($ptitle_paddings) && !empty($ptitle_paddings) ) {
                echo "body #pagetitle {
                    padding-top:" .esc_attr($ptitle_paddings['padding-top']). ";
                    padding-bottom:" .esc_attr($ptitle_paddings['padding-bottom']). ";
                }";
            }
        }
        /* Logo */
        $logo_maxh = k2_theme_frame_get_opt( 'logo_maxh' );

        if (!empty($logo_maxh['height']) && $logo_maxh['height'] != 'px')
        {
            printf( '#site-header-wrap .site-branding a img { max-height: %s; }', esc_attr($logo_maxh['height']) );
        } ?>
        @media screen and (max-width: 991px) {
            <?php
            $logo_maxh_sm = k2_theme_frame_get_opt( 'logo_maxh_sm' );
            if (!empty($logo_maxh_sm['height']) && $logo_maxh_sm['height'] != 'px') {
                printf( '#site-header-wrap .site-branding a img { max-height: %s; }', esc_attr($logo_maxh_sm['height']) );
            } ?>
        }
        <?php /* Menu */
        $menu_text_transform = k2_theme_frame_get_opt( 'menu_text_transform' );
        if ( ! empty( $menu_text_transform ) ) {
            printf( '.primary-menu > li > a { text-transform: %s !important; }', esc_attr($menu_text_transform) );
        }
        $menu_font_size = k2_theme_frame_get_opt( 'menu_font_size' );
        if ( ! empty( $menu_font_size ) ) {
            printf( '.primary-menu > li > a { font-size: %s'.'px !important; }', esc_attr($menu_font_size) );
        }
        $main_menu_color = k2_theme_frame_get_opt( 'main_menu_color' );
        if ( ! empty( $main_menu_color['regular'] ) ) {
            printf( '.primary-menu > li > a { color: %s !important; }', esc_attr($main_menu_color['regular']) );
        }
        if ( ! empty( $main_menu_color['hover'] ) ) {
            printf( '.primary-menu > li > a:hover { color: %s !important; }', esc_attr($main_menu_color['hover']) );
        }
        if ( ! empty( $main_menu_color['active'] ) ) {
            printf( '.primary-menu > li.current_page_item > a, .primary-menu > li.current-menu-item > a, .primary-menu > li.current_page_ancestor > a, .primary-menu > li.current-menu-ancestor > a { color: %s !important; }', esc_attr($main_menu_color['active']) );
        }
        $sticky_menu_color = k2_theme_frame_get_opt( 'sticky_menu_color' );
        if ( ! empty( $sticky_menu_color['regular'] ) ) {
            printf( '.headroom--pinned:not(.headroom--top) .primary-menu > li > a { color: %s !important; }', esc_attr($sticky_menu_color['regular']) );
        }
        if ( ! empty( $sticky_menu_color['hover'] ) ) {
            printf( '.headroom--pinned:not(.headroom--top) .primary-menu > li > a:hover { color: %s !important; }', esc_attr($sticky_menu_color['hover']) );
        }
        if ( ! empty( $sticky_menu_color['active'] ) ) {
            printf( '.headroom--pinned:not(.headroom--top) .primary-menu > li.current_page_item > a, .headroom--pinned:not(.headroom--top) .primary-menu > li.current-menu-item > a, .headroom--pinned:not(.headroom--top) .primary-menu > li.current_page_ancestor > a, .headroom--pinned:not(.headroom--top) .primary-menu > li.current-menu-ancestor > a { color: %s !important; }', esc_attr($sticky_menu_color['active']) );
        }

        /* Page Title */
        $page_ptitle_width = k2_theme_frame_get_page_opt( 'page_ptitle_width', '100' );
        ?>
        @media screen and (min-width: 800px) {
            <?php
            if ( $custom_pagetitle && isset($page_ptitle_width) ) {
                echo "#pagetitle .page-title-inner {
                    max-width:" .esc_attr($page_ptitle_width). "%;
                }";
            } ?>
        }
        @media screen and (max-width: 991px) {
            <?php
            $ptitle_paddings_sm = k2_theme_frame_get_opt( 'ptitle_paddings_sm', array( 'padding-top' => '135px', 'padding-bottom' => '135px' ) );
            if ( isset($ptitle_paddings_sm) && !empty($ptitle_paddings_sm) ) {
                echo "body #pagetitle {
                    padding-top:" .esc_attr($ptitle_paddings_sm['padding-top']). ";
                    padding-bottom:" .esc_attr($ptitle_paddings_sm['padding-bottom']). ";
                }";
            } ?>
        }
        <?php
        $ptitle_overlay_style = k2_theme_frame_get_opt( 'ptitle_overlay_style', 'secondary' );
        $page_ptitle_overlay_style = k2_theme_frame_get_page_opt( 'ptitle_overlay_style', 'secondary' );
        $ptitle_bg_color = k2_theme_frame_get_opt( 'ptitle_bg_color' );
        $page_ptitle_bg_color = k2_theme_frame_get_page_opt( 'ptitle_bg_color' );
        if($custom_pagetitle && $page_ptitle_overlay_style == 'default' && !empty($page_ptitle_bg_color) ) {
            $ptitle_bg_color = $page_ptitle_bg_color;
            $ptitle_overlay_style = $page_ptitle_overlay_style;
        }
        if ( ! empty($ptitle_bg_color) && $ptitle_overlay_style == 'default' )
        {
            printf( '#pagetitle.overlay-default { background-color: transparent; background-color: %s; }', esc_attr($ptitle_bg_color['rgba']) );
        }
        if ( $ptitle_overlay_style == 'none' )
        {
            echo "#pagetitle.bg-overlay:before {
                display: none;
            }";
        }
        $ptitle_font_size = k2_theme_frame_get_opt( 'ptitle_font_size' );
        $page_title_font_size = k2_theme_frame_get_page_opt( 'ptitle_font_size' );
        if($custom_pagetitle && !empty($page_title_font_size)) {
            $ptitle_font_size = $page_title_font_size;
        }
        if ( ! empty( $ptitle_font_size ) ) {
            printf( '#pagetitle h1.page-title { font-size: %s'.'px; }', esc_attr($ptitle_font_size) );
        }
        $ptitle_line_hegiht = k2_theme_frame_get_opt( 'ptitle_line_hegiht' );
        if ( ! empty( $ptitle_line_hegiht ) ) {
            printf( '#pagetitle h1.page-title { line-height: %s'.'px; }', esc_attr($ptitle_line_hegiht) );
        }

        /* Button */
        $button_border_color = k2_theme_frame_get_opt( 'button_border_color' );
        $button_color = k2_theme_frame_get_opt( 'button_color' );
        $button_bg_type_color = k2_theme_frame_get_opt( 'button_bg_type_color', 'normal' );
        $button_bg_color = k2_theme_frame_get_opt( 'button_bg_color' );
        $button_bg_gradient_color = k2_theme_frame_get_opt( 'button_bg_gradient_color' );
        $button_bg_gradient_color_hover = k2_theme_frame_get_opt( 'button_bg_gradient_color_hover' );
        $button_border = k2_theme_frame_get_opt( 'button_border' );
        $button_border_radius = k2_theme_frame_get_opt( 'button_border_radius' );
        $button_font_size = k2_theme_frame_get_opt( 'button_font_size' );
        $button_line_hegiht = k2_theme_frame_get_opt( 'button_line_hegiht' );
        $button_text_transform = k2_theme_frame_get_opt( 'button_text_transform' );
        $button_box_shadow = k2_theme_frame_get_opt( 'button_box_shadow', true );
        $button_text_shadow = k2_theme_frame_get_opt( 'button_text_shadow', false );
        if ( ! empty( $button_color['hover'] ) ) {
            printf( '.btn:hover, button:hover, .button:hover, input[type="submit"]:hover, .btn:focus, button:focus, .button:focus, input[type="submit"]:focus { color: %s; }', esc_attr($button_color['hover']) );
        }
        if ( ! empty( $button_border_color['regular'] ) ) {
            printf( '.btn, button, .button, input[type="submit"] { border-color: %s; }', esc_attr($button_border_color['regular']) );
        }
        if ( ! empty( $button_border_color['hover'] ) ) {
            printf( '.btn:hover, button:hover, .button:hover, input[type="submit"]:hover, .btn:focus, button:focus, .button:focus, input[type="submit"]:focus { border-color: %s; }', esc_attr($button_border_color['hover']) );
        }
        if ( $button_bg_type_color == 'normal' && ! empty( $button_bg_color['regular'] ) ) {
            printf( '.btn, button, .button, input[type="submit"] { background-color: %s; }', esc_attr($button_bg_color['regular']) );
        }
        if ( $button_bg_type_color == 'normal' && ! empty( $button_bg_color['hover'] ) ) {
            printf( '.btn:hover, button:hover, .button:hover, input[type="submit"]:hover, .btn:focus, button:focus, .button:focus, input[type="submit"]:focus {
                background-color: %s; }', esc_attr($button_bg_color['hover'])
            );
        }
        if ( $button_bg_type_color == 'gradient' && ! empty( $button_bg_gradient_color['from'] ) && ! empty( $button_bg_gradient_color['to'] ) ) {
            echo '.btn, button, .button, input[type="submit"] {
                background: '.$button_bg_gradient_color['from'].';
                background: -moz-linear-gradient(top, '.$button_bg_gradient_color['from'].' 0%, '.$button_bg_gradient_color['to'].' 100%);
                background: -webkit-gradient(left top, left bottom, color-stop(0%, '.$button_bg_gradient_color['from'].'), color-stop(100%, '.$button_bg_gradient_color['to'].'));
                background: -webkit-linear-gradient(top, '.$button_bg_gradient_color['from'].' 0%, '.$button_bg_gradient_color['to'].' 100%);
                background: -o-linear-gradient(top, '.$button_bg_gradient_color['from'].' 0%, '.$button_bg_gradient_color['to'].' 100%);
                background: -ms-linear-gradient(top, '.$button_bg_gradient_color['from'].' 0%, '.$button_bg_gradient_color['to'].' 100%);
                background: linear-gradient(to bottom, '.$button_bg_gradient_color['from'].' 0%, '.$button_bg_gradient_color['to'].' 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="'.$button_bg_gradient_color['from'].'", endColorstr="'.$button_bg_gradient_color['to'].'", GradientType=0 );
            }';
        }
        if ( $button_bg_type_color == 'gradient' && ! empty( $button_bg_gradient_color_hover['from'] ) && ! empty( $button_bg_gradient_color_hover['to'] ) ) {
            echo '.btn:hover, button:hover, .button:hover, input[type="submit"]:hover, .btn:focus, button:focus, .button:focus, input[type="submit"]:focus, .btn.active:not([disabled]):not(.disabled), .btn:active:not([disabled]):not(.disabled) {
                background: '.$button_bg_gradient_color_hover['from'].';
                background: -moz-linear-gradient(top, '.$button_bg_gradient_color_hover['from'].' 0%, '.$button_bg_gradient_color_hover['to'].' 100%);
                background: -webkit-gradient(left top, left bottom, color-stop(0%, '.$button_bg_gradient_color_hover['from'].'), color-stop(100%, '.$button_bg_gradient_color_hover['to'].'));
                background: -webkit-linear-gradient(top, '.$button_bg_gradient_color_hover['from'].' 0%, '.$button_bg_gradient_color_hover['to'].' 100%);
                background: -o-linear-gradient(top, '.$button_bg_gradient_color_hover['from'].' 0%, '.$button_bg_gradient_color_hover['to'].' 100%);
                background: -ms-linear-gradient(top, '.$button_bg_gradient_color_hover['from'].' 0%, '.$button_bg_gradient_color_hover['to'].' 100%);
                background: linear-gradient(to bottom, '.$button_bg_gradient_color_hover['from'].' 0%, '.$button_bg_gradient_color_hover['to'].' 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="'.$button_bg_gradient_color_hover['from'].'", endColorstr="'.$button_bg_gradient_color_hover['to'].'", GradientType=0 );
            }';
        }
        if ( ! empty( $button_border['border-top'] ) ) {
            printf( '.btn, button, .button, input[type="submit"], .btn.btn-primary-outline { border-top-width: %s; }', esc_attr($button_border['border-top']) );
        }
        if ( ! empty( $button_border['border-bottom'] ) ) {
            printf( '.btn, button, .button, input[type="submit"], .btn.btn-primary-outline { border-bottom-width: %s; }', esc_attr($button_border['border-bottom']) );
        }
        if ( ! empty( $button_border['border-left'] ) ) {
            printf( '.btn, button, .button, input[type="submit"], .btn.btn-primary-outline { border-left-width: %s; }', esc_attr($button_border['border-left']) );
        }
        if ( ! empty( $button_border['border-right'] ) ) {
            printf( '.btn, button, .button, input[type="submit"], .btn.btn-primary-outline { border-right-width: %s; }', esc_attr($button_border['border-right']) );
        }
        if ( ! empty( $button_border['border-style'] ) && $button_border['border-style'] != 'none' ) {
            printf( '.btn, button, .button, input[type="submit"] { border-style: %s; }', esc_attr($button_border['border-style']) );
        }
        if ( ! empty( $button_font_size ) ) {
            printf( '.btn, button, .button, input[type="submit"] { font-size: %s'.'px; }', esc_attr($button_font_size) );
        }
        if ( ! empty( $button_line_hegiht ) ) {
            printf( '.btn, button, .button, input[type="submit"] { line-height: %s'.'px; }', esc_attr($button_line_hegiht) );
        }
        if ( ! empty( $button_border_radius['padding-top'] ) ) {
            printf( '.btn, button, .button, input[type="submit"] { border-top-left-radius: %s'.'px; }', esc_attr($button_border_radius['padding-top']) );
            printf( '.btn, button, .button, input[type="submit"] { -webkit-border-top-left-radius: %s'.'px; }', esc_attr($button_border_radius['padding-top']) );
            printf( '.btn, button, .button, input[type="submit"] { -ms-border-top-left-radius: %s'.'px; }', esc_attr($button_border_radius['padding-top']) );
            printf( '.btn, button, .button, input[type="submit"] { -o-border-top-left-radius: %s'.'px; }', esc_attr($button_border_radius['padding-top']) );
        }
        if ( ! empty( $button_border_radius['padding-right'] ) ) {
            printf( '.btn, button, .button, input[type="submit"] { border-top-right-radius: %s'.'px; }', esc_attr($button_border_radius['padding-right']) );
            printf( '.btn, button, .button, input[type="submit"] { -webkit-border-top-right-radius: %s'.'px; }', esc_attr($button_border_radius['padding-right']) );
            printf( '.btn, button, .button, input[type="submit"] { -ms-border-top-right-radius: %s'.'px; }', esc_attr($button_border_radius['padding-right']) );
            printf( '.btn, button, .button, input[type="submit"] { -o-border-top-right-radius: %s'.'px; }', esc_attr($button_border_radius['padding-right']) );
        }
        if ( ! empty( $button_border_radius['padding-bottom'] ) ) {
            printf( '.btn, button, .button, input[type="submit"] { border-bottom-right-radius: %s'.'px; }', esc_attr($button_border_radius['padding-bottom']) );
            printf( '.btn, button, .button, input[type="submit"] { -webkit-border-bottom-right-radius: %s'.'px; }', esc_attr($button_border_radius['padding-bottom']) );
            printf( '.btn, button, .button, input[type="submit"] { -ms-border-bottom-right-radius: %s'.'px; }', esc_attr($button_border_radius['padding-bottom']) );
            printf( '.btn, button, .button, input[type="submit"] { -o-border-bottom-right-radius: %s'.'px; }', esc_attr($button_border_radius['padding-bottom']) );
        }
        if ( ! empty( $button_border_radius['padding-left'] ) ) {
            printf( '.btn, button, .button, input[type="submit"] { border-bottom-left-radius: %s'.'px; }', esc_attr($button_border_radius['padding-left']) );
            printf( '.btn, button, .button, input[type="submit"] { -webkit-border-bottom-left-radius: %s'.'px; }', esc_attr($button_border_radius['padding-left']) );
            printf( '.btn, button, .button, input[type="submit"] { -ms-border-bottom-left-radius: %s'.'px; }', esc_attr($button_border_radius['padding-left']) );
            printf( '.btn, button, .button, input[type="submit"] { -o-border-bottom-left-radius: %s'.'px; }', esc_attr($button_border_radius['padding-left']) );
        }
        if ( isset($button_box_shadow) && $button_box_shadow ) {
            printf( '.btn, button, .button, input[type="submit"] { box-shadow: %s; }', '6px 6px 0 rgba(0, 0, 0, 0.16)' );
            printf( '.btn, button, .button, input[type="submit"] { -webkit-box-shadow: %s; }', '6px 6px 0 rgba(0, 0, 0, 0.16)' );
            printf( '.btn, button, .button, input[type="submit"] { -ms-box-shadow: %s; }', '6px 6px 0 rgba(0, 0, 0, 0.16)' );
            printf( '.btn, button, .button, input[type="submit"] { -o-box-shadow: %s; }', '6px 6px 0 rgba(0, 0, 0, 0.16)' );
        }
        if ( isset($button_text_shadow) && $button_text_shadow ) {
            printf( '.btn, button, .button, input[type="submit"] { text-shadow: %s; }', '0px 2px 2px rgba(0, 0, 0, 0.15)' );
            printf( '.btn, button, .button, input[type="submit"] { -webkit-text-shadow: %s; }', '0px 2px 2px rgba(0, 0, 0, 0.15)' );
            printf( '.btn, button, .button, input[type="submit"] { -ms-text-shadow: %s; }', '0px 2px 2px rgba(0, 0, 0, 0.15)' );
            printf( '.btn, button, .button, input[type="submit"] { -o-text-shadow: %s; }', '0px 2px 2px rgba(0, 0, 0, 0.15)' );
        }
        if ( ! empty( $button_text_transform ) ) {
            printf( '.btn, button, .button, input[type="submit"] { text-transform: %s; }', esc_attr($button_text_transform) );
        }

        /* Form Fields */
        $field_color = k2_theme_frame_get_opt( 'field_color' );
        $field_border_color = k2_theme_frame_get_opt( 'field_border_color' );
        $field_background_color = k2_theme_frame_get_opt( 'field_background_color' );
        $field_border = k2_theme_frame_get_opt( 'field_border' );
        $field_border_radius = k2_theme_frame_get_opt( 'field_border_radius' );
        $field_font_size = k2_theme_frame_get_opt( 'field_font_size' );
        $field_line_hegiht = k2_theme_frame_get_opt( 'field_line_hegiht' );
        $field_text_transform = k2_theme_frame_get_opt( 'field_text_transform' );
        $field_box_shadow = k2_theme_frame_get_opt( 'field_box_shadow', true );
        $textarea_height = k2_theme_frame_get_opt( 'textarea_height' );
        if ( ! empty( $field_color['active'] ) ) {
            printf( 'input:not([type="submit"]):focus, textarea:focus, select:focus, .nice-select:focus { color: %s !important; }', esc_attr($field_color['active']) );
        }
        if ( ! empty( $field_border_color['regular'] ) ) {
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { border-color: %s !important; }', esc_attr($field_border_color['regular']) );
        }
        if ( ! empty( $field_border_color['active'] ) ) {
            printf( 'input:not([type="submit"]):focus, textarea:focus, select:focus, .nice-select:focus { border-color: %s !important; }', esc_attr($field_border_color['active']) );
        }
        if ( ! empty( $field_background_color['regular'] ) ) {
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { background-color: %s !important; }', esc_attr($field_background_color['regular']) );
        }
        if ( ! empty( $field_background_color['active'] ) ) {
            printf( 'input:not([type="submit"]):focus, textarea:focus, select:focus, .nice-select:focus { background-color: %s !important; }', esc_attr($field_background_color['active']) );
        }
        if ( ! empty( $field_border['border-top'] ) ) {
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { border-top-width: %s !important; }', esc_attr($field_border['border-top']) );
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { border-bottom-width: %s !important; }', esc_attr($field_border['border-bottom']) );
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { border-left-width: %s !important; }', esc_attr($field_border['border-left']) );
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { border-right-width: %s !important; }', esc_attr($field_border['border-right']) );
        }
        if ( ! empty( $field_border['border-style'] ) && $field_border['border-style'] != 'none' ) {
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { border-style: %s; }', esc_attr($field_border['border-style']) );
        }
        if ( ! empty( $field_border_radius['padding-top'] ) ) {
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { border-top-left-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-top']) );
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { -webkit-border-top-left-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-top']) );
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { -ms-border-top-left-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-top']) );
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { -o-border-top-left-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-top']) );
        }
        if ( ! empty( $field_border_radius['padding-right'] ) ) {
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { border-top-right-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-right']) );
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { -webkit-border-top-right-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-right']) );
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { -ms-border-top-right-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-right']) );
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { -o-border-top-right-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-right']) );
        }
        if ( ! empty( $field_border_radius['padding-bottom'] ) ) {
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { border-bottom-right-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-bottom']) );
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { -webkit-border-bottom-right-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-bottom']) );
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { -ms-border-bottom-right-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-bottom']) );
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { -o-border-bottom-right-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-bottom']) );
        }
        if ( ! empty( $field_border_radius['padding-left'] ) ) {
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { border-bottom-left-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-left']) );
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { -webkit-border-bottom-left-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-left']) );
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { -ms-border-bottom-left-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-left']) );
            printf( 'input:not([type="submit"]), textarea, select, .nice-select { -o-border-bottom-left-radius: %s'.'px !important; }', esc_attr($field_border_radius['padding-left']) );
        }
        if ( !empty( $textarea_height ) ) {
            echo 'textarea {
                height: '.$textarea_height.'px !important;
            }';
        }
        $field_primary_color = k2_theme_frame_get_opt( 'primary_color' );
        if ( $field_box_shadow ) {
            echo 'input:not([type="submit"]), textarea, select, .nice-select {
                box-shadow: 6px 6px 0 rgba(0, 0, 0, 0.16);
                -webkit-box-shadow: 6px 6px 0 rgba(0, 0, 0, 0.16);
                -ms-box-shadow: 6px 6px 0 rgba(0, 0, 0, 0.16);
                -o-box-shadow: 6px 6px 0 rgba(0, 0, 0, 0.16);
            }';
            echo 'input:not([type="submit"]):focus, textarea:focus, select:focus, .nice-select:focus {
                box-shadow: 6px 6px 0 '.$field_primary_color.';
                -webkit-box-shadow: 6px 6px 0 '.$field_primary_color.';
                -ms-box-shadow: 6px 6px 0 '.$field_primary_color.';
                -o-box-shadow: 6px 6px 0 '.$field_primary_color.';
            }';
        }

        $field_default_font = k2_theme_frame_get_opt( 'field_default_font' );
        if (!empty($field_default_font) && ($field_default_font != 'inherit')) {
            echo 'body input:not([type="submit"]), body textarea, body select, body .nice-select {
                font-family: '.esc_attr( $field_default_font ).';
            }';
        }

        /* Content */
        $character_content = k2_theme_frame_get_page_opt( 'character_content' );
        $single_post_layout = k2_theme_frame_get_opt( 'single_post_layout', 'default' );
        $post_bg_color = k2_theme_frame_get_opt( 'post_bg_color' );
        if($single_post_layout == 'real-estate' && !empty($post_bg_color)) {
            echo '.single-post #content.site-content {
                background-color: '.esc_attr( $post_bg_color ).';
            }';
        }
        $singe_portfolio_layout = k2_theme_frame_get_opt( 'singe_portfolio_layout', 'default' );
        $sg_portfolio_bg_color = k2_theme_frame_get_opt( 'sg_portfolio_bg_color' );
        if($singe_portfolio_layout == 'estate' && !empty($sg_portfolio_bg_color)) {
            echo '.single-portfolio #content.site-content {
                background-color: '.esc_attr( $sg_portfolio_bg_color ).';
            }';
        }
        $singe_service_layout = k2_theme_frame_get_opt( 'singe_service_layout', 'default' );
        $sg_service_bg_color = k2_theme_frame_get_opt( 'sg_service_bg_color' );
        if($singe_service_layout == 'estate' && !empty($sg_service_bg_color)) {
            echo '.single-service #content.site-content {
                background-color: '.esc_attr( $sg_service_bg_color ).';
            }';
        }
        $content_sidebar_space = k2_theme_frame_get_opt( 'content_sidebar_space' );
        $content_sidebar_space_number = ($content_sidebar_space/2).'px';
        ?>
        @media screen and (min-width: 1280px) {
            <?php if ( ! empty( $content_sidebar_space ) ) {
                printf( '.content-row { margin-left: -'.'%s; }', esc_attr($content_sidebar_space_number) );
                printf( '.content-row { margin-right: -'.'%s; }', esc_attr($content_sidebar_space_number) );
                printf( '.content-row #primary, .content-row #secondary { padding-left: %s; }', esc_attr($content_sidebar_space_number) );
                printf( '.content-row #primary, .content-row #secondary { padding-right: %s; }', esc_attr($content_sidebar_space_number) );
            } ?>
        }
        @media screen and (min-width: 992px) {
            <?php if ( ! empty( $character_content ) ) {
                printf( '.site-content:before { content: "%s"; }', esc_attr($character_content) );
            } ?>
        }
        <?php
        /* Footer */
        $footer_top_heading_color = k2_theme_frame_get_opt( 'footer_top_heading_color' );
        $footer_top_heading_fs = k2_theme_frame_get_opt( 'footer_top_heading_fs' );
        $footer_top_heading_tt = k2_theme_frame_get_opt( 'footer_top_heading_tt' );
        $footer_top_paddings = k2_theme_frame_get_opt( 'footer_top_paddings' );
        if(!empty($footer_top_heading_color)) {
            echo '.top-footer .footer-widget-title {
                color: '.esc_attr( $footer_top_heading_color ).' !important;
            }';
        }
        if(!empty($footer_top_heading_fs)) {
            echo '.top-footer .footer-widget-title {
                font-size: '.esc_attr( $footer_top_heading_fs ).'px !important;
            }';
        }
        if(!empty($footer_top_heading_tt)) {
            echo '.top-footer .footer-widget-title {
                text-transform: '.esc_attr( $footer_top_heading_tt ).' !important;
            }';
        }
        if ( isset($footer_top_paddings) && !empty($footer_top_paddings) ) {
            if(!empty($footer_top_paddings['padding-top'])) {
                echo ".site-footer .top-footer {
                    padding-top:" .esc_attr($footer_top_paddings['padding-top']). " !important;
                }";
            }
            if(!empty($footer_top_paddings['padding-bottom'])) {
                echo ".site-footer .top-footer {
                    padding-bottom:" .esc_attr($footer_top_paddings['padding-bottom']). " !important;
                }";
            }
        }
        /* Custom Css */
        $custom_css = k2_theme_frame_get_opt( 'site_css' );
        if(!empty($custom_css)) { echo esc_attr($custom_css); }

        return ob_get_clean();
    }
}

new CSS_Generator();