<?php
/**
 * Template for displaying content
 *
 * Used for single posts
 *
 * @package Darko
 */

$post_id = get_the_ID();
?>

<article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
    <?php darko_get_the_post_thumbnail( $post_id ); ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="post-content">
                <?php
                the_content();
                wp_link_pages(
                    array(
                        'before'        => '<div class="content-pages">' . __( 'Pages:', 'darko' ) . ' <ul>',
                        'after'         => '</ul></div>',
                        'link_before'   => '<li>',
                        'link_after'    => '</li>',
                    )
                );
                ?>
            </div> <!-- .post-content -->

            <div class="post-categories">
                <span><?php esc_html_e( 'Categories: ', 'darko' ); ?></span>
                <?php darko_categories(); ?>
            </div> <!-- .post-category -->

            <?php the_tags( '<div class="post-tags"><span>' . esc_html__( 'Tags: ', 'darko' ) . '</span><span class="tag">', '</span><span class="tag">', '</span></div>' ); ?>
        </div> <!-- .col-xs-12 -->
    </div> <!-- .row -->
</article>
<?php

if ( get_theme_mod( 'darko_adjacent_posts', true ) ) :
	do_action( 'darko_blog_adjacent_posts' );
endif;

if ( get_theme_mod( 'darko_related_posts', true ) ) :
	do_action( 'darko_blog_related_posts' );
endif;

if ( comments_open() || get_comments_number() ) :
    comments_template();
endif;
?>
