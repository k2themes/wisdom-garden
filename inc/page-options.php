<?php
/**
 * Register metabox for posts based on Redux Framework. Supported methods:
 *     isset_args( $post_type )
 *     set_args( $post_type, $redux_args, $metabox_args )
 *     add_section( $post_type, $sections )
 * Each post type can contains only one metabox. Pease note that each field id
 * leads by an underscore sign ( _ ) in order to not show that into Custom Field
 * Metabox from WordPress core feature.
 *
 * @param  k2_theme_frame_Post_Metabox $metabox
 */

function k2_theme_frame_page_options_register( $metabox ) {
	if ( ! $metabox->isset_args( 'post' ) ) {
		$metabox->set_args( 'post', array(
			'opt_name'            => 'post_option',
			'display_name'        => esc_html__( 'Post Settings', 'k2_text_domain' ),
			'show_options_object' => false,
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'page' ) ) {
		$metabox->set_args( 'page', array(
			'opt_name'            => k2_theme_frame_get_page_opt_name(),
			'display_name'        => esc_html__( 'Page Settings', 'k2_text_domain' ),
			'show_options_object' => false,
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'k2_pf_audio' ) ) {
		$metabox->set_args( 'k2_pf_audio', array(
			'opt_name'     => 'post_format_audio',
			'display_name' => esc_html__( 'Audio', 'k2_text_domain' ),
			'class'        => 'fully-expanded',
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'k2_pf_link' ) ) {
		$metabox->set_args( 'k2_pf_link', array(
			'opt_name'     => 'post_format_link',
			'display_name' => esc_html__( 'Link', 'k2_text_domain' )
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'k2_pf_quote' ) ) {
		$metabox->set_args( 'k2_pf_quote', array(
			'opt_name'     => 'post_format_quote',
			'display_name' => esc_html__( 'Quote', 'k2_text_domain' )
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'k2_pf_video' ) ) {
		$metabox->set_args( 'k2_pf_video', array(
			'opt_name'     => 'post_format_video',
			'display_name' => esc_html__( 'Video', 'k2_text_domain' ),
			'class'        => 'fully-expanded',
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'k2_pf_gallery' ) ) {
		$metabox->set_args( 'k2_pf_gallery', array(
			'opt_name'     => 'post_format_gallery',
			'display_name' => esc_html__( 'Gallery', 'k2_text_domain' ),
			'class'        => 'fully-expanded',
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	/* Extra Post Type */
	if ( ! $metabox->isset_args( 'service' ) ) {
		$metabox->set_args( 'service', array(
			'opt_name'            => 'service_option',
			'display_name'        => esc_html__( 'Services Settings', 'k2_text_domain' ),
			'show_options_object' => false,
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'portfolio' ) ) {
		$metabox->set_args( 'portfolio', array(
			'opt_name'            => 'portfolio_option',
			'display_name'        => esc_html__( 'Portfolio Settings', 'k2_text_domain' ),
			'show_options_object' => false,
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}
	/**
	 * Config service meta options
	 *
	 */

	$service_fields       = array(
		array(
			'id'       => 'service_excerpt',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Excerpt', 'k2_text_domain' ),
			'validate' => 'no_html'
		),
		array(
			'id'      => 'service_feature_img',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Feature Image', 'k2_text_domain' ),
			'options' => array(
				'show' => esc_html__( 'Show', 'k2_text_domain' ),
				'hide' => esc_html__( 'Hide', 'k2_text_domain' ),
			),
			'default' => 'show',
			'desc'    => 'Show/Hide feature image on single service'
		),
		array(
			'id'             => 'service_content_padding',
			'type'           => 'spacing',
			'output'         => array( '.single-service #content, .single-service-construction-company .site-main > .post-type-inner' ),
			'right'          => false,
			'left'           => false,
			'mode'           => 'padding',
			'units'          => array( 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Content Padding', 'k2_text_domain' ),
			'desc'           => esc_html__( 'Default: Theme Option.', 'k2_text_domain' ),
			'default'        => array(
				'padding-top'    => '',
				'padding-bottom' => '',
				'units'          => 'px',
			)
		),
		array(
			'id'      => 'service_icon',
			'type'    => 'media',
			'title'   => esc_html__( 'Icon', 'k2_text_domain' ),
			'default' => '',
		),
		array(
			'id'      => 'service_icon_hover',
			'type'    => 'media',
			'title'   => esc_html__( 'Icon Hover', 'k2_text_domain' ),
			'default' => '',
		),
		array(
			'id'       => 'character_content',
			'type'     => 'text',
			'title'    => esc_html__( 'Character', 'k2_text_domain' ),
			'subtitle' => esc_html__( 'Enter characters, it is blurry below the page.', 'k2_text_domain' ),
		),
	);
	$singe_service_layout = k2_theme_frame_get_opt( 'singe_service_layout', 'default' );
	if ( $singe_service_layout == 'industrial' || $singe_service_layout == 'corporate' ) :
		$service_fields[] = array(
			'id'    => 'service_gallery',
			'type'  => 'gallery',
			'title' => esc_html__( 'Add/Edit Gallery', 'k2_text_domain' ),
		);
	endif;
	if ( $singe_service_layout == 'construction-company' ) :
		$service_fields[] = array(
			'id'    => 'service_info_list',
			'type'  => 'multi_text',
			'title' => esc_html__( 'List Info', 'k2_text_domain' ),
		);
	endif;
	$metabox->add_section( 'service', array(
		'title'  => esc_html__( 'Content Settingss', 'k2_text_domain' ),
		'icon'   => 'el el-edit',
		'fields' => $service_fields
	) );
	$metabox->add_section( 'service', array(
		'title'  => esc_html__( 'Page Title Settings', 'k2_text_domain' ),
		'icon'   => 'el el-indent-left',
		'fields' => array(
			array(
				'id'      => 'custom_pagetitle',
				'type'    => 'switch',
				'title'   => esc_html__( 'Custom Page Title', 'k2_text_domain' ),
				'default' => false,
				'indent'  => true
			),
			array(
				'id'           => 'ptitle_layout',
				'type'         => 'image_select',
				'title'        => esc_html__( 'Layout', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Select a layout for page title.', 'k2_text_domain' ),
				'options'      => array(
					'0' => get_template_directory_uri() . '/assets/images/page-title-layout/p0.jpg',
					'1' => get_template_directory_uri() . '/assets/images/page-title-layout/p1.jpg',
				),
				'default'      => k2_theme_frame_get_option_of_theme_options( 'ptitle_layout' ),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'sub_title',
				'type'         => 'text',
				'title'        => esc_html__( 'Sub Title', 'k2_text_domain' ),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'custom_title',
				'type'         => 'text',
				'title'        => esc_html__( 'Title', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Use custom title for this page. The default title will be used on document title.', 'k2_text_domain' ),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'page_ptitle_color',
				'type'         => 'color',
				'title'        => esc_html__( 'Title Color', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Page title color.', 'k2_text_domain' ),
				'output'       => array( 'body #pagetitle h1.page-title' ),
				'default'      => '',
				'transparent'  => false,
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'ptitle_font_size',
				'type'         => 'text',
				'title'        => esc_html__( 'Title Font Size', 'k2_text_domain' ),
				'validate'     => 'numeric',
				'desc'         => 'Enter number',
				'msg'          => 'Please enter number',
				'default'      => '',
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'ptitle_description',
				'type'         => 'textarea',
				'title'        => esc_html__( 'Description', 'k2_text_domain' ),
				'validate'     => 'html_custom',
				'default'      => '',
				'allowed_html' => array(
					'a'      => array(
						'href'  => array(),
						'title' => array(),
						'class' => array(),
					),
					'br'     => array(),
					'em'     => array(),
					'strong' => array(),
					'span'   => array(),
					'p'      => array(),
					'div'    => array(
						'class' => array()
					),
					'h1'     => array(
						'class' => array()
					),
					'h2'     => array(
						'class' => array()
					),
					'h3'     => array(
						'class' => array()
					),
					'h4'     => array(
						'class' => array()
					),
					'h5'     => array(
						'class' => array()
					),
					'h6'     => array(
						'class' => array()
					),
					'ul'     => array(
						'class' => array()
					),
					'li'     => array(),
				),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'ptitle_description_color',
				'type'         => 'color',
				'title'        => esc_html__( 'Description Color', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Page title color.', 'k2_text_domain' ),
				'output'       => array( 'body #pagetitle .page-title-desc' ),
				'default'      => '',
				'transparent'  => false,
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'                    => 'page_ptitle_bg',
				'type'                  => 'background',
				'title'                 => esc_html__( 'Background', 'k2_text_domain' ),
				'subtitle'              => esc_html__( 'Page title background.', 'k2_text_domain' ),
				'output'                => array( '#pagetitle' ),
				'background-color'      => false,
				'background-repeat'     => false,
				'background-position'   => false,
				'background-attachment' => false,
				'background-size'       => false,
				'required'              => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output'          => true
			),
			array(
				'id'           => 'ptitle_overlay_style',
				'type'         => 'select',
				'title'        => __( 'Overlay Style', 'k2_text_domain' ),
				'options'      => array(
					'themeoption' => 'Theme Option',
					'secondary'   => 'Gradient Secondary',
					'white'       => 'Gradient White',
					'dotted'      => 'Dotted Overlay',
					'default'     => 'Custom Color',
				),
				'default'      => 'themeoption',
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'ptitle_bg_color',
				'type'         => 'color_rgba',
				'title'        => esc_html__( 'Select Color', 'k2_text_domain' ),
				'required'     => array( 0 => 'ptitle_overlay_style', 1 => 'equals', 2 => 'default' ),
				'force_output' => true,
			),
			array(
				'id'           => 'ptitle_paddings',
				'type'         => 'spacing',
				'title'        => esc_html__( 'Content Paddings', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Content page title paddings.', 'k2_text_domain' ),
				'mode'         => 'padding',
				'units'        => array( 'em', 'px', '%' ),
				'top'          => true,
				'right'        => false,
				'bottom'       => true,
				'left'         => false,
				'output'       => array( 'body #pagetitle' ),
				'default'      => array(
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
					'units'  => 'px',
				),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'ptitle_content_align',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Content Align', 'k2_text_domain' ),
				'options'      => array(
					'themeoption' => esc_html__( 'Theme Option', 'k2_text_domain' ),
					'left'        => esc_html__( 'Left', 'k2_text_domain' ),
					'center'      => esc_html__( 'Center', 'k2_text_domain' ),
					'right'       => esc_html__( 'Right', 'k2_text_domain' ),
				),
				'default'      => 'themeoption',
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'            => 'page_ptitle_width',
				'type'          => 'slider',
				'title'         => esc_html__( 'Content Width', 'k2_text_domain' ),
				"default"       => 100,
				"min"           => 50,
				"step"          => 1,
				"max"           => 100,
				'display_value' => 'label',
				'required'      => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output'  => true
			),
			array(
				'id'           => 'pagetitle_button',
				'type'         => 'switch',
				'title'        => esc_html__( 'Show Button', 'k2_text_domain' ),
				'default'      => false,
				'indent'       => true,
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_text',
				'type'         => 'text',
				'title'        => esc_html__( 'Button Text 1', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_link',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Button Link 1', 'k2_text_domain' ),
				'options'      => array(
					'page_link'   => esc_html__( 'Page Link', 'k2_text_domain' ),
					'custom_link' => esc_html__( 'Custom Link', 'k2_text_domain' ),
				),
				'default'      => 'page_link',
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_page_link',
				'type'         => 'select',
				'title'        => esc_html__( 'Page Link 1', 'k2_text_domain' ),
				'data'         => 'page',
				'args'         => array(
					'post_type'      => 'page',
					'posts_per_page' => - 1,
					'orderby'        => 'title',
					'order'          => 'ASC',
				),
				'required'     => array( 0 => 'pagetitle_button_link', 1 => '=', 2 => 'page_link' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_custom_link',
				'type'         => 'text',
				'title'        => esc_html__( 'Custom Link 1', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button_link', 1 => '=', 2 => 'custom_link' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_text2',
				'type'         => 'text',
				'title'        => esc_html__( 'Button Text 2', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_link2',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Button Link 2', 'k2_text_domain' ),
				'options'      => array(
					'page_link2'   => esc_html__( 'Page Link', 'k2_text_domain' ),
					'custom_link2' => esc_html__( 'Custom Link', 'k2_text_domain' ),
				),
				'default'      => 'page_link2',
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_page_link2',
				'type'         => 'select',
				'title'        => esc_html__( 'Page Link 2', 'k2_text_domain' ),
				'data'         => 'page',
				'args'         => array(
					'post_type'      => 'page',
					'posts_per_page' => - 1,
					'orderby'        => 'title',
					'order'          => 'ASC',
				),
				'required'     => array( 0 => 'pagetitle_button_link2', 1 => '=', 2 => 'page_link2' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_custom_link2',
				'type'         => 'text',
				'title'        => esc_html__( 'Custom Link 2', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button_link2', 1 => '=', 2 => 'custom_link2' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_text3',
				'type'         => 'text',
				'title'        => esc_html__( 'Button Text 3', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_link3',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Button Link 3', 'k2_text_domain' ),
				'options'      => array(
					'page_link3'   => esc_html__( 'Page Link', 'k2_text_domain' ),
					'custom_link3' => esc_html__( 'Custom Link', 'k2_text_domain' ),
					'none'         => esc_html__( 'None', 'k2_text_domain' ),
				),
				'default'      => 'page_link3',
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_page_link3',
				'type'         => 'select',
				'title'        => esc_html__( 'Page Link 3', 'k2_text_domain' ),
				'data'         => 'page',
				'args'         => array(
					'post_type'      => 'page',
					'posts_per_page' => - 1,
					'orderby'        => 'title',
					'order'          => 'ASC',
				),
				'required'     => array( 0 => 'pagetitle_button_link3', 1 => '=', 2 => 'page_link3' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_custom_link3',
				'type'         => 'text',
				'title'        => esc_html__( 'Custom Link 3', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button_link3', 1 => '=', 2 => 'custom_link3' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_class3',
				'type'         => 'text',
				'title'        => esc_html__( 'Button Class 3', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_size',
				'type'         => 'select',
				'title'        => __( 'Button Size', 'k2_text_domain' ),
				'options'      => array(
					'size-lg'      => 'Large',
					'size-default' => 'Medium',
				),
				'default'      => 'size-lg',
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
		)
	) );
	/**
	 * Config portfolio meta options
	 *
	 */
	$portfolio_fields       = array(
		array(
			'id'       => 'portfolio_excerpt',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Excerpt', 'k2_text_domain' ),
			'validate' => 'no_html'
		),
		array(
			'id'    => 'portfolio_address',
			'type'  => 'cms_address_input',
			'title' => esc_html__( 'Address', 'k2_text_domain' ),
			'desc'  => esc_html__( 'Address only show on CMS Grid Portfolio element.', 'k2_text_domain' ),
		),
		array(
			'id'      => 'portfolio_flag',
			'type'    => 'media',
			'title'   => esc_html__( 'Flag', 'k2_text_domain' ),
			'default' => ''
		),
		array(
			'id'             => 'portfolio_content_padding',
			'type'           => 'spacing',
			'output'         => array( '.single-portfolio #content, .single-portfolio-renovation .site-main > .post-type-inner, .single-portfolio-construction-company .site-main > .post-type-inner' ),
			'right'          => false,
			'left'           => false,
			'mode'           => 'padding',
			'units'          => array( 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Content Padding', 'k2_text_domain' ),
			'desc'           => esc_html__( 'Default: Theme Option.', 'k2_text_domain' ),
			'default'        => array(
				'padding-top'    => '',
				'padding-bottom' => '',
				'units'          => 'px',
			)
		),
		array(
			'id'       => 'character_content',
			'type'     => 'text',
			'title'    => esc_html__( 'Character', 'k2_text_domain' ),
			'subtitle' => esc_html__( 'Enter characters, it is blurry below the page.', 'k2_text_domain' ),
		),
	);
	$singe_portfolio_layout = k2_theme_frame_get_opt( 'singe_portfolio_layout', 'default' );
	if ( $singe_portfolio_layout == 'estate' ) :
		$portfolio_fields[] = array(
			'id'    => 'url_brochure',
			'type'  => 'text',
			'title' => esc_html__( 'Brochure Link', 'k2_text_domain' ),
		);
		$portfolio_fields[] = array(
			'id'    => 'project_start_date',
			'type'  => 'text',
			'title' => esc_html__( 'Started Date', 'k2_text_domain' ),
		);
		$portfolio_fields[] = array(
			'id'    => 'project_end_date',
			'type'  => 'text',
			'title' => esc_html__( 'Ended Date', 'k2_text_domain' ),
		);
		$portfolio_fields[] = array(
			'id'    => 'project_property_value',
			'type'  => 'text',
			'title' => esc_html__( 'Property Value', 'k2_text_domain' ),
		);
		$portfolio_fields[] = array(
			'id'    => 'project_property_type',
			'type'  => 'text',
			'title' => esc_html__( 'Property Type', 'k2_text_domain' ),
		);
	endif;
	if ( $singe_portfolio_layout == 'default' || $singe_portfolio_layout == 'renovation' || $singe_portfolio_layout == 'corporate' || $singe_portfolio_layout == 'estate' ) :
		$portfolio_fields[] = array(
			'id'      => 'portfolio_feature_img',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Feature Image', 'k2_text_domain' ),
			'options' => array(
				'show' => esc_html__( 'Show', 'k2_text_domain' ),
				'hide' => esc_html__( 'Hide', 'k2_text_domain' ),
			),
			'default' => 'show',
			'desc'    => 'Show/Hide feature image on single portfolio'
		);
		$portfolio_fields[] = array(
			'title'  => esc_html__( 'Gallery', 'k2_text_domain' ),
			'type'   => 'section',
			'id'     => 'project_gallery',
			'indent' => true
		);
		$portfolio_fields[] = array(
			'id'    => 'portfolio_gallery',
			'type'  => 'gallery',
			'title' => esc_html__( 'Add/Edit Gallery', 'k2_text_domain' ),
		);
	endif;
	if ( $singe_portfolio_layout == 'default' ) :
		$portfolio_fields[] = array(
			'title'  => esc_html__( 'Project Info', 'k2_text_domain' ),
			'type'   => 'section',
			'id'     => 'project_info',
			'indent' => true
		);
		$portfolio_fields[] = array(
			'id'    => 'project_info_title',
			'type'  => 'text',
			'title' => esc_html__( 'Title Info', 'k2_text_domain' ),
		);
		$portfolio_fields[] = array(
			'id'    => 'project_info_list',
			'type'  => 'multi_text',
			'title' => esc_html__( 'List Info', 'k2_text_domain' ),
			'desc'  => esc_html__( 'Odd order is label, even is content', 'k2_text_domain' )
		);
	endif;
	if ( $singe_portfolio_layout == 'corporate' ) :
		$portfolio_fields[] = array(
			'title'  => esc_html__( 'Project Info', 'k2_text_domain' ),
			'type'   => 'section',
			'id'     => 'project_info_corporate',
			'indent' => true
		);
		$portfolio_fields[] = array(
			'id'    => 'project_info_list_corporate',
			'type'  => 'multi_text',
			'title' => esc_html__( 'List Info', 'k2_text_domain' ),
			'desc'  => esc_html__( 'Odd order is label, even is content', 'k2_text_domain' )
		);
	endif;
	$metabox->add_section( 'portfolio', array(
		'title'  => esc_html__( 'Portfolio Settings', 'k2_text_domain' ),
		'icon'   => 'el el-briefcase',
		'fields' => $portfolio_fields
	) );
	$metabox->add_section( 'portfolio', array(
		'title'  => esc_html__( 'Page Title Settings', 'k2_text_domain' ),
		'icon'   => 'el el-indent-left',
		'fields' => array(
			array(
				'id'      => 'custom_pagetitle',
				'type'    => 'switch',
				'title'   => esc_html__( 'Custom Page Title', 'k2_text_domain' ),
				'default' => false,
				'indent'  => true
			),
			array(
				'id'           => 'ptitle_layout',
				'type'         => 'image_select',
				'title'        => esc_html__( 'Layout', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Select a layout for page title.', 'k2_text_domain' ),
				'options'      => array(
					'0' => get_template_directory_uri() . '/assets/images/page-title-layout/p0.jpg',
					'1' => get_template_directory_uri() . '/assets/images/page-title-layout/p1.jpg',
				),
				'default'      => k2_theme_frame_get_option_of_theme_options( 'ptitle_layout' ),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'sub_title',
				'type'         => 'text',
				'title'        => esc_html__( 'Sub Title', 'k2_text_domain' ),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'custom_title',
				'type'         => 'text',
				'title'        => esc_html__( 'Title', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Use custom title for this page. The default title will be used on document title.', 'k2_text_domain' ),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'page_ptitle_color',
				'type'         => 'color',
				'title'        => esc_html__( 'Title Color', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Page title color.', 'k2_text_domain' ),
				'output'       => array( 'body #pagetitle h1.page-title' ),
				'default'      => '',
				'transparent'  => false,
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'ptitle_font_size',
				'type'         => 'text',
				'title'        => esc_html__( 'Title Font Size', 'k2_text_domain' ),
				'validate'     => 'numeric',
				'desc'         => 'Enter number',
				'msg'          => 'Please enter number',
				'default'      => '',
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'ptitle_description',
				'type'         => 'textarea',
				'title'        => esc_html__( 'Description', 'k2_text_domain' ),
				'validate'     => 'html_custom',
				'default'      => '',
				'allowed_html' => array(
					'a'      => array(
						'href'  => array(),
						'title' => array(),
						'class' => array(),
					),
					'br'     => array(),
					'em'     => array(),
					'strong' => array(),
					'span'   => array(),
					'p'      => array(),
					'div'    => array(
						'class' => array()
					),
					'h1'     => array(
						'class' => array()
					),
					'h2'     => array(
						'class' => array()
					),
					'h3'     => array(
						'class' => array()
					),
					'h4'     => array(
						'class' => array()
					),
					'h5'     => array(
						'class' => array()
					),
					'h6'     => array(
						'class' => array()
					),
					'ul'     => array(
						'class' => array()
					),
					'li'     => array(),
				),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'ptitle_description_color',
				'type'         => 'color',
				'title'        => esc_html__( 'Description Color', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Page title color.', 'k2_text_domain' ),
				'output'       => array( 'body #pagetitle .page-title-desc' ),
				'default'      => '',
				'transparent'  => false,
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'                    => 'page_ptitle_bg',
				'type'                  => 'background',
				'title'                 => esc_html__( 'Background', 'k2_text_domain' ),
				'subtitle'              => esc_html__( 'Page title background.', 'k2_text_domain' ),
				'output'                => array( '#pagetitle' ),
				'background-color'      => false,
				'background-repeat'     => false,
				'background-position'   => false,
				'background-attachment' => false,
				'background-size'       => false,
				'required'              => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output'          => true
			),
			array(
				'id'           => 'ptitle_overlay_style',
				'type'         => 'select',
				'title'        => __( 'Overlay Style', 'k2_text_domain' ),
				'options'      => array(
					'themeoption' => 'Theme Option',
					'secondary'   => 'Gradient Secondary',
					'white'       => 'Gradient White',
					'dotted'      => 'Dotted Overlay',
					'default'     => 'Custom Color',
				),
				'default'      => 'themeoption',
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'ptitle_bg_color',
				'type'         => 'color_rgba',
				'title'        => esc_html__( 'Select Color', 'k2_text_domain' ),
				'required'     => array( 0 => 'ptitle_overlay_style', 1 => 'equals', 2 => 'default' ),
				'force_output' => true,
			),
			array(
				'id'           => 'ptitle_paddings',
				'type'         => 'spacing',
				'title'        => esc_html__( 'Content Paddings', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Content page title paddings.', 'k2_text_domain' ),
				'mode'         => 'padding',
				'units'        => array( 'em', 'px', '%' ),
				'top'          => true,
				'right'        => false,
				'bottom'       => true,
				'left'         => false,
				'output'       => array( 'body #pagetitle' ),
				'default'      => array(
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
					'units'  => 'px',
				),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'ptitle_content_align',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Content Align', 'k2_text_domain' ),
				'options'      => array(
					'themeoption' => esc_html__( 'Theme Option', 'k2_text_domain' ),
					'left'        => esc_html__( 'Left', 'k2_text_domain' ),
					'center'      => esc_html__( 'Center', 'k2_text_domain' ),
					'right'       => esc_html__( 'Right', 'k2_text_domain' ),
				),
				'default'      => 'themeoption',
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'            => 'page_ptitle_width',
				'type'          => 'slider',
				'title'         => esc_html__( 'Content Width', 'k2_text_domain' ),
				"default"       => 100,
				"min"           => 50,
				"step"          => 1,
				"max"           => 100,
				'display_value' => 'label',
				'required'      => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output'  => true
			),
			array(
				'id'           => 'pagetitle_button',
				'type'         => 'switch',
				'title'        => esc_html__( 'Show Button', 'k2_text_domain' ),
				'default'      => false,
				'indent'       => true,
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_text',
				'type'         => 'text',
				'title'        => esc_html__( 'Button Text 1', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_link',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Button Link 1', 'k2_text_domain' ),
				'options'      => array(
					'page_link'   => esc_html__( 'Page Link', 'k2_text_domain' ),
					'custom_link' => esc_html__( 'Custom Link', 'k2_text_domain' ),
				),
				'default'      => 'page_link',
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_page_link',
				'type'         => 'select',
				'title'        => esc_html__( 'Page Link 1', 'k2_text_domain' ),
				'data'         => 'page',
				'args'         => array(
					'post_type'      => 'page',
					'posts_per_page' => - 1,
					'orderby'        => 'title',
					'order'          => 'ASC',
				),
				'required'     => array( 0 => 'pagetitle_button_link', 1 => '=', 2 => 'page_link' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_custom_link',
				'type'         => 'text',
				'title'        => esc_html__( 'Custom Link 1', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button_link', 1 => '=', 2 => 'custom_link' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_text2',
				'type'         => 'text',
				'title'        => esc_html__( 'Button Text 2', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_link2',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Button Link 2', 'k2_text_domain' ),
				'options'      => array(
					'page_link2'   => esc_html__( 'Page Link', 'k2_text_domain' ),
					'custom_link2' => esc_html__( 'Custom Link', 'k2_text_domain' ),
				),
				'default'      => 'page_link2',
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_page_link2',
				'type'         => 'select',
				'title'        => esc_html__( 'Page Link 2', 'k2_text_domain' ),
				'data'         => 'page',
				'args'         => array(
					'post_type'      => 'page',
					'posts_per_page' => - 1,
					'orderby'        => 'title',
					'order'          => 'ASC',
				),
				'required'     => array( 0 => 'pagetitle_button_link2', 1 => '=', 2 => 'page_link2' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_custom_link2',
				'type'         => 'text',
				'title'        => esc_html__( 'Custom Link 2', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button_link2', 1 => '=', 2 => 'custom_link2' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_text3',
				'type'         => 'text',
				'title'        => esc_html__( 'Button Text 3', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_link3',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Button Link 3', 'k2_text_domain' ),
				'options'      => array(
					'page_link3'   => esc_html__( 'Page Link', 'k2_text_domain' ),
					'custom_link3' => esc_html__( 'Custom Link', 'k2_text_domain' ),
					'none'         => esc_html__( 'None', 'k2_text_domain' ),
				),
				'default'      => 'page_link3',
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_page_link3',
				'type'         => 'select',
				'title'        => esc_html__( 'Page Link 3', 'k2_text_domain' ),
				'data'         => 'page',
				'args'         => array(
					'post_type'      => 'page',
					'posts_per_page' => - 1,
					'orderby'        => 'title',
					'order'          => 'ASC',
				),
				'required'     => array( 0 => 'pagetitle_button_link3', 1 => '=', 2 => 'page_link3' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_custom_link3',
				'type'         => 'text',
				'title'        => esc_html__( 'Custom Link 3', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button_link3', 1 => '=', 2 => 'custom_link3' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_class3',
				'type'         => 'text',
				'title'        => esc_html__( 'Button Class 3', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_size',
				'type'         => 'select',
				'title'        => __( 'Button Size', 'k2_text_domain' ),
				'options'      => array(
					'size-lg'      => 'Large',
					'size-default' => 'Medium',
				),
				'default'      => 'size-lg',
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
		)
	) );

	/**
	 * Config post meta options
	 *
	 */
	$single_post_fields = array();
	$single_post_layout = k2_theme_frame_get_opt( 'single_post_layout', 'default' );
	if ( $single_post_layout == 'default' || $single_post_layout == 'renovation' || $single_post_layout == 'industrial' || $single_post_layout == 'corporate' || $single_post_layout == 'estate' ) :
		$single_post_fields[] = array(
			'id'      => 'custom_pagetitle',
			'type'    => 'switch',
			'title'   => esc_html__( 'Custom Page Title', 'k2_text_domain' ),
			'default' => false,
			'indent'  => true
		);
	endif;
	$single_post_fields[] = array(
		'id'           => 'ptitle_layout',
		'type'         => 'image_select',
		'title'        => esc_html__( 'Layout', 'k2_text_domain' ),
		'subtitle'     => esc_html__( 'Select a layout for page title.', 'k2_text_domain' ),
		'options'      => array(
			'0' => get_template_directory_uri() . '/assets/images/page-title-layout/p0.jpg',
			'1' => get_template_directory_uri() . '/assets/images/page-title-layout/p1.jpg',
		),
		'default'      => k2_theme_frame_get_option_of_theme_options( 'ptitle_layout' ),
		'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
		'force_output' => true
	);
	$single_post_fields[] = array(
		'id'           => 'custom_title',
		'type'         => 'text',
		'title'        => esc_html__( 'Custom Title', 'k2_text_domain' ),
		'subtitle'     => esc_html__( 'Use custom title for this page. The default title will be used on document title.', 'k2_text_domain' ),
		'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
		'force_output' => true
	);
	$single_post_fields[] = array(
		'id'           => 'page_ptitle_color',
		'type'         => 'color',
		'title'        => esc_html__( 'Title Color', 'k2_text_domain' ),
		'subtitle'     => esc_html__( 'Page title color.', 'k2_text_domain' ),
		'output'       => array( 'body #pagetitle h1.page-title' ),
		'default'      => '',
		'transparent'  => false,
		'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
		'force_output' => true
	);
	$single_post_fields[] = array(
		'id'           => 'ptitle_description',
		'type'         => 'textarea',
		'title'        => esc_html__( 'Description', 'k2_text_domain' ),
		'validate'     => 'html_custom',
		'default'      => '',
		'allowed_html' => array(
			'a'      => array(
				'href'  => array(),
				'title' => array(),
				'class' => array(),
			),
			'br'     => array(),
			'em'     => array(),
			'strong' => array(),
			'span'   => array(),
			'p'      => array(),
			'div'    => array(
				'class' => array()
			),
			'h1'     => array(
				'class' => array()
			),
			'h2'     => array(
				'class' => array()
			),
			'h3'     => array(
				'class' => array()
			),
			'h4'     => array(
				'class' => array()
			),
			'h5'     => array(
				'class' => array()
			),
			'h6'     => array(
				'class' => array()
			),
			'ul'     => array(
				'class' => array()
			),
			'li'     => array(),
		),
		'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
		'force_output' => true
	);
	$single_post_fields[] = array(
		'id'           => 'ptitle_description_color',
		'type'         => 'color',
		'title'        => esc_html__( 'Description Color', 'k2_text_domain' ),
		'subtitle'     => esc_html__( 'Page title color.', 'k2_text_domain' ),
		'output'       => array( 'body #pagetitle .page-title-desc' ),
		'default'      => '',
		'transparent'  => false,
		'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
		'force_output' => true
	);
	$single_post_fields[] = array(
		'id'                    => 'page_ptitle_bg',
		'type'                  => 'background',
		'title'                 => esc_html__( 'Background', 'k2_text_domain' ),
		'subtitle'              => esc_html__( 'Page title background.', 'k2_text_domain' ),
		'output'                => array( '#pagetitle' ),
		'background-color'      => false,
		'background-repeat'     => false,
		'background-position'   => false,
		'background-attachment' => false,
		'background-size'       => false,
		'required'              => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
		'force_output'          => true
	);
	$single_post_fields[] = array(
		'id'           => 'ptitle_overlay_style',
		'type'         => 'select',
		'title'        => __( 'Overlay Style', 'k2_text_domain' ),
		'options'      => array(
			'themeoption' => 'Theme Option',
			'secondary'   => 'Gradient Secondary',
			'dotted'      => 'Dotted Overlay',
			'white'       => 'Gradient White',
			'default'     => 'Custom Color',
		),
		'default'      => 'themeoption',
		'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
		'force_output' => true
	);
	$single_post_fields[] = array(
		'id'           => 'ptitle_bg_color',
		'type'         => 'color_rgba',
		'title'        => esc_html__( 'Select Color', 'k2_text_domain' ),
		'required'     => array( 0 => 'ptitle_overlay_style', 1 => 'equals', 2 => 'default' ),
		'force_output' => true,
	);
	$single_post_fields[] = array(
		'id'           => 'ptitle_paddings',
		'type'         => 'spacing',
		'title'        => esc_html__( 'Content Paddings', 'k2_text_domain' ),
		'subtitle'     => esc_html__( 'Content page title paddings.', 'k2_text_domain' ),
		'mode'         => 'padding',
		'units'        => array( 'em', 'px', '%' ),
		'top'          => true,
		'right'        => false,
		'bottom'       => true,
		'left'         => false,
		'output'       => array( 'body #pagetitle' ),
		'default'      => array(
			'top'    => '',
			'right'  => '',
			'bottom' => '',
			'left'   => '',
			'units'  => 'px',
		),
		'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
		'force_output' => true
	);
	$single_post_fields[] = array(
		'id'           => 'ptitle_content_align',
		'type'         => 'button_set',
		'title'        => esc_html__( 'Content Align', 'k2_text_domain' ),
		'options'      => array(
			'themeoption' => esc_html__( 'Theme Option', 'k2_text_domain' ),
			'left'        => esc_html__( 'Left', 'k2_text_domain' ),
			'center'      => esc_html__( 'Center', 'k2_text_domain' ),
			'right'       => esc_html__( 'Right', 'k2_text_domain' ),
		),
		'default'      => 'themeoption',
		'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
		'force_output' => true
	);
	$single_post_fields[] = array(
		'id'            => 'page_ptitle_width',
		'type'          => 'slider',
		'title'         => esc_html__( 'Content Width', 'k2_text_domain' ),
		"default"       => 100,
		"min"           => 50,
		"step"          => 1,
		"max"           => 100,
		'display_value' => 'label',
		'required'      => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
		'force_output'  => true
	);
	$single_post_fields[] = array(
		'id'             => 'post_content_padding',
		'type'           => 'spacing',
		'output'         => array( '.single-post #content' ),
		'right'          => false,
		'left'           => false,
		'mode'           => 'padding',
		'units'          => array( 'px' ),
		'units_extended' => 'false',
		'title'          => esc_html__( 'Content Padding', 'k2_text_domain' ),
		'desc'           => esc_html__( 'Default: Theme Option.', 'k2_text_domain' ),
		'default'        => array(
			'padding-top'    => '',
			'padding-bottom' => '',
			'units'          => 'px',
		)
	);
	$single_post_fields[] = array(
		'id'       => 'character_content',
		'type'     => 'text',
		'title'    => esc_html__( 'Character Page', 'k2_text_domain' ),
		'subtitle' => esc_html__( 'Enter characters, it is blurry below the page.', 'k2_text_domain' ),
	);
	$metabox->add_section( 'post', array(
		'title'  => esc_html__( 'Sidebar Position', 'k2_text_domain' ),
		'icon'   => 'el el-refresh',
		'fields' => $single_post_fields
	) );

	/**
	 * Config page meta options
	 *
	 */
	$metabox->add_section( 'page', array(
		'title'  => esc_html__( 'Header', 'k2_text_domain' ),
		'desc'   => esc_html__( 'Header settings for the page.', 'k2_text_domain' ),
		'icon'   => 'el-icon-website',
		'fields' => array(
			array(
				'id'      => 'custom_header',
				'type'    => 'switch',
				'title'   => esc_html__( 'Custom Header', 'k2_text_domain' ),
				'default' => false,
				'indent'  => true
			),
			array(
				'id'           => 'header_layout',
				'type'         => 'image_select',
				'title'        => esc_html__( 'Layout', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Select a layout for header.', 'k2_text_domain' ),
				'options'      => array(
					'0' => get_template_directory_uri() . '/assets/images/header-layout/h0.jpg',
					'1' => get_template_directory_uri() . '/assets/images/header-layout/h1.jpg',
					'2' => get_template_directory_uri() . '/assets/images/header-layout/h2.jpg',
					'3' => get_template_directory_uri() . '/assets/images/header-layout/h3.jpg',
					'4' => get_template_directory_uri() . '/assets/images/header-layout/h4.jpg',
					'5' => get_template_directory_uri() . '/assets/images/header-layout/h5.jpg',
					'6' => get_template_directory_uri() . '/assets/images/header-layout/h6.jpg',
					'7' => get_template_directory_uri() . '/assets/images/header-layout/h7.jpg',
				),
				'default'      => k2_theme_frame_get_option_of_theme_options( 'header_layout' ),
				'required'     => array( 0 => 'custom_header', 1 => 'equals', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'menu_fixed',
				'type'         => 'switch',
				'title'        => esc_html__( 'Menu fixed on Page Title', 'k2_text_domain' ),
				'default'      => false,
				'indent'       => true,
				'required'     => array( 0 => 'header_layout', 1 => 'equals', 2 => '2' ),
				'force_output' => true
			),
		)
	) );

	$metabox->add_section( 'page', array(
		'title'  => esc_html__( 'Page Title', 'k2_text_domain' ),
		'desc'   => esc_html__( 'Settings for page title.', 'k2_text_domain' ),
		'icon'   => 'el-icon-map-marker',
		'fields' => array(
			array(
				'id'      => 'custom_pagetitle',
				'type'    => 'switch',
				'title'   => esc_html__( 'Custom Page Title', 'k2_text_domain' ),
				'default' => false,
				'indent'  => true
			),
			array(
				'id'           => 'ptitle_layout',
				'type'         => 'image_select',
				'title'        => esc_html__( 'Layout', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Select a layout for page title.', 'k2_text_domain' ),
				'options'      => array(
					'0' => get_template_directory_uri() . '/assets/images/page-title-layout/p0.jpg',
					'1' => get_template_directory_uri() . '/assets/images/page-title-layout/p1.jpg',
				),
				'default'      => k2_theme_frame_get_option_of_theme_options( 'ptitle_layout' ),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'sub_title',
				'type'         => 'text',
				'title'        => esc_html__( 'Sub Title', 'k2_text_domain' ),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'custom_title',
				'type'         => 'text',
				'title'        => esc_html__( 'Title', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Use custom title for this page. The default title will be used on document title.', 'k2_text_domain' ),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'page_ptitle_color',
				'type'         => 'color',
				'title'        => esc_html__( 'Title Color', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Page title color.', 'k2_text_domain' ),
				'output'       => array( 'body #pagetitle h1.page-title' ),
				'default'      => '',
				'transparent'  => false,
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'ptitle_font_size',
				'type'         => 'text',
				'title'        => esc_html__( 'Title Font Size', 'k2_text_domain' ),
				'validate'     => 'numeric',
				'desc'         => 'Enter number',
				'msg'          => 'Please enter number',
				'default'      => '',
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'ptitle_description',
				'type'         => 'textarea',
				'title'        => esc_html__( 'Description', 'k2_text_domain' ),
				'validate'     => 'html_custom',
				'default'      => '',
				'allowed_html' => array(
					'a'      => array(
						'href'  => array(),
						'title' => array(),
						'class' => array(),
					),
					'br'     => array(),
					'em'     => array(),
					'strong' => array(),
					'span'   => array(),
					'p'      => array(),
					'div'    => array(
						'class' => array()
					),
					'h1'     => array(
						'class' => array()
					),
					'h2'     => array(
						'class' => array()
					),
					'h3'     => array(
						'class' => array()
					),
					'h4'     => array(
						'class' => array()
					),
					'h5'     => array(
						'class' => array()
					),
					'h6'     => array(
						'class' => array()
					),
					'ul'     => array(
						'class' => array()
					),
					'li'     => array(),
				),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'ptitle_description_color',
				'type'         => 'color',
				'title'        => esc_html__( 'Description Color', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Page title color.', 'k2_text_domain' ),
				'output'       => array( 'body #pagetitle .page-title-desc' ),
				'default'      => '',
				'transparent'  => false,
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'                    => 'page_ptitle_bg',
				'type'                  => 'background',
				'title'                 => esc_html__( 'Background', 'k2_text_domain' ),
				'subtitle'              => esc_html__( 'Page title background.', 'k2_text_domain' ),
				'output'                => array( '#pagetitle' ),
				'background-color'      => false,
				'background-repeat'     => false,
				'background-position'   => false,
				'background-attachment' => false,
				'background-size'       => false,
				'required'              => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output'          => true
			),
			array(
				'id'           => 'ptitle_overlay_style',
				'type'         => 'select',
				'title'        => __( 'Overlay Style', 'k2_text_domain' ),
				'options'      => array(
					'themeoption' => 'Theme Option',
					'secondary'   => 'Gradient Secondary',
					'white'       => 'Gradient White',
					'dotted'      => 'Dotted Overlay',
					'default'     => 'Custom Color',
				),
				'default'      => 'themeoption',
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'ptitle_bg_color',
				'type'         => 'color_rgba',
				'title'        => esc_html__( 'Select Color', 'k2_text_domain' ),
				'required'     => array( 0 => 'ptitle_overlay_style', 1 => 'equals', 2 => 'default' ),
				'force_output' => true,
			),
			array(
				'id'           => 'ptitle_paddings',
				'type'         => 'spacing',
				'title'        => esc_html__( 'Content Paddings', 'k2_text_domain' ),
				'subtitle'     => esc_html__( 'Content page title paddings.', 'k2_text_domain' ),
				'mode'         => 'padding',
				'units'        => array( 'em', 'px', '%' ),
				'top'          => true,
				'right'        => false,
				'bottom'       => true,
				'left'         => false,
				'output'       => array( 'body #pagetitle' ),
				'default'      => array(
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
					'units'  => 'px',
				),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'ptitle_content_align',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Content Align', 'k2_text_domain' ),
				'options'      => array(
					'themeoption' => esc_html__( 'Theme Option', 'k2_text_domain' ),
					'left'        => esc_html__( 'Left', 'k2_text_domain' ),
					'center'      => esc_html__( 'Center', 'k2_text_domain' ),
					'right'       => esc_html__( 'Right', 'k2_text_domain' ),
				),
				'default'      => 'themeoption',
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'            => 'page_ptitle_width',
				'type'          => 'slider',
				'title'         => esc_html__( 'Content Width', 'k2_text_domain' ),
				"default"       => 100,
				"min"           => 50,
				"step"          => 1,
				"max"           => 100,
				'display_value' => 'label',
				'required'      => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output'  => true
			),
			array(
				'id'           => 'pagetitle_button',
				'type'         => 'switch',
				'title'        => esc_html__( 'Show Button', 'k2_text_domain' ),
				'default'      => false,
				'indent'       => true,
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_text',
				'type'         => 'text',
				'title'        => esc_html__( 'Button Text 1', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_link',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Button Link 1', 'k2_text_domain' ),
				'options'      => array(
					'page_link'   => esc_html__( 'Page Link', 'k2_text_domain' ),
					'custom_link' => esc_html__( 'Custom Link', 'k2_text_domain' ),
				),
				'default'      => 'page_link',
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_page_link',
				'type'         => 'select',
				'title'        => esc_html__( 'Page Link 1', 'k2_text_domain' ),
				'data'         => 'page',
				'args'         => array(
					'post_type'      => 'page',
					'posts_per_page' => - 1,
					'orderby'        => 'title',
					'order'          => 'ASC',
				),
				'required'     => array( 0 => 'pagetitle_button_link', 1 => '=', 2 => 'page_link' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_custom_link',
				'type'         => 'text',
				'title'        => esc_html__( 'Custom Link 1', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button_link', 1 => '=', 2 => 'custom_link' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_text2',
				'type'         => 'text',
				'title'        => esc_html__( 'Button Text 2', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_link2',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Button Link 2', 'k2_text_domain' ),
				'options'      => array(
					'page_link2'   => esc_html__( 'Page Link', 'k2_text_domain' ),
					'custom_link2' => esc_html__( 'Custom Link', 'k2_text_domain' ),
				),
				'default'      => 'page_link2',
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_page_link2',
				'type'         => 'select',
				'title'        => esc_html__( 'Page Link 2', 'k2_text_domain' ),
				'data'         => 'page',
				'args'         => array(
					'post_type'      => 'page',
					'posts_per_page' => - 1,
					'orderby'        => 'title',
					'order'          => 'ASC',
				),
				'required'     => array( 0 => 'pagetitle_button_link2', 1 => '=', 2 => 'page_link2' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_custom_link2',
				'type'         => 'text',
				'title'        => esc_html__( 'Custom Link 2', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button_link2', 1 => '=', 2 => 'custom_link2' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_text3',
				'type'         => 'text',
				'title'        => esc_html__( 'Button Text 3', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_link3',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Button Link 3', 'k2_text_domain' ),
				'options'      => array(
					'page_link3'   => esc_html__( 'Page Link', 'k2_text_domain' ),
					'custom_link3' => esc_html__( 'Custom Link', 'k2_text_domain' ),
				),
				'default'      => 'page_link3',
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_page_link3',
				'type'         => 'select',
				'title'        => esc_html__( 'Page Link 3', 'k2_text_domain' ),
				'data'         => 'page',
				'args'         => array(
					'post_type'      => 'page',
					'posts_per_page' => - 1,
					'orderby'        => 'title',
					'order'          => 'ASC',
				),
				'required'     => array( 0 => 'pagetitle_button_link3', 1 => '=', 2 => 'page_link3' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_custom_link3',
				'type'         => 'text',
				'title'        => esc_html__( 'Custom Link 3', 'k2_text_domain' ),
				'required'     => array( 0 => 'pagetitle_button_link3', 1 => '=', 2 => 'custom_link3' ),
				'force_output' => true
			),
			array(
				'id'           => 'pagetitle_button_size',
				'type'         => 'select',
				'title'        => __( 'Button Size', 'k2_text_domain' ),
				'options'      => array(
					'size-lg'      => 'Large',
					'size-default' => 'Medium',
				),
				'default'      => 'size-lg',
				'required'     => array( 0 => 'pagetitle_button', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
		)
	) );

	$metabox->add_section( 'page', array(
		'title'  => esc_html__( 'Content', 'k2_text_domain' ),
		'desc'   => esc_html__( 'Settings for content area.', 'k2_text_domain' ),
		'icon'   => 'el-icon-pencil',
		'fields' => array(
			array(
				'id'       => 'content_bg_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Background Color', 'k2_text_domain' ),
				'subtitle' => esc_html__( 'Content background color.', 'k2_text_domain' ),
				'output'   => array( 'background-color' => '#content' )
			),
			array(
				'id'             => 'content_padding',
				'type'           => 'spacing',
				'output'         => array( '#content' ),
				'right'          => false,
				'left'           => false,
				'mode'           => 'padding',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Content Padding', 'k2_text_domain' ),
				'desc'           => esc_html__( 'Default: Theme Option.', 'k2_text_domain' ),
				'default'        => array(
					'padding-top'    => '',
					'padding-bottom' => '',
					'units'          => 'px',
				)
			),
			array(
				'id'      => 'show_sidebar_page',
				'type'    => 'switch',
				'title'   => esc_html__( 'Show Sidebar', 'k2_text_domain' ),
				'default' => false,
				'indent'  => true
			),
			array(
				'id'           => 'sidebar_page_pos',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Sidebar Position', 'k2_text_domain' ),
				'options'      => array(
					'left'  => esc_html__( 'Left', 'k2_text_domain' ),
					'right' => esc_html__( 'Right', 'k2_text_domain' ),
				),
				'default'      => 'right',
				'required'     => array( 0 => 'show_sidebar_page', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
			array(
				'id'       => 'character_content',
				'type'     => 'text',
				'title'    => esc_html__( 'Character', 'k2_text_domain' ),
				'subtitle' => esc_html__( 'Enter characters, it is blurry below the page.', 'k2_text_domain' ),
			),
		)
	) );

	$metabox->add_section( 'page', array(
		'title'  => esc_html__( 'Footer', 'k2_text_domain' ),
		'desc'   => esc_html__( 'Settings for page footer.', 'k2_text_domain' ),
		'icon'   => 'el el-website',
		'fields' => array(
			array(
				'id'      => 'custom_footer',
				'type'    => 'switch',
				'title'   => esc_html__( 'Custom Footer', 'k2_text_domain' ),
				'default' => false,
				'indent'  => true
			),
			array(
				'id'           => 'footer_layout',
				'type'         => 'image_select',
				'title'        => esc_html__( 'Layout', 'k2_text_domain' ),
				'options'      => array(
					'0' => get_template_directory_uri() . '/assets/images/footer-layout/f0.jpg',
				),
				'default'      => '0',
				'required'     => array( 0 => 'custom_footer', 1 => '=', 2 => '1' ),
				'force_output' => true
			)
		)
	) );

	/**
	 * Config post format meta options
	 *
	 */

	$metabox->add_section( 'k2_pf_video', array(
		'title'  => esc_html__( 'Video', 'k2_text_domain' ),
		'fields' => array(
			array(
				'id'    => 'post-video-url',
				'type'  => 'text',
				'title' => esc_html__( 'Video URL', 'k2_text_domain' ),
				'desc'  => esc_html__( 'YouTube or Vimeo video URL', 'k2_text_domain' )
			),

			array(
				'id'    => 'post-video-file',
				'type'  => 'editor',
				'title' => esc_html__( 'Video Upload', 'k2_text_domain' ),
				'desc'  => esc_html__( 'Upload video file', 'k2_text_domain' )
			),

			array(
				'id'    => 'post-video-html',
				'type'  => 'textarea',
				'title' => esc_html__( 'Embadded video', 'k2_text_domain' ),
				'desc'  => esc_html__( 'Use this option when the video does not come from YouTube or Vimeo', 'k2_text_domain' )
			)
		)
	) );

	$metabox->add_section( 'k2_pf_gallery', array(
		'title'  => esc_html__( 'Gallery', 'k2_text_domain' ),
		'fields' => array(
			array(
				'id'       => 'post-gallery-lightbox',
				'type'     => 'switch',
				'title'    => esc_html__( 'Lightbox?', 'k2_text_domain' ),
				'subtitle' => esc_html__( 'Enable lightbox for gallery images.', 'k2_text_domain' ),
				'default'  => true
			),
			array(
				'id'       => 'post-gallery-images',
				'type'     => 'gallery',
				'title'    => esc_html__( 'Gallery Images ', 'k2_text_domain' ),
				'subtitle' => esc_html__( 'Upload images or add from media library.', 'k2_text_domain' )
			)
		)
	) );

	$metabox->add_section( 'k2_pf_audio', array(
		'title'  => esc_html__( 'Audio', 'k2_text_domain' ),
		'fields' => array(
			array(
				'id'          => 'post-audio-url',
				'type'        => 'text',
				'title'       => esc_html__( 'Audio URL', 'k2_text_domain' ),
				'description' => esc_html__( 'Audio file URL in format: mp3, ogg, wav.', 'k2_text_domain' ),
				'validate'    => 'url',
				'msg'         => 'Url error!'
			)
		)
	) );

	$metabox->add_section( 'k2_pf_link', array(
		'title'  => esc_html__( 'Link', 'k2_text_domain' ),
		'fields' => array(
			array(
				'id'       => 'post-link-url',
				'type'     => 'text',
				'title'    => esc_html__( 'URL', 'k2_text_domain' ),
				'validate' => 'url',
				'msg'      => 'Url error!'
			)
		)
	) );

	$metabox->add_section( 'k2_pf_quote', array(
		'title'  => esc_html__( 'Quote', 'k2_text_domain' ),
		'fields' => array(
			array(
				'id'    => 'post-quote-cite',
				'type'  => 'text',
				'title' => esc_html__( 'Cite', 'k2_text_domain' )
			)
		)
	) );

}


add_action( 'k2_post_metabox_register', 'k2_theme_frame_page_options_register' );

function k2_theme_frame_get_option_of_theme_options( $key, $default = '' ) {
	if ( empty( $key ) ) {
		return '';
	}
	$options = get_option( k2_theme_frame_get_opt_name(), array() );
	$value   = isset( $options[ $key ] ) ? $options[ $key ] : $default;

	return $value;
}