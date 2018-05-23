<?php
/**
 * Template for displaying content
 *
 * Used for pages
 *
 * @package Mloc
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
            <div class="page-content">
                <?php the_content(); ?>
            </div> <!-- .post-content -->
        </div> <!-- .col-xs-12 -->
    </div> <!-- .row -->
</article>
