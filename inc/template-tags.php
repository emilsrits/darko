<?php
/**
 * Custom template tags
 *
 * @package Mloc
 */

if ( ! function_exists( 'mloc_content_layout_classes' ) ) {
	/**
	 * Decide which classes to add for main content area depending on sidebar configuration
	 *
	 * @param string $layout Sidebar layout
	 * @param int|string $sidebar Name or id of a sidebar
	 * @param array $args Optional arguments for layout classes
	 * @return mixed|string
	 */
    function mloc_content_layout_classes( $layout, $sidebar, $args ) {
        if ( ! $args ) {
            $args = array(
                'full-width'    => 'col-xs-12',
                'sidebar-right' => 'col-xs-12 col-md-8',
                'sidebar-left'  => 'col-xs-12 col-md-8 col-md-offset-1',
            );
        }

        $class_to_add = ! ( empty( $args['full-width'] ) ) ? $args['full-width'] : 'col-md-12';
        if ( is_active_sidebar( $sidebar ) ) {
        	switch ( $layout ) {
				case 'sidebar-right':
					$class_to_add = $args['sidebar-right'];
					break;
				case 'sidebar-left':
					$class_to_add = $args['sidebar-left'];
					break;
			}
		}

        return $class_to_add;
    }
}

if ( ! function_exists( 'mloc_get_the_post_thumbnail' ) ) {
    /**
     * Display featured image of post
     *
     * @param $post_id
     */
    function mloc_get_the_post_thumbnail( $post_id ) {
        global $multipage;
        if ( is_single() ) {
            $post_featured_image_enabled = get_theme_mod( 'mloc_single_post_featured_image', false );
        } else {
            $post_featured_image_enabled = get_theme_mod( 'mloc_page_featured_image', false );
        }
        $post_featured_image = get_the_post_thumbnail( $post_id );

        if ( $post_featured_image_enabled && ! empty( $post_featured_image )  && ! $multipage ) {
            $buffer = '<div class="row">';
                $buffer .= '<div class="col-xs-12">';
                    $buffer .= '<div class="featured-img">';
                        $buffer .= $post_featured_image;
                    $buffer .= '</div>';
                $buffer .= '</div>';
            $buffer .= '</div> <!-- .row -->';

            echo $buffer;
        }
    }
}

if ( ! function_exists( 'mloc_categories' ) ) {
    /**
     * Display categories of the post
     */
    function mloc_categories() {
        $categories = get_the_category();
        $count = 0;

        if ( $categories ) {
            foreach ( $categories as $category ) {
                $count++;
                echo '<span><a class="label" href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'mloc' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a></span>';
                if ( ! is_single() && $count >= 5 ) {
                    break;
                }
            }
        }
    }
}

if ( ! function_exists( 'mloc_tags_trimmed' ) ) {
    /**
     * Returns string/html of post tags up to specified number
     *
     * @param int $max Maximum number of tags
     * @return string $buffer Buffer of html to be displayed
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
}

if ( ! function_exists( 'mloc_comments_list' ) ) {
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
                        <span class="author-name"><?php echo get_comment_author(); ?></span>
                        <span class="comment-date">
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
                            'reply_text' => sprintf( '<i class="fas fa-reply"></i> %s', esc_html__( 'Reply', 'mloc' ) ),
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
}

if ( ! function_exists( 'mloc_comments_pagination' ) ) {
    /**
     * Custom template for comments pagination
     */
    function mloc_comments_pagination() {
        $pages = paginate_comments_links( array(
            'type'      => 'array',
            'echo'      => false,
            'mid_size'  => 2,
            'prev_text' => '<i class="fas fa-angle-left"></i>',
            'next_text' => '<i class="fas fa-angle-right"></i>',
        ) );

        if ( is_array( $pages ) ) {
            echo '<div class="comments-pagination pagination">';
                foreach ( $pages as $page ) {
                    echo $page;
                }
            echo '</div>';
        }
    }
}

