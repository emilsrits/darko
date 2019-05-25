<?php
/**
 * Theme functions and definitions
 *
 * @package Mloc
 */

define( 'MLOC_INC', trailingslashit( get_template_directory() ) . 'inc/' );
define( 'MLOC_IMG', trailingslashit( get_template_directory_uri() ) . 'assets/images/');

require_once( MLOC_INC . 'helpers.php' );
require_once( MLOC_INC . 'inline.php' );
require_once( MLOC_INC . 'template-tags.php' );
require_once( MLOC_INC . 'template-functions.php' );
require_once( MLOC_INC . 'customizer/customizer.php' );
require_once( MLOC_INC . 'customizer/settings/webfonts.php' );
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

/**
 * Load Gutenberg stylesheet
 */
function mloc_add_gutenberg_assets() {
    wp_enqueue_style( 'mloc-gutenberg', get_theme_file_uri('/assets/css/gutenberg-editor-style.css'), false );
}
add_action( 'enqueue_block_editor_assets', 'mloc_add_gutenberg_assets' );

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
    wp_register_style( 'mloc-style', get_stylesheet_uri());
    wp_enqueue_style( 'mloc-style' );

    do_action( 'mloc_after_styles' );

    // Main scripts
    wp_register_script( 'mloc-script', get_template_directory_uri() . '/assets/js/script.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'mloc-script' );

    wp_localize_script( 'mloc_script', 'phpVars', array( 'ajaxUrl' => admin_url( 'admin-ajax.php'), 'check_nonce' => wp_create_nonce( 'mloc-nonce' ) ) );
}
add_action( 'wp_enqueue_scripts', 'mloc_script' );

/**
 * Apply custom theme styles
 */
function mloc_custom_css( $output = '' ) {
    $output = apply_filters( 'mloc_head_css', $output );

    wp_add_inline_style( 'mloc-style', $output );
}
add_action( 'mloc_after_styles', 'mloc_custom_css' );