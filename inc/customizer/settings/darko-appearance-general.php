<?php
/**
 * Theme appearance customizer for layouts
 *
 * @package Darko
 */

/**
 * Customization for layouts
 *
 * @param $wp_customize
 */
function darko_appearance_general_customize_register( $wp_customize ) {
    // Check if class for custom radio image exists
    if ( class_exists( 'Darko_Customize_Image_Select_Control' ) ) {

        $sidebar_layouts = array(
            'sidebar-left'	=> array(
                'label'	=> esc_html__( 'Sidebar on left side', 'darko' ),
                'url'	=> '%ssidebar-left.jpg'
            ),
            'full-width'	=> array(
                'label'	=> esc_html__( 'No sidebar, full width content', 'darko' ),
                'url'	=> '%sfull-width.jpg'
            ),
            'sidebar-right'	=> array(
                'label'	=> esc_html__( 'Sidebar on right side', 'darko' ),
                'url'	=> '%ssidebar-right.jpg'
            ),
        );

        // Section: Layout
        $wp_customize->add_section( 'darko_appearance_general', array(
            'title'		=> __( 'General', 'darko' ),
            'panel'		=> 'darko_appearance_settings',
            'priority' 	=> 20,
        ) );

        // Blog sidebar layout
        $wp_customize->add_setting( 'darko_blog_sidebar_layout', array(
            'default'			=> 'full-width',
            'sanitize_callback'	=> 'sanitize_key',
        ) );
        $wp_customize->add_control(
            new Darko_Customize_Image_Select_Control( $wp_customize, 'darko_blog_sidebar_layout', array(
                'label'		=> esc_html__( 'Blog layout', 'darko' ),
                'section'	=> 'darko_appearance_general',
                'settings'	=> 'darko_blog_sidebar_layout',
                'choices'	=> $sidebar_layouts,
                'priority'	=> 10,
            ) )
        );

        // Page sidebar layout
        $wp_customize->add_setting( 'darko_page_sidebar_layout', array(
            'default'			=> 'full-width',
            'sanitize_callback'	=> 'sanitize_key',
        ) );
        $wp_customize->add_control(
            new Darko_Customize_Image_Select_Control( $wp_customize, 'darko_page_sidebar_layout', array(
                'label'		=> esc_html__( 'Page layout', 'darko' ),
                'section'	=> 'darko_appearance_general',
                'settings'	=> 'darko_page_sidebar_layout',
                'choices'	=> $sidebar_layouts,
                'priority'	=> 15,
            ) )
        );

        // Hide sidebar on mobile
        $wp_customize->add_setting( 'darko_sidebar_mobile', array(
            'default'			=> false,
            'sanitize_callback'	=> 'darko_sanitize_checkbox',
        ) );
        $wp_customize->add_control( 'darko_sidebar_mobile', array(
            'type'		=> 'checkbox',
            'label'		=> esc_html__( 'Hide sidebar on mobile', 'darko' ),
            'section'	=> 'darko_appearance_general',
            'settings'	=> 'darko_sidebar_mobile',
            'priority'	=> 20,
        ) );

        // Enable scroll to top button
        $wp_customize->add_setting( 'darko_go_top', array(
            'default'           => true,
            'sanitize_callback' => 'darko_sanitize_checkbox',
        ) );
        $wp_customize->add_control( 'darko_go_top', array(
            'type'		=> 'checkbox',
            'label'		=> esc_html__( 'Enable scroll to top button', 'darko' ),
            'section'	=> 'darko_appearance_general',
            'settings'	=> 'darko_go_top',
            'priority'	=> 25,
        ) );

    }
}
add_action( 'customize_register', 'darko_appearance_general_customize_register' );