if ( ! function_exists( 'mloc_comments_form_template' ) ) {
    /**
     * Custom comments form template
     */
    function mloc_comments_form_template() {
        if ( is_user_logged_in() ) {
            $current_user = get_avatar( wp_get_current_user(), 60 );
        } else {
            $current_user = '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.png" height="60" width="60"/>';
        }
        $commenter = wp_get_current_commenter();
        $req = get_option( 'require_name_email' );
        $aria_req = ( $req ? 'required' : '' );
        $consent  = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
        $args = array(
            'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . __( 'Your email address will not be published.', 'mloc' ) . '</p>',
            'fields'               => apply_filters(
                'comment_form_default_fields', array(
                    'cookies'   => '<div id="comment-cookies"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" ' . $consent . ' />' .
                                    '<label for="wp-comment-cookies-consent">' . __( 'Save my name and email in this browser for the next time I comment.', 'mloc' ) . '</label></div>',
                    'author'    => '<div class="row"><div class="col-xs-12 col-sm-6"><div class="form-group">' .
                                    '<label class="control-label label" for="author">' . __( 'Name', 'mloc' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label>' .
                                    '<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' /></div></div>',
                    'email'     => '<div class="col-xs-12 col-sm-6"><div class="form-group">' .
                                    '<label class="control-label label" for="email">' . __( 'Email', 'mloc' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label>' .
                                    '<input id="email" class="form-control" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" ' . $aria_req . ' /></div></div></div>',
                )
            ),
            'comment_field'        => '<div class="form-group"><label class="control-label label" for="comment">' . esc_html__( 'Comment', 'mloc' ) . '<span class="required">*</span>' . '</label>' .
                                        '<textarea id="comment" class="form-control" name="comment" rows="7" required></textarea></div>',
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
            'class_submit'         => 'fas fa-paper-plane btn',
            'label_submit'         => '&#xf1d8;',
            'title_reply_before'   => '<h3 class="comments-reply-header">',
            'title_reply_after'    => '</h3><div class="form-body"><div class="author-avatar">' . $current_user . '</div>',
            'cancel_reply_before'  => ' <span class="required">',
            'cancel_reply_after'   => '</span>',
            'cancel_reply_link'    => __( '[Cancel reply]', 'mloc' ),
        );

        return $args;
    }
}

if ( ! function_exists( 'mloc_adjacent_posts' ) ) {
    /**
     * Template for showing previous and next posts
     */
    function mloc_adjacent_posts() {
        $prev_post = get_previous_post();
        $next_post = get_next_post();

        if ( $prev_post || $next_post ) :
			do_action( 'mloc_before_adjacent_posts' );
			?>
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
            </div> <!-- #adjacent-posts -->
        	<?php
			do_action( 'mloc_after_adjacent_posts' );
        endif;
    }
	add_action( 'mloc_blog_adjacent_posts', 'mloc_adjacent_posts' );
}

if ( ! function_exists( 'mloc_related_posts' ) ) {
    /**
     * Template for showing related posts
     *
     * @param int $page Related posts page
     * @param bool $ajax Whether this is a ajax request
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
                if ( $ajax == false ) :
					do_action( 'mloc_before_related_posts' );
					?>
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
					do_action( 'mloc_after_related_posts' );

                    if ( $max_pages != 1 ) :
                        mloc_ajax_related_posts_navigation();
						do_action( 'mloc_after_related_posts_navigation' );
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
	add_action( 'mloc_blog_related_posts', 'mloc_related_posts' );
}

if ( ! function_exists( 'mloc_ajax_related_posts_navigation' ) ) {
    /**
     * Template for related posts navigation
     */
    function mloc_ajax_related_posts_navigation() {
        ?>
        <div id="related-posts-navigation">
            <button class="ajax-prev-page btn" disabled>
                <i class="fas fa-angle-left"></i>
            </button>
            <button class="ajax-next-page btn">
                <i class="fas fa-angle-right"></i>
            </button>
        </div>
        <?php
    }
}

if ( ! function_exists( 'mloc_content_area_search_form' ) ) {
	/**
	 * Template for content area search form
	 *
	 * @param string $class_to_add Classes to add to search form container
	 */
    function mloc_content_area_search_form( $class_to_add = '' ) {
        $buffer = '
        <div class="mloc-search ' . $class_to_add . '">
            <form action="' . esc_url( home_url( '/' ) ) . '" role="search" method="get">
                <input name="s" type="search" placeholder="' . __( 'Search...', 'mloc' ) . '" value="' . get_search_query() . '" required>
                <button type="submit" class="btn"><i class="fas fa-search"></i></button>
            </form>
        </div>';

        echo $buffer;
    }
}