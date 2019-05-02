<?php
/**
 * Template for displaying content
 *
 * Used for index
 *
 * @package Mloc
 */

$post_id = get_the_ID();
$content_type = get_theme_mod( 'mloc_blog_post_content_type', 'excerpt' );
?>

<article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
    <?php if ( is_sticky( $post_id ) ) : ?>
        <div class="sticky-post-icon">
            <i class="fas fa-thumbtack"></i>
        </div>
    <?php endif; ?>
    <div class="row">
        <?php
        $post_featured_img = get_the_post_thumbnail( $post_id, 'mloc-blog' );
        if ( $content_type === 'excerpt' && ! empty( $post_featured_img ) ) : ?>
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
            if ( is_single() ) :
                the_title( '<h1 class="post-title">', '</h1>' );
            else :
                the_title( '<h2 class="post-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
            endif;
            ?>
            <div class="post-author">
                <?php
                echo sprintf(
                /* translators: %1$s is author name, %2$s is date */
                    esc_html( 'By %1$s, %2$s' ),
                    /* translators: %1$s is author name, %2$s is author link */
                    sprintf(
                        '<a href="%2$s" title="%1$s" class="author"><strong>%1$s</strong></a>',
                        esc_html( get_the_author() ),
                        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
                    ),
                    esc_html( get_the_time( get_option( 'date_format' ) ) )
                );
                ?>
            </div> <!-- .post-author -->

            <div class="post-categories">
                <?php mloc_categories(); ?>
            </div> <!-- .post-category -->

            <div class="post-content content-<?php echo $content_type ?>">
                <p>
                    <?php
                    if ( is_single() || $content_type === 'full' ) :
                        echo mloc_get_the_content_with_formatting();
                    else :
                        $read_more = strpos( $post->post_content, '<!--more' );
                        if ( $read_more ) :
                            echo get_the_content();
                        else :
                            echo get_the_excerpt();
                        endif;
                    endif;
                    ?>
                </p>
            </div> <!-- .post-content -->
        </div> <!-- .col-xs-12 -->
    </div> <!-- .row -->
</article>
