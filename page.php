<?php
/**
 * Template for displaying a page
 *
 * @package Darko
 */

get_header();

$darko_page_sidebar_layout = get_theme_mod( 'darko_page_sidebar_layout', 'full-width' );
$class_to_add = darko_content_layout_classes( $darko_page_sidebar_layout, 'sidebar-1', null );
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="content-container container">
			<div class="row">
				<?php
				if ( $darko_page_sidebar_layout === 'sidebar-left' ) :
					get_sidebar();
				endif;
				?>
				<div class="<?php echo esc_attr( $class_to_add ); ?>">
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
				</div>
				<?php
				if ( $darko_page_sidebar_layout === 'sidebar-right' ) :
					get_sidebar();
				endif;
				?>
			</div> <!-- .row -->
        </div> <!-- .container -->
    </main> <!-- #main -->
</div> <!-- #primary -->

<?php get_footer();