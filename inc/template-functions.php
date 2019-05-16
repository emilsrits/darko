<?php
/**
 * Additional helpers and features for template styling
 *
 * @package Mloc
 */

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
                    <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </li>';

    return $search_form;
}

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
    $go_top = get_theme_mod( 'mloc_go_top' );

    if ( $go_top ) {
        ?>
        <button id="mloc-go-top" class="faded-out">
            <i class="fas fa-angle-up"></i>
        </button>
        <?php
    }
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