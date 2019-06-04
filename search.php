<?php
/**
 * Template for displaying search results
 *
 * @package Darko
 */

get_header();

$darko_blog_sidebar_layout = get_theme_mod( 'darko_blog_sidebar_layout', 'full-width' );
$class_to_add = darko_content_layout_classes( $darko_blog_sidebar_layout, 'sidebar-1', null );
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="content-container container">
			<div class="row">
				<?php
				if ( $darko_blog_sidebar_layout === 'sidebar-left' ) :
					get_sidebar();
				endif;
				?>
				<div class="<?php echo esc_attr( $class_to_add ); ?>">
					<?php
					if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/post/content' );
						endwhile;
						the_posts_pagination( array(
							'mid_size' => 2,
							'prev_text' => '<i class="fas fa-angle-left"></i>',
							'next_text' => '<i class="fas fa-angle-right"></i>',
						) );
					else :
						get_template_part( 'template-parts/post/content', 'none' );
					endif;
					?>
				</div>
				<?php
				if ( $darko_blog_sidebar_layout === 'sidebar-right' ) :
					get_sidebar();
				endif;
				?>
			</div> <!-- .row -->
        </div> <!-- .container -->
    </main> <!-- #main -->
</div> <!-- #primary -->

<?php get_footer();