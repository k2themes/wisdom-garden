<?php
if (!class_exists('ReduxFramework')) {
    return;
}
if (class_exists('ReduxFrameworkPlugin')) {
    remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
}
if(class_exists('WPCF7')) {
    $cf7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );

    $contact_forms = array();
    if ( $cf7 ) {
        foreach ( $cf7 as $cform ) {
            $contact_forms[ $cform->ID ] = $cform->post_title;
        }
    } else {
        $contact_forms[ esc_html__( 'No contact forms found', 'k2_text_domain' ) ] = 0;
    }
} else {
    $contact_forms = '';
}

$opt_name = k2_theme_frame_get_opt_name();
$theme = wp_get_theme();

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'         => $theme->get('Name'),
    // Name that appears at the top of your panel
    'display_version'      => $theme->get('Version'),
    // Version that appears at the top of your panel
    'menu_type'            => class_exists('K2_Framework') ? 'submenu' : '',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => true,
    // Show the sections below the admin menu item or not
    'menu_title'           => esc_html__('Theme Options', 'k2_text_domain'),
    'page_title'           => esc_html__('Theme Options', 'k2_text_domain'),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'       => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => false,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => true,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-admin-generic',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 50,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => true,
    // Show the time the page took to load, etc
    'update_notice'        => true,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => true,
    // Enable basic customizer support
    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
    'show_options_object' => false,
    // OPTIONAL -> Give you extra features
    'page_priority'        => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => class_exists('K2_Framework') ? $theme->get('TextDomain') : '',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'     => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'            => '',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => 'theme-options',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

    // HINTS
    'hints'                => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'red',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ),
            'hide' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ),
        ),
    ),
    'templates_path'       => class_exists('K2_Framework') ? k2framework()->path('APP_DIR') . '/templates/redux/' : '',
);

Redux::SetArgs($opt_name, $args);

