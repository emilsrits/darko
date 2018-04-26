<?php
/**
 * Custom template tags
 *
 * @package Mloc
 */
?>

<?php
if ( ! function_exists( 'mloc_categories' ) ) :
    /**
     * Display the first category of the post
     */
    function mloc_categories() {
        $categories = get_the_category();
        if ( $categories ) {
            foreach ($categories as $category) {
                echo '<span><a class="label" href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'mloc' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a></span>';
            }
        }
    }
endif;

if ( ! function_exists( 'mloc_tags_trimmed' ) ) :
    /**
     * Returns string/html of post tags up to specified number
     *
     * @param int $max
     * @return string $buffer
     */
    function mloc_tags_trimmed( $max = 3 ) {
        $tags = get_the_tags();
        $count = 0;

        if ( $tags ) {
            $buffer = '';
            foreach( $tags as $tag ) {
                $count++;
                $buffer .= '<span class="tag">';
                $buffer .= '<a class="label" href="' . get_tag_link( $tag->term_id ).'" rel="tag">#' . $tag->name . '</a>';
                $buffer .= '</span>';
                if( $count >= $max ) {
                    break;
                }
            }
            return $buffer;
        }
    }
endif;

if ( ! function_exists( 'mloc_comments_list' ) ) :
    /**
     * Custom display of comments
     *
     * @param $comment
     * @param $args
     * @param $depth
     */
    function mloc_comments_list( $comment, $args, $depth ) {
        ?>
        <div id="<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? 'comment' : 'parent comment' ); ?>>
            <?php if ( $args['type'] != 'pings' ) : ?>
                <div class="author-avatar">
                    <?php echo get_avatar( $comment, 60 ); ?>
                </div> <!-- .author-avatar -->
            <?php endif; ?>
            <div class="comment-body">
                <div class="comment-meta">
                    <h4>
                        <?php echo get_comment_author(); ?>
                        <span>
                            <?php
                            printf(
                            /* translators: %1$s is date, %2$s is time */
                                esc_html__( '- %1$s at %2$s', 'mloc' ),
                                get_comment_date(),
                                get_comment_time()
                            );
                            edit_comment_link( esc_html__( '[Edit]', 'mloc' ), '  ', '' );
                            ?>
                        </span>
                    </h4>
                </div> <!-- .comment-meta -->
                <div class="comment-content">
                    <?php comment_text(); ?>
                </div> <!-- .comment-content -->
                <div class="comment-footer">
                    <?php
                    echo get_comment_reply_link(
                        array(
                            'depth'      => $depth,
                            'max_depth'  => $args['max_depth'],
                            'reply_text' => sprintf( '<i class="material-icons">&#xE15E;</i> %s', esc_html__( 'Reply', 'mloc' ) ),
                        ),
                        $comment->comment_ID,
                        $comment->comment_post_ID
                    );
                    ?>
                </div> <!-- .comment-footer -->
            </div> <!-- .comment-body -->
        </div>
        <?php
    }
endif;

if ( ! function_exists( 'mloc_comments_pagination' ) ) :
    /**
     * Custom template for comments pagination
     */
    function mloc_comments_pagination() {
        $pages = paginate_comments_links( array(
            'type' => 'array',
            'echo' => false,
            'mid_size' => 2,
            'prev_text' => __( '<i class="material-icons">&#xE5CB;</i>' ),
            'next_text' => __( '<i class="material-icons">&#xE5CC;</i>' ),
        ) );

        if ( is_array( $pages ) ) {
            echo '<div class="comments-pagination pagination">';
                foreach ( $pages as $page ) {
                    echo $page;
                }
            echo '</div>';
        }
    }
endif;

