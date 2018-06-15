<?php
/**
 * Theme functions and definitions
 *
 * @package Mloc
 */

define( 'MLOC_INC', trailingslashit( get_template_directory() ) . 'inc/' );
const MLOC_SIDEBAR_PRIMARY = 'sidebar-primary';
const MLOC_SIDEBAR_FOOTER1 = 'sidebar-footer-1';
const MLOC_SIDEBAR_FOOTER2 = 'sidebar-footer-2';

require_once( MLOC_INC . 'template-tags.php' );

if ( ! function_exists( 'mloc_setup_theme' ) ) {
    /**
     * Theme setup
     */
    function mloc_setup_theme() {
        /**
         * This will limit the width of all uploaded images and embeds
         */
        global $content_width;
        if ( ! isset( $content_width ) ) {
            $content_width = 750;
        }

        /**
         * Adds image sizes
         */
        add_image_size( 'mloc-blog', 360, 240, true );
        add_image_size( 'mloc-post-thumb', 218, 150, true );

        /**
         * Enable support for title tag
         */
        add_theme_support( 'title-tag' );

        /**
         * Enable support for post thumbnails
         */
        add_theme_support( 'post-thumbnails' );

        /**
         * Enable support for custom logo
         */
        $logo_config = array(
            'flex-width'    => true,
            'width'         => 50,
            'flex-height'   => true,
            'height'        => 50,
        );
        add_theme_support( 'custom-logo', $logo_config );

        /**
         * Enable support for custom header
         */
        $header_config = array(
            'flex-width'    => true,
            'width'         => 1000,
            'flex-height'   => true,
            'height'        => 250,
            'header-text'   => false,
        );
        add_theme_support( 'custom-header', $header_config );

        /**
         * Enable support for custom navigation menus
         */
        register_nav_menus( array(
            'primary'   => __( 'Primary Menu', 'mloc' ),
            'footer'    => __( 'Footer Menu', 'mloc' ),
        ) );
    }
    add_action( 'after_setup_theme', 'mloc_setup_theme' );
}

/**
 * Register widget areas
 */
function mloc_widgets_init() {
    $sidebars_array = array(
		MLOC_SIDEBAR_PRIMARY  => __( 'Primary', 'mloc' ),
		MLOC_SIDEBAR_FOOTER1  => __( 'Footer 1', 'mloc' ),
		MLOC_SIDEBAR_FOOTER2  => __( 'Footer 2', 'mloc' ),
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

    // Google fonts
    wp_register_style( 'mloc-google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Roboto+Slab' );
    wp_enqueue_style( 'mloc-google-fonts' );

    // Material icons
	wp_register_style( 'mloc-material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons' );
	wp_enqueue_style( 'mloc-material-icons' );

    // Main styles
    wp_register_style( 'style', get_stylesheet_uri());
    wp_enqueue_style( 'style' );

    // Main scripts
    wp_register_script( 'script', get_template_directory_uri() . '/assets/js/script.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'script' );

    wp_localize_script( 'script', 'phpVars', array( 'ajaxUrl' => admin_url( 'admin-ajax.php'), 'check_nonce' => wp_create_nonce( 'mloc-nonce' ) ) );
}
add_action( 'wp_enqueue_scripts', 'mloc_script' );

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
 * Append elements to primary navigation
 */
function mloc_after_primary_navigation() {
    $buffer_nav = '<ul id="%1$s" class="%2$s">%3$s';
    if ( function_exists( 'mloc_primary_menu_search' ) ) {
        $buffer_nav .= mloc_primary_menu_search();
    }
    $buffer_nav .= '</ul>';

    return $buffer_nav;
}

/**
 * Display search form in primary menu
 */
function mloc_primary_menu_search() {
    $search_form = '
        <li class="mloc-nav-search">
            <form action="' . esc_url( home_url( '/' ) ) . '" role="search" method="get">
                <div class="mloc-nav-search-container">
                    <input name="s" type="search" placeholder="' . __( 'Search...', 'mloc' ) . '" value="' . get_search_query() . '" required>
                    <button type="submit" class="btn"><i class="material-icons">&#xE8B6;</i></button>
                </div>
            </form>
        </li>';

    return $search_form;
}

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

if ( function_exists( 'mloc_comments_form_template' ) ) {
	/**
	 * Adds missing closing tag after the comment form
	 */
	function mloc_comment_form_after() {
		?>
		</div>
		<?php
	}
	add_action( 'comment_form_after', 'mloc_comment_form_after' );
}

/**
 * Display go to top button which scrolls user to top of the page when clicked
 */
function mloc_go_top() {
	?>
	<button id="mloc-go-top" class="faded-out">
		<i class="material-icons">&#xE316;</i>
	</button>
	<?php
}
add_action( 'wp_footer', 'mloc_go_top' );

/**
 * Return formatted post content
 *
 * @param string $more_link_text
 * @param int $stripteaser
 * @return mixed|string
 */
function mloc_get_the_content_with_formatting( $more_link_text = '(more...)', $stripteaser = 0 ) {
    $content = get_the_content( $more_link_text, $stripteaser );
    $content = apply_filters( 'the_content', $content );
    $content = str_replace( ']]>', ']]&gt;', $content );
    return $content;
}

/**
 * Hook adjacent and related post templates to their actions
 */
add_action( 'mloc_blog_adjacent_posts', 'mloc_adjacent_posts' );
add_action( 'mloc_blog_related_posts', 'mloc_related_posts' );

/**
 * Display a different page of related posts from ajax request
 */
function mloc_ajax_related_posts() {
    check_ajax_referer( 'mloc-nonce', 'security' );
    $page = $_POST['paged'];
    if ( empty( $page ) ) {
        $page = 1;
    }
    mloc_related_posts( $page, true );
    die();
}
add_action( 'wp_ajax_mloc_related_posts', 'mloc_ajax_related_posts' );
add_action( 'wp_ajax_nopriv_mloc_related_posts', 'mloc_ajax_related_posts' );