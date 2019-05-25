<?php
/**
 * Theme appearance customizer for single posts
 *
 * @package Mloc
 */

/**
 * Customization for single posts
 *
 * @param $wp_customize
 */
function mloc_content_single_post_customize_register( $wp_customize ) {
    // Section: Single post settings
    $wp_customize->add_section( 'mloc_single_post_settings', array(
        'title'		=> __( 'Single Post Settings', 'mloc' ),
        'panel'     => 'mloc_content_settings',
        'priority'	=> 60,
    ) );

    // Single post featured image display
    $wp_customize->add_setting( 'mloc_single_post_featured_image', array(
        'default' 			=> true,
        'sanitize_callback'	=> 'mloc_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'mloc_single_post_featured_image', array(
        'type'			=> 'checkbox',
        'label'			=> esc_html__( 'Enable featured image display', 'mloc' ),
        'description'	=> __( 'Display featured image of the post at the beginning of its content.', 'mloc' ),
        'section'		=> 'mloc_single_post_settings',
        'settings'		=> 'mloc_single_post_featured_image',
        'priority'		=> 20,
    ) );

    // Adjacent posts
    $wp_customize->add_setting( 'mloc_adjacent_posts', array(
        'default' 			=> true,
        'sanitize_callback'	=> 'mloc_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'mloc_adjacent_posts', array(
        'type'			=> 'checkbox',
        'label'			=> esc_html__( 'Enable adjacent posts', 'mloc' ),
        'description'	=> __( 'Display links to previous and next post.', 'mloc' ),
        'section'		=> 'mloc_single_post_settings',
        'settings'		=> 'mloc_adjacent_posts',
        'priority'		=> 40,
    ) );

    // Related posts
    $wp_customize->add_setting( 'mloc_related_posts', array(
        'default' 			=> true,
        'sanitize_callback'	=> 'mloc_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'mloc_related_posts', array(
        'type'			=> 'checkbox',
        'label'			=> esc_html__( 'Enable related posts', 'mloc' ),
        'description'	=> __( 'Display related posts based on relevant tags or categories.', 'mloc' ),
        'section'		=> 'mloc_single_post_settings',
        'settings'		=> 'mloc_related_posts',
        'priority'		=> 60,
    ) );
}
add_action( 'customize_register', 'mloc_content_single_post_customize_register' );