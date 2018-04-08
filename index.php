<?php
/**
 * The main template file
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="content-container container">
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    get_template_part( 'template-parts/post/content', get_post_format() );
                endwhile;
                the_posts_pagination( array(
                    'mid_size' => 2,
                    'prev_text' => __( '<i class="material-icons">&#xE5CB;</i>' ),
                    'next_text' => __( '<i class="material-icons">&#xE5CC;</i>' ),
                ) );
            else :
                get_template_part( 'template-parts/post/content', 'none' );
            endif;
            ?>
        </div> <!-- .container -->
    </main> <!-- #main -->
</div> <!-- #primary -->
<?php get_sidebar(); ?>

<?php get_footer();
