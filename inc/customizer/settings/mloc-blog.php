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
function mloc_blog_customize_register( $wp_customize ) {
    // Section: Blog settings
    $wp_customize->add_section( 'mloc_blog_settings', array(
        'title'		=> __( 'Blog Settings', 'mloc' ),
        'panel'     => 'mloc_content_settings',
        'priority'	=> 20,
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
        'priority'		=> 20,
    ) );
}
add_action( 'customize_register', 'mloc_blog_customize_register' );