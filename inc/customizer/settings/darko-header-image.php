<?php
/**
 * Theme appearance customizer for header hero
 *
 * @package Darko
 */

/**
 * Customization for header hero
 *
 * @param $wp_customize
 */
function darko_header_image_customize_register( $wp_customize ) {
    // Enable header hero
    $wp_customize->add_setting( 'darko_header_hero', array(
        'default'			=> true,
        'sanitize_callback'	=> 'darko_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'darko_header_hero', array(
        'type'		=> 'checkbox',
        'label'		=> esc_html__( 'Enable header hero', 'darko' ),
        'section'	=> 'header_image',
        'settings'	=> 'darko_header_hero',
        'priority'	=> 15,
    ) );
}
add_action( 'customize_register', 'darko_header_image_customize_register' );