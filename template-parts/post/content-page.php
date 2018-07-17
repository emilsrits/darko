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
    <?php mloc_get_the_post_thumbnail( get_the_ID() ); ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="page-content">
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
        </div> <!-- .col-xs-12 -->
    </div> <!-- .row -->
</article>
