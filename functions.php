<?php
/**
 * Mloc functions and definitions
 */

define( 'MLOC_INC', trailingslashit( get_template_directory() ) . 'inc/');

require_once( MLOC_INC . 'template-tags.php' );

if ( ! function_exists( 'mloc_setup_theme' ) ) {
    function mloc_setup_theme() {
        /**
         * This will limit the width of all uploaded images and embeds
         */
        global $content_width;
        if ( ! isset( $content_width ) ) {
            $content_width = 750;
        }

        /**
         * Adds image size
         */
        add_image_size( 'mloc-blog', 360, 240, true );

        /**
         * Enable support for title tag
         */
        add_theme_support( 'title-tag' );

        /**
         * Enable support for post thumbnails and featured images
         */
        add_theme_support( 'post-thumbnails' );

        /**
         * Enable support for custom navigation menus
         */
        register_nav_menus( array(
            'primary'   => __( 'Primary Menu', 'mloc' ),
            'footer'    => __( 'Footer Menu', 'mloc' ),
        ) );
    }
    add_action('after_setup_theme', 'mloc_setup_theme');
}

function mloc_script() {
    // Normalize styles
    wp_register_style( 'normalize', get_template_directory_uri() . '/assets/css/normalize.min.css');
    wp_enqueue_style( 'normalize' );

    // Flexbox grid styles
    wp_register_style( 'flexboxgrid', get_template_directory_uri() . '/assets/css/flexboxgrid.min.css' );
    wp_enqueue_style( 'flexboxgrid' );

    // Main styles
    wp_register_style( 'style', get_stylesheet_uri());
    wp_enqueue_style( 'style' );

    // Main scripts
    wp_register_script( 'script', get_template_directory_uri() . '/assets/js/script.js', null, false, true );
    wp_enqueue_script( 'script' );
}
add_action('wp_enqueue_scripts', 'mloc_script');

/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string
 * @return string
 */
function mloc_excerpt_more( $more ) {
    return sprintf( '<a class="read-more" href="%1$s">%2$s</a>',
        get_permalink( get_the_ID() ),
        __( 'Read more...', 'mloc' )
    );
}
add_filter( 'excerpt_more', 'mloc_excerpt_more' );

/**
 * Filter comment form fields,
 * remove website url field
 *
 * @param $fields
 * @return mixed
 */
function mloc_filter_comment_fields( $fields ) {
    unset( $fields['url'] );

    return $fields;
}
add_filter( 'comment_form_default_fields', 'mloc_filter_comment_fields' );

/**
 * Move comment textarea to bottom
 *
 * @param $fields
 * @return mixed
 */
function mloc_move_comment_textarea( $fields ) {
    $comments_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comments_field;

    return $fields;
}
add_filter( 'comment_form_fields', 'mloc_move_comment_textarea' );

/**
 * Return formatted post content
 *
 * @param string $more_link_text
 * @param int $stripteaser
 * @param string $more_file
 * @return mixed|string
 */
function mloc_get_the_content_with_formatting ($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}

add_action( 'mloc_blog_adjacent_posts', 'mloc_adjacent_posts' );

add_action( 'mloc_blog_related_posts', 'mloc_related_posts' );