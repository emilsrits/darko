<?php
/**
 * Helper functions for the theme
 *
 * @package Mloc
 */

if ( ! function_exists( 'mloc_enqueue_custom_fonts' ) ) {
    /**
     * Enqueues selected Google fonts from theme customizer
     */
    function mloc_enqueue_custom_fonts() {
        $heading_font = get_theme_mod( 'mloc_typography_heading' );
        $body_font = get_theme_mod( 'mloc_typography_body' );
        $fonts_url = 'https://fonts.googleapis.com/css?family=';

        if ( ! $heading_font || ! $body_font ) {
            if ( ( $heading_font && ! $body_font ) || ( ! $body_font && ! $heading_font ) ) {
                // Default Google fonts
                wp_register_style( 'mloc-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700' );
                wp_enqueue_style( 'mloc-google-fonts' );

                $css = "
                body {
                    font-family: 'Roboto', 'Helvetica', 'Arial', sans-serif;
                }
            ";
                wp_add_inline_style( 'mloc-style', $css );
            }

            if ( ! $body_font && ! $heading_font ) {
                return;
            }
        }

        if ( $heading_font ) {
            $heading_font = str_replace( ' ', '+', $heading_font );
        }

        if ( $body_font ) {
            $body_font = str_replace( ' ', '+', $body_font );
        }

        if ( $heading_font === $body_font ) {
            if ( strpos( $body_font, '_sys' ) === false ) {
                $fonts = $body_font . ':300,400,500,700';
            } else {
                $fonts = '';
            }
        } else {
            $fonts = sprintf(
            /* translators: %1$s is heading font, %2$s separator, %3$s is body font */
                '%1$s%2$s%3$s',
                ( $heading_font && strpos( $heading_font, '_sys' ) === false ? $heading_font . ':300,400,500,700' : '' ),
                ( ( $heading_font && $body_font ) && ( strpos( $heading_font, '_sys' ) === false && strpos( $body_font, '_sys' ) === false ) ? '|' : '' ),
                ( $body_font && strpos( $body_font, '_sys' ) === false ? $body_font . ':300,400,500,700' : '' )
            );
        }

        // If both fonts are system fonts
        if ( ! $fonts ) {
            return;
        }

        $fonts_url .= $fonts;

        wp_register_style( 'mloc-custom-fonts', $fonts_url );
        wp_enqueue_style( 'mloc-custom-fonts' );
    }
    add_action( 'mloc_after_styles', 'mloc_enqueue_custom_fonts' );
}