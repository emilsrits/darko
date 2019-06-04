<?php
/**
 * Template for footer info
 *
 * @package Darko
 */

$copyright = get_theme_mod( 'darko_copyright', '© Copyright - ' . get_bloginfo( 'name' ) );
?>

<div class="footer-info">
	<?php if ( has_nav_menu( 'footer' ) ) :
		wp_nav_menu( array(
			'theme_location'    => 'footer',
			'depth'             => 1,
			'container'         => 'div',
			'menu_class'        => 'footer-menu',
		) );
	endif; ?>
	<div class="copyright">
		<p><?php echo $copyright; ?></p>
	</div> <!-- .copyright -->
</div> <!-- .footer-info -->