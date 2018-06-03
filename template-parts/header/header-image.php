<?php
/**
 * Template for displaying header image
 *
 * @package Mloc
 */

$current_object_id = get_queried_object_id();
$is_home = is_home();
$is_single = is_single();
$is_page = is_page();
$is_archive = is_archive();
$is_search = is_search();
$has_header_image = get_header_image();

if ( $is_single || $is_page || $is_archive ) : ?>
    <div class="hero">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    if ( $is_single || $is_page ) :
                        the_title( '<h1 class="hero-title">', '</h1>' );
                    endif;
                    if ( $is_archive ) :
                        the_archive_title( '<h1 class="hero-title">', '</h1>' );
                    endif;
                    if ( $is_single ) : ?>
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
                    <?php endif; ?>
                </div> <!-- .col-xs-12 -->
            </div> <!-- .row -->
        </div> <!-- .container -->
        <?php if ( has_post_thumbnail( $current_object_id ) ) : ?>
            <div class="hero-img" style="background-image: url('<?php echo get_the_post_thumbnail_url( $current_object_id ); ?>')">
                <!-- empty div -->
            </div> <!-- .hero-img -->
        <?php else : ?>
            <?php if ( $has_header_image ) : ?>
                <div class="hero-img" style="background-image: url('<?php header_image(); ?>')">
                    <!-- empty div -->
                </div> <!-- .hero-img -->
            <?php else : ?>
                <div class="hero-img">
                    <!-- empty div -->
                </div> <!-- .hero-img -->
            <?php endif; ?>
        <?php endif; ?>
    </div> <!-- .hero -->
<?php endif; ?>
<?php if ( ( $is_home || $is_search ) && $has_header_image ) : ?>
    <div class="hero">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="hero-title">
                        <?php
                        if ( $is_search ) :
                            /* translators: %s is search query */
                            printf( esc_html__( 'Search results for: %s', 'mloc' ), get_search_query() );
                        else :
                            $buffer = single_post_title( '', false );
                            if ( ! is_front_page() && $buffer ) :
                                echo $buffer;
                            else :
                                bloginfo( 'description' );
                            endif;
                        endif;
                        ?>
                    </h1>
                </div> <!-- .col-xs-12 -->
            </div> <!-- .row -->
        </div> <!-- .container -->
        <div class="hero-img" style="background-image: url('<?php header_image(); ?>')">
            <!-- empty div -->
        </div> <!-- .hero-img -->
    </div> <!-- .hero -->
<?php endif; ?>
