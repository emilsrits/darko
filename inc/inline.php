<?php
/**
 * Generate custom inline styles for theme
 *
 * @package Mloc
 */

/**
 * Typography inline styles
 */
function mloc_inline_typography( $output ) {
    $heading_font = get_theme_mod( 'mloc_typography_heading' );
    $body_font = get_theme_mod( 'mloc_typography_body' );
    $menu_font_size = get_theme_mod( 'mloc_typography_size_menu' );
    $css = '';

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
    if ( $menu_font_size != 16 ) {
        $css .= "
            #main-menu #main-navigation .navbar-nav { font-size: " . esc_html( $menu_font_size ) . "px; }
        ";
    }

    if ( $css != '' ) {
        $output = $css;
    }

    return $output;
}
add_filter( 'mloc_head_css', 'mloc_inline_typography' );