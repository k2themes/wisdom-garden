<?php
/**
 * Include the TGM_Plugin_Activation class.
 */
require( get_template_directory() . '/inc/libs/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'k2_theme_frame_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
*/
function k2_theme_frame_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        array(
            'name'               => esc_html__('K2 Framework', 'k2_text_domain'),
            'slug'               => 'k2-framework',
            'source'             => esc_url('http://k2themes.com/plugins/k2-framework.zip'),
            'required'           => true,
        ),
        array(
            'name'               => esc_html__('SWA Import Export', 'k2_text_domain'),
            'slug'               => 'swa-import-export',
            'source'             => esc_url('http://k2themes.com/plugins/swa-import-export.zip'),
            'required'           => true,
        ),

        array(
            'name'               => esc_html__('Visual Composer', 'k2_text_domain'),
            'slug'               => 'js_composer',
            'source'             => esc_url('http://k2themes.com/plugins/js_composer.zip'),
            'required'           => true,
        ),

        array(
            'name'               => esc_html__('Revolution Slider', 'k2_text_domain'),
            'slug'               => 'revslider',
            'source'             => esc_url('http://k2themes.com/plugins/revslider.zip'),
            'required'           => true,
        ),

        array(
            'name'               => esc_html__('Contact Form 7', 'k2_text_domain'),
            'slug'               => 'contact-form-7',
            'required'           => false,
        ),
        array(
            'name'               => esc_html__('Newsletter', 'k2_text_domain'),
            'slug'               => 'newsletter',
            'required'           => false,
        ),
    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
    */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'k2_text_domain' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'k2_text_domain' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'k2_text_domain' ), // %s = plugin name.
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'k2_text_domain' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'k2_text_domain' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' , 'k2_text_domain' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' , 'k2_text_domain' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'k2_text_domain' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'k2_text_domain' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'k2_text_domain' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'k2_text_domain' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'k2_text_domain' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'k2_text_domain' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'k2_text_domain' ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'k2_text_domain' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'k2_text_domain' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'k2_text_domain' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}