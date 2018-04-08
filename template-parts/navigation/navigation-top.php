<?php
/**
 * Displays top navigation
 */
?>

<nav id="main-menu">
    <div class="container">
        <a class="navbar-brand" href="<?php bloginfo('url')?>"><?php bloginfo('name')?></a>
        <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#main-navigation" aria-controls="main-navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span><i class="material-icons">&#xE8EE;</i></span>
        </button>
        <?php
        wp_nav_menu( array(
            'theme_location'    => 'primary',
            'depth'             => 2,
            'container'         => 'div',
            'container_class'   => 'collapse navbar-collapse',
            'container_id'      => 'main-navigation',
            'menu_class'        => 'navbar-nav',
        ) );
        ?>
    </div>
</nav>