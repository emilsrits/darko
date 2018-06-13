<?php
/**
 * Template for attachment
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
					get_template_part( 'template-parts/post/content', 'attachment' );
				endwhile;
			endif;
			?>
		</div> <!-- .container -->
	</main> <!-- #main -->
</div> <!-- #primary -->

<?php get_footer();
