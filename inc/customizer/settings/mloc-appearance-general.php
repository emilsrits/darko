<?php
/**
 * Theme appearance customizer for layouts
 *
 * @package Mloc
 */

/**
 * Customization for layouts
 *
 * @param $wp_customize
 */
function mloc_appearance_general_customize_register( $wp_customize ) {
    // Check if class for custom radio image exists
    if ( class_exists( 'Mloc_Customize_Image_Select_Control' ) ) {

        $sidebar_layouts = array(
            'sidebar-left'	=> array(
                'label'	=> esc_html__( 'Sidebar on left side', 'mloc' ),
                'url'	=> '%ssidebar-left.jpg'
            ),
            'full-width'	=> array(
                'label'	=> esc_html__( 'No sidebar, full width content', 'mloc' ),
                'url'	=> '%sfull-width.jpg'
            ),
            'sidebar-right'	=> array(
                'label'	=> esc_html__( 'Sidebar on right side', 'mloc' ),
                'url'	=> '%ssidebar-right.jpg'
            ),
        );

        // Section: Layout
        $wp_customize->add_section( 'mloc_appearance_general', array(
            'title'		=> __( 'General', 'mloc' ),
            'panel'		=> 'mloc_appearance_settings',
            'priority' 	=> 20,
        ) );

        // Blog sidebar layout
        $wp_customize->add_setting( 'mloc_blog_sidebar_layout', array(
            'default'			=> 'full-width',
            'sanitize_callback'	=> 'sanitize_key',
        ) );
        $wp_customize->add_control(
            new Mloc_Customize_Image_Select_Control( $wp_customize, 'mloc_blog_sidebar_layout', array(
                'label'		=> esc_html__( 'Blog layout', 'mloc' ),
                'section'	=> 'mloc_appearance_general',
                'settings'	=> 'mloc_blog_sidebar_layout',
                'choices'	=> $sidebar_layouts,
                'priority'	=> 10,
            ) )
        );

        // Page sidebar layout
        $wp_customize->add_setting( 'mloc_page_sidebar_layout', array(
            'default'			=> 'full-width',
            'sanitize_callback'	=> 'sanitize_key',
        ) );
        $wp_customize->add_control(
            new Mloc_Customize_Image_Select_Control( $wp_customize, 'mloc_page_sidebar_layout', array(
                'label'		=> esc_html__( 'Page layout', 'mloc' ),
                'section'	=> 'mloc_appearance_general',
                'settings'	=> 'mloc_page_sidebar_layout',
                'choices'	=> $sidebar_layouts,
                'priority'	=> 15,
            ) )
        );

        // Hide sidebar on mobile
        $wp_customize->add_setting( 'mloc_sidebar_mobile', array(
            'default'			=> false,
            'sanitize_callback'	=> 'mloc_sanitize_checkbox',
        ) );
        $wp_customize->add_control( 'mloc_sidebar_mobile', array(
            'type'		=> 'checkbox',
            'label'		=> esc_html__( 'Hide sidebar on mobile', 'mloc' ),
            'section'	=> 'mloc_appearance_general',
            'settings'	=> 'mloc_sidebar_mobile',
            'priority'	=> 20,
        ) );

        // Enable scroll to top button
        $wp_customize->add_setting( 'mloc_go_top', array(
            'default'           => true,
            'sanitize_callback' => 'mloc_sanitize_checkbox',
        ) );
        $wp_customize->add_control( 'mloc_go_top', array(
            'type'		=> 'checkbox',
            'label'		=> esc_html__( 'Enable scroll to top button', 'mloc' ),
            'section'	=> 'mloc_appearance_general',
            'settings'	=> 'mloc_go_top',
            'priority'	=> 25,
        ) );

    }
}
add_action( 'customize_register', 'mloc_appearance_general_customize_register' );