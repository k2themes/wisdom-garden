<?php
/**
 * Helper functions for the theme
 *
 * @package k2_prefix
 */

/**
 * Get theme option based on its id.
 *
 * @param  string $opt_id Required. the option id.
 * @param  mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 *
 * @return mixed
 */
function k2_theme_frame_get_opt( $opt_id, $default = false ) {
	$opt_name = k2_theme_frame_get_opt_name();
	if ( empty( $opt_name ) ) {
		return $default;
	}

	global ${$opt_name};
	if ( ! isset( ${$opt_name} ) || ! isset( ${$opt_name}[ $opt_id ] ) ) {
		$options = get_option( $opt_name );
	} else {
		$options = ${$opt_name};
	}
	if ( ! isset( $options ) || ! isset( $options[ $opt_id ] ) || $options[ $opt_id ] === '' ) {
		return $default;
	}
	if ( is_array( $options[ $opt_id ] ) && is_array( $default ) ) {
		foreach ( $options[ $opt_id ] as $key => $value ) {
			if ( isset( $default[ $key ] ) && $value === '' ) {
				$options[ $opt_id ][ $key ] = $default[ $key ];
			}
		}
	}

	return $options[ $opt_id ];
}

/**
 * Get theme option based on its id.
 *
 * @param  string $opt_id Required. the option id.
 * @param  mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 *
 * @return mixed
 */
function k2_theme_frame_get_page_opt( $opt_id, $default = false ) {
	$page_opt_name = k2_theme_frame_get_page_opt_name();
	if ( empty( $page_opt_name ) ) {
		return $default;
	}
	$id = get_the_ID();
	if ( ! is_archive() && is_home() ) {
		if ( ! is_front_page() ) {
			$page_for_posts = get_option( 'page_for_posts' );
			$id             = $page_for_posts;
		}
	}

	return $options = ! empty( intval( $id ) ) ? get_post_meta( intval( $id ), $opt_id, true ) : $default;
}

/**
 *
 * Get post format values.
 *
 * @param $post_format_key
 * @param bool $default
 *
 * @return bool|mixed
 */
function k2_theme_frame_get_post_format_value( $post_format_key, $default = false ) {
	global $post;

	return $value = ! empty( $post->ID ) ? get_post_meta( $post->ID, $post_format_key, true ) : $default;
}


/**
 * Get opt_name for Redux Framework options instance args and for
 * getting option value.
 *
 * @return string
 */
function k2_theme_frame_get_opt_name() {
	return apply_filters( 'k2_theme_frame_opt_name', 'cms_theme_options' );
}

/**
 * Get opt_name for Redux Framework options instance args and for
 * getting option value.
 *
 * @return string
 */
function k2_theme_frame_get_page_opt_name() {
	return apply_filters( 'k2_theme_frame_page_opt_name', 'cms_page_options' );
}

/**
 * Get opt_name for Redux Framework options instance args and for
 * getting option value.
 *
 * @return string
 */
function k2_theme_frame_get_post_opt_name() {
	return apply_filters( 'k2_theme_frame_post_opt_name', 'k2_theme_frame_post_options' );
}

/**
 * Get page title and description.
 *
 * @return array Contains 'title'
 */
