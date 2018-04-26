<?php
/**
 * Template for displaying a message that posts cannot be found
 *
 * @package Mloc
 */
?>

<section class="no-results not-found">
    <header class="section-header">
        <h1 class="section-title"><?php _e( 'Nothing Found', 'mloc' ); ?></h1>
    </header>
    <div class="section-content">
        <?php
        if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
            <p>
                <?php
                printf(
                    /* translators: %1$s is a link to new post */
                    __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'mloc' ),
                    esc_url( admin_url( 'post-new.php' ) )
                );
                ?>
            </p>
        <?php else : ?>
            <p>
                <?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mloc' ); ?>
            </p>
            <?php
            get_search_form();
        endif;
        ?>
    </div> <!-- .page-content -->
</section> <!-- .no-results -->
