<?php
/**
 * Theme appearance customizer for navigation
 *
 * @package Mloc
 */

/**
 * Customization for navigation
 *
 * @param $wp_customize
 */
function mloc_header_navigation_customize_register( $wp_customize ) {
    // Section: Navigation
    $wp_customize->add_section( 'mloc_navigation', array(
        'title'			=> __( 'Navigation', 'mloc' ),
        'panel'			=> 'mloc_header_settings',
        'priority'		=> 20,
    ) );

    // Navigation search input
    $wp_customize->add_setting( 'mloc_navigation_search', array(
        'default'			=> false,
        'sanitize_callback'	=> 'mloc_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'mloc_navigation_search', array(
        'type'		=> 'checkbox',
        'label'		=> esc_html__( 'Enable search in primary navigation', 'mloc' ),
        'section'	=> 'mloc_navigation',
        'settings'	=> 'mloc_navigation_search',
        'priority'	=> 10,
    ) );

    // Navigation transparency
    $wp_customize->add_setting( 'mloc_navigation_transparency', array(
        'default'			=> false,
        'sanitize_callback'	=> 'mloc_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'mloc_navigation_transparency', array(
        'type'		=> 'checkbox',
        'label'		=> esc_html__( 'Transparent background', 'mloc' ),
        'section'	=> 'mloc_navigation',
        'settings'	=> 'mloc_navigation_transparency',
        'priority'	=> 15,
    ) );

    // Navbar brand
    $wp_customize->add_setting( 'mloc_navigation_brand', array(
        'default'			=> true,
        'sanitize_callback'	=> 'mloc_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'mloc_navigation_brand', array(
        'type'		=> 'checkbox',
        'label'		=> esc_html__( 'Display brand', 'mloc' ),
        'section'	=> 'mloc_navigation',
        'settings'	=> 'mloc_navigation_brand',
        'priority'	=> 20,
    ) );
}
add_action( 'customize_register', 'mloc_header_navigation_customize_register' );