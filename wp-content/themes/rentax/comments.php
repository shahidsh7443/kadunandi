<?php

if ( post_password_required() ) {
    return;
}

?>
<?php if ( have_comments() ) : ?>
    <ol class="comment-list rtd">
        <?php
        wp_list_comments( array(
            'style'       => 'ol',
            'short_ping'  => true,
            'avatar_size' => 56,
            'walker'      => new RentaxCommentWalker()
        ) );
        ?>
    </ol>
    
    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
            <h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'rentax' ); ?></h1>
            <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'rentax' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'rentax' ) ); ?></div>
        </nav><!-- #comment-nav-below -->
    <?php endif; // Check for comment navigation. ?>
    
<?php endif;?>

<?php
// If comments are closed and there are comments, let's leave a little note, shall we?
if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
    ?>
    <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'rentax' ); ?></p>
<?php endif;?>


<?php rentax_comment_form() ?>