if ( ! function_exists( 'mloc_comments_form_template' ) ) :
    /**
     * Custom comments form template
     */
    function mloc_comments_form_template() {
        if ( is_user_logged_in() ) {
            $current_user = get_avatar( wp_get_current_user(), 60 );
        } else {
            $current_user = '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.png" height="64" width="64"/>';
        }
        $req = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $args = array(
            'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . __( 'Your email address will not be published.' ) . '</p>',
            'fields'               => apply_filters(
                'comment_form_default_fields', array(
                    'author' => '<div class="row"><div class="col-xs-12 col-sm-6"><div class="form-group"><label for="name" class="control-label label">' . esc_html__( 'Name', 'mloc' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label><input id="author" name="author" class="form-control" type="text"' . $aria_req . ' /></div></div>',
                    'email'  => '<div class="col-xs-12 col-sm-6"><div class="form-group"><label for="email" class="control-label label">' . esc_html__( 'Email', 'mloc' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label><input id="email" name="email" class="form-control" type="email"' . $aria_req . ' /></div></div></div>',
                )
            ),
            'comment_field'        => '<div class="form-group"><label class="control-label label">' . esc_html__( 'Comment', 'mloc' ) . '<span class="required">*</span>' . '</label><textarea id="comment" name="comment" class="form-control" rows="7" aria-required="true"></textarea></div>',
            'must_log_in'          => '<p class="must-log-in">' .
                sprintf(
                    wp_kses(
                    /* translators: %s is a link to login */
                        __( 'You must be <a href="%s">logged in</a> to post a comment.', 'mloc' ), array(
                            'a' => array(
                                'href' => array(),
                            ),
                        )
                    ), esc_url( wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) )
                ) . '</p> </div>',
            'class_submit'         => 'material-icons btn',
            'label_submit'         => __( '&#xE163;' ),
            'title_reply_before'   => '<h4 class="comments-reply-header">',
            'title_reply_after'    => '</h4><div class="form-body"><div class="author-avatar">' . $current_user . '</div>',
            'cancel_reply_before'  => ' <span class="required">',
            'cancel_reply_after'   => '</span>',
            'cancel_reply_link'    => __( '[Cancel reply]' ),
        );

        return $args;
    }
endif;

if ( ! function_exists( 'mloc_adjacent_posts' ) ) :
    /**
     * Template for showing previous and next posts
     */
    function mloc_adjacent_posts() {
        $prev_post = get_previous_post();
        $next_post = get_next_post();

        if ( $prev_post || $next_post ) : ?>
            <div id="adjacent-posts" class="row">
                <div class="col-xs-6 align-left">
                    <?php
                    if ( $prev_post ) {
                        echo '<span>' . esc_html__( 'Previous post', 'mloc' ) . '</span>';
                        previous_post_link( '%link' );
                    }
                    ?>
                </div>
                <div class="col-xs-6 align-right">
                    <?php
                    if ( $next_post ) {
                        echo '<span>' . esc_html__( 'Next post', 'mloc' ) . '</span>';
                        next_post_link( '%link' );
                    }
                    ?>
                </div>
            </div>
        <?php
        endif;
    }
endif;

if ( ! function_exists( 'mloc_related_posts' ) ) :
    /**
     * Template for showing related posts
     *
     * @param int $page
     * @param bool $ajax
     */
    function mloc_related_posts( $page, $ajax = false ) {
        global $post;

        if ( empty( $post ) ) {
            $post_id = $_POST['postId'];
        } else {
            $post_id = $post->ID;
        }
        if ( empty( $page ) ) {
            $page = 1;
        }

        $tags = wp_get_post_tags( $post_id );
        if ( $tags ) {
            $tag_ids = [];
            $i = 0;
            foreach ( $tags as $tag ) {
                $tag_ids[$i] = $tag->term_id;
                $i++;
                if ( $i == 3 ) {
                    break;
                }
            }
            $args = array(
                'tag__in' => $tag_ids,
                'post__not_in' => array( $post_id ),
                'posts_per_page' => 3,
                'paged' => $page
            );

            $query = new WP_Query( $args );
            $max_pages = $query->max_num_pages;
            $buffer = '';
            if ( $page > $max_pages ) {
                wp_reset_query();
                http_response_code( 400 );
                return;
            }
            if( $query->have_posts() ) {
                if ( $ajax == false ) : ?>
                    <div id="related-posts" data-id="<?php echo $post_id; ?>">
                        <div class="row center-xs">
                <?php
                endif;
                while ( $query->have_posts() ) : $query->the_post();
                    $post_thumb = get_the_post_thumbnail( get_the_ID(), 'mloc-post-thumb' );

                    $buffer .= '<div class="related-post col-xs-12 col-sm-4 col-md-4">';
                        $buffer .= '<div class="related-post-thumb">';
                            $buffer .= '<a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . $post_thumb . '</a>';
                        $buffer .= '</div> <!-- .related-post-thumb -->';

                        $buffer .= '<div class="related-post-meta">';
                            $buffer .= '<div class="related-post-tags">';
                                $buffer .= mloc_tags_trimmed();
                            $buffer .= '</div>';

                            $buffer .= '<h3 class="related-post-title">';
                                $buffer .= '<a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a>';
                            $buffer .= '</h3>';
                        $buffer .= '</div> <!-- .related-post-meta -->';
                    $buffer .= '</div> <!-- .related-post -->';
                endwhile;
                if ( $ajax == false ) :
                            echo $buffer;
                            ?>
                        </div> <!-- .row -->
                        <div class="mloc-ajax-spinner">
                            <div class="mloc-spinner1 mloc-spinner"></div>
                            <div class="mloc-spinner2 mloc-spinner"></div>
                            <div class="mloc-spinner3 mloc-spinner"></div>
                            <div class="mloc-spinner4 mloc-spinner"></div>
                            <div class="mloc-spinner5 mloc-spinner"></div>
                            <div class="mloc-spinner6 mloc-spinner"></div>
                            <div class="mloc-spinner7 mloc-spinner"></div>
                            <div class="mloc-spinner8 mloc-spinner"></div>
                            <div class="mloc-spinner9 mloc-spinner"></div>
                            <div class="mloc-spinner10 mloc-spinner"></div>
                            <div class="mloc-spinner11 mloc-spinner"></div>
                            <div class="mloc-spinner12 mloc-spinner"></div>
                        </div> <!-- .sk-fading-circle -->
                    </div> <!-- #related_posts -->
                    <?php
                    if ( $max_pages != 1 ) :
                        mloc_ajax_related_posts_navigation();
                    endif;
                endif;
            }
            wp_reset_query();
            if ( ! $ajax == false ) :
                ( $page == $max_pages ) ? $last_page = true : $last_page = false;
                ( $page == 1 ) ? $first_page = true : $first_page = false;
                echo json_encode( array( 'html' => $buffer, 'firstPage' => $first_page, 'lastPage' => $last_page ) );
            endif;
        }
    }
endif;

if ( ! function_exists( 'mloc_ajax_related_posts_navigation' ) ) :
    /**
     * Template for related posts navigation
     */
    function mloc_ajax_related_posts_navigation() {
        ?>
        <div id="related-posts-navigation">
            <button class="ajax-prev-page btn" disabled>
                <i class="material-icons">&#xE5CB;</i>
            </button>
            <button class="ajax-next-page btn">
                <i class="material-icons">&#xE5CC;</i>
            </button>
        </div>
        <?php
    }
endif;

if ( ! function_exists( 'mloc_go_top' ) ) :
    /**
     * Template for displaying go to top button
     */
    function mloc_go_top() {
        ?>
        <button id="mloc-go-top" class="faded-out">
            <i class="material-icons">&#xE316;</i>
        </button>
        <?php
    }
    add_action( 'wp_footer', 'mloc_go_top' );
endif;