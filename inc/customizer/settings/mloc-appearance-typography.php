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
        'priority'		=> 10,
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
        'priority'		=> 15,
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
            'section'	    => 'mloc_appearance_typography',
            'settings'	    => 'mloc_typography_size_menu',
            'input_attrs'   => array(
                'min'   => 1,
                'max'   => 32,
                'value' => 16,
                'step'  => 1,
            ),
            'priority'      => 20,
        ) )
    );

    // Blog post heading font size
    $wp_customize->add_setting( 'mloc_typography_size_blog_heading', array(
        'default' 			=> 24,
        'sanitize_callback'	=> 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Mloc_Customize_Slider_Control( $wp_customize, 'mloc_typography_size_blog_heading', array(
            'label'		    => esc_html__( 'Blog post heading font size', 'mloc' ),
            'section'	    => 'mloc_appearance_typography',
            'settings'	    => 'mloc_typography_size_blog_heading',
            'input_attrs'   => array(
                'min'   => 1,
                'max'   => 32,
                'value' => 24,
                'step'  => 1,
            ),
            'priority'      => 25,
        ) )
    );

    // Blog post body font size
    $wp_customize->add_setting( 'mloc_typography_size_blog_body', array(
        'default' 			=> 16,
        'sanitize_callback'	=> 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Mloc_Customize_Slider_Control( $wp_customize, 'mloc_typography_size_blog_body', array(
            'label'		    => esc_html__( 'Blog post body font size', 'mloc' ),
            'section'	    => 'mloc_appearance_typography',
            'settings'	    => 'mloc_typography_size_blog_body',
            'input_attrs'   => array(
                'min'   => 1,
                'max'   => 32,
                'value' => 16,
                'step'  => 1,
            ),
            'priority'      => 30,
        ) )
    );

    // Single post/page body font size

    // Blog post body font size
    $wp_customize->add_setting( 'mloc_typography_size_page_body', array(
        'default' 			=> 16,
        'sanitize_callback'	=> 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Mloc_Customize_Slider_Control( $wp_customize, 'mloc_typography_size_page_body', array(
            'label'		    => esc_html__( 'Page body font size', 'mloc' ),
            'section'	    => 'mloc_appearance_typography',
            'settings'	    => 'mloc_typography_size_page_body',
            'input_attrs'   => array(
                'min'   => 1,
                'max'   => 32,
                'value' => 16,
                'step'  => 1,
            ),
            'priority'      => 35,
        ) )
    );

    // Sidebar font size
    $wp_customize->add_setting( 'mloc_typography_size_sidebar', array(
        'default' 			=> 16,
        'sanitize_callback'	=> 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Mloc_Customize_Slider_Control( $wp_customize, 'mloc_typography_size_sidebar', array(
            'label'		    => esc_html__( 'Sidebar font size', 'mloc' ),
            'section'	    => 'mloc_appearance_typography',
            'settings'	    => 'mloc_typography_size_sidebar',
            'input_attrs'   => array(
                'min'   => 1,
                'max'   => 32,
                'value' => 16,
                'step'  => 1,
            ),
            'priority'      => 40,
        ) )
    );

    // Footer sidebar font size
    $wp_customize->add_setting( 'mloc_typography_size_footer_sidebar', array(
        'default' 			=> 16,
        'sanitize_callback'	=> 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Mloc_Customize_Slider_Control( $wp_customize, 'mloc_typography_size_footer_sidebar', array(
            'label'		    => esc_html__( 'Footer sidebar font size', 'mloc' ),
            'section'	    => 'mloc_appearance_typography',
            'settings'	    => 'mloc_typography_size_footer_sidebar',
            'input_attrs'   => array(
                'min'   => 1,
                'max'   => 32,
                'value' => 16,
                'step'  => 1,
            ),
            'priority'      => 45,
        ) )
    );

    // Footer copyright font size
    $wp_customize->add_setting( 'mloc_typography_size_copyright', array(
        'default' 			=> 16,
        'sanitize_callback'	=> 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Mloc_Customize_Slider_Control( $wp_customize, 'mloc_typography_size_copyright', array(
            'label'		    => esc_html__( 'Footer copyright font size', 'mloc' ),
            'section'	    => 'mloc_appearance_typography',
            'settings'	    => 'mloc_typography_size_copyright',
            'input_attrs'   => array(
                'min'   => 1,
                'max'   => 32,
                'value' => 16,
                'step'  => 1,
            ),
            'priority'      => 50,
        ) )
    );
}
add_action( 'customize_register', 'mloc_appearance_typography_customize_register' );
