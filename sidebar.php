<?php
/**
 * Template for displaying sidebar
 *
 * @package Mloc
 */

$class_to_add = '';
$mloc_sidebar_blog_layout = 'sidebar-right';

if ( $mloc_sidebar_blog_layout === 'sidebar-right' ) {
	$class_to_add = ' col-md-offset-1';
}

if ( is_active_sidebar( MLOC_SIDEBAR_PRIMARY ) ) { ?>
    <div class="col-xs-12 col-md-3 <?php echo esc_attr( $class_to_add ); ?>">
        <aside id="sidebar-primary" role="complementary">
            <?php dynamic_sidebar( MLOC_SIDEBAR_PRIMARY ); ?>
        </aside> <!-- #secondary -->
    </div>
    <?php
}
?>


