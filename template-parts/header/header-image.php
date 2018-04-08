<?php
/**
 * Template for displaying header image
 */

$current_object_id = get_queried_object_id() ;

if ( is_single() ) : ?>
    <div class="hero">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    the_title( '<h1 class="post-title">', '</h1>' );
                    ?>
                    <div class="post-author">
                        <?php
                        $author = $post->post_author;
                        echo sprintf(
                            esc_html( 'By %1$s, %2$s' ),
                            sprintf(
                                '<a href="%2$s" title="%1$s" class="author"><strong>%1$s</strong></a>',
                                get_user_option('display_name', $author ),
                                esc_url( get_author_posts_url( $author ) )
                            ),
                            esc_html( get_the_time( get_option( 'date_format' ) ) )
                        );
                        ?>
                    </div> <!-- .post-author -->
                </div> <!-- .col-xs-12 -->
            </div> <!-- .row -->
        </div> <!-- .container -->
        <?php
        if ( has_post_thumbnail( $current_object_id ) ) : ?>
            <div class="hero-img" style="background-image: url('<?php echo get_the_post_thumbnail_url( $current_object_id ); ?>')">
                <!-- empty div -->
            </div> <!-- .hero-img -->
        <?php else : ?>
            <div class="hero-img">
                <!-- empty div -->
            </div> <!-- .hero-img -->
        <?php endif; ?>
    </div> <!-- .hero -->
<?php endif; ?>
