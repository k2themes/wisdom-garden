<?php
/**
 * Custom template tags for this theme.
 *
 * @package k2_prefix
 */

/**
 * Header layout
 **/
function k2_theme_frame_page_loading()
{
    $page_loading = k2_theme_frame_get_opt( 'show_page_loading', false );

    if($page_loading) { ?>
        <div id="cms-loadding" class="cms-loader">
            <div class="loading-spin">
                <div class="spinner">
                    <div class="right-side"><div class="bar"></div></div>
                    <div class="left-side"><div class="bar"></div></div>
                </div>
                <div class="spinner color-2" style="">
                    <div class="right-side"><div class="bar"></div></div>
                    <div class="left-side"><div class="bar"></div></div>
                </div>
            </div>
        </div>
    <?php }
}

/**
 * Header layout
 **/
function k2_theme_frame_header_layout()
{
    $header_layout = k2_theme_frame_get_opt( 'header_layout', '1' );
    $custom_header = k2_theme_frame_get_page_opt( 'custom_header', '0' );

    if ( is_page() && $custom_header == '1' )
    {
        $page_header_layout = k2_theme_frame_get_page_opt('header_layout');
        $header_layout = $page_header_layout;
        if($header_layout == '0') {
            return;
        }
    }

    get_template_part( 'template-parts/header-layout', $header_layout );
}

/**
 * Page title layout
 **/
function k2_theme_frame_page_title_layout()
{

    $ptitle_layout = k2_theme_frame_get_opt( 'ptitle_layout', '1' );
    $custom_pagetitle = k2_theme_frame_get_page_opt( 'custom_pagetitle', '0' );
    if ( $custom_pagetitle == '1' )
    {
        $page_ptitle_layout = k2_theme_frame_get_page_opt('ptitle_layout');
        $ptitle_layout = $page_ptitle_layout;
    }
    if($ptitle_layout == '0') {
        return;
    }
    get_template_part( 'template-parts/page-title', $ptitle_layout );
}

/**
 * Page title layout
 **/
function k2_theme_frame_footer()
{
    $footer_layout = k2_theme_frame_get_opt( 'footer_layout', '1' );
    $custom_footer = k2_theme_frame_get_page_opt( 'custom_footer', '0' );

    if ( is_page() && $custom_footer == '1' )
    {
        $page_footer_layout = k2_theme_frame_get_page_opt('footer_layout');
        $footer_layout = $page_footer_layout;
        if($footer_layout == '0') {
            return;
        }
    }
    get_template_part( 'template-parts/footer-layout', $footer_layout );
}

/**
 * Set primary content class based on sidebar position
 * 
 * @param  string $sidebar_pos
 * @param  string $extra_class
 */
function k2_theme_frame_primary_class( $sidebar_pos, $extra_class = '' )
{
    if ( class_exists( 'WooCommerce' ) && (is_product_category()) ) :
        $sidebar_load = 'sidebar-shop';
    elseif (is_page()) :
        $sidebar_load = 'sidebar-page';
    else :
        $sidebar_load = 'sidebar-blog';
    endif;

    if ( is_active_sidebar( $sidebar_load ) ) {
        $class = array( trim( $extra_class ) );
        switch ( $sidebar_pos )
        {
            case 'left':
                $class[] = 'content-has-sidebar float-right col-xl-8 col-lg-8 col-md-12';
                break;

            case 'right':
                $class[] = 'content-has-sidebar float-left col-xl-8 col-lg-8 col-md-12';
                break;

            default:
                $class[] = 'content-full-width col-12';
                break;
        }

        $class = implode( ' ', array_filter( $class ) );

        if ( $class )
        {
            echo ' class="' . esc_html($class) . '"';
        }
    } else {
        echo ' class="content-area col-12"'; 
    }
}

/**
 * Set secondary content class based on sidebar position
 * 
 * @param  string $sidebar_pos
 * @param  string $extra_class
 */
function k2_theme_frame_secondary_class( $sidebar_pos, $extra_class = '' )
{
    if ( class_exists( 'WooCommerce' ) && (is_product_category()) ) :
        $sidebar_load = 'sidebar-shop';
    elseif (is_page()) :
        $sidebar_load = 'sidebar-page';
    else :
        $sidebar_load = 'sidebar-blog';
    endif;

    if ( is_active_sidebar( $sidebar_load ) ) {
        $class = array(trim($extra_class));
        switch ($sidebar_pos) {
            case 'left':
                $class[] = 'widget-has-sidebar sidebar-fixed col-xl-4 col-lg-4 col-md-12';
                break;

            case 'right':
                $class[] = 'widget-has-sidebar sidebar-fixed col-xl-4 col-lg-4 col-md-12';
                break;

            default:
                break;
        }

        $class = implode(' ', array_filter($class));

        if ($class) {
            echo ' class="' . esc_html($class) . '"';
        }
    }
}


/**
 * Prints HTML for breadcrumbs.
 */
function k2_theme_frame_breadcrumb()
{
    if ( ! class_exists( 'K2_Breadcrumb' ) )
    {
        return;
    }

    $breadcrumb = new K2_Breadcrumb();
    $entries = $breadcrumb->get_entries();

    if ( empty( $entries ) )
    {
        return;
    }

    ob_start();

    foreach ( $entries as $entry )
    {
        $entry = wp_parse_args( $entry, array(
            'label' => '',
            'url'   => ''
        ) );

        if ( empty( $entry['label'] ) )
        {
            continue;
        }

        echo '<li>';

        if ( ! empty( $entry['url'] ) )
        {
            printf(
                '<a class="breadcrumb-entry" href="%1$s">%2$s</a>',
                esc_url( $entry['url'] ),
                esc_attr( $entry['label'] )
            );
        }
        else
        {
            printf( '<span class="breadcrumb-entry" >%s</span>', esc_html( $entry['label'] ) );
        }

        echo '</li>';
    }

    $output = ob_get_clean();

    if ( $output )
    {
        printf( '<ul class="cms-breadcrumb">%s</ul>', wp_kses_post($output));
    }
}