function k2_theme_frame_get_page_titles() {
	$title = '';

	// Default titles
	if ( ! is_archive() ) {
		// Posts page view
		if ( is_home() ) {
			// Only available if posts page is set.
			if ( ! is_front_page() && $page_for_posts = get_option( 'page_for_posts' ) ) {
				$title = get_post_meta( $page_for_posts, 'custom_title', true );
				if ( empty( $title ) ) {
					$title = get_the_title( $page_for_posts );
				}
			}
			if ( is_front_page() ) {
				$title = esc_html__( 'Blog', 'k2_text_domain' );
			}
		} // Single page view
        elseif ( is_page() ) {
			$title = get_post_meta( get_the_ID(), 'custom_title', true );
			if ( ! $title ) {
				$title = get_the_title();
			}
		} elseif ( is_404() ) {
			$title = esc_html__( '404', 'k2_text_domain' );
		} elseif ( is_search() ) {
			$title = esc_html__( 'Search results', 'k2_text_domain' );
		} else {
			$title = get_post_meta( get_the_ID(), 'custom_title', true );
			if ( ! $title ) {
				$title = get_the_title();
			}
		}
	} elseif ( is_author() ) {
		$title = esc_html__( 'Author:', 'k2_text_domain' ) . ' ' . get_the_author();
	} // Author
	else {
		$title = get_the_archive_title();
	}

	return array(
		'title' => $title,
	);
}

/**
 * Generates an excerpt from the post content with custom length.
 * Default length is 55 words, same as default the_excerpt()
 *
 * The excerpt words amount will be 55 words and if the amount is greater than
 * that, then the string '&hellip;' will be appended to the excerpt. If the string
 * is less than 55 words, then the content will be returned as it is.
 *
 * @param int $length Optional. Custom excerpt length, default to 55.
 * @param int|WP_Post $post Optional. You will need to provide post id or post object if used outside loops.
 *
 * @return string           The excerpt with custom length.
 */
function k2_theme_frame_get_the_excerpt( $length = 55, $post = null ) {
	$post = get_post( $post );

	if ( empty( $post ) || 0 >= $length ) {
		return '';
	}

	if ( post_password_required( $post ) ) {
		return esc_html__( 'Post password required.', 'k2_text_domain' );
	}

	$content = apply_filters( 'the_content', strip_shortcodes( $post->post_content ) );
	$content = str_replace( ']]>', ']]&gt;', $content );

	$excerpt_more = apply_filters( 'k2_theme_frame_excerpt_more', '&hellip;' );
	$excerpt      = wp_trim_words( $content, $length, $excerpt_more );

	return $excerpt;
}


/**
 * Check if provided color string is valid color.
 * Only supports 'transparent', HEX, RGB, RGBA.
 *
 * @param  string $color
 *
 * @return boolean
 */
function k2_theme_frame_is_valid_color( $color ) {
	$color = preg_replace( "/\s+/m", '', $color );

	if ( $color === 'transparent' ) {
		return true;
	}

	if ( '' == $color ) {
		return false;
	}

	// Hex format
	if ( preg_match( "/(?:^#[a-fA-F0-9]{6}$)|(?:^#[a-fA-F0-9]{3}$)/", $color ) ) {
		return true;
	}

	// rgb or rgba format
	if ( preg_match( "/(?:^rgba\(\d+\,\d+\,\d+\,(?:\d*(?:\.\d+)?)\)$)|(?:^rgb\(\d+\,\d+\,\d+\)$)/", $color ) ) {
		preg_match_all( "/\d+\.*\d*/", $color, $matches );
		if ( empty( $matches ) || empty( $matches[0] ) ) {
			return false;
		}

		$red   = empty( $matches[0][0] ) ? $matches[0][0] : 0;
		$green = empty( $matches[0][1] ) ? $matches[0][1] : 0;
		$blue  = empty( $matches[0][2] ) ? $matches[0][2] : 0;
		$alpha = empty( $matches[0][3] ) ? $matches[0][3] : 1;

		if ( $red < 0 || $red > 255 || $green < 0 || $green > 255 || $blue < 0 || $blue > 255 || $alpha < 0 || $alpha > 1.0 ) {
			return false;
		}
	} else {
		return false;
	}

	return true;
}

/**
 * Minify css
 *
 * @param  string $css
 *
 * @return string
 */