/*--------------------------------------------------------------
# General
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('General', 'k2_text_domain'),
    'icon'   => 'el-icon-home',
    'fields' => array(
        array(
            'id'       => 'show_page_loading',
            'type'     => 'switch',
            'title'    => esc_html__('Enable Page Loading', 'k2_text_domain'),
            'subtitle' => esc_html__('Enable page loading effect when you load site.', 'k2_text_domain'),
            'default'  => false
        ),
        array(
            'id'       => 'smoothscroll',
            'type'     => 'switch',
            'title'    => esc_html__('Smooth Scroll', 'k2_text_domain'),
            'default'  => false
        ),
        array(
            'id'       => 'parallaxscroll',
            'type'     => 'switch',
            'title'    => esc_html__('Parallax Scroll', 'k2_text_domain'),
            'default'  => false
        ),
        array(
            'id'      => 'parallaxscroll_speed',
            'type'    => 'text',
            'title'   => esc_html__('Parallax Scroll Speed', 'k2_text_domain'),
            'default' => '',
            'desc' => 'Enter parallax speed ratio (Note: Default value is 4, min value is 1)',
            'required' => array( 0 => 'parallaxscroll', 1 => '=', 2 => '1' ),
            'force_output' => true
        ),
    )
));

/*--------------------------------------------------------------
# Header
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Header', 'k2_text_domain'),
    'icon'   => 'el-icon-website',
    'fields' => array(
        array(
            'id'       => 'header_layout',
            'type'     => 'image_select',
            'title'    => esc_html__('Layout', 'k2_text_domain'),
            'subtitle' => esc_html__('Select a layout for header.', 'k2_text_domain'),
            'options'  => array(
                '1' => get_template_directory_uri() . '/assets/images/header-layout/h1.jpg',
                '2' => get_template_directory_uri() . '/assets/images/header-layout/h2.jpg',
                '3' => get_template_directory_uri() . '/assets/images/header-layout/h3.jpg',
                '4' => get_template_directory_uri() . '/assets/images/header-layout/h4.jpg',
                '5' => get_template_directory_uri() . '/assets/images/header-layout/h5.jpg',
                '6' => get_template_directory_uri() . '/assets/images/header-layout/h6.jpg',
                '7' => get_template_directory_uri() . '/assets/images/header-layout/h7.jpg',
            ),
            'default'  => '1'
        ),
        array(
            'id'       => 'sticky_on',
            'type'     => 'switch',
            'title'    => esc_html__('Sticky Header', 'k2_text_domain'),
            'subtitle' => esc_html__('Header will be sticked when applicable.', 'k2_text_domain'),
            'default'  => false
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Top Bar', 'k2_text_domain'),
    'icon'       => 'el-icon-circle-arrow-right',
    'subsection' => true,
    'fields'     => array(
        array(
            'id' => 'top_bar_phone_label',
            'type' => 'text',
            'title' => esc_html__('Phone Label', 'k2_text_domain'),
            'default' => '',
            'desc' => 'Ex: Call us 8:30am - 5:00pm'
        ),
        array(
            'id' => 'top_bar_phone',
            'type' => 'text',
            'title' => esc_html__('Phone', 'k2_text_domain'),
            'default' => '',
            'desc' => 'Ex: 222-145-1425'
        ),
        array(
            'id' => 'top_bar_time_label',
            'type' => 'text',
            'title' => esc_html__('Time Label', 'k2_text_domain'),
            'default' => '',
            'desc' => 'Ex: Open Weekdays'
        ),
        array(
            'id' => 'top_bar_time',
            'type' => 'text',
            'title' => esc_html__('Time', 'k2_text_domain'),
            'default' => '',
            'desc' => 'Ex: 8:30azm till 5:00pm'
        ),
        array(
            'id' => 'top_bar_email_label',
            'type' => 'text',
            'title' => esc_html__('Email Label', 'k2_text_domain'),
            'default' => '',
            'desc' => 'Ex: Email us'
        ),
        array(
            'id' => 'top_bar_email',
            'type' => 'text',
            'title' => esc_html__('Email', 'k2_text_domain'),
            'default' => '',
            'desc' => 'Ex: contact@example.com'
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Logo', 'k2_text_domain'),
    'icon'       => 'el el-picture',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'logo_light',
            'type'     => 'media',
            'title'    => esc_html__('Logo Light', 'k2_text_domain'),
             'default' => array(
                'url'=>get_template_directory_uri().'/assets/images/logo-light.png'
            )
        ),
        array(
            'id'       => 'logo',
            'type'     => 'media',
            'title'    => esc_html__('Logo Dark', 'k2_text_domain'),
             'default' => array(
                'url'=>get_template_directory_uri().'/assets/images/logo-dark.png'
            )
        ),
        array(
            'id'       => 'logo_mobile',
            'type'     => 'media',
            'title'    => esc_html__('Logo Tablet & Mobile', 'k2_text_domain'),
             'default' => array(
                'url'=>get_template_directory_uri().'/assets/images/logo-dark.png'
            )
        ),
        array(
            'id'       => 'logo_maxh',
            'type'     => 'dimensions',
            'title'    => esc_html__('Logo Max height', 'k2_text_domain'),
            'subtitle' => esc_html__('Set maximum height for your logo, just in case the logo is too large.', 'k2_text_domain'),
            'width'    => false,
            'unit'     => 'px'
        ),
        array(
            'id'       => 'logo_maxh_sm',
            'type'     => 'dimensions',
            'title'    => esc_html__('Logo Max height Tablet & Mobile', 'k2_text_domain'),
            'width'    => false,
            'unit'     => 'px'
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Navigation', 'k2_text_domain'),
    'icon'       => 'el el-lines',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'menu_default_font',
            'type'     => 'select',
            'title'    => esc_html__('Menu Default Font', 'k2_text_domain'),
            'options'  => array(
                'Cabin'  => esc_html__('Cabin', 'k2_text_domain'),
                'GT-Walsheim-Regular'  => esc_html__('GT Walsheim Regular', 'k2_text_domain'),
                'GT-Walsheim-Medium'  => esc_html__('GT Walsheim Medium', 'k2_text_domain'),
                'GT-Walsheim-Bold'  => esc_html__('GT Walsheim Bold', 'k2_text_domain'),
                'Nimbus-Sans-Regular'  => esc_html__('Nimbus Sans Regular', 'k2_text_domain'),
                'Nimbus-Sans-Bold'  => esc_html__('Nimbus Sans Bold', 'k2_text_domain'),
                'Maison-Neue-Mono'  => esc_html__('Maison Neue Mono', 'k2_text_domain'),
                'Maison-Neue-Bold'  => esc_html__('Maison Neue Bold', 'k2_text_domain'),
                'Proxima-Nova-Bold'  => esc_html__('Proxima Nova Bold', 'k2_text_domain'),
                'Proxima-Nova-Semibold'  => esc_html__('Proxima Nova Semibold', 'k2_text_domain'),
                'Proxima-Nova-Regular'  => esc_html__('Proxima Nova Regular', 'k2_text_domain'),
                'Calibre-Regular'  => esc_html__('Calibre Regular', 'k2_text_domain'),
                'Calibre-Medium'  => esc_html__('Calibre Medium', 'k2_text_domain'),
                'Calibre-Semibold'  => esc_html__('Calibre Semibold', 'k2_text_domain'),
                'Norwester'  => esc_html__('Norwester', 'k2_text_domain'),
                'inherit'  => esc_html__('Inherit', 'k2_text_domain'),
            ),
            'default'  => 'Cabin',
            'desc' => 'The selector & tag is used: .primary-menu > li > a'
        ),
        array(
            'id'          => 'font_menu',
            'type'        => 'typography',
            'title'       => esc_html__('Custom Google Font', 'k2_text_domain'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'font-style'  => false,
            'font-weight'  => true,
            'text-align'  => false,
            'font-size'  => false,
            'line-height'  => false,
            'color'  => false,
            'output'      => array('body .primary-menu > li > a, body .primary-menu .sub-menu li a'),
            'units'       => 'px'
        ),
        array(
            'id'       => 'menu_font_size',
            'type'     => 'text',
            'title'    => esc_html__('Font Size', 'k2_text_domain'),
            'validate' => 'numeric',
            'desc'     => 'Enter number',
            'msg'      => 'Please enter number',
            'default'  => ''
        ),
        array(
            'id'       => 'menu_text_transform',
            'type'     => 'select',
            'title'    => esc_html__('Text Transform', 'k2_text_domain'),
            'options'  => array(
                ''  => esc_html__('Capitalize', 'k2_text_domain'),
                'uppercase' => esc_html__('Uppercase', 'k2_text_domain'),
                'lowercase'  => esc_html__('Lowercase', 'k2_text_domain'),
                'initial'  => esc_html__('Initial', 'k2_text_domain'),
                'inherit'  => esc_html__('Inherit', 'k2_text_domain'),
                'none'  => esc_html__('None', 'k2_text_domain'),
            ),
            'default'  => ''
        ),
        array(
            'title' => esc_html__('Main Menu', 'k2_text_domain'),
            'type'  => 'section',
            'id' => 'main_menu',
            'indent' => true
        ),
        array(
            'id'      => 'main_menu_color',
            'type'    => 'link_color',
            'title'   => esc_html__('Color', 'k2_text_domain'),
            'default' => array(
                'regular' => '',
                'hover'   => '',
                'active'   => '',
            ),
        ),
        array(
            'title' => esc_html__('Sticky Menu', 'k2_text_domain'),
            'type'  => 'section',
            'id' => 'sticky_menu',
            'indent' => true
        ),
        array(
            'id'      => 'sticky_menu_color',
            'type'    => 'link_color',
            'title'   => esc_html__('Color', 'k2_text_domain'),
            'default' => array(
                'regular' => '',
                'hover'   => '',
                'active'   => '',
            ),
        ),
        array(
            'title' => esc_html__('Button Navigation', 'k2_text_domain'),
            'type'  => 'section',
            'id' => 'button_navigation',
            'indent' => true
        ),
        array(
            'id' => 'h_btn_text',
            'type' => 'text',
            'title' => esc_html__('Button Text', 'k2_text_domain'),
            'default' => '',
        ),
        array(
            'id'       => 'h_btn_link_type',
            'type'     => 'button_set',
            'title'    => esc_html__('Button Link', 'k2_text_domain'),
            'options'  => array(
                'page_link'  => esc_html__('Page Link', 'k2_text_domain'),
                'custom_link'  => esc_html__('Custom Link', 'k2_text_domain'),
                'contact_form'  => esc_html__('Popup Contact Form 7', 'k2_text_domain'),
            ),
            'default'  => 'page_link',
        ),
        array(
            'id'    => 'h_btn_page_link',
            'type'  => 'select',
            'title' => esc_html__( 'Page Link', 'k2_text_domain' ), 
            'data'  => 'page',
            'args'  => array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ),
            'required' => array( 0 => 'h_btn_link_type', 1 => 'equals', 2 => 'page_link' ),
            'force_output' => true
        ),
        array(
            'id' => 'h_btn_custom_link',
            'type' => 'text',
            'title' => esc_html__('Custom Link', 'k2_text_domain'),
            'default' => '',
            'required' => array( 0 => 'h_btn_link_type', 1 => 'equals', 2 => 'custom_link' ),
            'force_output' => true
        ),
        array(
            'id' => 'title_contact_form',
            'type' => 'text',
            'title' => esc_html__('Title Contact Form', 'k2_text_domain'),
            'default' => '',
            'required' => array( 0 => 'h_btn_link_type', 1 => 'equals', 2 => 'contact_form' ),
            'force_output' => true
        ),
        array(
            'id'       => 'popup_contact_form',
            'type'     => 'select',
            'title'    => __('Select Contact Form', 'k2_text_domain'), 
            'options'  => $contact_forms,
            'default'  => '',
            'required' => array( 0 => 'h_btn_link_type', 1 => 'equals', 2 => 'contact_form' ),
            'force_output' => true
        ),
        array(
            'id'=>'footer_contact_form',
            'type' => 'textarea',
            'title' => esc_html__('Footer Contact Form', 'k2_text_domain'),
            'validate' => 'html_custom',
            'default' => '',
            'allowed_html' => array(
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'class' => array(),
                ),
                'br' => array(),
                'em' => array(),
                'strong' => array(),
                'span' => array(),
                'p' => array(),
                'div' => array(
                    'class' => array()
                ),
                'h1' => array(
                    'class' => array()
                ),
                'h2' => array(
                    'class' => array()
                ),
                'h3' => array(
                    'class' => array()
                ),
                'h4' => array(
                    'class' => array()
                ),
                'h5' => array(
                    'class' => array()
                ),
                'h6' => array(
                    'class' => array()
                ),
                'ul' => array(
                    'class' => array()
                ),
                'li' => array(),
            ),
            'required' => array( 0 => 'h_btn_link_type', 1 => 'equals', 2 => 'contact_form' ),
            'force_output' => true
        ),
        array(
            'id'       => 'h_btn_target',
            'type'     => 'button_set',
            'title'    => esc_html__('Button Target', 'k2_text_domain'),
            'options'  => array(
                '_self'  => esc_html__('Self', 'k2_text_domain'),
                '_blank'  => esc_html__('Blank', 'k2_text_domain')
            ),
            'default'  => '_self',
        ),
    )
));

/*--------------------------------------------------------------
# Page Title area
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Page Title', 'k2_text_domain'),
    'icon'   => 'el-icon-map-marker',
    'fields' => array(
        array(
            'id'       => 'ptitle_layout',
            'type'     => 'image_select',
            'title'    => esc_html__('Layout', 'k2_text_domain'),
            'subtitle' => esc_html__('Select a layout for page title.', 'k2_text_domain'),
            'options'  => array(
                '0' => get_template_directory_uri() . '/assets/images/page-title-layout/p0.jpg',
                '1' => get_template_directory_uri() . '/assets/images/page-title-layout/p1.jpg',
            ),
            'default'  => '1'
        ),
        array(
            'id'       => 'ptitle_overlay_style',
            'type'     => 'select',
            'title'    => __('Overlay Style', 'k2_text_domain'),
            'options'  => array(
                'secondary' => 'Gradient Secondary',
                'white' => 'Gradient White',
                'dotted' => 'Dotted Overlay',
                'default' => 'Custom Color',
                'none' => 'None',
            ),
            'default'  => 'secondary',
        ),
        array(
            'id'       => 'ptitle_bg_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__('Select Color', 'k2_text_domain'),
            'required' => array( 0 => 'ptitle_overlay_style', 1 => 'equals', 2 => 'default' ),
            'force_output' => true
        ),
        array(
            'id'       => 'ptitle_bg',
            'type'     => 'background',
            'title'    => esc_html__('Background', 'k2_text_domain'),
            'subtitle' => esc_html__('Page title background.', 'k2_text_domain'),
            'output'   => array('#pagetitle'),
            'background-color'   => false,
        ),
        array(
            'id'       => 'ptitle_paddings',
            'type'     => 'spacing',
            'title'    => esc_html__('Content Paddings', 'k2_text_domain'),
            'subtitle' => esc_html__('Content page title paddings.', 'k2_text_domain'),
            'mode'     => 'padding',
            'units'    => array('em', 'px', '%'),
            'top'      => true,
            'right'    => false,
            'bottom'   => true,
            'left'     => false,
            'output'   => array('#pagetitle'),
            'default'  => array(
                'top'    => '',
                'right'  => '',
                'bottom' => '',
                'left'   => '',
                'units'  => 'px',
            )
        ),
        array(
            'id'       => 'ptitle_paddings_sm',
            'type'     => 'spacing',
            'title'    => esc_html__('Content Paddings Tablet & Mobile', 'k2_text_domain'),
            'subtitle' => esc_html__('Content page title paddings for Tablet & Mobile.', 'k2_text_domain'),
            'mode'     => 'padding',
            'units'    => array('em', 'px', '%'),
            'top'      => true,
            'right'    => false,
            'bottom'   => true,
            'left'     => false,
            'default'  => array(
                'top'    => '',
                'right'  => '',
                'bottom' => '',
                'left'   => '',
                'units'  => 'px',
            )
        ),
        array(
            'id'       => 'ptitle_content_align',
            'type'     => 'button_set',
            'title'    => esc_html__('Content Align', 'k2_text_domain'),
            'options'  => array(
                'left'  => esc_html__('Left', 'k2_text_domain'),
                'center'  => esc_html__('Center', 'k2_text_domain'),
                'right' => esc_html__('Right', 'k2_text_domain'),
            ),
            'default'  => 'center'
        ),
        array(
            'title' => esc_html__('Title', 'k2_text_domain'),
            'type'  => 'section',
            'id' => 'pt_title',
            'indent' => true
        ),
        array(
            'id'       => 'ptitle_color',
            'type'     => 'color',
            'title'    => esc_html__('Title Color', 'k2_text_domain'),
            'subtitle' => esc_html__('Page title color.', 'k2_text_domain'),
            'output'   => array('#pagetitle h1.page-title'),
            'default'  => '',
            'transparent' => false,
        ),
        array(
            'id'       => 'ptitle_font_size',
            'type'     => 'text',
            'title'    => esc_html__('Font Size', 'k2_text_domain'),
            'validate' => 'numeric',
            'desc'     => 'Enter number',
            'msg'      => 'Please enter number',
            'default'  => ''
        ),
        array(
            'id'       => 'ptitle_line_hegiht',
            'type'     => 'text',
            'title'    => esc_html__('Line Height', 'k2_text_domain'),
            'validate' => 'numeric',
            'desc'     => 'Enter number',
            'msg'      => 'Please enter number',
            'default'  => ''
        ),
        array(
            'title' => esc_html__('Breadcrumb', 'k2_text_domain'),
            'type'  => 'section',
            'id' => 'pt_breadcrumb',
            'indent' => true
        ),
        array(
            'id'      => 'breadcrumb_on',
            'type'    => 'switch',
            'title'   => esc_html__('Breadcrumb', 'k2_text_domain'),
            'default' => false
        ),
    )
));

/*--------------------------------------------------------------
# WordPress default content
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title' => esc_html__('Content', 'k2_text_domain'),
    'icon'  => 'el-icon-pencil',
    'fields'     => array(
        array(
            'id'       => 'content_bg_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__('Background Color', 'k2_text_domain'),
            'subtitle' => esc_html__('Content background color.', 'k2_text_domain'),
            'output' => array('background-color' => '#content')
        ),
        array(
            'id'             => 'content_padding',
            'type'           => 'spacing',
            'output'         => array('#content, .single-portfolio-renovation .site-main > .post-type-inner, .single-portfolio-construction-company .site-main > .post-type-inner, .single-service-construction-company .site-main > .post-type-inner'),
            'right'   => false,
            'left'    => false,
            'mode'           => 'padding',
            'units'          => array('px'),
            'units_extended' => 'false',
            'title'          => esc_html__('Content Padding', 'k2_text_domain'),
            'desc'           => esc_html__('Default: Top-85px, Bottom-85px', 'k2_text_domain'),
            'default'            => array(
                'padding-top'   => '',
                'padding-bottom'   => '',
                'units'          => 'px',
            )
        ),
        array(
            'id'       => 'content_sidebar_space',
            'type'     => 'text',
            'title'    => esc_html__('Content & Sidebar Space', 'k2_text_domain'),
            'validate' => 'numeric',
            'desc'     => 'Enter number (Default 60).',
            'msg'      => 'Please enter number',
            'default'  => ''
        ),
        array(
            'id'       => 'sidebar_style',
            'type'     => 'select',
            'title'    => __('Sidebar Styles', 'k2_text_domain'),
            'options'  => array(
                'default' => 'Default',
                'industrial' => 'Industrial',
                'corporate' => 'Corporate',
                'conversion' => 'Conversion',
                'real-estate' => 'Real Estate',
                'construction-company' => 'General Construction Company',
            ),
            'default'  => 'default',
        ),
        array(
            'id'      => 'search_field_placeholder',
            'type'    => 'text',
            'title'   => esc_html__('Search Form - Text Placeholder', 'k2_text_domain'),
            'default' => '',
            'desc'           => esc_html__('Default: Search Keywords...', 'k2_text_domain'),
        ),
    )
));


Redux::setSection($opt_name, array(
    'title'      => esc_html__('Archive', 'k2_text_domain'),
    'icon'       => 'el-icon-list',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'archive_sidebar_pos',
            'type'     => 'button_set',
            'title'    => esc_html__('Sidebar Position', 'k2_text_domain'),
            'subtitle' => esc_html__('Select a sidebar position for blog home, archive, search...', 'k2_text_domain'),
            'options'  => array(
                'left'  => esc_html__('Left', 'k2_text_domain'),
                'right' => esc_html__('Right', 'k2_text_domain'),
                'none'  => esc_html__('Disabled', 'k2_text_domain')
            ),
            'default'  => 'right'
        ),
        array(
            'id'       => 'archive_author_on',
            'title'    => esc_html__('Author', 'k2_text_domain'),
            'subtitle' => esc_html__('Show author name on each post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false,
        ),
        array(
            'id'       => 'archive_date_on',
            'title'    => esc_html__('Date', 'k2_text_domain'),
            'subtitle' => esc_html__('Show date posted on each post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => true,
        ),
        array(
            'id'       => 'archive_categories_on',
            'title'    => esc_html__('Categories', 'k2_text_domain'),
            'subtitle' => esc_html__('Show category names on each post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => true,
        ),
        array(
            'id'       => 'archive_sticky_on',
            'title'    => esc_html__('Sticky', 'k2_text_domain'),
            'subtitle' => esc_html__('Show sticky on each post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false
        ),
        array(
            'id'       => 'archive_comments_on',
            'title'    => esc_html__('Comments', 'k2_text_domain'),
            'subtitle' => esc_html__('Show comments count on each post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false,
        ),
        array(
            'id'       => 'pagination_style',
            'type'     => 'select',
            'title'    => __('Pagination Styles', 'k2_text_domain'),
            'options'  => array(
                'default' => 'Default',
                'renovation' => 'Renovation',
                'industrial' => 'Industrial',
                'real-estate' => 'Real Estate',
            ),
            'default'  => 'default',
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Single Post', 'k2_text_domain'),
    'icon'       => 'el-icon-file-edit',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'single_post_layout',
            'type'     => 'image_select',
            'title'    => esc_html__('Post Blog Layout', 'k2_text_domain'),
            'subtitle' => esc_html__('Select a layout for post blog.', 'k2_text_domain'),
            'options'  => array(
                'default' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-blog1.jpg',
                'renovation' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-blog2.jpg',
                'industrial' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-blog3.jpg',
                'corporate' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-blog4.jpg',
                'conversion' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-blog5.jpg',
                'real-estate' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-blog6.jpg',
                'construction-company' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-blog7.jpg',
            ),
            'default'  => 'default'
        ),
        array(
            'id'          => 'post_bg_color',
            'type'        => 'color',
            'title'       => esc_html__('Content Background Color', 'k2_text_domain'),
            'transparent' => false,
            'default'     => '',
            'required' => array( 0 => 'single_post_layout', 1 => 'equals', 2 => 'real-estate' ),
            'force_output' => true
        ),
        array(
            'id'       => 'post_sidebar_pos',
            'type'     => 'button_set',
            'title'    => esc_html__('Sidebar Position', 'k2_text_domain'),
            'subtitle' => esc_html__('Select a sidebar position', 'k2_text_domain'),
            'options'  => array(
                'left'  => esc_html__('Left', 'k2_text_domain'),
                'right' => esc_html__('Right', 'k2_text_domain'),
                'none'  => esc_html__('Disabled', 'k2_text_domain')
            ),
            'default'  => 'right'
        ),
        array(
            'id'       => 'post_author_on',
            'title'    => esc_html__('Author', 'k2_text_domain'),
            'subtitle' => esc_html__('Show author name on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => true
        ),
        array(
            'id'       => 'post_date_on',
            'title'    => esc_html__('Date', 'k2_text_domain'),
            'subtitle' => esc_html__('Show date on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => true
        ),
        array(
            'id'       => 'post_categories_on',
            'title'    => esc_html__('Categories', 'k2_text_domain'),
            'subtitle' => esc_html__('Show category names on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => true
        ),
        array(
            'id'       => 'post_tags_on',
            'title'    => esc_html__('Tags', 'k2_text_domain'),
            'subtitle' => esc_html__('Show tag names on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => true
        ),
        array(
            'id'       => 'post_comments_on',
            'title'    => esc_html__('Comments', 'k2_text_domain'),
            'subtitle' => esc_html__('Show comments count on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => true
        ),
        array(
            'id'       => 'post_sticky_on',
            'title'    => esc_html__('Sticky', 'k2_text_domain'),
            'subtitle' => esc_html__('Show sticky on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false
        ),
        array(
            'id'       => 'post_social_share_on',
            'title'    => esc_html__('Social Share', 'k2_text_domain'),
            'subtitle' => esc_html__('Show social share on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false,
            'required' => array( 0 => 'single_post_layout', 1 => 'equals', 2 => 'default' ),
            'force_output' => true
        ),
        array(
            'id'       => 'post_social_share_on_industrial',
            'title'    => esc_html__('Social Share', 'k2_text_domain'),
            'subtitle' => esc_html__('Show social share on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false,
            'required' => array( 0 => 'single_post_layout', 1 => 'equals', 2 => 'industrial' ),
            'force_output' => true
        ),
        array(
            'id'       => 'post_social_share_on_con_company',
            'title'    => esc_html__('Social Share', 'k2_text_domain'),
            'subtitle' => esc_html__('Show social share on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false,
            'required' => array( 0 => 'single_post_layout', 1 => 'equals', 2 => 'construction-company' ),
            'force_output' => true
        ),
        array(
            'id'       => 'post_social_share_on_conversion',
            'title'    => esc_html__('Social Share', 'k2_text_domain'),
            'subtitle' => esc_html__('Show social share on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false,
            'required' => array( 0 => 'single_post_layout', 1 => 'equals', 2 => 'conversion' ),
            'force_output' => true
        ),
        array(
            'id'       => 'post_social_share_on_real',
            'title'    => esc_html__('Social Share', 'k2_text_domain'),
            'subtitle' => esc_html__('Show social share on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false,
            'required' => array( 0 => 'single_post_layout', 1 => 'equals', 2 => 'real-estate' ),
            'force_output' => true
        ),
        array(
            'id'       => 'post_comments_form_on',
            'title'    => esc_html__('Comments Form', 'k2_text_domain'),
            'subtitle' => esc_html__('Show comments form on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => true
        ),
        array(
            'id'       => 'post_navigation_link_on',
            'title'    => esc_html__('Navigation Links', 'k2_text_domain'),
            'subtitle' => esc_html__('Show navigation link info on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false,
            'required' => array( 0 => 'single_post_layout', 1 => 'equals', 2 => 'renovation' ),
            'force_output' => true
        ),
        array(
            'id'       => 'post_navigation_link_on_industrial',
            'title'    => esc_html__('Navigation Links', 'k2_text_domain'),
            'subtitle' => esc_html__('Show navigation link info on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false,
            'required' => array( 0 => 'single_post_layout', 1 => 'equals', 2 => 'industrial' ),
            'force_output' => true
        ),
        array(
            'id'       => 'post_author_info_on',
            'title'    => esc_html__('Author Info', 'k2_text_domain'),
            'subtitle' => esc_html__('Author info on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false,
            'required' => array( 0 => 'single_post_layout', 1 => 'equals', 2 => 'industrial' ),
            'force_output' => true
        ),
        array(
            'id'       => 'post_author_info_real_on',
            'title'    => esc_html__('Author Info', 'k2_text_domain'),
            'subtitle' => esc_html__('Author info on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false,
            'required' => array( 0 => 'single_post_layout', 1 => 'equals', 2 => 'real-estate' ),
            'force_output' => true
        ),
        array(
            'id'       => 'post_author_info_con_company',
            'title'    => esc_html__('Author Info', 'k2_text_domain'),
            'subtitle' => esc_html__('Author info on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false,
            'required' => array( 0 => 'single_post_layout', 1 => 'equals', 2 => 'construction-company' ),
            'force_output' => true
        ),
        array(
            'id'       => 'post_feature_image_on',
            'title'    => esc_html__('Feature Image', 'k2_text_domain'),
            'subtitle' => esc_html__('Show feature image on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false
        ),
        array(
            'id'       => 'post_related_on_conversion',
            'title'    => esc_html__('Related Post', 'k2_text_domain'),
            'subtitle' => esc_html__('Show related post on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false,
            'required' => array( 0 => 'single_post_layout', 1 => 'equals', 2 => 'conversion' ),
            'force_output' => true
        ),
        array(
            'id'       => 'post_related_on_con_company',
            'title'    => esc_html__('Related Post', 'k2_text_domain'),
            'subtitle' => esc_html__('Show related post on single post.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => false,
            'required' => array( 0 => 'single_post_layout', 1 => 'equals', 2 => 'construction-company' ),
            'force_output' => true
        ),
        array(
            'id'       => 'post_ptitle_paddings',
            'type'     => 'spacing',
            'title'    => esc_html__('Content Paddings', 'k2_text_domain'),
            'subtitle' => esc_html__('Content page title paddings on single post.', 'k2_text_domain'),
            'mode'     => 'padding',
            'units'    => array('em', 'px', '%'),
            'top'      => true,
            'right'    => false,
            'bottom'   => true,
            'left'     => false,
            'output'   => array('body.single-post #pagetitle'),
            'default'  => array(
                'top'    => '',
                'right'  => '',
                'bottom' => '',
                'left'   => '',
                'units'  => 'px',
            )
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Single Services', 'k2_text_domain'),
    'icon'       => 'el el-cog',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'singe_service_layout',
            'type'     => 'image_select',
            'title'    => esc_html__('Service Layout', 'k2_text_domain'),
            'subtitle' => esc_html__('Select a layout for service.', 'k2_text_domain'),
            'options'  => array(
                'default' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-service1.jpg',
                'renovation' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-service2.jpg',
                'industrial' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-service3.jpg',
                'corporate' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-service4.jpg',
                'conversion' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-service5.jpg',
                'estate' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-service6.jpg',
                'construction-company' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-service7.jpg',
            ),
            'default'  => 'default'
        ),
        array(
            'id'          => 'sg_service_bg_color',
            'type'        => 'color',
            'title'       => esc_html__('Content Background Color', 'k2_text_domain'),
            'transparent' => false,
            'default'     => '',
            'required' => array( 0 => 'singe_service_layout', 1 => 'equals', 2 => 'estate' ),
            'force_output' => true
        ),
        array(
            'id'       => 'service_related_on',
            'title'    => esc_html__('Related Service', 'k2_text_domain'),
            'subtitle' => esc_html__('Show related service on single service.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => true,
            'required' => array( 0 => 'singe_service_layout', 1 => 'equals', 2 => 'construction-company' ),
            'force_output' => true
        ),
        array(
            'id'    => 'all_services_page',
            'type'  => 'select',
            'title' => esc_html__( 'All Services Page', 'k2_text_domain' ),
            'data'  => 'page',
            'args'  => array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
            )
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Single Portfolio', 'k2_text_domain'),
    'icon'       => 'el el-briefcase',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'singe_portfolio_layout',
            'type'     => 'image_select',
            'title'    => esc_html__('Portfolio Layout', 'k2_text_domain'),
            'subtitle' => esc_html__('Select a layout for portfolio.', 'k2_text_domain'),
            'options'  => array(
                'default' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-portfolio1.jpg',
                'renovation' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-portfolio2.jpg',
                'industrial' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-portfolio3.jpg',
                'corporate' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-portfolio4.jpg',
                'conversion' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-portfolio5.jpg',
                'estate' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-portfolio6.jpg',
                'construction-company' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-portfolio7.jpg',
            ),
            'default'  => 'default'
        ),
        array(
            'id'          => 'sg_portfolio_bg_color',
            'type'        => 'color',
            'title'       => esc_html__('Content Background Color', 'k2_text_domain'),
            'transparent' => false,
            'default'     => '',
            'required' => array( 0 => 'singe_portfolio_layout', 1 => 'equals', 2 => 'estate' ),
            'force_output' => true
        ),
        array(
            'id'       => 'portfolio_related_on',
            'title'    => esc_html__('Related Service', 'k2_text_domain'),
            'subtitle' => esc_html__('Show related portfolio on single portfolio.', 'k2_text_domain'),
            'type'     => 'switch',
            'default'  => true,
            'required' => array( 0 => 'singe_portfolio_layout', 1 => 'equals', 2 => 'construction-company' ),
            'force_output' => true
        ),
        array(
            'id'    => 'all_portfolio_page',
            'type'  => 'select',
            'title' => esc_html__( 'All Portfolio Page', 'k2_text_domain' ),
            'data'  => 'page',
            'args'  => array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
            )
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Single Careers', 'k2_text_domain'),
    'icon'       => 'el el-folder-open',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'singe_careers_layout',
            'type'     => 'image_select',
            'title'    => esc_html__('Careers Layout', 'k2_text_domain'),
            'subtitle' => esc_html__('Select a layout for career.', 'k2_text_domain'),
            'options'  => array(
                'default' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-careers1.jpg',
                'corporate' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-careers2.jpg',
                'construction-company' => get_template_directory_uri() . '/assets/images/post-type-layout/sg-careers3.jpg',
            ),
            'default'  => 'default'
        ),
        array(
            'id'    => 'all_careers_page',
            'type'  => 'select',
            'title' => esc_html__( 'All Careers Page', 'k2_text_domain' ),
            'data'  => 'page',
            'args'  => array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
            )
        ),
    )
));

/*--------------------------------------------------------------
# Footer
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Footer', 'k2_text_domain'),
    'icon'   => 'el el-website',
    'fields' => array(
        array(
            'id'       => 'footer_layout',
            'type'     => 'image_select',
            'title'    => esc_html__('Layout', 'k2_text_domain'),
            'subtitle' => esc_html__('Select a layout for upper footer area.', 'k2_text_domain'),
            'options'  => array(
                '1' => get_template_directory_uri() . '/assets/images/footer-layout/f1.jpg',
                '2' => get_template_directory_uri() . '/assets/images/footer-layout/f2.jpg',
                '3' => get_template_directory_uri() . '/assets/images/footer-layout/f3.jpg',
                '4' => get_template_directory_uri() . '/assets/images/footer-layout/f4.jpg',
                '5' => get_template_directory_uri() . '/assets/images/footer-layout/f5.jpg',
                '6' => get_template_directory_uri() . '/assets/images/footer-layout/f6.jpg',
            ),
            'default'  => '1'
        ),
        array(
            'id'       => 'footer_bg_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__('Background Overlay', 'k2_text_domain'),
            'subtitle' => esc_html__('Footer top background color overlay', 'k2_text_domain'),
            'output' => array('background-color' => '.top-footer')
        ),
        array(
            'id'       => 'footer_bg',
            'type'     => 'background',
            'title'    => esc_html__('Background', 'k2_text_domain'),
            'subtitle' => esc_html__('Footer background.', 'k2_text_domain'),
            'default'  => '',
            'output'   => array('.top-footer'),
            'background-color'   => false,
        ),
        array(
            'id'       => 'back_totop_on',
            'type'     => 'switch',
            'title'    => esc_html__('Back to Top Button', 'k2_text_domain'),
            'subtitle' => esc_html__('Show back to top button when scrolled down.', 'k2_text_domain'),
            'default'  => true
        ),
        array(
            'id'       => 'back_totop_style',
            'type'     => 'select',
            'title'    => __('Back to Top Styles', 'k2_text_domain'),
            'options'  => array(
                'default' => 'Default',
                'renovation' => 'Renovation',
                'industrial' => 'Industrial',
                'corporate' => 'Corporate',
            ),
            'default'  => 'default',
            'required' => array( 0 => 'back_totop_on', 1 => 'equals', 2 => '1' ),
            'force_output' => true
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Footer Top', 'k2_text_domain'),
    'icon'       => 'el el-circle-arrow-right',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'footer_top_column',
            'type'     => 'button_set',
            'title'    => esc_html__('Columns', 'k2_text_domain'),
            'options'  => array(
                '2'  => esc_html__('2 Column', 'k2_text_domain'),
                '3'  => esc_html__('3 Column', 'k2_text_domain'),
                '4'  => esc_html__('4 Column', 'k2_text_domain'),
            ),
            'default'  => '4',
        ),
        array(
            'id'       => 'footer_top_custom_width',
            'type'     => 'button_set',
            'title'    => esc_html__('Custom Width Column', 'k2_text_domain'),
            'options'  => array(
                'custom-width'  => esc_html__('Yes', 'k2_text_domain'),
                'default-width'  => esc_html__('No', 'k2_text_domain'),
            ),
            'default'  => 'default-width',
            'required' => array( 0 => 'footer_top_column', 1 => 'equals', 2 => '4' ),
            'force_output' => true
        ),
        array(
            'id'       => 'footer_top_custom_width_f5',
            'type'     => 'button_set',
            'title'    => esc_html__('Custom Width Column', 'k2_text_domain'),
            'options'  => array(
                'custom-width'  => esc_html__('Yes', 'k2_text_domain'),
                'default-width'  => esc_html__('No', 'k2_text_domain'),
            ),
            'default'  => 'default-width',
            'required' => array(
                array('footer_top_column','equals','3'),
                array('footer_layout','equals','5')
            ),
            'force_output' => true
        ),
        array(
            'id'       => 'footer_top_custom_width_f6',
            'type'     => 'button_set',
            'title'    => esc_html__('Custom Width Column', 'k2_text_domain'),
            'options'  => array(
                'custom-width'  => esc_html__('Yes', 'k2_text_domain'),
                'default-width'  => esc_html__('No', 'k2_text_domain'),
            ),
            'default'  => 'default-width',
            'required' => array(
                array('footer_top_column','equals','3'),
                array('footer_layout','equals','6')
            ),
            'force_output' => true
        ),
        array(
            'id'       => 'footer_top_paddings',
            'type'     => 'spacing',
            'title'    => esc_html__('Paddings', 'k2_text_domain'),
            'subtitle' => esc_html__('Footer top paddings.', 'k2_text_domain'),
            'mode'     => 'padding',
            'units'    => array('px'),
            'right'    => false,
            'left'     => false,
            'default'  => array(
                'padding-top'    => '',
                'padding-bottom' => ''
            ),
        ),
        array(
            'id'    => 'footer_top_color',
            'type'  => 'color',
            'title' => esc_html__('Text Color', 'k2_text_domain'),
            'output'   => array('.top-footer')
        ),
        array(
            'id'      => 'footer_top_link_color',
            'type'    => 'link_color',
            'title'   => esc_html__('Links Color', 'k2_text_domain'),
            'regular' => true,
            'hover'   => true,
            'active'  => true,
            'visited' => true,
            'output'  => array('.top-footer a'),
        ),
        array(
            'title' => esc_html__('Widget Title', 'k2_text_domain'),
            'type'  => 'section',
            'id' => 'footer_wg_title',
            'indent' => true,
        ),
        array(
            'id'    => 'footer_top_heading_color',
            'type'  => 'color',
            'title' => esc_html__('Title Color', 'k2_text_domain'),
        ),
        array(
            'id'       => 'footer_top_heading_fs',
            'type'     => 'text',
            'title'    => esc_html__('Font Size', 'k2_text_domain'),
            'validate' => 'numeric',
            'desc'     => 'Enter number',
            'msg'      => 'Please enter number',
            'default'  => ''
        ),
        array(
            'id'       => 'footer_top_heading_tt',
            'type'     => 'select',
            'title'    => esc_html__('Text Transform', 'k2_text_domain'),
            'options'  => array(
                ''  => esc_html__('Capitalize', 'k2_text_domain'),
                'uppercase' => esc_html__('Uppercase', 'k2_text_domain'),
                'lowercase'  => esc_html__('Lowercase', 'k2_text_domain'),
                'initial'  => esc_html__('Initial', 'k2_text_domain'),
                'inherit'  => esc_html__('Inherit', 'k2_text_domain'),
                'none'  => esc_html__('None', 'k2_text_domain'),
            ),
            'default'  => ''
        ),
        array(
            'title' => esc_html__('Quick Contact', 'k2_text_domain'),
            'type'  => 'section',
            'id' => 'quick_contact',
            'indent' => true,
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '5' ),
        ),
        array(
            'id' => 'footer_contact_phone_label',
            'type' => 'text',
            'title' => esc_html__('Phone Label', 'k2_text_domain'),
            'default' => '',
            'desc' => 'Ex: Telephone:',
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '5' ),
        ),
        array(
            'id' => 'footer_contact_phone',
            'type' => 'text',
            'title' => esc_html__('Phone', 'k2_text_domain'),
            'default' => '',
            'desc' => 'Ex: 222-145-1425',
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '5' ),
        ),
        array(
            'id' => 'footer_contact_email_label',
            'type' => 'text',
            'title' => esc_html__('Email Label', 'k2_text_domain'),
            'default' => '',
            'desc' => 'Ex: Email:',
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '5' ),
        ),
        array(
            'id' => 'footer_contact_email',
            'type' => 'text',
            'title' => esc_html__('Email', 'k2_text_domain'),
            'default' => '',
            'desc' => 'Ex: contact@example.com',
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '5' ),
        ),
        array(
            'title' => esc_html__('Call To Action', 'k2_text_domain'),
            'type'  => 'section',
            'id' => 'call_to_action',
            'indent' => true,
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '1' ),
        ),
        array(
            'id'      => 'footer_cta_title',
            'type'    => 'text',
            'title'   => esc_html__('Title', 'k2_text_domain'),
            'default' => '',
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '1' ),
        ),
        array(
            'id'      => 'footer_cta_email',
            'type'    => 'text',
            'title'   => esc_html__('Email', 'k2_text_domain'),
            'default' => '',
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '1' ),
        ),
        array(
            'id'      => 'footer_cta_phone',
            'type'    => 'text',
            'title'   => esc_html__('Phone', 'k2_text_domain'),
            'default' => '',
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '1' ),
        ),
        array(
            'title' => esc_html__('Quick Contact', 'k2_text_domain'),
            'type'  => 'section',
            'id' => 'quick_contact2',
            'indent' => true,
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '6' ),
        ),
        array(
            'id'=>'quick_contact_text1',
            'type' => 'textarea',
            'title' => esc_html__('Text 1', 'k2_text_domain'),
            'validate' => 'html_custom',
            'default' => '<h2>Not Sure Where to Begin?  Call Us Free on 456 - 421 - 9489</h2>',
            'subtitle' => esc_html__('Custom HTML Allowed: a,br,em,strong,span,p,div,h1->h6', 'k2_text_domain'),
            'allowed_html' => array(
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'class' => array(),
                ),
                'br' => array(),
                'em' => array(),
                'strong' => array(),
                'span' => array(),
                'p' => array(),
                'cite' => array(),
                'div' => array(
                    'class' => array()
                ),
                'h1' => array(
                    'class' => array()
                ),
                'h2' => array(
                    'class' => array()
                ),
                'h3' => array(
                    'class' => array()
                ),
                'h4' => array(
                    'class' => array()
                ),
                'h5' => array(
                    'class' => array()
                ),
                'h6' => array(
                    'class' => array()
                ),
                'ul' => array(
                    'class' => array()
                ),
                'li' => array(),
            ),
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '6' ),
        ),
        array(
            'id'=>'quick_contact_text2',
            'type' => 'textarea',
            'title' => esc_html__('Text 2', 'k2_text_domain'),
            'validate' => 'html_custom',
            'default' => 'Aenean tempus lectus eu laoreet ultrices. Aliquam accumsan, elit ut vehicula ullamcorper, nibh ex iaculis ligula, sit amet tincidunt lorem orci a sapien. Nunc ut tincidunt metus, a maximus odio. Duis tristique id nisl ac vestibulum. Mauris ut tellus a nunc volutpat accumsan in quis lacus. Duis rutrum, lorem sed placerat ullamcorper.',
            'subtitle' => esc_html__('Custom HTML Allowed: a,br,em,strong,span,p,div,h1->h6', 'k2_text_domain'),
            'allowed_html' => array(
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'class' => array(),
                ),
                'br' => array(),
                'em' => array(),
                'strong' => array(),
                'span' => array(),
                'p' => array(),
                'cite' => array(),
                'div' => array(
                    'class' => array()
                ),
                'h1' => array(
                    'class' => array()
                ),
                'h2' => array(
                    'class' => array()
                ),
                'h3' => array(
                    'class' => array()
                ),
                'h4' => array(
                    'class' => array()
                ),
                'h5' => array(
                    'class' => array()
                ),
                'h6' => array(
                    'class' => array()
                ),
                'ul' => array(
                    'class' => array()
                ),
                'li' => array(),
            ),
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '6' ),
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Footer Bottom', 'k2_text_domain'),
    'icon'       => 'el el-circle-arrow-right',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'=>'footer_copyright',
            'type' => 'textarea',
            'title' => esc_html__('Copyright', 'k2_text_domain'),
            'validate' => 'html_custom',
            'default' => '',
            'subtitle' => esc_html__('Custom HTML Allowed: a,br,em,strong,span,p,div,h1->h6', 'k2_text_domain'),
            'allowed_html' => array(
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'class' => array(),
                ),
                'br' => array(),
                'em' => array(),
                'strong' => array(),
                'span' => array(),
                'p' => array(),
                'div' => array(
                    'class' => array()
                ),
                'h1' => array(
                    'class' => array()
                ),
                'h2' => array(
                    'class' => array()
                ),
                'h3' => array(
                    'class' => array()
                ),
                'h4' => array(
                    'class' => array()
                ),
                'h5' => array(
                    'class' => array()
                ),
                'h6' => array(
                    'class' => array()
                ),
                'ul' => array(
                    'class' => array()
                ),
                'li' => array(),
            )
        ),
        array(
            'id'      => 'footer_social',
            'type'    => 'sorter',
            'title'   => 'Social',
            'desc'    => 'Choose which social networks are displayed and edit where they link to.',
            'options' => array(
                'enabled'  => array(
                    'facebook'  => 'Facebook', 
                    'twitter'   => 'Twitter', 
                    'instagram' => 'Instagram',
                ),
                'disabled' => array(
                    'tripadvisor'     => 'Tripadvisor',
                    'google'    => 'Google',
                    'youtube'   => 'Youtube', 
                    'vimeo'     => 'Vimeo', 
                    'tumblr'    => 'Tumblr',
                    'pinterest' => 'Pinterest',
                    'yelp'      => 'Yelp',
                    'skype'     => 'Skype',
                    'linkedin'  => 'Linkedin',
                )
            ),
        ),
    )
));


/*--------------------------------------------------------------
# Colors
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Colors', 'k2_text_domain'),
    'icon'   => 'el-icon-file-edit',
    'fields' => array(
        array(
            'id'          => 'primary_color',
            'type'        => 'color',
            'title'       => esc_html__('Primary Color', 'k2_text_domain'),
            'transparent' => false,
            'default'     => '#ffc916'
        ),
        array(
            'id'          => 'secondary_color',
            'type'        => 'color',
            'title'       => esc_html__('Secondary Color', 'k2_text_domain'),
            'transparent' => false,
            'default'     => '#233050'
        ),
        array(
            'id'      => 'link_color',
            'type'    => 'link_color',
            'title'   => __('Link Colors', 'k2_text_domain'),
            'default' => array(
                'regular' => '#ffc916',
                'hover'   => '#f3bc0b',
                'active'  => '#f3bc0b'
            ),
            'output'  => array('a')
        )
    )
));

/*--------------------------------------------------------------
# Typography
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Typography', 'k2_text_domain'),
    'icon'   => 'el-icon-text-width',
    'fields' => array(
        array(
            'id'       => 'body_default_font',
            'type'     => 'select',
            'title'    => esc_html__('Body Default Font', 'k2_text_domain'),
            'options'  => array(
                'GT-Walsheim-Regular'  => esc_html__('GT Walsheim Regular', 'k2_text_domain'),
                'GT-Walsheim-Medium'  => esc_html__('GT Walsheim Medium', 'k2_text_domain'),
                'GT-Walsheim-Bold'  => esc_html__('GT Walsheim Bold', 'k2_text_domain'),
                'Nimbus-Sans-Regular'  => esc_html__('Nimbus Sans Regular', 'k2_text_domain'),
                'Nimbus-Sans-Bold'  => esc_html__('Nimbus Sans Bold', 'k2_text_domain'),
                'Maison-Neue-Mono'  => esc_html__('Maison Neue Mono', 'k2_text_domain'),
                'Maison-Neue-Bold'  => esc_html__('Maison Neue Bold', 'k2_text_domain'),
                'Proxima-Nova-Bold'  => esc_html__('Proxima Nova Bold', 'k2_text_domain'),
                'Proxima-Nova-Semibold'  => esc_html__('Proxima Nova Semibold', 'k2_text_domain'),
                'Proxima-Nova-Regular'  => esc_html__('Proxima Nova Regular', 'k2_text_domain'),
                'Calibre-Regular'  => esc_html__('Calibre Regular', 'k2_text_domain'),
                'Calibre-Medium'  => esc_html__('Calibre Medium', 'k2_text_domain'),
                'Calibre-Semibold'  => esc_html__('Calibre Semibold', 'k2_text_domain'),
                'Norwester'  => esc_html__('Norwester', 'k2_text_domain'),
                'inherit'  => esc_html__('Inherit', 'k2_text_domain'),
            ),
            'default'  => 'GT-Walsheim-Regular',
            'desc' => 'The selector & tag is used: .ft-main-r, body'
        ),
        array(
            'id'       => 'heading_default_font_medium',
            'type'     => 'select',
            'title'    => esc_html__('Heading Default Font Medium', 'k2_text_domain'),
            'options'  => array(
                'GT-Walsheim-Medium'  => esc_html__('GT Walsheim Medium', 'k2_text_domain'),
                'GT-Walsheim-Regular'  => esc_html__('GT Walsheim Regular', 'k2_text_domain'),
                'GT-Walsheim-Bold'  => esc_html__('GT Walsheim Bold', 'k2_text_domain'),
                'Nimbus-Sans-Regular'  => esc_html__('Nimbus Sans Regular', 'k2_text_domain'),
                'Nimbus-Sans-Bold'  => esc_html__('Nimbus Sans Bold', 'k2_text_domain'),
                'Maison-Neue-Mono'  => esc_html__('Maison Neue Mono', 'k2_text_domain'),
                'Maison-Neue-Bold'  => esc_html__('Maison Neue Bold', 'k2_text_domain'),
                'Proxima-Nova-Bold'  => esc_html__('Proxima Nova Bold', 'k2_text_domain'),
                'Proxima-Nova-Semibold'  => esc_html__('Proxima Nova Semibold', 'k2_text_domain'),
                'Proxima-Nova-Regular'  => esc_html__('Proxima Nova Regular', 'k2_text_domain'),
                'Calibre-Regular'  => esc_html__('Calibre Regular', 'k2_text_domain'),
                'Calibre-Medium'  => esc_html__('Calibre Medium', 'k2_text_domain'),
                'Calibre-Semibold'  => esc_html__('Calibre Semibold', 'k2_text_domain'),
                'Norwester'  => esc_html__('Norwester', 'k2_text_domain'),
                'inherit'  => esc_html__('Inherit', 'k2_text_domain'),
            ),
            'default'  => 'GT-Walsheim-Medium',
            'desc' => 'The selector & tag is used: .ft-heading-m, h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6'
        ),
        array(
            'id'       => 'heading_default_font_bold',
            'type'     => 'select',
            'title'    => esc_html__('Heading Default Font Bold', 'k2_text_domain'),
            'options'  => array(
                'GT-Walsheim-Bold'  => esc_html__('GT Walsheim Bold', 'k2_text_domain'),
                'GT-Walsheim-Medium'  => esc_html__('GT Walsheim Medium', 'k2_text_domain'),
                'GT-Walsheim-Regular'  => esc_html__('GT Walsheim Regular', 'k2_text_domain'),
                'Nimbus-Sans-Regular'  => esc_html__('Nimbus Sans Regular', 'k2_text_domain'),
                'Nimbus-Sans-Bold'  => esc_html__('Nimbus Sans Bold', 'k2_text_domain'),
                'Maison-Neue-Mono'  => esc_html__('Maison Neue Mono', 'k2_text_domain'),
                'Maison-Neue-Bold'  => esc_html__('Maison Neue Bold', 'k2_text_domain'),
                'Proxima-Nova-Bold'  => esc_html__('Proxima Nova Bold', 'k2_text_domain'),
                'Proxima-Nova-Semibold'  => esc_html__('Proxima Nova Semibold', 'k2_text_domain'),
                'Proxima-Nova-Regular'  => esc_html__('Proxima Nova Regular', 'k2_text_domain'),
                'Calibre-Regular'  => esc_html__('Calibre Regular', 'k2_text_domain'),
                'Calibre-Medium'  => esc_html__('Calibre Medium', 'k2_text_domain'),
                'Calibre-Semibold'  => esc_html__('Calibre Semibold', 'k2_text_domain'),
                'Norwester'  => esc_html__('Norwester', 'k2_text_domain'),
                'inherit'  => esc_html__('Inherit', 'k2_text_domain'),
            ),
            'default'  => 'GT-Walsheim-Bold',
            'desc' => 'The selector & tag is used: .ft-heading-b'
        ),
    )
));

$custom_font_selectors_1 = Redux::getOption($opt_name, 'custom_font_selectors_1');
$custom_font_selectors_1 = !empty($custom_font_selectors_1) ? explode(',', $custom_font_selectors_1) : array();

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Google Fonts', 'k2_text_domain'),
    'icon'       => 'el el-fontsize',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'          => 'font_main',
            'type'        => 'typography',
            'title'       => esc_html__('Main Font', 'k2_text_domain'),
            'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'k2_text_domain'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'line-height'  => true,
            'font-size'  => true,
            'text-align'  => false,
            'output'      => array('body'),
            'units'       => 'px'
        ),
        array(
            'id'          => 'font_h1',
            'type'        => 'typography',
            'title'       => esc_html__('H1', 'k2_text_domain'),
            'subtitle'    => esc_html__('Heading 1 typography.', 'k2_text_domain'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'output'      => array('h1', '.h1', '.text-heading'),
            'units'       => 'px'
        ),
        array(
            'id'          => 'font_h2',
            'type'        => 'typography',
            'title'       => esc_html__('H2', 'k2_text_domain'),
            'subtitle'    => esc_html__('Heading 2 typography.', 'k2_text_domain'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'output'      => array('h2', '.h2'),
            'units'       => 'px'
        ),
        array(
            'id'          => 'font_h3',
            'type'        => 'typography',
            'title'       => esc_html__('H3', 'k2_text_domain'),
            'subtitle'    => esc_html__('Heading 3 typography.', 'k2_text_domain'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'output'      => array('h3', '.h3'),
            'units'       => 'px'
        ),
        array(
            'id'          => 'font_h4',
            'type'        => 'typography',
            'title'       => esc_html__('H4', 'k2_text_domain'),
            'subtitle'    => esc_html__('Heading 4 typography.', 'k2_text_domain'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'output'      => array('h4', '.h4'),
            'units'       => 'px'
        ),
        array(
            'id'          => 'font_h5',
            'type'        => 'typography',
            'title'       => esc_html__('H5', 'k2_text_domain'),
            'subtitle'    => esc_html__('Heading 5 typography.', 'k2_text_domain'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'output'      => array('h5', '.h5'),
            'units'       => 'px'
        ),
        array(
            'id'          => 'font_h6',
            'type'        => 'typography',
            'title'       => esc_html__('H6', 'k2_text_domain'),
            'subtitle'    => esc_html__('Heading 6 typography.', 'k2_text_domain'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'output'      => array('h6', '.h6'),
            'units'       => 'px'
        )
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Fonts Selectors', 'k2_text_domain'),
    'icon'       => 'el el-fontsize',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'          => 'custom_font_1',
            'type'        => 'typography',
            'title'       => esc_html__('Custom Font', 'k2_text_domain'),
            'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'k2_text_domain'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'output'      => $custom_font_selectors_1,
            'units'       => 'px',

        ),
        array(
            'id'       => 'custom_font_selectors_1',
            'type'     => 'textarea',
            'title'    => esc_html__('CSS Selectors', 'k2_text_domain'),
            'subtitle' => esc_html__('Add css selectors to apply above font.', 'k2_text_domain'),
            'validate' => 'no_html'
        )
    )
));

/* Button */
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Buttons', 'k2_text_domain'),
    'icon'       => 'el el-briefcase',
    'subsection' => false,
    'fields'     => array(
        array(
            'id'          => 'font_button',
            'type'        => 'typography',
            'title'       => esc_html__('Button Font', 'k2_text_domain'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'font-style'  => false,
            'font-weight'  => true,
            'text-align'  => false,
            'font-size'  => true,
            'line-height'  => true,
            'color'  => false,
            'output'      => array('.btn, button, .button, input[type="submit"]'),
            'units'       => 'px'
        ),
        array(
            'id'      => 'button_color',
            'type'    => 'link_color',
            'title'   => esc_html__('Color', 'k2_text_domain'),
            'active'  => false,
            'default' => array(
                'regular' => '',
                'hover'   => '',
            ),
            'output'      => array('.btn, button, .button, input[type="submit"]'),
        ),
        array(
            'id'      => 'button_border_color',
            'type'    => 'link_color',
            'title'   => esc_html__('Border Color', 'k2_text_domain'),
            'active'  => false,
            'default' => array(
                'regular' => '',
                'hover'   => '',
            ),
        ),
        array(
            'id'       => 'button_bg_type_color',
            'type'     => 'button_set',
            'title'    => esc_html__('Background Color Type', 'k2_text_domain'),
            'options'  => array(
                'normal'  => esc_html__('Normal', 'k2_text_domain'),
                'gradient'  => esc_html__('Gradient', 'k2_text_domain'),
            ),
            'default'  => 'normal'
        ),
        array(
            'id'      => 'button_bg_color',
            'type'    => 'link_color',
            'title'   => esc_html__('Background Color', 'k2_text_domain'),
            'active'  => false,
            'default' => array(
                'regular' => '',
                'hover'   => '',
            ),
            'required' => array( 0 => 'button_bg_type_color', 1 => 'equals', 2 => 'normal' ),
            'force_output' => true
        ),
        array(
            'id'       => 'button_bg_gradient_color',
            'type'     => 'color_gradient',
            'title'    => esc_html__('Gradient Color Regular', 'k2_text_domain'),
            'validate' => 'color',
            'transparent' => false,
            'default'  => array(
                'from' => '',
                'to'   => '', 
            ),
            'required' => array( 0 => 'button_bg_type_color', 1 => 'equals', 2 => 'gradient' ),
            'force_output' => true
        ),
        array(
            'id'       => 'button_bg_gradient_color_hover',
            'type'     => 'color_gradient',
            'title'    => esc_html__('Gradient Color Hover', 'k2_text_domain'),
            'validate' => 'color',
            'transparent' => false,
            'default'  => array(
                'from' => '',
                'to'   => '', 
            ),
            'required' => array( 0 => 'button_bg_type_color', 1 => 'equals', 2 => 'gradient' ),
            'force_output' => true
        ),
        array(
            'id'       => 'button_border',
            'type'     => 'border',
            'title'    => __('Border', 'k2_text_domain'),
            'color' => false,
            'default'  => array(
                'border-color'  => '',
                'border-style'  => '',
                'border-top'    => '',
                'border-right'  => '',
                'border-bottom' => '',
                'border-left'   => ''
            )
        ),
        array(
            'id'       => 'button_border_radius',
            'type'     => 'spacing',
            'title'    => esc_html__('Border Radius', 'k2_text_domain'),
            'mode'     => 'padding',
            'top'      => true,
            'right'    => true,
            'bottom'   => true,
            'left'     => true,
            'units'     => false,
            'default'  => array(
                'top'    => '',
                'right'  => '',
                'bottom' => '',
                'left'   => '',
            ),
            'msg'      => 'Please enter number',
        ),
        array(
            'id'       => 'button_text_transform',
            'type'     => 'select',
            'title'    => esc_html__('Text Transform', 'k2_text_domain'),
            'options'  => array(
                ''  => esc_html__('Capitalize', 'k2_text_domain'),
                'uppercase' => esc_html__('Uppercase', 'k2_text_domain'),
                'lowercase'  => esc_html__('Lowercase', 'k2_text_domain'),
                'initial'  => esc_html__('Initial', 'k2_text_domain'),
                'inherit'  => esc_html__('Inherit', 'k2_text_domain'),
                'none'  => esc_html__('None', 'k2_text_domain'),
            ),
            'default'  => ''
        ),
        array(
            'id'       => 'button_padding',
            'type'     => 'spacing',
            'title'    => esc_html__('Padding', 'k2_text_domain'),
            'mode'     => 'padding',
            'units'    => array('em', 'px'),
            'top'      => true,
            'right'    => true,
            'bottom'   => true,
            'left'     => true,
            'default'  => array(
                'top'    => '',
                'right'  => '',
                'bottom' => '',
                'left'   => '',
                'units'  => 'px',
            ),
            'output'      => array('.btn, button, .button, input[type="submit"]'),
        ),
        array(
            'id'       => 'button_box_shadow',
            'type'     => 'switch',
            'title'    => esc_html__('Box Shadow', 'k2_text_domain'),
            'default'  => true
        ),
        array(
            'id'       => 'button_text_shadow',
            'type'     => 'switch',
            'title'    => esc_html__('Text Shadow', 'k2_text_domain'),
            'default'  => false
        ),
    )
));

