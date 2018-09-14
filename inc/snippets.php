<?php
/**
 * Function snippets, not part of the theme. Use at your own risks
 */


/**
 * Filter breadcrumb entries for single custom post type
 * 
 * @param  array   $entries Each entry should be an array with 'label' and 'url' keys.
 * @param  WP_Post $post    Current post object
 * @return array
 */
function k2_theme_frame_breadcrumb_single_filter( $entries, $post )
{
    if ( 'cpt' == $post->post_type )
    {
        $new_entries = array();
        $term        = current( wp_get_post_terms( $post->ID, 'ctax2' ) );
        $taxonomy    = get_taxonomy( $term->taxonomy );

        $new_entries[] = array(
            'label' => $term->name,
            'url'   => get_term_link( $term )
        );

        $pterm_id = $term->parent;

        while ( $pterm_id )
        {
            $pterm = get_term( $pterm_id );

            $new_entries[] = array(
                'label' => $pterm->name,
                'url'   => get_term_link( $pterm )
            );
            $pterm_id = $pterm->parent;
        }

        $new_entries[] = array(
            'label' => $taxonomy->labels->name
        );

        return array_reverse( $new_entries );
    }

    return $entries;
}
add_filter( 'k2_theme_frame_breadcrumb_single', 'k2_theme_frame_breadcrumb_single_filter', 10, 2 );