function k2_theme_frame_css_minifier( $css ) {
	// Normalize whitespace
	$css = preg_replace( '/\s+/', ' ', $css );
	// Remove spaces before and after comment
	$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );
	// Remove comment blocks, everything between /* and */, unless
	// preserved with /*! ... */ or /** ... */
	$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );
	// Remove ; before }
	$css = preg_replace( '/;(?=\s*})/', '', $css );
	// Remove space after , : ; { } */ >
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );
	// Remove space before , ; { } ( ) >
	$css = preg_replace( '/ (,|;|\{|}|\(|\)|>)/', '$1', $css );
	// Strips leading 0 on decimal values (converts 0.5px into .5px)
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );
	// Strips units if value is 0 (converts 0px to 0)
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );
	// Converts all zeros value into short-hand
	$css = preg_replace( '/0 0 0 0/', '0', $css );
	// Shortern 6-character hex color codes to 3-character where possible
	$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

	return trim( $css );
}

/**
 * Header Tracking Code to wp_head hook.
 */
function k2_theme_frame_header_code() {
	$site_header_code = k2_theme_frame_get_opt( 'site_header_code' );
	if ( $site_header_code !== '' ) {
		print wp_kses( $site_header_code, wp_kses_allowed_html() );
	}
}

add_action( 'wp_head', 'k2_theme_frame_header_code' );

/**
 * Footer Tracking Code to wp_footer hook.
 */
function k2_theme_frame_footer_code() {
	$site_footer_code = k2_theme_frame_get_opt( 'site_footer_code' );
	if ( $site_footer_code !== '' ) {
		print wp_kses( $site_footer_code, wp_kses_allowed_html() );
	}
}

add_action( 'wp_footer', 'k2_theme_frame_footer_code' );

/**
 * Custom Comment List
 */
function k2_theme_frame_comment_list( $comment, $args, $depth ) {
	if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
	?>
    <<?php echo ''.$tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
		    <div class="comment-inner clearfix">
		        <div class="comment-media">
					<?php if ( $args['avatar_size'] != 0 ) {
						echo get_avatar( $comment, $args['avatar_size'] );
					} ?>
		        </div>
		        <div class="comment-content">
		        	<div class="comment-reply">
						<?php comment_reply_link( array_merge( $args, array(
							'add_below' => $add_below,
							'depth'     => $depth,
							'max_depth' => $args['max_depth']
						) ) ); ?>
		            </div>
		            <h4 class="comment-title">
		            	<?php printf( '%s', get_comment_author_link() ); ?>
		            	<span class="comment-date">
	                        <?php echo get_comment_date(); ?>
	                    </span>
		            </h4>
		            <div class="comment-text"><?php comment_text(); ?></div>
		        </div>
		    </div>
		<?php if ( 'div' != $args['style'] ) : ?>
        </div>
	<?php endif;
}

function k2_theme_frame_comment_reply_text( $link ) {
$link = str_replace( 'Reply', '<span>'.esc_html__('Reply to comment', 'k2_text_domain').'</span><i class="zmdi zmdi-mail-reply"></i>', $link );
return $link;
}
add_filter( 'comment_reply_link', 'k2_theme_frame_comment_reply_text' );

/**
 * Add field subtitle to post.
 */
function k2_theme_frame_add_subtitle_field() {
	global $post;

	$screen = get_current_screen();

	if ( in_array( $screen->id, array( 'acm-post' ) ) ) {

		$value = get_post_meta( $post->ID, 'post_subtitle', true );

		echo '<div class="subtitle"><input type="text" name="post_subtitle" value="' . esc_attr( $value ) . '" id="subtitle" placeholder = "' . esc_html__( 'Subtitle', 'k2_text_domain' ) . '" style="width: 100%;margin-top: 4px;"></div>';
	}
}

add_action( 'edit_form_after_title', 'k2_theme_frame_add_subtitle_field' );

/**
 * Save custom theme meta
 */
function k2_theme_frame_save_meta_boxes( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['post_subtitle'] ) ) {
		update_post_meta( $post_id, 'post_subtitle', $_POST['post_subtitle'] );
	}
}

