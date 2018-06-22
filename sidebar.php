<?php
/**
 * Template for displaying sidebar
 *
 * @package Mloc
 */

$class_to_add = '';
$mloc_blog_sidebar_layout = get_theme_mod( 'mloc_blog_sidebar_layout', 'full-width' );

if ( $mloc_blog_sidebar_layout === 'sidebar-right' ) {
	$class_to_add = ' col-md-offset-1';
}

if ( is_active_sidebar( MLOC_SIDEBAR_PRIMARY ) ) : ?>
    <div class="col-xs-12 col-md-3 <?php echo esc_attr( $class_to_add ); ?>">
        <aside id="sidebar-primary" role="complementary">
            <?php dynamic_sidebar( MLOC_SIDEBAR_PRIMARY ); ?>
        </aside> <!-- #secondary -->
    </div>
<?php endif; ?>


