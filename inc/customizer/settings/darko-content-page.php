<?php
/**
 * Theme appearance customizer for pages
 *
 * @package Darko
 */

/**
 * Customization for pages
 *
 * @param $wp_customize
 */
function darko_content_page_customize_register( $wp_customize ) {
    // Section: Page settings
    $wp_customize->add_section( 'darko_page_settings', array(
        'title'		=> __( 'Page Settings', 'darko' ),
        'panel'     => 'darko_content_settings',
        'priority'	=> 40,
    ) );

    // Page featured image display
    $wp_customize->add_setting( 'darko_page_featured_image', array(
        'default' 			=> true,
        'sanitize_callback'	=> 'darko_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'darko_page_featured_image', array(
        'type'			=> 'checkbox',
        'label'			=> esc_html__( 'Enable featured image display', 'darko' ),
        'description'	=> __( 'Display featured image of the page at the beginning of its content.', 'darko' ),
        'section'		=> 'darko_page_settings',
        'settings'		=> 'darko_page_featured_image',
        'priority'		=> 10,
    ) );
}
add_action( 'customize_register', 'darko_content_page_customize_register' );