<?php
/**
 * Theme appearance customizer for typography
 *
 * @package Darko
 */

/**
 * Customization for typography
 *
 * @param $wp_customize
 */
function darko_appearance_typography_customize_register( $wp_customize ) {
    $default_p = 16;
    $default_h1 = 32;
    $default_h2 = 24;
    $f_min = 1;
    $f_max = 40;
    $f_step = 1;

    // Section: Typography settings
    $wp_customize->add_section( 'darko_appearance_typography', array(
        'title'		=> __( 'Typography', 'darko' ),
        'panel'     => 'darko_appearance_settings',
        'priority'	=> 25,
    ) );

    // Heading font
    $wp_customize->add_setting( 'darko_typography_heading', array(
        'default' 			=> '',
        'sanitize_callback'	=> 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'darko_typography_heading', array(
        'type'			=> 'select',
        'choices'       => darko_get_combined_fonts(),
        'label'			=> esc_html__( 'Heading font family', 'darko' ),
        'section'		=> 'darko_appearance_typography',
        'settings'		=> 'darko_typography_heading',
        'priority'		=> 10,
    ) );

    // Body font
    $wp_customize->add_setting( 'darko_typography_body', array(
        'default' 			=> '',
        'sanitize_callback'	=> 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'darko_typography_body', array(
        'type'			=> 'select',
        'choices'       => darko_get_combined_fonts(),
        'label'			=> esc_html__( 'Body font family', 'darko' ),
        'section'		=> 'darko_appearance_typography',
        'settings'		=> 'darko_typography_body',
        'priority'		=> 15,
    ) );

    // Menu font size
    $wp_customize->add_setting( 'darko_typography_size_menu', array(
        'default' 			=> $default_p,
        'sanitize_callback'	=> 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Darko_Customize_Slider_Control( $wp_customize, 'darko_typography_size_menu', array(
            'label'		    => esc_html__( 'Menu font size', 'darko' ),
            'section'	    => 'darko_appearance_typography',
            'settings'	    => 'darko_typography_size_menu',
            'input_attrs'   => array(
                'min'   => $f_min,
                'max'   => $f_max,
                'value' => $default_p,
                'step'  => $f_step,
            ),
            'priority'      => 20,
        ) )
    );

    // Hero font size
    $wp_customize->add_setting( 'darko_typography_size_hero', array(
        'default' 			=> $default_h1,
        'sanitize_callback'	=> 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Darko_Customize_Slider_Control( $wp_customize, 'darko_typography_size_hero', array(
            'label'		    => esc_html__( 'Hero font size', 'darko' ),
            'section'	    => 'darko_appearance_typography',
            'settings'	    => 'darko_typography_size_hero',
            'input_attrs'   => array(
                'min'   => $f_min,
                'max'   => $f_max,
                'value' => $default_h1,
                'step'  => $f_step,
            ),
            'priority'      => 25,
        ) )
    );

    // Blog post heading font size
    $wp_customize->add_setting( 'darko_typography_size_blog_heading', array(
        'default' 			=> $default_h2,
        'sanitize_callback'	=> 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Darko_Customize_Slider_Control( $wp_customize, 'darko_typography_size_blog_heading', array(
            'label'		    => esc_html__( 'Blog post heading font size', 'darko' ),
            'section'	    => 'darko_appearance_typography',
            'settings'	    => 'darko_typography_size_blog_heading',
            'input_attrs'   => array(
                'min'   => $f_min,
                'max'   => $f_max,
                'value' => $default_h2,
                'step'  => $f_step,
            ),
            'priority'      => 30,
        ) )
    );

    // Blog post body font size
    $wp_customize->add_setting( 'darko_typography_size_blog_body', array(
        'default' 			=> $default_p,
        'sanitize_callback'	=> 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Darko_Customize_Slider_Control( $wp_customize, 'darko_typography_size_blog_body', array(
            'label'		    => esc_html__( 'Blog post body font size', 'darko' ),
            'section'	    => 'darko_appearance_typography',
            'settings'	    => 'darko_typography_size_blog_body',
            'input_attrs'   => array(
                'min'   => $f_min,
                'max'   => $f_max,
                'value' => $default_p,
                'step'  => $f_step,
            ),
            'priority'      => 35,
        ) )
    );

    // Single post/page body font size
    $wp_customize->add_setting( 'darko_typography_size_page_body', array(
        'default' 			=> $default_p,
        'sanitize_callback'	=> 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Darko_Customize_Slider_Control( $wp_customize, 'darko_typography_size_page_body', array(
            'label'		    => esc_html__( 'Page body font size', 'darko' ),
            'section'	    => 'darko_appearance_typography',
            'settings'	    => 'darko_typography_size_page_body',
            'input_attrs'   => array(
                'min'   => $f_min,
                'max'   => $f_max,
                'value' => $default_p,
                'step'  => $f_step
            ),
            'priority'      => 40,
        ) )
    );

    // Sidebar font size
    $wp_customize->add_setting( 'darko_typography_size_sidebar', array(
        'default' 			=> $default_p,
        'sanitize_callback'	=> 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Darko_Customize_Slider_Control( $wp_customize, 'darko_typography_size_sidebar', array(
            'label'		    => esc_html__( 'Sidebar font size', 'darko' ),
            'section'	    => 'darko_appearance_typography',
            'settings'	    => 'darko_typography_size_sidebar',
            'input_attrs'   => array(
                'min'   => $f_min,
                'max'   => $f_max,
                'value' => $default_p,
                'step'  => $f_step,
            ),
            'priority'      => 45,
        ) )
    );

    // Footer sidebar font size
    $wp_customize->add_setting( 'darko_typography_size_footer_sidebar', array(
        'default' 			=> $default_p,
        'sanitize_callback'	=> 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Darko_Customize_Slider_Control( $wp_customize, 'darko_typography_size_footer_sidebar', array(
            'label'		    => esc_html__( 'Footer sidebar font size', 'darko' ),
            'section'	    => 'darko_appearance_typography',
            'settings'	    => 'darko_typography_size_footer_sidebar',
            'input_attrs'   => array(
                'min'   => $f_min,
                'max'   => $f_max,
                'value' => $default_p,
                'step'  => $f_step,
            ),
            'priority'      => 50,
        ) )
    );

    // Footer copyright font size
    $wp_customize->add_setting( 'darko_typography_size_copyright', array(
        'default' 			=> $default_p,
        'sanitize_callback'	=> 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control(
        new Darko_Customize_Slider_Control( $wp_customize, 'darko_typography_size_copyright', array(
            'label'		    => esc_html__( 'Footer copyright font size', 'darko' ),
            'section'	    => 'darko_appearance_typography',
            'settings'	    => 'darko_typography_size_copyright',
            'input_attrs'   => array(
                'min'   => $f_min,
                'max'   => $f_max,
                'value' => $default_p,
                'step'  => $f_step,
            ),
            'priority'      => 55,
        ) )
    );
}
add_action( 'customize_register', 'darko_appearance_typography_customize_register' );
