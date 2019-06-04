<?php
/**
 * Theme appearance customizer for single posts
 *
 * @package Darko
 */

/**
 * Customization for single posts
 *
 * @param $wp_customize
 */
function darko_content_single_post_customize_register( $wp_customize ) {
    // Section: Single post settings
    $wp_customize->add_section( 'darko_single_post_settings', array(
        'title'		=> __( 'Single Post Settings', 'darko' ),
        'panel'     => 'darko_content_settings',
        'priority'	=> 60,
    ) );

    // Single post featured image display
    $wp_customize->add_setting( 'darko_single_post_featured_image', array(
        'default' 			=> true,
        'sanitize_callback'	=> 'darko_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'darko_single_post_featured_image', array(
        'type'			=> 'checkbox',
        'label'			=> esc_html__( 'Enable featured image display', 'darko' ),
        'description'	=> __( 'Display featured image of the post at the beginning of its content.', 'darko' ),
        'section'		=> 'darko_single_post_settings',
        'settings'		=> 'darko_single_post_featured_image',
        'priority'		=> 10,
    ) );

    // Adjacent posts
    $wp_customize->add_setting( 'darko_adjacent_posts', array(
        'default' 			=> true,
        'sanitize_callback'	=> 'darko_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'darko_adjacent_posts', array(
        'type'			=> 'checkbox',
        'label'			=> esc_html__( 'Enable adjacent posts', 'darko' ),
        'description'	=> __( 'Display links to previous and next post.', 'darko' ),
        'section'		=> 'darko_single_post_settings',
        'settings'		=> 'darko_adjacent_posts',
        'priority'		=> 15,
    ) );

    // Related posts
    $wp_customize->add_setting( 'darko_related_posts', array(
        'default' 			=> true,
        'sanitize_callback'	=> 'darko_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'darko_related_posts', array(
        'type'			=> 'checkbox',
        'label'			=> esc_html__( 'Enable related posts', 'darko' ),
        'description'	=> __( 'Display related posts based on relevant tags or categories.', 'darko' ),
        'section'		=> 'darko_single_post_settings',
        'settings'		=> 'darko_related_posts',
        'priority'		=> 20,
    ) );
}
add_action( 'customize_register', 'darko_content_single_post_customize_register' );