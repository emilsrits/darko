<?php
/**
 * Template for footer widgets
 *
 * @package Darko
 */

$sidebar_footer1 = is_active_sidebar( 'sidebar-footer1' );
$sidebar_footer2 = is_active_sidebar( 'sidebar-footer2' );

if ( $sidebar_footer1 || $sidebar_footer2 ) :
	do_action( 'darko_before_sidebar_footer' );
	?>
	<aside id="sidebar-footer" role="complementary">
		<div class="row">
			<?php if ( $sidebar_footer1 ) : ?>
				<div class="col-xs-12 col-md-6">
					<div class="sidebar-footer-item">
						<?php dynamic_sidebar( 'sidebar-footer1' ); ?>
					</div> <!-- .sidebar-footer-item -->
				</div>
			<?php endif; ?>

			<?php if ( $sidebar_footer2 ) : ?>
				<div class="<?php echo ( $sidebar_footer1 ) ? 'col-xs-12 col-md-6' : 'col-xs-12 col-md-6 col-md-offset-6'; ?>">
					<div class="sidebar-footer-item">
						<?php dynamic_sidebar( 'sidebar-footer2' ); ?>
					</div> <!-- .sidebar-footer-item -->
				</div>
			<?php endif; ?>
		</div> <!-- .row -->
	</aside>
	<?php
	do_action( 'darko_after_sidebar_footer' );
endif; ?>