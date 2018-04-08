<?php
/**
 * Custom template tags
 */
?>

<?php
if ( ! function_exists( 'mloc_category' ) ) :
    /**
     * Display the first category of the post
     */
    function mloc_category() {
        $categories = get_the_category();
        if ( $categories ) {
            foreach ($categories as $category) {
                echo '<span class=' . "label" . '><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'mloc' ), $category->name ) ) . '" ' . '>' . esc_html( $category->name ) . '</a></span>';
            }
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
                            /* translators: %1$s is Date, %2$s is Time */
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
                    'author' => '<div class="row"><div class="col-xs-12 col-sm-6"><div class="form-group"><label for="name" class="control-label">' . esc_html__( 'Name', 'mloc' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label><input id="author" name="author" class="form-control" type="text"' . $aria_req . ' /></div></div>',
                    'email'  => '<div class="col-xs-12 col-sm-6"><div class="form-group"><label for="email" class="control-label">' . esc_html__( 'Email', 'mloc' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label><input id="email" name="email" class="form-control" type="email"' . $aria_req . ' /></div></div></div>',
                )
            ),
            'comment_field'        => '<div class="form-group"><label class="control-label">' . esc_html__( 'Comment', 'mloc' ) . '<span class="required">*</span>' . '</label><textarea id="comment" name="comment" class="form-control" rows="7" aria-required="true"></textarea></div>',
            'must_log_in'          => '<p class="must-log-in">' .
                sprintf(
                    wp_kses(
                    /* translators: %s is Link to login */
                        __( 'You must be <a href="%s">logged in</a> to post a comment.', 'mloc' ), array(
                            'a' => array(
                                'href' => array(),
                            ),
                        )
                    ), esc_url( wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) )
                ) . '</p> </div>',
            'class_submit'         => 'btn',
            'title_reply_before'   => '<h3 class="comments-reply-header">',
            'title_reply_after'    => '</h3><div class="form-body"><div class="author-avatar">' . $current_user . '</div>',
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
            <div class="next_and_previous_posts row">
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
     */
    function mloc_related_posts() {
        // TODO: add related posts
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