<?php
/**
 * Template for displaying sidebar
 *
 * @package Mloc
 */

$class_to_add = '';
$hide_on_mobile = get_theme_mod( 'mloc_sidebar_mobile', false );

if ( $hide_on_mobile ) {
    $class_to_add .= ' hidden-xs';
}

if ( is_page() ) {
	$mloc_sidebar_layout = get_theme_mod( 'mloc_page_sidebar_layout', 'full-width' );
} else {
	$mloc_sidebar_layout = get_theme_mod( 'mloc_blog_sidebar_layout', 'full-width' );
}

if ( $mloc_sidebar_layout === 'sidebar-right' ) {
	$class_to_add .= ' col-md-offset-1';
}

if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
    <div class="col-xs-12 col-md-3 <?php echo esc_attr( $class_to_add ); ?>">
        <aside id="sidebar-primary" class="<?php echo esc_attr( $mloc_sidebar_layout ) ?>" role="complementary">
            <?php dynamic_sidebar( 'sidebar-1' ); ?>
        </aside> <!-- #secondary -->
    </div>
<?php endif; ?>


