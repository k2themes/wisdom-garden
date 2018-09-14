<?php
/**
 * Cart Form
 */

echo '<div class="site-shopping-cart">';

if ( class_exists( 'WC_Widget_Cart' ) )
{
    the_widget( 'WC_Widget_Cart',
        array(
            'title'         => esc_html__( 'Cart', 'k2_text_domain' ),
            'hide_if_empty' => 0
        ),
        array(
            'before_widget' => '<section class="widget woocommerce widget_shopping_cart">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>'
        )
    );
}

echo '</div>';