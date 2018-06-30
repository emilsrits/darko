<?php
/**
 * The main template file
 *
 * @package Mloc
 */

get_header();

$mloc_blog_sidebar_layout = get_theme_mod( 'mloc_blog_sidebar_layout', 'full-width' );
$class_to_add = mloc_content_layout_classes( $mloc_blog_sidebar_layout, 'sidebar-1', null );
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="content-container container">
            <div class="row">
				<?php
				if ( $mloc_blog_sidebar_layout === 'sidebar-left' ) :
					get_sidebar();
				endif;
				?>
                <div class="<?php echo esc_attr( $class_to_add ); ?>">
                    <?php
                    if ( have_posts() ) :
                        while ( have_posts() ) :
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
                </div>
				<?php
				if ( $mloc_blog_sidebar_layout === 'sidebar-right' ) :
					get_sidebar();
				endif;
				?>
            </div> <!-- .row -->
        </div> <!-- .container -->
    </main> <!-- #main -->
</div> <!-- #primary -->

<?php get_footer();