/* Form Styles */
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Form Styles', 'k2_text_domain'),
    'icon'       => 'el el-upload',
    'subsection' => false,
    'fields'     => array(
        array(
            'id'       => 'field_default_font',
            'type'     => 'select',
            'title'    => esc_html__('Fields Default Font', 'k2_text_domain'),
            'options'  => array(
                'GT-Walsheim-Regular'  => esc_html__('GT Walsheim Regular', 'k2_text_domain'),
                'GT-Walsheim-Medium'  => esc_html__('GT Walsheim Medium', 'k2_text_domain'),
                'GT-Walsheim-Bold'  => esc_html__('GT Walsheim Bold', 'k2_text_domain'),
                'Nimbus-Sans-Regular'  => esc_html__('Nimbus Sans Regular', 'k2_text_domain'),
                'Nimbus-Sans-Bold'  => esc_html__('Nimbus Sans Bold', 'k2_text_domain'),
                'Maison-Neue-Mono'  => esc_html__('Maison Neue Mono', 'k2_text_domain'),
                'Maison-Neue-Bold'  => esc_html__('Maison Neue Bold', 'k2_text_domain'),
                'Proxima-Nova-Bold'  => esc_html__('Proxima Nova Bold', 'k2_text_domain'),
                'Proxima-Nova-Semibold'  => esc_html__('Proxima Nova Semibold', 'k2_text_domain'),
                'Proxima-Nova-Regular'  => esc_html__('Proxima Nova Regular', 'k2_text_domain'),
                'Calibre-Regular'  => esc_html__('Calibre Regular', 'k2_text_domain'),
                'Calibre-Medium'  => esc_html__('Calibre Medium', 'k2_text_domain'),
                'Calibre-Semibold'  => esc_html__('Calibre Semibold', 'k2_text_domain'),
                'Norwester'  => esc_html__('Norwester', 'k2_text_domain'),
                'inherit'  => esc_html__('Inherit', 'k2_text_domain'),
            ),
            'default'  => '',
        ),
        array(
            'id'          => 'font_field',
            'type'        => 'typography',
            'title'       => esc_html__('Fields Font', 'k2_text_domain'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'font-style'  => false,
            'font-weight'  => true,
            'text-align'  => false,
            'font-size'  => true,
            'line-height'  => false,
            'color'  => false,
            'output'      => array('input:not([type="submit"]), textarea, select, .nice-select'),
            'units'       => 'px'
        ),
        array(
            'id'      => 'field_color',
            'type'    => 'link_color',
            'title'   => esc_html__('Fields Color', 'k2_text_domain'),
            'hover'  => false,
            'default' => array(
                'regular' => '',
                'hover'   => '',
            ),
            'output'      => array('input:not([type="submit"]), textarea, select, .nice-select'),
        ),
        array(
            'id'      => 'field_border_color',
            'type'    => 'link_color',
            'title'   => esc_html__('Fields Border Color', 'k2_text_domain'),
            'hover'  => false,
            'default' => array(
                'regular' => '',
                'hover'   => '',
            ),
        ),
        array(
            'id'      => 'field_background_color',
            'type'    => 'link_color',
            'title'   => esc_html__('Fields Background Color', 'k2_text_domain'),
            'hover'  => false,
            'default' => array(
                'regular' => '',
                'hover'   => '',
            ),
        ),
        array(
            'id'       => 'field_border',
            'type'     => 'border',
            'title'    => __('Fields Border', 'k2_text_domain'),
            'color' => false,
            'default'  => array(
                'border-color'  => '',
                'border-style'  => '',
                'border-top'    => '',
                'border-right'  => '',
                'border-bottom' => '',
                'border-left'   => ''
            )
        ),
        array(
            'id'       => 'field_border_radius',
            'type'     => 'spacing',
            'title'    => esc_html__('Fields Border Radius', 'k2_text_domain'),
            'mode'     => 'padding',
            'top'      => true,
            'right'    => true,
            'bottom'   => true,
            'left'     => true,
            'units'     => false,
            'default'  => array(
                'top'    => '',
                'right'  => '',
                'bottom' => '',
                'left'   => '',
            ),
            'msg'      => 'Please enter number',
        ),
        array(
            'id'       => 'field_text_transform',
            'type'     => 'select',
            'title'    => esc_html__('Fields Text Transform', 'k2_text_domain'),
            'options'  => array(
                ''  => esc_html__('Capitalize', 'k2_text_domain'),
                'uppercase' => esc_html__('Uppercase', 'k2_text_domain'),
                'lowercase'  => esc_html__('Lowercase', 'k2_text_domain'),
                'initial'  => esc_html__('Initial', 'k2_text_domain'),
                'inherit'  => esc_html__('Inherit', 'k2_text_domain'),
                'none'  => esc_html__('None', 'k2_text_domain'),
            ),
            'default'  => ''
        ),
        array(
            'id'       => 'field_padding',
            'type'     => 'spacing',
            'title'    => esc_html__('Fields Padding', 'k2_text_domain'),
            'mode'     => 'padding',
            'units'    => array('em', 'px'),
            'top'      => true,
            'right'    => true,
            'bottom'   => true,
            'left'     => true,
            'default'  => array(
                'top'    => '',
                'right'  => '',
                'bottom' => '',
                'left'   => '',
                'units'  => 'px',
            ),
            'output'      => array('input:not([type="submit"]), textarea, select, .nice-select'),
        ),
        array(
            'id'       => 'field_box_shadow',
            'type'     => 'switch',
            'title'    => esc_html__('Fields Box Shadow', 'k2_text_domain'),
            'default'  => true
        ),
        array(
            'id'       => 'textarea_height',
            'type'     => 'text',
            'title'    => esc_html__('Textarea Height', 'k2_text_domain'),
            'validate' => 'numeric',
            'desc'     => 'Enter number',
            'msg'      => 'Please enter number',
            'default'  => ''
        ),
    )
));