add_action( 'save_post', 'k2_theme_frame_save_meta_boxes' );


add_filter( 'cms_extra_post_types', 'k2_theme_frame_add_posttype' );
function k2_theme_frame_add_posttype( $postypes ) {
	$postypes['portfolio'] = array(
		'status' => true,
	);

	$postypes['service'] = array(
		'status'     => true,
		'item_name'  => esc_html__( 'Services', 'k2_text_domain' ),
		'items_name' => esc_html__( 'Services', 'k2_text_domain' ),
		'args'       => array(
			'menu_icon'          => 'dashicons-admin-tools',
			'supports'           => array(
				'title',
				'thumbnail',
				'editor',
			),
			'public'             => true,
			'publicly_queryable' => true,
		),
		'labels'     => array()
	);

	$postypes['career'] = array(
		'status'     => true,
		'item_name'  => esc_html__( 'Careers', 'k2_text_domain' ),
		'items_name' => esc_html__( 'Careers', 'k2_text_domain' ),
		'args'       => array(
			'menu_icon'          => 'dashicons-media-text',
			'supports'           => array(
				'title',
				'editor',
			),
			'public'             => true,
			'publicly_queryable' => true,
		),
		'labels'     => array()
	);

	$postypes['career-apply'] = array(
		'status'     => true,
		'item_name'  => esc_html__( 'Apply Position', 'k2_text_domain' ),
		'items_name' => esc_html__( 'Apply Position', 'k2_text_domain' ),
		'args'       => array(
			'menu_icon'          => 'dashicons-media-text',
			'supports'           => array(
				'title',
			),
			'public'             => false,
			'publicly_queryable' => false,
			'show_in_menu'       => 'edit.php?post_type=career',
		),
		'labels'     => array()
	);

	return $postypes;
}

add_action( 'cms_taxonomy_meta_register', 'k2_theme_frame_taxonomy_portfolio' );
function k2_theme_frame_taxonomy_portfolio( $taxonomy ) {
	$portfolio_category = array(
		'opt_name'     => 'portfolio-category',
		'display_name' => esc_html__( 'Settings', 'k2_text_domain' ),
	);

	if ( ! $taxonomy->isset_args( 'portfolio-category' ) ) {
		$taxonomy->set_args( 'portfolio-category', $portfolio_category );
	}

	$taxonomy->add_section( 'portfolio-category', array(
		'id'     => 'portfolio-category',
		'title'  => '',
		'desc'   => '',
		'fields' => array(
			array(
				'id'       => 'thumbnail',
				'type'     => 'media',
				'title'    => esc_html__( 'Thumbnail', 'k2_text_domain' ),
				'subtitle' => esc_html__( 'elect icon image from media library.', 'k2_text_domain' ),
			)
		)
	) );
}

add_filter( 'cms_extra_taxonomies', 'k2_theme_frame_add_tax' );
function k2_theme_frame_add_tax( $taxonomies ) {
	$taxonomies['service-category'] = array(
		'status'     => true,
		'post_type'  => array( 'service' ),
		'taxonomy'   => esc_html__( 'Category', 'k2_text_domain' ),
		'taxonomies' => esc_html__( 'Categories', 'k2_text_domain' ),
		'args'       => array(),
		'labels'     => array()
	);
	$taxonomies['career-category']  = array(
		'status'     => true,
		'post_type'  => array( 'career' ),
		'taxonomy'   => esc_html__( 'Category', 'k2_text_domain' ),
		'taxonomies' => esc_html__( 'Categories', 'k2_text_domain' ),
		'args'       => array(),
		'labels'     => array()
	);

	return $taxonomies;
}

add_filter( 'cms_enable_megamenu', 'k2_theme_frame_enable_megamenu' );
function k2_theme_frame_enable_megamenu() {
	return false;
}

