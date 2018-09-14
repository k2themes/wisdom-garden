<?php
/**
 * The template for displaying comments.
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package k2_prefix
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
$post_comments_form_on = k2_theme_frame_get_opt( 'post_comments_form_on', true );

if($post_comments_form_on) : ?>

    <div id="comments" class="comments-area">

        <?php
        // You can start editing here -- including this comment!
        if ( have_comments() ) : ?>
            <div class="comment-list-wrap">
                <h2 class="comments-title">
                    <?php
                    $comment_count = get_comments_number();
                    if ( 1 === intval($comment_count) ) {
                        echo esc_html_e( 'Comment (1)', 'k2_text_domain' );
                    } else {
                        echo esc_html__('Comments', 'k2_text_domain').' ('.esc_attr( $comment_count ).')';
                    }
                    ?>
                </h2><!-- .comments-title -->

                <?php the_comments_navigation(); ?>

                <ul class="comment-list">
                    <?php
                        wp_list_comments( array(
                            'style'      => 'ul',
                            'short_ping' => true,
                            'callback'   => 'k2_theme_frame_comment_list'
                        ) );
                    ?>
                </ul><!-- .comment-list -->

                <?php the_comments_navigation(); ?>
            </div>
            <?php if ( ! comments_open() ) : ?>
                <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'k2_text_domain' ); ?></p>
            <?php
            endif;

        endif; // Check for have_comments().

    $args = array(
            'id_form'           => 'commentform',
            'id_submit'         => 'submit',
            'title_reply'       => esc_html__( 'Leave A Comment', 'k2_text_domain'),
            'title_reply_to'    => esc_html__( 'Leave A Comment To ', 'k2_text_domain') . '%s',
            'cancel_reply_link' => esc_html__( 'Cancel Comment', 'k2_text_domain'),
            'label_submit'      => esc_html__( 'Submit Comment', 'k2_text_domain'),
            'comment_notes_before' => '',
            'fields' => apply_filters( 'comment_form_default_fields', array(

                    'author' =>
                    '<div class="row"><div class="comment-form-author col-lg-4 col-md-4 col-sm-12">'.
                    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                    '" size="30" placeholder="'.esc_html__('Name', 'k2_text_domain').'"/></div>',

                    'email' =>
                    '<div class="comment-form-email col-lg-4 col-md-4 col-sm-12">'.
                    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                    '" size="30" placeholder="'.esc_html__('Email', 'k2_text_domain').'"/></div>',

                    'website' =>
                    '<div class="comment-form-website col-lg-4 col-md-4 col-sm-12">'.
                    '<input id="website" name="website" type="text" value="" size="30" placeholder="'.esc_html__('Website', 'k2_text_domain').'"/></div></div>',
            )
            ),
            'comment_field' =>  '<div class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" placeholder="'.esc_html__('Comment', 'k2_text_domain').'" aria-required="true">' .
            '</textarea></div>',
    );
    comment_form($args);
    ?>

    </div><!-- #comments -->

<?php endif; ?>