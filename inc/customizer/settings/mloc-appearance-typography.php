<?php
/**
 * Theme appearance customizer for typography
 *
 * @package Mloc
 */

/**
 * Customization for typography
 *
 * @param $wp_customize
 */
function mloc_appearance_typography_customize_register( $wp_customize ) {
    // Default attributes for slider control
    $input_attrs = array(
        'min'   => 11,
        'max'   => 21,
        'value' => 16,
        'step'  => 1,
    );

    // Section: Typography settings
    $wp_customize->add_section( 'mloc_appearance_typography', array(
        'title'		=> __( 'Typography', 'mloc' ),
        'panel'     => 'mloc_appearance_settings',
        'priority'	=> 25,
    ) );

    // Heading font
    $wp_customize->add_setting( 'mloc_typography_heading', array(
        'default' 			=> '',
        'sanitize_callback'	=> 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'mloc_typography_heading', array(
        'type'			=> 'select',
        'choices'       => mloc_get_combined_fonts(),
        'label'			=> esc_html__( 'Heading font family', 'mloc' ),
        'section'		=> 'mloc_appearance_typography',
        'settings'		=> 'mloc_typography_heading',
        'priority'		=> 20,
    ) );

    // Body font
    $wp_customize->add_setting( 'mloc_typography_body', array(
        'default' 			=> '',
        'sanitize_callback'	=> 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'mloc_typography_body', array(
        'type'			=> 'select',
        'choices'       => mloc_get_combined_fonts(),
        'label'			=> esc_html__( 'Body font family', 'mloc' ),
        'section'		=> 'mloc_appearance_typography',
        'settings'		=> 'mloc_typography_body',
        'priority'		=> 40,
    ) );

    // Menu font size
    $wp_customize->add_setting( 'mloc_typography_size_menu', array(
        'default' 			=> 16,
        'sanitize_callback'	=> 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Mloc_Customize_Slider_Control( $wp_customize, 'mloc_typography_size_menu', array(
            'label'		    => esc_html__( 'Menu font size', 'mloc' ),
            'description'   => esc_html__( 'From 11 to 21 pixels', 'mloc' ),
            'section'	    => 'mloc_appearance_typography',
            'settings'	    => 'mloc_typography_size_menu',
            'input_attrs'   => $input_attrs,
            'priority'      => 60,
        ) )
    );
}
add_action( 'customize_register', 'mloc_appearance_typography_customize_register' );