/* Add default pagram Carousel */
function k2_theme_frame_get_param_carousel( $atts ) {
	$default  = array(
		'col_xs'           => '1',
		'col_sm'           => '2',
		'col_md'           => '3',
		'col_lg'           => '4',
		'margin'           => '30',
		'loop'             => 'false',
		'autoplay'         => 'false',
		'autoplay_timeout' => '5000',
		'smart_speed'      => '250',
		'center'           => 'false',
		'stage_padding'    => '0',
		'arrows'           => 'false',
		'bullets'          => 'false',
	);
	$new_data = array_merge( $default, $atts );
	extract( $new_data );
	$carousel      = array(
		'data-item-xs' => $col_xs,
		'data-item-sm' => $col_sm,
		'data-item-md' => $col_md,
		'data-item-lg' => $col_lg,

		'data-margin'          => $margin,
		'data-loop'            => $loop,
		'data-autoplay'        => $autoplay,
		'data-autoplaytimeout' => $autoplay_timeout,
		'data-smartspeed'      => $smart_speed,
		'data-center'          => $center,
		'data-arrows'          => $arrows,
		'data-bullets'         => $bullets,
		'data-stagepadding'    => $stage_padding,
		'data-rtl'             => is_rtl() ? 'true' : 'false',
	);
	$carousel_data = '';
	foreach ( $carousel as $key => $value ) {
		if ( isset( $value ) ) {
			$carousel_data .= $key . '=' . $value . ' ';
		}
	}
	$new_data['carousel_data'] = $carousel_data;

	return $new_data;
}

