<?php
/**
 * Theme functions and definitions
 *
 * @package Mloc
 */

define( 'MLOC_INC', trailingslashit( get_template_directory() ) . 'inc/' );
define( 'MLOC_IMG', trailingslashit( get_template_directory_uri() ) . 'assets/images/');

require_once( MLOC_INC . 'template-tags.php' );
require_once( MLOC_INC . 'template-functions.php' );
require_once( MLOC_INC . 'customizer/customizer.php' );
require_once( MLOC_INC . 'walker/class-mloc-navwalker.php' );

if ( ! function_exists( 'mloc_setup_theme' ) ) {
    /**
     * Theme setup
     */
    function mloc_setup_theme() {
        // This will limit the width of all uploaded images and embeds
        global $content_width;
        if ( ! isset( $content_width ) ) {
            $content_width = 750;
        }

        // Adds image sizes
        add_image_size( 'mloc-blog', 360, 240, true );
        add_image_size( 'mloc-post-thumb', 218, 150, true );

        // Enable support for title tag
        add_theme_support( 'title-tag' );

        // Enable support for automatic feed links
        add_theme_support( 'automatic-feed-links' );

        // Enable support for post thumbnails
        add_theme_support( 'post-thumbnails' );

        // Enable support for custom background
        add_theme_support(
            'custom-background', array(
                'default-color' => '3e3e3e',
            )
        );

        // Enable support for custom logo
        $logo_config = array(
            'flex-width'    => true,
            'width'         => 50,
            'flex-height'   => true,
            'height'        => 50,
        );
        add_theme_support( 'custom-logo', $logo_config );

        // Enable support for custom header
        $header_config = array(
            'flex-width'    => true,
            'width'         => 1000,
            'flex-height'   => true,
            'height'        => 250,
            'header-text'   => false,
        );
        add_theme_support( 'custom-header', $header_config );

        // Enable support for selective refresh widgets
        add_theme_support( 'customize-selective-refresh-widgets' );

        // Enable support for custom navigation menus
        register_nav_menus( array(
            'primary'   => __( 'Primary Menu', 'mloc' ),
            'footer'    => __( 'Footer Menu', 'mloc' ),
        ) );

        // Enable support for editor style
        add_editor_style();
    }
    add_action( 'after_setup_theme', 'mloc_setup_theme' );
}

add_action( 'enqueue_block_editor_assets', 'mloc_add_gutenberg_assets' );

/**
 * Load Gutenberg stylesheet
 */
function mloc_add_gutenberg_assets() {
    wp_enqueue_style( 'mloc-gutenberg', get_theme_file_uri('/assets/css/gutenberg-editor-style.css'), false );
}

/**
 * Register widget areas
 */
function mloc_widgets_init() {
    $sidebars_array = array(
		'sidebar-1'  => __( 'Primary', 'mloc' ),
		'sidebar-footer1'  => __( 'Footer 1', 'mloc' ),
		'sidebar-footer2'  => __( 'Footer 2', 'mloc' ),
    );

    foreach ( $sidebars_array as $sidebar_id => $sidebar_name ) {
        $sidebar_config = array(
            'name'          => $sidebar_name,
            'id'            => $sidebar_id,
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>',
        );

        register_sidebar( $sidebar_config );
    }
}
add_action( 'widgets_init', 'mloc_widgets_init' );

/**
 * Script and style registering/enqueuing
 */
function mloc_script() {
    // Normalize styles
    wp_register_style( 'normalize', get_template_directory_uri() . '/assets/css/normalize.min.css' );
    wp_enqueue_style( 'normalize' );

    // Flexbox grid styles
    wp_register_style( 'flexboxgrid', get_template_directory_uri() . '/assets/css/flexboxgrid.min.css' );
    wp_enqueue_style( 'flexboxgrid' );

	// Font Awesome
    wp_register_style( 'mloc-font-awesome', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css' );
    wp_enqueue_style( 'mloc-font-awesome' );

    // Main styles
    wp_register_style( 'mloc_style', get_stylesheet_uri());
    wp_enqueue_style( 'mloc_style' );

    // Fonts from customizer
    mloc_enqueue_custom_fonts();

    // Main scripts
    wp_register_script( 'mloc_script', get_template_directory_uri() . '/assets/js/script.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'mloc_script' );

    wp_localize_script( 'mloc_script', 'phpVars', array( 'ajaxUrl' => admin_url( 'admin-ajax.php'), 'check_nonce' => wp_create_nonce( 'mloc-nonce' ) ) );
}
add_action( 'wp_enqueue_scripts', 'mloc_script' );

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
            wp_add_inline_style( 'mloc_style', $css );
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
        mloc_inline_styles();
        return;
    }

    $fonts_url .= $fonts;

    wp_register_style( 'mloc-custom-fonts', $fonts_url );
    wp_enqueue_style( 'mloc-custom-fonts' );

    mloc_inline_styles();
}

/**
 * Add inline styles
 */
function mloc_inline_styles() {
    $heading_font = get_theme_mod( 'mloc_typography_heading' );
    $body_font = get_theme_mod( 'mloc_typography_body' );
    $css = '';

    if ( $heading_font ) {
        if ( strpos( $heading_font, '_sys' ) !== false ) {
            $heading_font = str_replace( '_sys ', '', $heading_font );
        }

        $css .= "
            h1, h2, h3, h4, h5, h6, .hero-title, .post-title, .widget h2 {
                font-family: '" . esc_html( $heading_font ) . "';
            }
        ";
    }

    if ( $body_font ) {
        if ( strpos( $body_font, '_sys' ) !== false ) {
            $body_font = str_replace( '_sys ', '', $body_font );
        }

        $css .= "
            body {
                font-family: '" . esc_html( $body_font ) . "';
            }
        ";
    }

    if ( $css ) {
        wp_add_inline_style( 'mloc_style', $css );
    } else {
        return;
    }
}