function k2_theme_frame_entry_link_pages()
{
    wp_link_pages( array(
        'before' => sprintf( '<div class="page-links">', esc_html__( 'Pages:', 'k2_text_domain' ) ),
        'after'  => '</div>',
    ) );
}


if ( ! function_exists( 'k2_theme_frame_entry_excerpt' ) ) :
    /**
     * Print post excerpt based on length.
     *
     * @param  integer $length
     */
    function k2_theme_frame_entry_excerpt( $length = 55 )
    {
        $cms_the_excerpt = get_the_excerpt();
        if(!empty($cms_the_excerpt)) {
            echo esc_html($cms_the_excerpt);
        } else {
            echo wp_kses_post(k2_theme_frame_get_the_excerpt( $length ));
        }
    }
endif;

/**
 * Prints post edit link when applicable
 */
function k2_theme_frame_entry_edit_link()
{
    edit_post_link(
        sprintf(
            wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                esc_html__( 'Edit', 'k2_text_domain' ),
                array(
                    'span' => array(
                        'class' => array(),
                    ),
                )
            ),
            get_the_title()
        ),
        '<div class="entry-edit-link"><i class="fa fa-edit"></i>',
        '</div>'
    );
}


/**
 * Prints posts pagination based on query
 *
 * @param  WP_Query $query     Custom query, if left blank, this will use global query ( current query )
 * @return void
 */
function k2_theme_frame_posts_pagination( $query = null )
{
    $classes = array();

    if ( empty( $query ) )
    {
        $query = $GLOBALS['wp_query'];
    }

    if ( empty( $query->max_num_pages ) || ! is_numeric( $query->max_num_pages ) || $query->max_num_pages < 2 )
    {
        return;
    }

    $paged = get_query_var( 'paged' );

    if ( ! $paged && is_front_page() && ! is_home() )
    {
        $paged = get_query_var( 'page' );
    }

    $paged = $paged ? intval( $paged ) : 1;

    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $query_args   = array();
    $url_parts    = explode( '?', $pagenum_link );

    if ( isset( $url_parts[1] ) )
    {
        wp_parse_str( $url_parts[1], $query_args );
    }

    $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
    $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

    $pagination_style = k2_theme_frame_get_opt('pagination_style', 'default');
    $html_prev = '';
    $html_next = '';
    if($pagination_style == 'renovation' || $pagination_style == 'industrial') {
        $html_prev = esc_html__('Previous', 'k2_text_domain');
        $html_next = esc_html__('Next', 'k2_text_domain');
    } else {
        $html_prev = '<i class="fa fa-long-arrow-left"></i>';
        $html_next = '<i class="fa fa-long-arrow-right"></i>';
    }
    // Set up paginated links.
    $links = paginate_links( array(
        'base'     => $pagenum_link,
        'total'    => $query->max_num_pages,
        'current'  => $paged,
        'mid_size' => 1,
        'add_args' => array_map( 'urlencode', $query_args ),
        'prev_text' => $html_prev,
        'next_text' => $html_next,
    ) );

    $template = '
    <nav class="navigation posts-pagination style-'.$pagination_style.'">
        <div class="posts-page-links">%2$s</div>
    </nav>';

    if ( $links )
    {
        printf(
            wp_kses_post($template),
            esc_html__( 'Navigation', 'k2_text_domain' ),
            wp_kses_post($links)
        );
    }
}

/**
 * Prints archive meta on blog
 */
if ( ! function_exists( 'k2_theme_frame_archive_meta' ) ) :
    function k2_theme_frame_archive_meta() {
        $archive_author_on = k2_theme_frame_get_opt( 'archive_author_on', true );
        $archive_categories_on = k2_theme_frame_get_opt( 'archive_categories_on', true );
        $archive_comments_on = k2_theme_frame_get_opt( 'archive_comments_on', true );
        $archive_date_on = k2_theme_frame_get_opt( 'archive_date_on', true );
        $archive_sticky_on = k2_theme_frame_get_opt( 'archive_sticky_on', true );
        if($archive_author_on || $archive_comments_on || $archive_categories_on || $archive_date_on || $archive_sticky_on) : ?>
            <ul class="entry-meta">
                <?php if($archive_author_on) : ?>
                    <li><?php the_author_posts_link(); ?></li>
                <?php endif; ?>
                <?php if($archive_comments_on) : ?>
                    <li><a href="<?php the_permalink(); ?>"><?php echo comments_number(esc_html__('Comment 0', 'k2_text_domain'),esc_html__('Comment 1', 'k2_text_domain'),esc_html__('% Comments', 'k2_text_domain')); ?></a></li>
                <?php endif; ?>
                <?php if($archive_categories_on) : ?>
                    <li><?php the_terms( get_the_ID(), 'category', '', ', ' ); ?></li>
                <?php endif; ?>
                <?php if($archive_date_on) : ?>
                    <li><?php echo get_the_date(); ?></li>
                <?php endif; ?>
                <?php if($archive_sticky_on && is_sticky()) { ?>
                    <li><?php echo esc_html__('Sticky', 'k2_text_domain'); ?></li>
                <?php } ?>
            </ul>
    <?php endif; }
endif;

