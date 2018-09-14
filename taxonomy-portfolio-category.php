<?php
/**
 * The template for displaying Archive Portfolio
 *
 * @package k2_prefix
 */

get_header();
?>
<div class="container">
    <div class="row">
        <div id="primary" class="col-12">
            <main id="main" class="site-main">
                <?php
	            	$term = get_term_by( 'slug', get_query_var( 'portfolio-category' ), get_query_var( 'taxonomy' ) );
	                echo apply_filters('the_content','[cms_portfolio_grid cms_template="cms_portfolio_grid.php" limit="9" img_size="500x500" layout="masonry" filter="false" col_xs="1" col_sm="2" col_md="3" col_lg="3" custom_column="false" source="'.$term->slug.'|portfolio-category"]');
	            ?>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div>
</div>
<?php get_footer(); ?>