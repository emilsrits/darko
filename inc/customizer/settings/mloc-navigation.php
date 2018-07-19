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
function mloc_navigation_customize_register( $wp_customize ) {
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
        'priority'	=> 20,
    ) );
}
add_action( 'customize_register', 'mloc_navigation_customize_register' );