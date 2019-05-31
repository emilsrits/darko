<?php
/**
 * Template for top navigation
 * 
 * @package Mloc
 */

$custom_logo_id = get_theme_mod( 'custom_logo' );
$navbar_brand = get_theme_mod( 'mloc_navigation_brand', true );
$primary_menu_search = get_theme_mod( 'mloc_navigation_search', false );
$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
?>

<nav id="main-menu" class="<?php echo ( $navbar_brand ) ? '' : 'no-brand' ; ?>">
    <div class="container">
        <?php if ( $navbar_brand ) : ?>
            <a class="navbar-brand" href="<?php echo esc_url( home_url() ); ?>">
                <?php if ( has_custom_logo() ) : ?>
                    <img src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                <?php else : ?>
                    <p><?php bloginfo( 'name' ); ?></p>
                <?php endif; ?>
            </a>
        <?php endif; ?>
        <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#main-navigation" aria-controls="main-navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="hamburger-bar"></span>
        </button>
        <?php
        wp_nav_menu( array(
            'theme_location'    => 'primary',
            'depth'             => 4,
            'container'         => 'div',
            'container_class'   => 'collapse navbar-collapse',
            'container_id'      => 'main-navigation',
            'menu_class'        => 'navbar-nav',
            'items_wrap'        => ( function_exists( 'mloc_after_primary_navigation' ) && $primary_menu_search ) ? mloc_after_primary_navigation() : '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'walker'			=> new Mloc_Navwalker(),
        ) );
        ?>
    </div>
</nav>