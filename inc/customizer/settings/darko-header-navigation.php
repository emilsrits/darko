<?php
/**
 * Theme appearance customizer for navigation
 *
 * @package Darko
 */

/**
 * Customization for navigation
 *
 * @param $wp_customize
 */
function darko_header_navigation_customize_register( $wp_customize ) {
    // Section: Navigation
    $wp_customize->add_section( 'darko_navigation', array(
        'title'			=> __( 'Navigation', 'darko' ),
        'panel'			=> 'darko_header_settings',
        'priority'		=> 20,
    ) );

    // Navigation search input
    $wp_customize->add_setting( 'darko_navigation_search', array(
        'default'			=> false,
        'sanitize_callback'	=> 'darko_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'darko_navigation_search', array(
        'type'		=> 'checkbox',
        'label'		=> esc_html__( 'Enable search in primary navigation', 'darko' ),
        'section'	=> 'darko_navigation',
        'settings'	=> 'darko_navigation_search',
        'priority'	=> 10,
    ) );

    // Navigation transparency
    $wp_customize->add_setting( 'darko_navigation_transparency', array(
        'default'			=> false,
        'sanitize_callback'	=> 'darko_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'darko_navigation_transparency', array(
        'type'		=> 'checkbox',
        'label'		=> esc_html__( 'Transparent background', 'darko' ),
        'section'	=> 'darko_navigation',
        'settings'	=> 'darko_navigation_transparency',
        'priority'	=> 15,
    ) );

    // Navbar brand
    $wp_customize->add_setting( 'darko_navigation_brand', array(
        'default'			=> true,
        'sanitize_callback'	=> 'darko_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'darko_navigation_brand', array(
        'type'		=> 'checkbox',
        'label'		=> esc_html__( 'Display brand', 'darko' ),
        'section'	=> 'darko_navigation',
        'settings'	=> 'darko_navigation_brand',
        'priority'	=> 20,
    ) );
}
add_action( 'customize_register', 'darko_header_navigation_customize_register' );