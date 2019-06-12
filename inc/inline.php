<?php
/**
 * Generate custom inline styles for theme
 *
 * @package Darko
 */

/**
 * Inline styles
 *
 * @param string $output
 * @return string
 */
function darko_inline( $output ) {
    $background_transparency = get_theme_mod( 'darko_background_transparency' );

    $css = '';

    // Background transparency
    if ( $background_transparency && $background_transparency != 0.97 ) {
        $css .= "
            body.custom-background #main { background-color: rgba(62, 62, 62, " . esc_html( $background_transparency ) . "); }
        ";
    }

    $output .= $css;

    return $output;
}
add_filter( 'darko_head_css', 'darko_inline' );

/**
 * Typography inline styles
 *
 * @param string $output
 * @return string
 */
function darko_inline_typography( $output ) {
    $heading_font = get_theme_mod( 'darko_typography_heading' );
    $body_font = get_theme_mod( 'darko_typography_body' );
    $menu_font_size = get_theme_mod( 'darko_typography_size_menu' );
    $hero_font_size = get_theme_mod( 'darko_typography_size_hero' );
    $blog_heading_font_size = get_theme_mod( 'darko_typography_size_blog_heading' );
    $blog_body_font_size = get_theme_mod( 'darko_typography_size_blog_body' );
    $page_body_font_size = get_theme_mod( 'darko_typography_size_page_body' );
    $sidebar_font_size = get_theme_mod( 'darko_typography_size_sidebar' );
    $footer_sidebar_font_size = get_theme_mod( 'darko_typography_size_footer_sidebar' );
    $footer_copyright_font_size = get_theme_mod( 'darko_typography_size_copyright' );

    $css = '';
    // Default font size for content body
    $default_p = 16;
    // Default font size for h1 heading
    $default_h1 = 32;
    // Default font size for h2 heading
    $default_h2 = 24;

    // Heading font
    if ( $heading_font ) {
        if ( strpos( $heading_font, '_sys' ) !== false ) {
            $heading_font = str_replace( '_sys ', '', $heading_font );
        }

        $css .= "
            h1, h2, h3, h4, h5, h6, .hero-title, .post-title, .widget h2 { font-family: '" . esc_html( $heading_font ) . "'; }
        ";
    }

    // Body font
    if ( $body_font ) {
        if ( strpos( $body_font, '_sys' ) !== false ) {
            $body_font = str_replace( '_sys ', '', $body_font );
        }

        $css .= "
            body { font-family: '" . esc_html( $body_font ) . "'; }
        ";
    }

    // Menu font size
    if ( $menu_font_size && $menu_font_size != $default_p ) {
        $css .= "
            #main-menu #main-navigation .navbar-nav { font-size: " . esc_html( $menu_font_size ) . "px; }
        ";
    }

    // Hero font size
    if ( $hero_font_size && $hero_font_size != $default_h1 ) {
        $css .= "
            header .hero .hero-title { font-size: " . esc_html( $hero_font_size ) . "px; }
        ";
    }

    // Blog post heading font size
    if ( $blog_heading_font_size && $blog_heading_font_size != $default_h2 ) {
        $css .= "
            .blog .post .post-title { font-size: " . esc_html( $blog_heading_font_size ) . "px; }
        ";
    }

    // Blog post body font size
    if ( $blog_body_font_size && $blog_body_font_size != $default_p ) {
        $css .= "
            .blog .post .post-content { font-size: " . esc_html( $blog_body_font_size ) . "px; }
        ";
    }

    // Page body font size
    if ( $page_body_font_size && $page_body_font_size != $default_p ) {
        $css .= "
            .page .page-content, .single-post .post-content { font-size: " . esc_html( $page_body_font_size ) . "px; }
        ";
    }

    // Main sidebar font size
    if ( $sidebar_font_size &&  $sidebar_font_size != $default_p ) {
        $css .= "
            #sidebar-primary { font-size: " . esc_html( $sidebar_font_size ) . "px; }
        ";
    }

    // Footer sidebar font size
    if ( $footer_sidebar_font_size && $footer_sidebar_font_size != $default_p ) {
        $css .= "
            #site-footer .sidebar-footer-item { font-size: " . esc_html( $footer_sidebar_font_size ) . "px; }
        ";
    }

    // Footer copyright font size
    if ( $footer_copyright_font_size && $footer_copyright_font_size != $default_p ) {
        $css .= "
            #site-footer .copyright { font-size: " . esc_html( $footer_copyright_font_size ) . "px; }
        ";
    }

    $output .= $css;

    return $output;
}
add_filter( 'darko_head_css', 'darko_inline_typography' );