<?php
/**
 * Template part for displaying posts
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
        <?php
        $post_featured_img = get_the_post_thumbnail( get_the_ID(), 'mloc-blog' );
        if ( ! empty( $post_featured_img ) ) : ?>
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                <div class="post-featured-img">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php echo $post_featured_img; ?>
                    </a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
        <?php else : ?>
            <div class="col-xs-12">
        <?php endif;
            if ( is_single() ) {
                the_title( '<h1 class="post-title">', '</h1>' );
            } else {
                the_title( '<h2 class="post-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
            }
            ?>
            <div class="post-content">
                <p>
                    <?php
                    if ( is_single() ) {
                        echo get_the_content_with_formatting();
                    } else {
                        $read_more = strpos( $post->post_content, '<!--more' );
                        if ( $read_more ) :
                            echo get_the_content();
                        else :
                            echo get_the_excerpt();
                        endif;
                    }
                    ?>
                </p>
            </div> <!-- .post-content -->

            <div class="post-author">
                <?php
                echo sprintf(
                    esc_html( 'By %1$s, %2$s' ),
                    sprintf(
                        '<a href="%2$s" title="%1$s" class="author"><strong>%1$s</strong></a>',
                        esc_html( get_the_author() ),
                        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
                    ),
                    esc_html( get_the_time( get_option( 'date_format' ) ) )
                );
                ?>
            </div> <!-- .post-author -->

            <div class="post-category">
                <?php mloc_category(); ?>
            </div> <!-- .post-category -->
        </div>
    </div> <!-- .row -->
</article>
