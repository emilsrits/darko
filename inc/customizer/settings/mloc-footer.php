<?php
/**
 * Theme appearance customizer for footer
 *
 * @package Mloc
 */

/**
 * Customization for footer
 *
 * @param $wp_customize
 */
function mloc_footer_customize_register( $wp_customize ) {
    // Section: Footer
    $wp_customize->add_section( 'mloc_footer', array(
        'title'			=> __( 'Footer Settings', 'mloc' ),
        'priority'		=> 55,
    ) );

    // Copyright
    $wp_customize->add_setting( 'mloc_copyright', array(
        'default'			=> '© Copyright - ' . get_bloginfo( 'name' ),
        'sanitize_callback'	=> 'wp_filter_nohtml_kses',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mloc_copyright', array(
        'type'			=> 'text',
        'label'			=> esc_html__( 'Copyright', 'mloc' ),
        'section'		=> 'mloc_footer',
        'settings'		=> 'mloc_copyright',
        'priority'		=> 10,
    ) );
}
add_action( 'customize_register', 'mloc_footer_customize_register' );