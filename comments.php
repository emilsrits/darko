<?php
/**
 * Template for displaying comments
 *
 * @package Mloc
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments">
    <h4 class="comments-header">
        <?php
        $comments_number = get_comments_number();
        if ( 1 === $comments_number ) {
            /* translators: %s: post title */
            _x( 'One comment', 'comments title', 'hestia' );
        } else {
            printf(
                _nx(
                    '%1$s Comment',
                    '%1$s Comments',
                    $comments_number,
                    'comments title',
                    'mloc'
                ),
                number_format_i18n( $comments_number )
            );
        }
        ?>
    </h4>
    <div class="post-comments">
        <?php
        wp_list_comments( 'type=comment&callback=mloc_comments_list' );
        wp_list_comments( 'type=pings&callback=mloc_comments_list' );
        mloc_comments_pagination();
        ?>
    </div> <!-- .post-comments -->
    <div class="comments-reply">
        <?php
        comment_form( mloc_comments_form_template() );
        if ( ! comments_open() && get_comments_number() ) :
            if ( is_single() ) : ?>
                <h4 class="no-comments"><?php esc_html_e( 'Comments are closed', 'mloc' ); ?></h4>
            <?php
            endif;
        endif; ?>
    </div> <!-- .comments-reply -->
</div> <!-- #comments -->