/* Social Media */
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Social Media', 'k2_text_domain'),
    'icon'       => 'el el-twitter',
    'subsection' => false,
    'fields'     => array(
        array(
            'id'      => 'social_facebook_url',
            'type'    => 'text',
            'title'   => esc_html__('Facebook URL', 'k2_text_domain'),
            'default' => '',
        ),
        array(
            'id'      => 'social_twitter_url',
            'type'    => 'text',
            'title'   => esc_html__('Twitter URL', 'k2_text_domain'),
            'default' => '',
        ),
        array(
            'id'      => 'social_inkedin_url',
            'type'    => 'text',
            'title'   => esc_html__('Inkedin URL', 'k2_text_domain'),
            'default' => '',
        ),
        array(
            'id'      => 'social_rss_url',
            'type'    => 'text',
            'title'   => esc_html__('Rss URL', 'k2_text_domain'),
            'default' => '',
        ),
        array(
            'id'      => 'social_instagram_url',
            'type'    => 'text',
            'title'   => esc_html__('Instagram URL', 'k2_text_domain'),
            'default' => '',
        ),
        array(
            'id'      => 'social_google_url',
            'type'    => 'text',
            'title'   => esc_html__('Google URL', 'k2_text_domain'),
            'default' => '',
        ),
        array(
            'id'      => 'social_skype_url',
            'type'    => 'text',
            'title'   => esc_html__('Skype URL', 'k2_text_domain'),
            'default' => '',
        ),
        array(
            'id'      => 'social_pinterest_url',
            'type'    => 'text',
            'title'   => esc_html__('Pinterest URL', 'k2_text_domain'),
            'default' => '',
        ),
        array(
            'id'      => 'social_vimeo_url',
            'type'    => 'text',
            'title'   => esc_html__('Vimeo URL', 'k2_text_domain'),
            'default' => '',
        ),
        array(
            'id'      => 'social_youtube_url',
            'type'    => 'text',
            'title'   => esc_html__('Youtube URL', 'k2_text_domain'),
            'default' => '',
        ),
        array(
            'id'      => 'social_yelp_url',
            'type'    => 'text',
            'title'   => esc_html__('Yelp URL', 'k2_text_domain'),
            'default' => '',
        ),
        array(
            'id'      => 'social_tumblr_url',
            'type'    => 'text',
            'title'   => esc_html__('Tumblr URL', 'k2_text_domain'),
            'default' => '',
        ),
        array(
            'id'      => 'social_tripadvisor_url',
            'type'    => 'text',
            'title'   => esc_html__('Tripadvisor URL', 'k2_text_domain'),
            'default' => '',
        ),
    )
));

