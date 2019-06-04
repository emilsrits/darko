<?php
/**
 * Theme appearance customizer for background image
 *
 * @package Darko
 */

/**
 * Customization for background image
 *
 * @param $wp_customize
 */
function darko_appearance_background_image_customize_register( $wp_customize ) {
    // Default opacity
    $default_o = 0.97;

    // Background transparency
    $wp_customize->add_setting( 'darko_background_transparency', array(
        'default'			=> $default_o,
        'sanitize_callback'	=> 'darko_sanitize_float',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Darko_Customize_Slider_Control( $wp_customize, 'darko_background_transparency', array(
            'label'		        => esc_html__( 'Background transparency', 'darko' ),
            'section'	        => 'background_image',
            'settings'	        => 'darko_background_transparency',
            'input_attrs'       => array(
                'min'   => 0,
                'max'   => 1,
                'value' => $default_o,
                'step'  => 0.01,
            ),
            'active_callback'   => 'darko_appearance_has_background_image',
            'priority'          => 10,
        ) )
    );
}
add_action( 'customize_register', 'darko_appearance_background_image_customize_register' );

/**
 * Check if background image is set
 */
function darko_appearance_has_background_image() {
    return ( get_background_image() !== '' ) ? true : false;
}