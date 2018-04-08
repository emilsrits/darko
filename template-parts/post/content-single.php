<?php
/**
 * Template part for displaying single post
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    $post_featured_img = get_the_post_thumbnail( get_the_ID() );
    if ( ! empty( $post_featured_img ) ) : ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="featured-img">
                    <?php echo $post_featured_img; ?>
                </div>
            </div>
        </div> <!-- .row -->
    <?php endif; ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="post-content">
                <?php
                the_content();
                ?>
            </div> <!-- .post-content -->

            <div class="post-category">
                <span><?php esc_html_e( 'Categories: ', 'mloc' ); ?></span>
                <?php mloc_category(); ?>
            </div> <!-- .post-category -->

            <?php the_tags( '<div class="post-tags"><span>' . esc_html__( 'Tags: ', 'mloc' ) . '</span><span class="tag">', '</span><span class="tag">', '</span></div>' ); ?>
        </div> <!-- .col-xs-12 -->
    </div> <!-- .row -->
</article>
<?php

do_action( 'mloc_blog_adjacent_posts' );

do_action( 'mloc_blog_related_posts' );

if ( comments_open() || get_comments_number() ) :
    comments_template();
endif;
?>
