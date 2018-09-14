<?php
/**
 * The template for displaying all single service
 *
 * @package k2_prefix
 */
get_header();
$singe_portfolio_layout = k2_theme_frame_get_opt( 'singe_portfolio_layout', 'default' );
get_template_part( 'template-parts/content-portfolio/content', $singe_portfolio_layout );
get_footer();