if ( ! function_exists( 'k2_theme_frame_post_meta' ) ) :
    function k2_theme_frame_post_meta() {
        $post_author_on = k2_theme_frame_get_opt( 'post_author_on', true );
        $post_categories_on = k2_theme_frame_get_opt( 'post_categories_on', true );
        $post_comments_on = k2_theme_frame_get_opt( 'post_comments_on', true );
        $post_date_on = k2_theme_frame_get_opt( 'post_date_on', false );
        $post_sticky_on = k2_theme_frame_get_opt( 'post_sticky_on', true );
        $post_tags_on = k2_theme_frame_get_opt( 'post_tags_on', false );
        $single_post_layout = k2_theme_frame_get_opt( 'single_post_layout', 'default' );
        if($post_author_on || $post_comments_on || $post_categories_on || $post_date_on || $post_sticky_on || $post_tags_on) : ?>
        <ul class="entry-meta">
            <?php if($post_author_on) : ?>
                <li>
                    <?php if($single_post_layout == 'conversion') { ?>
                        <span><?php echo esc_html__('by', 'k2_text_domain'); ?></span>
                    <?php } ?>
                    <?php the_author_posts_link(); ?>
                </li>
            <?php endif; ?>
            <?php if($post_comments_on) : ?>
                <li><a href="<?php the_permalink(); ?>"><?php echo comments_number(esc_html__('Comment 0', 'k2_text_domain'),esc_html__('Comment 1', 'k2_text_domain'),esc_html__('% Comments', 'k2_text_domain')); ?></a></li>
            <?php endif; ?>
            <?php if($post_categories_on) : ?>
                <li><?php the_terms( get_the_ID(), 'category', '', ', ' ); ?></li>
            <?php endif; ?>
            <?php if($post_date_on) : ?>
                <li><?php echo get_the_date(); ?></li>
            <?php endif; ?>
            <?php if($post_sticky_on && is_sticky()) { ?>
                <li><?php echo esc_html__('Sticky', 'k2_text_domain'); ?></li>
            <?php } ?>
            <?php if($post_tags_on && $single_post_layout != 'real-estate') : ?>
                <li><?php k2_theme_frame_entry_tagged_in(); ?></li>
            <?php endif; ?>
        </ul>
    <?php endif; }
endif;

if ( ! function_exists( 'k2_theme_frame_post_meta_con_company' ) ) :
    function k2_theme_frame_post_meta_con_company() {
        $post_author_on = k2_theme_frame_get_opt( 'post_author_on', true );
        $post_categories_on = k2_theme_frame_get_opt( 'post_categories_on', true );
        $post_comments_on = k2_theme_frame_get_opt( 'post_comments_on', true );
        $post_date_on = k2_theme_frame_get_opt( 'post_date_on', false );
        $post_sticky_on = k2_theme_frame_get_opt( 'post_sticky_on', true );
        $post_tags_on = k2_theme_frame_get_opt( 'post_tags_on', false );
        $single_post_layout = k2_theme_frame_get_opt( 'single_post_layout', 'default' );
        if($post_author_on || $post_comments_on || $post_categories_on || $post_date_on || $post_sticky_on || $post_tags_on) : ?>
        <ul class="entry-meta">
            <?php if($post_date_on) : ?>
                <li><?php echo get_the_date(); ?></li>
            <?php endif; ?>
            <?php if($post_author_on) : ?>
                <li class="post-meta-author">
                    <span><?php echo esc_html__('by', 'k2_text_domain'); ?></span>
                    <?php the_author_posts_link(); ?>
                </li>
            <?php endif; ?>
            <?php if($post_comments_on) : ?>
                <li><a href="<?php the_permalink(); ?>"><?php echo comments_number(esc_html__('Comment 0', 'k2_text_domain'),esc_html__('Comment 1', 'k2_text_domain'),esc_html__('% Comments', 'k2_text_domain')); ?></a></li>
            <?php endif; ?>
            <?php if($post_categories_on) : ?>
                <li><?php the_terms( get_the_ID(), 'category', '', ', ' ); ?></li>
            <?php endif; ?>
            <?php if($post_sticky_on && is_sticky()) { ?>
                <li><?php echo esc_html__('Sticky', 'k2_text_domain'); ?></li>
            <?php } ?>
            <?php if($post_tags_on && $single_post_layout != 'real-estate') : ?>
                <li><?php k2_theme_frame_entry_tagged_in(); ?></li>
            <?php endif; ?>
        </ul>
    <?php endif; }
endif;

/**
 * Prints tag list
 */
