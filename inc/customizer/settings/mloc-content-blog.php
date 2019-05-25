<?php
/**
 * Theme appearance customizer for blog
 *
 * @package Mloc
 */

/**
 * Customization for blog
 *
 * @param $wp_customize
 */
function mloc_content_blog_customize_register( $wp_customize ) {
    // Section: Blog settings
    $wp_customize->add_section( 'mloc_blog_settings', array(
        'title'		=> __( 'Blog Settings', 'mloc' ),
        'panel'     => 'mloc_content_settings',
        'priority'	=> 20,
    ) );

    // Blog excerpt length
    $wp_customize->add_setting( 'mloc_blog_post_content_type', array(
        'default' 			=> 'excerpt',
        'sanitize_callback'	=> 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'mloc_blog_post_content_type', array(
        'type'			=> 'select',
        'choices'       => array(
            'full'      => esc_html__( 'Full', 'mloc' ),
            'excerpt'   => esc_html__( 'Excerpt', 'mloc' ),
        ),
        'label'			=> esc_html__( 'Blog post content type', 'mloc' ),
        'section'		=> 'mloc_blog_settings',
        'settings'		=> 'mloc_blog_post_content_type',
        'priority'		=> 20,
    ) );

    // Blog excerpt length
    $wp_customize->add_setting( 'mloc_blog_excerpt_length', array(
        'default' 			=> 55,
        'sanitize_callback'	=> 'absint',
    ) );
    $wp_customize->add_control( 'mloc_blog_excerpt_length', array(
        'type'			=> 'number',
        'label'			=> esc_html__( 'Excerpt length', 'mloc' ),
        'section'		=> 'mloc_blog_settings',
        'settings'		=> 'mloc_blog_excerpt_length',
        'priority'		=> 40,
    ) );
}
add_action( 'customize_register', 'mloc_content_blog_customize_register' );