function k2_theme_frame_add_vc_extra_param( $old_param ) {
	$extra_param         = array(
		array(
			"type"             => "dropdown",
			"heading"          => esc_html__( "Columns XS (< 767px)", 'k2_text_domain' ),
			"param_name"       => "col_xs",
			"edit_field_class" => "vc_col-sm-3",
			"value"            => array( 1, 2, 3, 4 ),
			"std"              => 1,
			"group"            => 'Carousel Settings',
		),
		array(
			"type"             => "dropdown",
			"heading"          => esc_html__( "Columns SM (< 991px)", 'k2_text_domain' ),
			"param_name"       => "col_sm",
			"edit_field_class" => "vc_col-sm-3",
			"value"            => array( 1, 2, 3, 4 ),
			"std"              => 2,
			"group"            => 'Carousel Settings',
		),
		array(
			"type"             => "dropdown",
			"heading"          => esc_html__( "Columns MD (< 1199px)", 'k2_text_domain' ),
			"param_name"       => "col_md",
			"edit_field_class" => "vc_col-sm-3",
			"value"            => array( 1, 2, 3, 4 ),
			"std"              => 3,
			"group"            => 'Carousel Settings',
		),
		array(
			"type"             => "dropdown",
			"heading"          => esc_html__( "Columns LG (> 1200px)", 'k2_text_domain' ),
			"param_name"       => "col_lg",
			"edit_field_class" => "vc_col-sm-3",
			"value"            => array( 1, 2, 3, 4, 5, 6 ),
			"std"              => 4,
			"group"            => 'Carousel Settings',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Margin Items', 'k2_text_domain' ),
			'param_name'  => 'margin',
			'value'       => '',
			'group'       => 'Carousel Settings',
			'description' => 'Enter number: ...( Default 30 )',
		),
		array(
			"type"       => "dropdown",
			"heading"    => esc_html__( "Loop Items", 'k2_text_domain' ),
			"param_name" => "loop",
			"value"      => array(
				"No"  => "false",
				"Yes" => "true",
			),
			"group"      => 'Carousel Settings',
		),
		array(
			"type"       => "dropdown",
			"heading"    => esc_html__( "Autoplay", 'k2_text_domain' ),
			"param_name" => "autoplay",
			"value"      => array(
				"No"  => "false",
				"Yes" => "true",
			),
			"group"      => 'Carousel Settings',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Autoplay Timeout', 'k2_text_domain' ),
			'param_name'  => 'autoplay_timeout',
			'value'       => '',
			'group'       => 'Carousel Settings',
			'description' => 'Enter number: ...( Default 5000 )',
			'dependency'  => array(
				'element' => 'autoplay',
				'value'   => 'true',
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Smart Speed', 'k2_text_domain' ),
			'param_name'  => 'smart_speed',
			'value'       => '',
			'group'       => 'Carousel Settings',
			'description' => 'Enter number: ...( Default 250 )',
			'dependency'  => array(
				'element' => 'autoplay',
				'value'   => 'true',
			),
		),
		array(
			"type"       => "dropdown",
			"heading"    => esc_html__( "Center", 'k2_text_domain' ),
			"param_name" => "center",
			"value"      => array(
				"No"  => "false",
				"Yes" => "true",
			),
			"group"      => 'Carousel Settings',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Stage Padding', 'k2_text_domain' ),
			'param_name'  => 'stage_padding',
			'value'       => '',
			'group'       => 'Carousel Settings',
			'description' => 'Enter number: ...( Default 0 )',
			'dependency'  => array(
				'element' => 'center',
				'value'   => 'true',
			),
		),
		array(
			"type"       => "dropdown",
			"heading"    => esc_html__( "Show Arrows", 'k2_text_domain' ),
			"param_name" => "arrows",
			"value"      => array(
				"No"  => "false",
				"Yes" => "true",
			),
			"group"      => 'Carousel Settings',
		),
		array(
			"type"       => "dropdown",
			"heading"    => esc_html__( "Show Bullets", 'k2_text_domain' ),
			"param_name" => "bullets",
			"value"      => array(
				"No"  => "false",
				"Yes" => "true",
			),
			"group"      => 'Carousel Settings',
		),
	);
	$old_param['params'] = array_merge( $old_param['params'], $extra_param );

	return $old_param;
}

/* Show/hide CMS Carousel */
add_filter( 'enable_cms_carousel', 'k2_theme_frame_enable_cms_carousel' );
function k2_theme_frame_enable_cms_carousel() {
	return false;
}

/*
 * Set post views count using post meta
 */
function k2_theme_frame_set_post_views( $postID ) {
	$countKey = 'post_views_count';
	$count    = get_post_meta( $postID, $countKey, true );
	if ( $count == '' ) {
		$count = 0;
		delete_post_meta( $postID, $countKey );
		add_post_meta( $postID, $countKey, '0' );
	} else {
		$count ++;
		update_post_meta( $postID, $countKey, $count );
	}
}

/**
 * Apply Position code by KP
 */
add_action( 'wp_ajax_show_career_apply_form', 'k2_theme_frame_show_career_apply_form' );
add_action( 'wp_ajax_nopriv_show_career_apply_form', 'k2_theme_frame_show_career_apply_form' );
function k2_theme_frame_show_career_apply_form() {
	if ( ! empty( $_POST['pid'] ) ) {
		$post           = get_post( $_POST['pid'] );
		$career_apply_content = get_post_meta( $post->ID, 'career_apply_content', true );
		$career_address = get_post_meta($post->ID, 'career_address', true);
		$career_price = get_post_meta($post->ID, 'career_price', true);
		?>
        <div class="cms-career-modal-wrap">
            <div class="item-career-modal">
            	<div class="item-career-modal-inner row">
	                <div class="item-career-content col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
	                    <h3 class="item-title"><?php echo esc_attr( get_the_title( $post->ID ) ); ?></h3>
						<?php if(!empty($career_address)) : ?>
	                        <div class="item-address ft-pn-sb"><i class="zmdi zmdi-pin"></i><?php echo esc_attr( $career_address ); ?></div>
	                    <?php endif; ?>
	                    <?php if(!empty($career_price)) : ?>
	                        <div class="item-price ft-pn-sb"><i class="zmdi zmdi-money"></i><?php echo esc_attr( $career_price ); ?></div>
	                    <?php endif; ?>
	                    <div class="item-content">
							<?php echo wp_kses_post($career_apply_content); ?>
	                    </div>
	                    <div class="item-share entry-social-share">
	                    	<ul>
	                            <li><a class="fb-social" title="Facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_permalink( $post->ID )); ?>"><i class="zmdi zmdi-facebook"></i><span><?php echo esc_html__('Share', 'k2_text_domain'); ?></span></a></li>
	                            <li><a class="tw-social" title="Twitter" target="_blank" href="https://twitter.com/home?status=<?php echo esc_url(get_permalink( $post->ID )); ?>"><i class="zmdi zmdi-twitter"></i><span><?php echo esc_html__('Twitter', 'k2_text_domain'); ?></span></a></li>
	                            <li><a class="g-social" title="Google Plus" target="_blank" href="https://plus.google.com/share?url=<?php echo esc_url(get_permalink( $post->ID )); ?>"><i class="zmdi zmdi-google-plus"></i><span><?php echo esc_html__('Share', 'k2_text_domain'); ?></span></a></li>
	                            <li><a class="in-social" title="LinkedIn" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url(get_permalink( $post->ID )); ?>&title=<?php echo esc_attr(get_the_title($post->ID)); ?>&summary=&source="><i class="zmdi zmdi-linkedin"></i><span><?php echo esc_html__('Share', 'k2_text_domain'); ?></span></a></li>
	                        </ul>
	                    </div>
	                </div>
	                <div class="item-career-form col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
						<?php if ( ! empty( $form_title ) ) : ?>
	                        <h3><?php echo esc_attr( $form_title ); ?></h3>
	                    <p class="cms-contact-notice"></p>
						<?php endif; ?>
	                    <div class="cms-contact-form-inner">
	                        <h3><?php esc_html_e( 'Apply for Position', 'k2_text_domain' ) ?></h3>
	                        <div class="apply-form-row row">
	                        	<div class="col-12">
		                            <div class="apply-name">
		                                <input type="text" class="apply-field-name" placeholder="<?php esc_html_e( 'Your Name *', 'k2_text_domain' ) ?>">
		                            </div>
		                        </div>
	                        </div>
	                        <div class="apply-form-row row">
	                        	<div class="col-xl-6 col-lg-6 col-md-12">
	                        		<div class="apply-cv">
		                                <input type="text" class="apply-upload-cv" placeholder="<?php esc_html_e( 'Upload CV *', 'k2_text_domain' ) ?>">
		                                <input type="file" class="apply-file apply-upload-cv-file" name="cv_file" data-type="pdf,docx,doc,rtf" data-size="1024" style="display: none"
		                                       data-type-notice="<?php esc_html_e( 'File format not supported, you can only upload the following "pdf,docx,doc" file.', 'k2_text_domain' ) ?>"
		                                       data-size-notice="<?php esc_html_e( 'You can not upload files larger than 1MB', 'k2_text_domain' ) ?>">
		                            </div>
	                        	</div>
	                        	<div class="col-xl-6 col-lg-6 col-md-12">
	                        		<div class="apply-cover-letter">
		                                <input type="text" class="apply-upload-cover" placeholder="<?php esc_html_e( 'Upload Cover Letter *', 'k2_text_domain' ) ?>">
		                                <input type="file" class="apply-file apply-upload-cover-file" name="cover_file" data-type="pdf,docx,doc,rtf" data-size="1024" style="display: none"
		                                       data-type-notice="<?php esc_html_e( 'File format not supported, you can only upload the following "pdf,docx,doc" file.', 'k2_text_domain' ) ?>"
		                                       data-size-notice="<?php esc_html_e( 'You can not upload files larger than 1MB', 'k2_text_domain' ) ?>">
		                            </div>
	                        	</div>
	                        </div>
	                        <div class="apply-form-row row">
	                        	<div class="col-12">
		                            <div class="apply-message">
		                                <textarea class="apply-message-val" name="apply-message-val" id="apply-message-val" cols="30" rows="10" placeholder="<?php esc_html_e( 'Brief Message about Yourself *', 'k2_text_domain' ) ?>"></textarea>
		                            </div>
		                        </div>
	                        </div>

	                        <div class="apply-form-row row">
	                        	<div class="col-12">
	                            	<button class="apply-submit btn-block" data-notice="<?php esc_html_e('Please select file !','k2_text_domain') ?>" data-id="<?php echo esc_attr($post->ID); ?>"><?php esc_html_e( 'Submit Application', 'k2_text_domain' ) ?> </button>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
                <div class="modal-close"><i class="zmdi zmdi-close"></i></div>
            </div>
        </div>
		<?php
		$layout = ob_get_clean();
		wp_send_json( array( 'stt' => 'done', 'layout' => $layout ) );
		die();
	}
	wp_send_json( array( 'stt' => 'error' ) );
	die();
}

function k2_theme_frame_upload_files( $file, $post = array() ) {

	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	$upload = wp_handle_upload( $file, array( 'test_form' => false ) );

	/* upload error. */
	if ( isset( $upload['error'] ) ) {
		return false;
	}

	$file_name = sanitize_file_name( basename( $upload['file'] ) );

	$post['post_title']     = $file_name;
	$post['post_mime_type'] = $upload['type'];
	$id                     = wp_insert_attachment( $post, $upload['file'] );

	if ( ! $id ) {
		unlink( $upload['file'] );

		return false;
	}

	if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
	}

	/* update file meta. */
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );

	return $id;
}

