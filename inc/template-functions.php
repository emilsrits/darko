<?php
/**
 * Helper functions for template styling and layouts
 *
 * @package Mloc
 */

if ( ! function_exists( 'mloc_after_primary_navigation' ) ) {
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
}

if ( ! function_exists( 'mloc_primary_menu_search' ) ) {
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
}

if ( ! function_exists( 'mloc_excerpt_more' ) ) {
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
}

if ( ! function_exists( 'mloc_custom_excerpt_length' ) ) {
    /**
     * Filter excerpt length default value to custom one
     *
     * @param integer $length
     * @return integer
     */
    function mloc_custom_excerpt_length( $length ) {
        $custom = get_theme_mod( 'mloc_blog_excerpt_length' );
        if ( $custom ) {
            return $length = intval( $custom );
        } else {
            return $length;
        }
    }
    add_filter( 'excerpt_length', 'mloc_custom_excerpt_length' );
}

if ( ! function_exists( 'mloc_filter_comment_fields' ) ) {
    /**
     * Filter comment form fields,
     * remove website url field
     *
     * @param array $fields
     * @return mixed
     */
    function mloc_filter_comment_fields( $fields ) {
        unset( $fields['url'] );

        return $fields;
    }
    add_filter( 'comment_form_default_fields', 'mloc_filter_comment_fields' );
}

if ( ! function_exists( 'mloc_move_comment_textarea' ) ) {
    /**
     * Move comment text area to bottom
     *
     * @param array $fields
     * @return mixed
     */
    function mloc_move_comment_textarea( $fields ) {
        $comment_field = $fields['comment'];
        unset( $fields['comment'] );
        $fields['comment'] = $comment_field;

        return $fields;
    }
    add_filter( 'comment_form_fields', 'mloc_move_comment_textarea' );
}

if ( ! function_exists( 'mloc_comment_form_after' ) && function_exists( 'mloc_comment_form_template' ) ) {
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

if ( ! function_exists( 'mloc_go_top' ) ) {
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
}

if ( ! function_exists( 'mloc_get_the_content_with_formatting' ) ) {
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
}

if ( ! function_exists( 'mloc_ajax_related_posts' ) ) {
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
}