if ( ! function_exists( 'k2_theme_frame_entry_tagged_in' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function k2_theme_frame_entry_tagged_in()
    {
        $single_post_layout = k2_theme_frame_get_opt( 'single_post_layout', 'default' );
        if($single_post_layout == 'real-estate') {
            $tags_list = get_the_tag_list( '<label>'.esc_html__('Tags', 'k2_text_domain').'</label>', ' ' );
        } else {
            $tags_list = get_the_tag_list( '', ' ' );
        }

        if ( $tags_list )
        {
            echo '<div class="entry-tags">';
            printf('%2$s', '', $tags_list);
            echo '</div>';
        }
    }
endif;

/**
 * List socials share for post.
 */
function k2_theme_frame_socials_share_default() { ?>
    <ul>
        <li><a class="fb-social" title="Facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="zmdi zmdi-facebook"></i><span><?php echo esc_html__('Share', 'k2_text_domain'); ?></span></a></li>
        <li><a class="tw-social" title="Twitter" target="_blank" href="https://twitter.com/home?status=<?php the_permalink(); ?>"><i class="zmdi zmdi-twitter"></i><span><?php echo esc_html__('Twitter', 'k2_text_domain'); ?></span></a></li>
        <li><a class="g-social" title="Google Plus" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="zmdi zmdi-google-plus"></i><span><?php echo esc_html__('Share', 'k2_text_domain'); ?></span></a></li>
        <li><a class="in-social" title="LinkedIn" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&summary=&source="><i class="zmdi zmdi-linkedin"></i><span><?php echo esc_html__('Share', 'k2_text_domain'); ?></span></a></li>
    </ul>
    <?php
}
function k2_theme_frame_socials_share_industrial() { ?>
    <ul>
        <li><a class="fb-social" title="Facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="zmdi zmdi-facebook"></i><span><?php echo esc_html__('Share', 'k2_text_domain'); ?></span></a></li>
        <li><a class="tw-social" title="Twitter" target="_blank" href="https://twitter.com/home?status=<?php the_permalink(); ?>"><i class="zmdi zmdi-twitter"></i><span><?php echo esc_html__('Twitter', 'k2_text_domain'); ?></span></a></li>
        <li><a class="g-social" title="Google Plus" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="zmdi zmdi-google-plus"></i><span><?php echo esc_html__('Share', 'k2_text_domain'); ?></span></a></li>
        <li><a class="in-social" title="LinkedIn" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&summary=&source="><i class="zmdi zmdi-linkedin"></i><span><?php echo esc_html__('Share', 'k2_text_domain'); ?></span></a></li>
        <li><a class="pin-social" title="Pinterest" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url(the_post_thumbnail_url( 'full' )); ?>&media=&description=<?php the_title(); ?>"><i class="zmdi zmdi-pinterest"></i><span><?php echo esc_html__('Pin', 'k2_text_domain'); ?></span></a></li>
    </ul>
    <?php
}
function k2_theme_frame_socials_share_corporate() { ?>
    <ul>
        <li><?php echo esc_html__('Share this Story:', 'k2_text_domain');?></li>
        <li><a class="fb-social" title="Facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="zmdi zmdi-facebook"></i></a></li>
        <li><a class="tw-social" title="Twitter" target="_blank" href="https://twitter.com/home?status=<?php the_permalink(); ?>"><i class="zmdi zmdi-twitter"></i></a></li>
        <li><a class="g-social" title="Google Plus" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="zmdi zmdi-google-plus"></i></a></li>
        <li><a class="in-social" title="LinkedIn" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&summary=&source="><i class="zmdi zmdi-linkedin"></i></a></li>
        <li><a class="pin-social" title="Pinterest" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url(the_post_thumbnail_url( 'full' )); ?>&media=&description=<?php the_title(); ?>"><i class="zmdi zmdi-pinterest"></i></a></li>
    </ul>
    <?php
}
function k2_theme_frame_socials_share_conversion() { ?>
    <ul>
        <li><a class="fb-social" title="Facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="zmdi zmdi-facebook"></i><span><?php echo esc_html__('Share', 'k2_text_domain'); ?></span></a></li>
        <li><a class="tw-social" title="Twitter" target="_blank" href="https://twitter.com/home?status=<?php the_permalink(); ?>"><i class="zmdi zmdi-twitter"></i><span><?php echo esc_html__('Twitter', 'k2_text_domain'); ?></span></a></li>
    </ul>
    <?php
}
function k2_theme_frame_socials_share_real() { ?>
    <ul>
        <li><label><?php echo esc_html__('Share Story', 'k2_text_domain'); ?></label></li>
        <li><a class="fb-social" title="Facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="zmdi zmdi-facebook"></i></a></li>
        <li><a class="tw-social" title="Twitter" target="_blank" href="https://twitter.com/home?status=<?php the_permalink(); ?>"><i class="zmdi zmdi-twitter"></i></a></li>
        <li><a class="tw-email" title="Email" href="mailto:contact@example.com?subject=<?php the_title(); ?>&body=Check out this site <?php the_permalink(); ?>"><i class="zmdi zmdi-email"></i></a></li>
    </ul>
    <?php
}

/**
 * Footer Top
 */
function k2_theme_frame_footer_top() {
    $footer_top_column = k2_theme_frame_get_opt( 'footer_top_column' );
    $footer_layout = k2_theme_frame_get_opt( 'footer_layout' );
    $footer_contact_phone_label = k2_theme_frame_get_opt( 'footer_contact_phone_label' );
    $footer_contact_phone = k2_theme_frame_get_opt( 'footer_contact_phone' );
    $footer_contact_email_label = k2_theme_frame_get_opt( 'footer_contact_email_label' );
    $footer_contact_email = k2_theme_frame_get_opt( 'footer_contact_email' );

    if(empty($footer_top_column))
        return;

    $_class = "";

    switch ($footer_top_column){
        case '2':
            $_class = 'col-xl-6 col-lg-6 col-md-6 col-sm-12';
            break;
        case '3':
            $_class = 'col-xl-4 col-lg-4 col-md-12 col-sm-12';
            break;
        case '4':
            $_class = 'col-xl-3 col-lg-3 col-md-6 col-sm-12';
            break;
    }

    for($i = 1 ; $i <= $footer_top_column ; $i++){
        if ( is_active_sidebar( 'sidebar-footer-' . $i ) ){
            echo '<div class="cms-footer-item ' . esc_html($_class) . '">';
                dynamic_sidebar( 'sidebar-footer-' . $i );
                if($i == '3' && $footer_layout == '5') { ?>
                    <div class="footer5-section-group">
                        <?php if(!empty($footer_contact_phone) && !empty($footer_contact_email)) : ?>
                            <section id="footer5-quick-contact" class="widget">
                                <h2 class="footer-widget-title"><?php echo esc_html__('Quick Contact', 'k2_text_domain'); ?></h2>
                                <div class="footer-widget-content">
                                    <?php if(!empty($footer_contact_phone)) : ?>
                                        <div class="quick-contact-item">
                                            <label><?php echo esc_attr( $footer_contact_phone_label ); ?></label>
                                            <a class="ft-pn-sb" href="tel:<?php echo esc_attr( $footer_contact_phone ); ?>"><?php echo esc_attr( $footer_contact_phone ); ?></a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(!empty($footer_contact_email)) : ?>
                                        <div class="quick-contact-item">
                                            <label><?php echo esc_attr( $footer_contact_email_label ); ?></label>
                                            <a class="ft-pn-sb" href="mailto:<?php echo esc_attr( $footer_contact_email ); ?>"><?php echo esc_attr( $footer_contact_email ); ?></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </section>
                        <?php endif; ?>
                        <section id="footer5-social-contact" class="widget">
                            <h2 class="footer-widget-title"><?php echo esc_html__('Social', 'k2_text_domain'); ?></h2>
                            <div class="footer-widget-content">
                                <div class="footer-social">
                                    <?php k2_theme_frame_top_bar_social_icon_box(); ?>
                                </div>
                            </div>
                        </section>
                    </div>
                <?php }
                if($i == '3' && $footer_layout == '6') { ?>
                    <div class="footer5-section-group">
                        <section id="footer5-social-contact" class="widget">
                            <h2 class="footer-widget-title"><?php echo esc_html__('Follow Us!', 'k2_text_domain'); ?></h2>
                            <div class="footer-widget-content">
                                <div class="footer-social">
                                    <?php k2_theme_frame_top_bar_social_icon_box(); ?>
                                </div>
                            </div>
                        </section>
                    </div>
                <?php }
            echo "</div>";
        }
    }
}

/**
* Display navigation to next/previous post when applicable.
*/
function k2_theme_frame_post_nav_default() {
    global $post;
    // Don't print empty markup if there's nowhere to navigate.
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous )
        return;
    ?>
    <?php
    $next_post = get_next_post();
    $previous_post = get_previous_post();
    if( !empty($next_post) || !empty($previous_post) ) { ?>
        <div class="post-previous-next style-default">
            <div class="nav-links row clearfix">
                <?php if ( is_a( $previous_post , 'WP_Post' ) && get_the_title( $previous_post->ID ) != '') { ?>
                    <div class="nav-link-prev col-md-6 col-sm-12">
                        <?php $url_prev = wp_get_attachment_image_src(get_post_thumbnail_id($previous_post->ID), 'k2_prefix-medium', false); ?>
                        <div class="nav-item-inner">
                            <span><?php echo esc_html_e('Previous Story', 'k2_text_domain') ?></span>
                            <?php if(!empty($url_prev)) : ?>
                                <div class="nav-item-image bg-image" style="background-image: url(<?php echo esc_url($url_prev[0]); ?>);">
                                    <a href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>"></a>
                                </div>
                            <?php endif; ?>
                            <h3><a href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>"><?php echo get_the_title( $previous_post->ID ); ?></a></h3>
                            <div class="nav-item-date"><?php echo get_the_date(); ?></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ( is_a( $next_post , 'WP_Post' ) && get_the_title( $next_post->ID ) != '') { ?>
                    <div class="nav-link-next col-md-6 col-sm-12">
                        <?php $url_next = wp_get_attachment_image_src(get_post_thumbnail_id($next_post->ID), 'k2_prefix-medium', false); ?>
                        <div class="nav-item-inner">
                            <span><?php echo esc_html_e('Next Story', 'k2_text_domain') ?></span>
                            <?php if(!empty($url_next)) : ?>
                                <div class="nav-item-image bg-image" style="background-image: url(<?php echo esc_url($url_next[0]); ?>);">
                                    <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"></a>
                                </div>
                            <?php endif; ?>
                            <h3><a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><?php echo get_the_title( $next_post->ID ); ?></a></h3>
                            <div class="nav-item-date"><?php echo get_the_date(); ?></div>
                        </div>
                    </div>
                <?php } ?>
            </div><!-- .nav-links -->
        </div>
    <?php }
}
function k2_theme_frame_post_nav_industrial() {
    global $post;
    // Don't print empty markup if there's nowhere to navigate.
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous )
        return;
    ?>
    <?php
    $next_post = get_next_post();
    $previous_post = get_previous_post();
    if( !empty($next_post) || !empty($previous_post) ) { ?>
        <div class="post-previous-next cms-grid-blog cms-grid-blog-layout3 cms-grid-layout-modern">
            <div class="nav-links row clearfix">
                <?php if ( is_a( $previous_post , 'WP_Post' ) && get_the_title( $previous_post->ID ) != '') { ?>
                    <div class="nav-link-prev grid-item col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <span><?php echo esc_html_e('Previous Story', 'k2_text_domain') ?></span>
                        <?php $url_prev = wp_get_attachment_image_src(get_post_thumbnail_id($previous_post->ID), 'k2_prefix-medium', false); ?>
                        <div class="grid-item-inner">
                            <div class="item-featured">
                                <a href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>" class="overlay-gradient">
                                    <span style="background-image: url(<?php echo esc_url($url_prev[0]); ?>);"></span>
                                </a>
                            </div>
                            <div class="item-holder hide-hover">
                                <div class="item-category text-heading">
                                    <?php the_terms( $previous_post->ID, 'category', '', ', ' ); ?>
                                </div>
                                <h3 class="item-title">
                                    <a href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>"><?php echo get_the_title( $previous_post->ID ); ?></a>
                                </h3>
                            </div>
                            <div class="item-holder">
                                <div class="item-category text-heading">
                                    <?php the_terms( $previous_post->ID, 'category', '', ', ' ); ?>
                                </div>
                                <h3 class="item-title">
                                    <a href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>"><?php echo get_the_title( $previous_post->ID ); ?></a>
                                </h3>
                                <div class="item-readmore text-heading">
                                    <a href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>"><?php echo esc_html__('Read Story', 'k2_text_domain'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ( is_a( $next_post , 'WP_Post' ) && get_the_title( $next_post->ID ) != '') { ?>
                    <div class="nav-link-next grid-item col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <span><?php echo esc_html_e('Next Story', 'k2_text_domain') ?></span>
                        <?php $url_next = wp_get_attachment_image_src(get_post_thumbnail_id($next_post->ID), 'k2_prefix-medium', false); ?>
                        <div class="grid-item-inner">
                            <div class="item-featured">
                                <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>" class="overlay-gradient">
                                    <span style="background-image: url(<?php echo esc_url($url_next[0]); ?>);"></span>
                                </a>
                            </div>
                            <div class="item-holder hide-hover">
                                <div class="item-category text-heading">
                                    <?php the_terms( $next_post->ID, 'category', '', ', ' ); ?>
                                </div>
                                <h3 class="item-title">
                                    <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><?php echo get_the_title( $next_post->ID ); ?></a>
                                </h3>
                            </div>
                            <div class="item-holder">
                                <div class="item-category text-heading">
                                    <?php the_terms( $next_post->ID, 'category', '', ', ' ); ?>
                                </div>
                                <h3 class="item-title">
                                    <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><?php echo get_the_title( $next_post->ID ); ?></a>
                                </h3>
                                <div class="item-readmore text-heading">
                                    <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><?php echo esc_html__('Read Story', 'k2_text_domain'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div><!-- .nav-links -->
        </div>
    <?php }
}

function k2_theme_frame_post_nav_corporate() {
    global $post;
    // Don't print empty markup if there's nowhere to navigate.
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous )
        return;
    ?>
    <?php
    $next_post = get_next_post();
    $previous_post = get_previous_post();
    if( !empty($next_post) || !empty($previous_post) ) { ?>
        <div class="post-previous-next cms-grid-portfolio cms-grid-portfolio-layout4">
            <div class="nav-links row clearfix">
                <div class="line-gap"></div>
                <?php if ( is_a( $previous_post , 'WP_Post' ) && get_the_title( $previous_post->ID ) != '') { ?>
                    <div class="nav-link-prev grid-item col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <span><?php echo esc_html_e('Previous Project', 'k2_text_domain') ?></span>
                        <?php $url_prev = wp_get_attachment_image_src(get_post_thumbnail_id($previous_post->ID), 'medium', false); ?>
                        <div class="grid-item-inner">
                            <div class="item-featured">
                                <a href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>" class="bg-overlay">
                                    <img src="<?php echo esc_url($url_prev[0]); ?>" />
                                </a>
                            </div>
                            <div class="item-holder">
                                <div class="item-category">
                                    <?php the_terms( $previous_post->ID, 'portfolio-category', '', ', ' ); ?>
                                </div>
                                <h3 class="item-title">
                                    <a href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>"><?php echo get_the_title( $previous_post->ID ); ?></a>
                                </h3>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ( is_a( $next_post , 'WP_Post' ) && get_the_title( $next_post->ID ) != '') { ?>
                    <div class="nav-link-next grid-item col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <span><?php echo esc_html_e('Next Project', 'k2_text_domain') ?></span>
                        <?php $url_next = wp_get_attachment_image_src(get_post_thumbnail_id($next_post->ID), 'medium', false); ?>
                        <div class="grid-item-inner">
                            <div class="item-featured">
                                <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>" class="bg-overlay">
                                    <img src="<?php echo esc_url($url_next[0]); ?>" />
                                </a>
                            </div>
                            <div class="item-holder">
                                <div class="item-category">
                                    <?php the_terms( $next_post->ID, 'portfolio-category', '', ', ' ); ?>
                                </div>
                                <h3 class="item-title">
                                    <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><?php echo get_the_title( $next_post->ID ); ?></a>
                                </h3>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div><!-- .nav-links -->
        </div>
    <?php }
}

/**
 * Social Footer
 */
function k2_theme_frame_footer_social() {
    $footer_social = k2_theme_frame_get_opt( 'footer_social' );
    $social = $footer_social['enabled'];
    if ($social) : foreach ($social as $key=>$value) { ?>
        <?php switch($key) {

            case 'facebook': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_facebook_url' )).'"><span>'.esc_html( 'Facebook', 'k2_text_domain' ).'</span></a>';
            break;

            case 'twitter': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_twitter_url' )).'"><span>'.esc_html( 'Twitter', 'k2_text_domain' ).'</span></a>';
            break;

            case 'linkedin': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_inkedin_url' )).'"><span>'.esc_html( 'Linkedin', 'k2_text_domain' ).'</span></a>';
            break;

            case 'instagram': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_instagram_url' )).'"><span>'.esc_html( 'Instagram', 'k2_text_domain' ).'</span></a>';
            break;

            case 'google': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_google_url' )).'"><span>'.esc_html( 'Google Plus', 'k2_text_domain' ).'</span></a>';
            break;

            case 'skype': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_skype_url' )).'"><span>'.esc_html( 'Skype', 'k2_text_domain' ).'</span></a></li>';
            break;

            case 'pinterest': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_pinterest_url' )).'"><span>'.esc_html( 'Pinterest', 'k2_text_domain' ).'</span></a>';
            break;

            case 'vimeo': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_vimeo_url' )).'"><span>'.esc_html( 'Vimeo', 'k2_text_domain' ).'</span></a>';
            break;

            case 'youtube': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_youtube_url' )).'"><span>'.esc_html( 'Youtube', 'k2_text_domain' ).'</span></a>';
            break;

            case 'yelp': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_yelp_url' )).'"><span>'.esc_html( 'Yelp', 'k2_text_domain' ).'</span></a>';
            break;

            case 'tumblr': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_tumblr_url' )).'"><span>'.esc_html( 'Tumblr', 'k2_text_domain' ).'</span></a>';
            break;

            case 'tripadvisor': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_tripadvisor_url' )).'"><span>'.esc_html( 'Tripadvisor', 'k2_text_domain' ).'</span></a>';

            break;

        }
    }
    endif;
}
function k2_theme_frame_top_bar_social_icon() {
    $footer_social = k2_theme_frame_get_opt( 'footer_social' );
    $social = $footer_social['enabled'];
    if ($social) : foreach ($social as $key=>$value) { ?>
        <?php switch($key) {

            case 'facebook': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_facebook_url' )).'"><i class="zmdi zmdi-facebook"></i></a>';
            break;

            case 'twitter': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_twitter_url' )).'"><i class="zmdi zmdi-twitter"></i></a>';
            break;

            case 'linkedin': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_inkedin_url' )).'"><i class="zmdi zmdi-linkedin"></i></a>';
            break;

            case 'instagram': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_instagram_url' )).'"><i class="zmdi zmdi-instagram"></i></a>';
            break;

            case 'google': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_google_url' )).'"><i class="zmdi zmdi-google-plus"></i></a>';
            break;

            case 'skype': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_skype_url' )).'"><i class="zmdi zmdi-skype"></i></a>';
            break;

            case 'pinterest': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_pinterest_url' )).'"><i class="zmdi zmdi-pinterest"></i></a>';
            break;

            case 'vimeo': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_vimeo_url' )).'"><i class="zmdi zmdi-vimeo"></i></a>';
            break;

            case 'youtube': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_youtube_url' )).'"><i class="zmdi zmdi-youtube"></i></a>';
            break;

            case 'yelp': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_yelp_url' )).'"><i class="fa fa-yelp"></i></a>';
            break;

            case 'tumblr': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_tumblr_url' )).'"><i class="fa fa-tumblr"></i></a>';
            break;

            case 'tripadvisor': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_tripadvisor_url' )).'"><i class="fa fa-tripadvisor"></i></a>';
            break;

        }
    }
    endif;
}
function k2_theme_frame_top_bar_social_icon_box() {
    $footer_social = k2_theme_frame_get_opt( 'footer_social' );
    $social = $footer_social['enabled'];
    if ($social) : foreach ($social as $key=>$value) { ?>
        <?php switch($key) {

            case 'facebook': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_facebook_url' )).'"><i class="zmdi zmdi-facebook-box"></i></a>';
            break;

            case 'twitter': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_twitter_url' )).'"><i class="zmdi zmdi-twitter-box"></i></a>';
            break;

            case 'linkedin': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_inkedin_url' )).'"><i class="zmdi zmdi-linkedin-box"></i></a>';
            break;

            case 'instagram': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_instagram_url' )).'"><i class="zmdi zmdi-instagram"></i></a>';
            break;

            case 'google': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_google_url' )).'"><i class="zmdi zmdi-google-plus-box"></i></a>';
            break;

            case 'skype': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_skype_url' )).'"><i class="zmdi zmdi-skype-box"></i></a>';
            break;

            case 'pinterest': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_pinterest_url' )).'"><i class="zmdi zmdi-pinterest-box"></i></a>';
            break;

            case 'vimeo': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_vimeo_url' )).'"><i class="zmdi zmdi-vimeo-box"></i></a>';
            break;

            case 'youtube': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_youtube_url' )).'"><i class="zmdi zmdi-youtube-box"></i></a>';
            break;

            case 'yelp': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_yelp_url' )).'"><i class="fa fa-yelp-box"></i></a>';
            break;

            case 'tumblr': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_tumblr_url' )).'"><i class="fa fa-tumblr-box"></i></a>';
            break;

            case 'tripadvisor': echo '<a href="'.esc_url(k2_theme_frame_get_opt( 'social_tripadvisor_url' )).'"><i class="fa fa-tripadvisor-box"></i></a>';
            break;

        }
    }
    endif;
}
function k2_theme_frame_contact_form() {
    $h_btn_link_type = k2_theme_frame_get_opt('h_btn_link_type', 'page_link');
    $popup_contact_form = k2_theme_frame_get_opt('popup_contact_form');
    $title_contact_form = k2_theme_frame_get_opt('title_contact_form');
    $footer_contact_form = k2_theme_frame_get_opt('footer_contact_form');
    if(class_exists('WPCF7') && $h_btn_link_type == 'contact_form' && !empty($popup_contact_form)) { ?>
    <div class="cms-modal cms-modal-contact-form">
        <div class="cms-close"></div>
        <div class="cms-modal-inner">
            <div class="cms-contact-form placeholder-dark cms-contact-form-flat style-primary">
                <?php if(!empty($title_contact_form)) : ?><h3 class="el-title"><?php echo esc_html__('Request a Free Quotation', 'k2_text_domain')?></h3><?php endif; ?>
                <?php echo do_shortcode('[contact-form-7 id="'.esc_attr( $popup_contact_form ).'"]'); ?>
            </div>
            <?php if(!empty($footer_contact_form)) : ?>
                <div class="cms-contact-form-footer">
                    <?php echo wp_kses_post($footer_contact_form); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php }
}

function k2_theme_frame_parallax_scroll() {
    $parallaxscroll = k2_theme_frame_get_opt( 'parallaxscroll', false );
    $parallaxscroll_speed = k2_theme_frame_get_opt( 'parallaxscroll_speed', '4' );
    $data_parallax = '';
    if($parallaxscroll == true) {
        $data_parallax = 'data-speed='.$parallaxscroll_speed.'';
        echo esc_html( $data_parallax );
    }
    return $data_parallax;
}

/**
 * Related Post
 */
function k2_theme_frame_related_post()
{
    global $post;
    $current_id = $post->ID;
    $posttags = get_the_category($post->ID);
    if (empty($posttags)) return;

    $tags = array();

    foreach ($posttags as $tag) {

        $tags[] = $tag->term_id;
    }
    $post_number = '4';
    $item_class = 'col-xl-4 col-lg-4 col-md-12';
    $post_sidebar_pos = k2_theme_frame_get_opt( 'post_sidebar_pos', 'none' );
    if($post_sidebar_pos == 'left' || $post_sidebar_pos == 'right') {
        $post_number = '3';
        $item_class = 'col-xl-6 col-lg-6 col-md-12';
    }
    $query_similar = new WP_Query(array('posts_per_page' => $post_number, 'post_type' => 'post', 'post_status' => 'publish', 'category__in' => $tags));
    if (count($query_similar->posts) > 1) {
        ?>
        <div class="cms-related-post cms-grid-blog-layout5 clearfix">
            <h3 class="section-title"><?php echo esc_html__('More News', 'k2_text_domain'); ?></h3>
            <div class="cms-related-post-inner row">
                <?php foreach ($query_similar->posts as $post):
                    $thumbnail_url = '';
                    if (has_post_thumbnail(get_the_ID()) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) :
                        $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
                    endif;
                    if ($post->ID !== $current_id) : ?>
                        <div class="grid-item <?php echo esc_attr($item_class); ?>">
                            <div class="grid-item-inner">
                                <div class="item-featured">
                                    <a href="<?php the_permalink(); ?>" class="bg-overlay" style="background-image: url(<?php echo esc_url($thumbnail_url[0]); ?>);"></a>
                                </div>
                                <div class="item-holder">
                                    <h3 class="item-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="item-date ft-heading-b">
                                        <?php $date_formart = get_option('date_format'); echo get_the_date($date_formart, $post->ID); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif;
                endforeach; ?>
            </div>
        </div>
    <?php }

    wp_reset_postdata();
}

/**
 * Related Post
 */
function k2_theme_frame_related_post_real()
{
    global $post;
    $current_id = $post->ID;
    $posttags = get_the_category($post->ID);
    if (empty($posttags)) return;

    $tags = array();

    foreach ($posttags as $tag) {

        $tags[] = $tag->term_id;
    }
    $post_number = '4';
    $item_class = 'col-xl-4 col-lg-4 col-md-12';
    $post_sidebar_pos = k2_theme_frame_get_opt( 'post_sidebar_pos', 'none' );
    if($post_sidebar_pos == 'left' || $post_sidebar_pos == 'right') {
        $post_number = '3';
        $item_class = 'col-xl-6 col-lg-6 col-md-12';
    }
    $query_similar = new WP_Query(array('posts_per_page' => $post_number, 'post_type' => 'post', 'post_status' => 'publish', 'category__in' => $tags));
    if (count($query_similar->posts) > 1) {
        ?>
        <div class="cms-related-post cms-grid cms-grid-blog-layout6 cms-grid-effect-top clearfix">
            <h3 class="section-title"><?php echo esc_html__('Related Stories', 'k2_text_domain'); ?></h3>
            <div class="cms-related-post-inner row">
                <?php foreach ($query_similar->posts as $post):
                    $thumbnail_url = '';
                    if (has_post_thumbnail(get_the_ID()) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) :
                        $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
                    endif;
                    if ($post->ID !== $current_id) : ?>
                        <div class="grid-item <?php echo esc_attr($item_class); ?>">
                            <div class="grid-item-inner">
                                <?php if(!empty($thumbnail_url)) : ?>
                                    <div class="item-featured">
                                        <a href="<?php the_permalink(); ?>" class="bg-overlay bg-image" style="background-image: url(<?php echo esc_url($thumbnail_url[0]); ?>);"></a>
                                    </div>
                                <?php endif; ?>
                                <div class="item-holder">
                                    <div class="item-holder-inner">
                                        <div class="item-category">
                                            <?php the_terms( $post->ID, 'category', '', ', ' ); ?>
                                        </div>
                                        <h3 class="item-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <div class="item-meta clearfix">
                                            <?php
                                                echo esc_html__('by', 'k2_text_domain').' ';
                                                the_author_posts_link();
                                                echo ' '.esc_html__('on', 'k2_text_domain').' '; ?>
                                                <span>
                                                    <?php $date_formart = get_option('date_format'); echo get_the_date($date_formart, $post->ID); ?>
                                                </span>
                                        </div>
                                        <div class="item-readmore">
                                            <a class="btn btn-block" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_html__('Read Full Story', 'k2_text_domain'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif;
                endforeach; ?>
            </div>
        </div>
    <?php }

    wp_reset_postdata();
}

/**
 * Related Post
 */
function k2_theme_frame_related_post_con_company()
{
    global $post;
    $current_id = $post->ID;
    $posttags = get_the_category($post->ID);
    if (empty($posttags)) return;

    $tags = array();

    foreach ($posttags as $tag) {

        $tags[] = $tag->term_id;
    }
    $post_number = '4';
    $item_class = 'col-xl-4 col-lg-4 col-md-12';
    $post_sidebar_pos = k2_theme_frame_get_opt( 'post_sidebar_pos', 'none' );
    if($post_sidebar_pos == 'left' || $post_sidebar_pos == 'right') {
        $post_number = '3';
        $item_class = 'col-xl-6 col-lg-6 col-md-12';
    }
    $query_similar = new WP_Query(array('posts_per_page' => $post_number, 'post_type' => 'post', 'post_status' => 'publish', 'category__in' => $tags));
    if (count($query_similar->posts) > 1) {
        ?>
        <div class="cms-related-post cms-grid-blog-layout7 clearfix">
            <h3 class="section-title"><?php echo esc_html__('Related News', 'k2_text_domain'); ?></h3>
            <div class="cms-related-post-inner row">
                <?php foreach ($query_similar->posts as $post):
                    $thumbnail_url = '';
                    if (has_post_thumbnail(get_the_ID()) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) :
                        $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
                    endif;
                    if ($post->ID !== $current_id) : ?>
                        <div class="grid-item <?php echo esc_attr($item_class); ?>">
                            <div class="grid-item-inner">
                                <?php if(!empty($thumbnail_url)) : ?>
                                    <div class="item-featured">
                                        <a href="<?php the_permalink(); ?>" class="bg-overlay bg-image" style="background-image: url(<?php echo esc_url($thumbnail_url[0]); ?>);"></a>
                                    </div>
                                <?php endif; ?>

                                <div class="item-holder">
                                    <div class="item-meta clearfix">
                                        <div class="item-date">
                                            <?php $date_formart = get_option('date_format'); echo get_the_date($date_formart, $post->ID); ?>
                                        </div>
                                        <div class="item-posted">
                                            <?php
                                                echo esc_html__('by', 'k2_text_domain').' ';
                                                the_author_posts_link();
                                                echo ' '.esc_html__('in', 'k2_text_domain').' '; ?>
                                                <span>
                                                    <?php the_terms( $post->ID, 'category', '', ', ' ); ?>
                                                </span>
                                        </div>
                                    </div>
                                    <h3 class="item-title">
                                        <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                                    </h3>
                                    <div class="item-content">
                                        <?php echo wp_trim_words( $post->post_excerpt, $num_words = 17, $more = null ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif;
                endforeach; ?>
            </div>
        </div>
    <?php }

    wp_reset_postdata();
}