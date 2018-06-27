<?php
/**
 * Template for displaying content
 *
 * Used for pages
 *
 * @package Mloc
 */

$page_featured_image_enabled = get_theme_mod( 'mloc_page_featured_image', true );
$page_featured_image = get_the_post_thumbnail( get_the_ID() );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ( $page_featured_image_enabled && ! empty( $page_featured_image ) ) : ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="featured-img">
                    <?php echo $page_featured_image; ?>
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