/* Custom Code /--------------------------------------------------------- */
Redux::setSection($opt_name, array(
    'title'  => esc_html__('Custom Code', 'k2_text_domain'),
    'icon'   => 'el-icon-edit',
    'fields' => array(

        array(
            'id'       => 'site_header_code',
            'type'     => 'textarea',
            'theme'    => 'chrome',
            'title'    => esc_html__('Header Custom Codes', 'k2_text_domain'),
            'subtitle' => esc_html__('It will insert the code to wp_head hook.', 'k2_text_domain'),
        ),
        array(
            'id'       => 'site_footer_code',
            'type'     => 'textarea',
            'theme'    => 'chrome',
            'title'    => esc_html__('Footer Custom Codes', 'k2_text_domain'),
            'subtitle' => esc_html__('It will insert the code to wp_footer hook.', 'k2_text_domain'),
        ),

    ),
));

/* Custom CSS /--------------------------------------------------------- */
Redux::setSection($opt_name, array(
    'title'  => esc_html__('Custom CSS', 'k2_text_domain'),
    'icon'   => 'el-icon-adjust-alt',
    'fields' => array(

        array(
            'id'   => 'customcss',
            'type' => 'info',
            'desc' => esc_html__('Custom CSS', 'k2_text_domain')
        ),

        array(
            'id'       => 'site_css',
            'type'     => 'ace_editor',
            'title'    => esc_html__('CSS Code', 'k2_text_domain'),
            'subtitle' => esc_html__('Advanced CSS Options. You can paste your custom CSS Code here.', 'k2_text_domain'),
            'mode'     => 'css',
            'validate' => 'css',
            'theme'    => 'chrome',
            'default'  => ""
        ),

    ),
));