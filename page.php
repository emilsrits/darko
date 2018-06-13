<?php
/**
 * Template for displaying a page
 *
 * @package Mloc
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="content-container container">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/post/content', 'page' );
                endwhile;
            else :
                get_template_part( 'template-parts/post/content', 'none' );
            endif;
            ?>
        </div> <!-- .container -->
    </main> <!-- #main -->
</div> <!-- #primary -->

<?php get_footer();