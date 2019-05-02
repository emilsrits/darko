<?php
/**
 * Template for displaying content
 *
 * Used for single posts
 *
 * @package Mloc
 */

$post_id = get_the_ID();
?>

<article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
    <?php mloc_get_the_post_thumbnail( $post_id ); ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="post-content">
                <?php
                the_content();
                wp_link_pages(
                    array(
                        'before'        => '<div class="content-pages">' . __( 'Pages:', 'mloc' ) . ' <ul>',
                        'after'         => '</ul></div>',
                        'link_before'   => '<li>',
                        'link_after'    => '</li>',
                    )
                );
                ?>
            </div> <!-- .post-content -->

            <div class="post-categories">
                <span><?php esc_html_e( 'Categories: ', 'mloc' ); ?></span>
                <?php mloc_categories(); ?>
            </div> <!-- .post-category -->

            <?php the_tags( '<div class="post-tags"><span>' . esc_html__( 'Tags: ', 'mloc' ) . '</span><span class="tag">', '</span><span class="tag">', '</span></div>' ); ?>
        </div> <!-- .col-xs-12 -->
    </div> <!-- .row -->
</article>
<?php

if ( get_theme_mod( 'mloc_adjacent_posts', true ) ) :
	do_action( 'mloc_blog_adjacent_posts' );
endif;

if ( get_theme_mod( 'mloc_related_posts', true ) ) :
	do_action( 'mloc_blog_related_posts' );
endif;

if ( comments_open() || get_comments_number() ) :
    comments_template();
endif;
?>
