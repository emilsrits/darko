<?php
/**
 * Theme appearance customizer for pages
 *
 * @package Mloc
 */

/**
 * Customization for pages
 *
 * @param $wp_customize
 */
function mloc_page_customize_register( $wp_customize ) {
    // Section: Page settings
    $wp_customize->add_section( 'mloc_page_settings', array(
        'title'		=> __( 'Page Settings', 'mloc' ),
        'panel'     => 'mloc_content_settings',
        'priority'	=> 40,
    ) );

    // Page featured image display
    $wp_customize->add_setting( 'mloc_page_featured_image', array(
        'default' 			=> true,
        'sanitize_callback'	=> 'mloc_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'mloc_page_featured_image', array(
        'type'			=> 'checkbox',
        'label'			=> esc_html__( 'Enable featured image display', 'mloc' ),
        'description'	=> __( 'Display featured image of the page at the beginning of its content.', 'mloc' ),
        'section'		=> 'mloc_page_settings',
        'settings'		=> 'mloc_page_featured_image',
        'priority'		=> 20,
    ) );
}
add_action( 'customize_register', 'mloc_page_customize_register' );