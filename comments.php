<?php
/**
 * Template for displaying comments
 *
 * @package Darko
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments">
	<?php
	$comments_count = get_comments_number();
	if ( $comments_count == ! 0 ) : ?>
		<h4 class="comments-header">
			<?php
			printf(
				_nx(
					'%1$s Comment',
					'%1$s Comments',
					$comments_count,
					'comments title',
					'darko'
				),
				number_format_i18n( $comments_count )
			);
			?>
		</h4>
	<?php endif; ?>
    <div class="post-comments">
        <?php
        wp_list_comments( 'type=comment&callback=darko_comments_list' );
        wp_list_comments( 'type=pings&callback=darko_comments_list' );
        darko_comments_pagination();
        ?>
	</div> <!-- .post-comments -->
    <div class="comments-reply">
        <?php
        comment_form( darko_comment_form_template() );
        if ( ! comments_open() && get_comments_number() ) :
            if ( is_single() ) : ?>
                <h4 class="no-comments"><?php esc_html_e( 'Comments are closed', 'darko' ); ?></h4>
            <?php
            endif;
        endif; ?>
    </div> <!-- .comments-reply -->
</div> <!-- #comments -->
