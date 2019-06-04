<?php
/**
 * Theme appearance customizer for footer
 *
 * @package Darko
 */

/**
 * Customization for footer
 *
 * @param $wp_customize
 */
function darko_footer_customize_register( $wp_customize ) {
    // Section: Footer
    $wp_customize->add_section( 'darko_footer', array(
        'title'			=> __( 'Footer Settings', 'darko' ),
        'priority'		=> 55,
    ) );

    // Copyright
    $wp_customize->add_setting( 'darko_copyright', array(
        'default'			=> '© Copyright - ' . get_bloginfo( 'name' ),
        'sanitize_callback'	=> 'wp_filter_nohtml_kses',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'darko_copyright', array(
        'type'			=> 'text',
        'label'			=> esc_html__( 'Copyright', 'darko' ),
        'section'		=> 'darko_footer',
        'settings'		=> 'darko_copyright',
        'priority'		=> 10,
    ) );
}
add_action( 'customize_register', 'darko_footer_customize_register' );