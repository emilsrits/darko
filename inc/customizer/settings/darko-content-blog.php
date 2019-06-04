<?php
/**
 * Theme appearance customizer for blog
 *
 * @package Darko
 */

/**
 * Customization for blog
 *
 * @param $wp_customize
 */
function darko_content_blog_customize_register( $wp_customize ) {
    // Section: Blog settings
    $wp_customize->add_section( 'darko_blog_settings', array(
        'title'		=> __( 'Blog Settings', 'darko' ),
        'panel'     => 'darko_content_settings',
        'priority'	=> 20,
    ) );

    // Blog excerpt length
    $wp_customize->add_setting( 'darko_blog_post_content_type', array(
        'default' 			=> 'excerpt',
        'sanitize_callback'	=> 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'darko_blog_post_content_type', array(
        'type'			=> 'select',
        'choices'       => array(
            'full'      => esc_html__( 'Full', 'darko' ),
            'excerpt'   => esc_html__( 'Excerpt', 'darko' ),
        ),
        'label'			=> esc_html__( 'Blog post content type', 'darko' ),
        'section'		=> 'darko_blog_settings',
        'settings'		=> 'darko_blog_post_content_type',
        'priority'		=> 10,
    ) );

    // Blog excerpt length
    $wp_customize->add_setting( 'darko_blog_excerpt_length', array(
        'default' 			=> 55,
        'sanitize_callback'	=> 'absint',
    ) );
    $wp_customize->add_control( 'darko_blog_excerpt_length', array(
        'type'			=> 'number',
        'label'			=> esc_html__( 'Excerpt length', 'darko' ),
        'section'		=> 'darko_blog_settings',
        'settings'		=> 'darko_blog_excerpt_length',
        'priority'		=> 15,
    ) );
}
add_action( 'customize_register', 'darko_content_blog_customize_register' );