<?php
/**
 * Theme functions and definitions
 *
 * @package Darko
 */

define( 'DARKO_THEME_URI', get_template_directory_uri() );
define( 'DARKO_INC', trailingslashit( get_template_directory() ) . 'inc/' );
define( 'DARKO_IMG_URI', DARKO_THEME_URI . '/dist/images/');
define( 'DARKO_JS_URI', DARKO_THEME_URI .'/dist/js/' );
define( 'DARKO_CSS_URI', DARKO_THEME_URI .'/dist/css/' );

require_once( DARKO_INC . 'helpers.php' );
require_once( DARKO_INC . 'inline.php' );
require_once( DARKO_INC . 'template-tags.php' );
require_once( DARKO_INC . 'template-functions.php' );
require_once( DARKO_INC . 'customizer/customizer.php' );
require_once( DARKO_INC . 'customizer/settings/webfonts.php' );
require_once( DARKO_INC . 'walker/class-darko-navwalker.php' );

if ( ! function_exists( 'darko_setup_theme' ) ) {
    /**
     * Theme setup
     */
    function darko_setup_theme() {
        // This will limit the width of all uploaded images and embeds
        global $content_width;
        if ( ! isset( $content_width ) ) {
            $content_width = 750;
        }

        // Adds image sizes
        add_image_size( 'darko-blog', 360, 240, true );
        add_image_size( 'darko-post-thumb', 218, 150, true );

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
            'primary'   => __( 'Primary Menu', 'darko' ),
            'footer'    => __( 'Footer Menu', 'darko' ),
        ) );

        // Enable support for editor style
        add_editor_style();
    }
    add_action( 'after_setup_theme', 'darko_setup_theme' );
}

/**
 * Load Gutenberg stylesheet
 */
function darko_add_gutenberg_assets() {
    wp_enqueue_style( 'darko-gutenberg', get_theme_file_uri('/dist/css/gutenberg-editor-style.css'), false );
}
add_action( 'enqueue_block_editor_assets', 'darko_add_gutenberg_assets' );

/**
 * Register widget areas
 */
function darko_widgets_init() {
    $sidebars_array = array(
		'sidebar-1'  => __( 'Primary', 'darko' ),
		'sidebar-footer1'  => __( 'Footer 1', 'darko' ),
		'sidebar-footer2'  => __( 'Footer 2', 'darko' ),
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
add_action( 'widgets_init', 'darko_widgets_init' );

/**
 * Script and style registering/enqueuing
 */
function darko_script() {
    global $wp_query; 
    
    // Normalize styles
    wp_register_style( 'normalize', DARKO_CSS_URI . 'normalize.min.css' );
    wp_enqueue_style( 'normalize' );

    // Flexbox grid styles
    wp_register_style( 'flexboxgrid', DARKO_CSS_URI . 'flexboxgrid.min.css' );
    wp_enqueue_style( 'flexboxgrid' );

	// Font Awesome
    wp_register_style( 'darko-font-awesome', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css' );
    wp_enqueue_style( 'darko-font-awesome' );

    // Main styles
    wp_register_style( 'darko-style', DARKO_CSS_URI . 'style.css');
    wp_enqueue_style( 'darko-style' );

    do_action( 'darko_after_styles' );

    // Main scripts
    wp_register_script( 'darko-script', DARKO_JS_URI . 'script.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'darko-script' );

    wp_localize_script( 'darko-script', 'phpVars', array( 
        'ajaxUrl' => admin_url( 'admin-ajax.php'), 
        'check_nonce' => wp_create_nonce( 'darko-nonce' ), 
        'current_page' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
        'max_page' => $wp_query->max_num_pages
    ) );
}
add_action( 'wp_enqueue_scripts', 'darko_script' );

/**
 * Enqueues selected Google fonts from theme customizer
 */
function darko_enqueue_custom_fonts() {
    $heading_font = get_theme_mod( 'darko_typography_heading' );
    $body_font = get_theme_mod( 'darko_typography_body' );
    $fonts_url = 'https://fonts.googleapis.com/css?family=';

    if ( ! $heading_font || ! $body_font ) {
        if ( ( $heading_font && ! $body_font ) || ( ! $body_font && ! $heading_font ) ) {
            // Default Google fonts
            wp_register_style( 'darko-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700' );
            wp_enqueue_style( 'darko-google-fonts' );
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

    wp_register_style( 'darko-custom-fonts', $fonts_url );
    wp_enqueue_style( 'darko-custom-fonts' );
}
add_action( 'darko_after_styles', 'darko_enqueue_custom_fonts' );

/**
 * Apply custom theme styles
 *
 * @param string $output
 */
function darko_enqueue_custom_css( $output = '' ) {
    $output = apply_filters( 'darko_head_css', $output );

    // Use inline styles if customizer is open
    if ( is_customize_preview() ) {
        wp_add_inline_style( 'darko-style', $output );
    } else {
        $upload_dir = wp_upload_dir();

        if ( file_exists( $upload_dir['basedir'] . '/darko/custom-styles.css' ) && ! empty( $output ) ) {
            wp_enqueue_style( 'darko-custom', trailingslashit( $upload_dir['baseurl'] ) . 'darko/custom-styles.css', false, null );
        }
    }
}
add_action( 'darko_after_styles', 'darko_enqueue_custom_css' );

/**
 * Save custom css to a file
 *
 * @param string $output
 */
function darko_save_custom_css( $output = '' ) {
    // WP_Filesystem
    require_once( ABSPATH . 'wp-admin/includes/file.php' );

    $output = apply_filters( 'darko_head_css', $output );
    $output = darko_minify_css( $output );

    global $wp_filesystem;
    $upload_dir = wp_upload_dir();
    $dir = trailingslashit( $upload_dir['basedir'] ) . 'darko/';

    WP_Filesystem();
    $wp_filesystem->mkdir( $dir );
    $wp_filesystem->put_contents( $dir . 'custom-styles.css', $output, 0644 );
}
add_action( 'admin_bar_init', 'darko_save_custom_css' );
