<?php
/**
 * The header for our theme.
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package k2_prefix
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
    <?php k2_theme_frame_page_loading(); ?>
    <?php k2_theme_frame_header_layout(); ?>
    <?php k2_theme_frame_page_title_layout(); ?>
    <div id="content" class="site-content">
    	<div class="content-inner" <?php k2_theme_frame_parallax_scroll(); ?>>
