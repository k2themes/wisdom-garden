<?php
/**
 * Search Form
 */
$search_field_placeholder = k2_theme_frame_get_opt( 'search_field_placeholder' );
$sidebar_style = k2_theme_frame_get_opt( 'sidebar_style', 'default' );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url( '/' )); ?>">
	<div class="searchform-wrap">
        <input type="text" placeholder="<?php if(!empty($search_field_placeholder)) { echo esc_attr( $search_field_placeholder ); } else { esc_html_e('Search Keywords...', 'k2_text_domain'); } ?>" name="s" class="search-field" />
    	<?php if($sidebar_style == 'conversion') : ?>
			<i class="zmdi zmdi-search"></i>
    		<input type="submit" id="searchsubmit" value="<?php echo esc_html__('Search', 'k2_text_domain')?>" />
    	<?php endif; ?>
    </div>
</form>