add_action( 'wp_ajax_career_submit_form', 'k2_theme_frame_career_submit_form' );
add_action( 'wp_ajax_nopriv_career_submit_form', 'k2_theme_frame_career_submit_form' );

function k2_theme_frame_career_submit_form() {
	if ( ! empty( $_FILES['cv'] ) ) {
		$cv_id = k2_theme_frame_upload_files( $_FILES['cv'] );
	}
	if ( ! empty( $_FILES['cover'] ) ) {
		$cover_id = k2_theme_frame_upload_files( $_FILES['cover'] );
	}
	if(!empty($_POST['name']) &&!empty($_POST['message'])){
		$pid = wp_insert_post(array(
			'post_type'=>'career-apply',
			'post_title'=>esc_attr($_POST['name']),
			'post_content'=>esc_attr($_POST['message']),
			'post_status'=>'pending',
		));
		if($pid){
		    update_post_meta($pid,'career_apply_name',$_POST['name']);
		    update_post_meta($pid,'career_apply_post_name',get_the_title( $_POST['post_id'] ));
		    update_post_meta($pid,'career_apply_cv',$cv_id);
		    update_post_meta($pid,'career_apply_cover_letter',$cover_id);
		    update_post_meta($pid,'career_apply_message',$_POST['message']);
        }
	}
	wp_send_json(array('stt'=>'done','msg'=>esc_html__('Apply successfully!','k2_text_domain')));
	die();
}

/* Create Demo Data */
add_filter('swa_ie_export_mode', 'k2_theme_frame_enable_export_mode');
function k2_theme_frame_enable_export_mode()
{
    return false;
}
/* Dashboard Theme */
add_filter('cms_documentation_link',function(){
     return 'http://doc.cmssuperheroes.com/wordpress/k2_prefix/';
});

add_filter('cms_ticket_link', 'k2_theme_frame_add_cms_ticket_link');
function k2_theme_frame_add_cms_ticket_link($url)
{
    $url = array('type' => 'url', 'link' => 'https://cmssuperheroes.com/ticket');
    return $url;
}
add_filter('cms_video_tutorial_link',function(){
     return 'https://www.youtube.com';
});