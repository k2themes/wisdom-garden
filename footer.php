<?php
/**
 * The template for displaying the footer.
 * Contains the closing of the #content div and all content after.
 *
 * @package k2_prefix
 */
$back_totop_on = k2_theme_frame_get_opt('back_totop_on', true);
$back_totop_style = k2_theme_frame_get_opt('back_totop_style', 'default'); ?>
	</div><!-- #content inner -->
</div><!-- #content -->

<?php k2_theme_frame_footer(); ?>

<?php if (isset($back_totop_on) && $back_totop_on) : ?>
    <a href="#" class="scroll-top <?php echo esc_attr( $back_totop_style ); ?>"><i class="zmdi zmdi-long-arrow-up"></i></a>
<?php endif; ?>

<?php k2_theme_frame_contact_form(); ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
