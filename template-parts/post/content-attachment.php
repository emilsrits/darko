<?php
/**
 * Template for displaying attachment
 *
 * Used for attachments
 *
 * @package Darko
 */

$post_id = get_the_ID();
?>

<article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
	<div class="row">
		<div class="col-xs-12">
			<div class="post-content">
				<div class="attachment-single">
					<?php
					$attachment_caption = wp_get_attachment_caption( $post_id );
					if ( wp_attachment_is_image( $post_id ) ) :
						$attachment = wp_get_attachment_image_src( $post_id, 'full' );
						?>
						<a href="<?php echo esc_url( wp_get_attachment_url( $post_id ) ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
							<img src="<?php echo esc_url( $attachment[0] ); ?>" alt="<?php the_title_attribute(); ?>" width="<?php echo esc_attr( $attachment[1] ); ?>" height="<?php echo esc_attr( $attachment[2] ); ?>">
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( wp_get_attachment_url( $post_id ) ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
							<?php echo basename( $post->guid ); ?>
						</a>
					<?php endif; ?>
					<?php if ( $attachment_caption ) : ?>
						<p class="wp-caption-text"><?php echo $attachment_caption; ?></p>
					<?php endif; ?>
				</div> <!-- .attachment-single -->
			</div> <!-- .post-content -->
		</div> <!-- .col-xs-12 -->
	</div> <!-- .row -->
</article>
<?php

if ( comments_open() || get_comments_number() ) :
	comments_template();
endif;
?>
