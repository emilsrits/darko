<?php
/**
 * Theme customizer functionality
 *
 * @package Mloc
 */

/**
 * Include custom customizer object classes
 */
function mloc_require_customizer_objects() {
	$objects_array = array(
		'customizer/mloc-control-image-select/mloc-control-image-select.php'
	);

	foreach ( $objects_array as $object ) {
		$object_path = MLOC_INC . $object;
		if ( file_exists( $object_path ) ) {
			require_once( $object_path );
		}
	}
}
add_action( 'customize_register', 'mloc_require_customizer_objects', 0 );

/**
 * Register custom customizer objects
 *
 * @param $wp_customize
 */
function mloc_register_customizer_objects( $wp_customize ) {
	$wp_customize->register_control_type( 'Mloc_Control_Image_Select' );
}
add_action( 'customize_register', 'mloc_register_customizer_objects', 0 );

/**
 * Add theme customization to customizer
 *
 * @param $wp_customize
 */
function mloc_customize_register( $wp_customize ) {
	/**
	 * Appearance settings
	 */
	$wp_customize->add_panel( 'mloc_appearance_settings', array(
		'title'		=> __( 'Appearance Settings', 'mloc' ),
		'priority'	=> 25,
	) );

	if ( class_exists( 'Mloc_Control_Image_Select' ) ) {
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
		$wp_customize->add_section( 'mloc_layout', array(
			'title'			=> __( 'Layout', 'mloc' ),
			'description'	=> __( 'Layout for posts and pages', 'mloc' ),
			'panel'			=> 'mloc_appearance_settings',
			'priority'		=> 20,
		) );

		// Blog sidebar layout
		$wp_customize->add_setting( 'mloc_blog_sidebar_layout', array(
			'default'			=> 'full-width',
			'sanitize_callback'	=> 'sanitize_key',
		) );
		$wp_customize->add_control(
			new Mloc_Control_Image_Select( $wp_customize, 'mloc_blog_sidebar_layout', array(
				'label'		=> esc_html__( 'Blog Layout', 'mloc' ),
				'section'	=> 'mloc_layout',
				'settings'	=> 'mloc_blog_sidebar_layout',
				'choices'	=> $sidebar_layouts,
				'priority'	=> 20,
			) )
		);

		// Page sidebar layout
		$wp_customize->add_setting( 'mloc_page_sidebar_layout', array(
			'default'			=> 'full-width',
			'sanitize_callback'	=> 'sanitize_key',
		) );
		$wp_customize->add_control(
			new Mloc_Control_Image_Select( $wp_customize, 'mloc_page_sidebar_layout', array(
				'label'		=> esc_html__( 'Page Layout', 'mloc' ),
				'section'	=> 'mloc_layout',
				'settings'	=> 'mloc_page_sidebar_layout',
				'choices'	=> $sidebar_layouts,
				'priority'	=> 40,
			) )
		);
	}

	/**
	 * Header settings
	 */
	$wp_customize->add_panel( 'mloc_header_settings', array(
		'title'		=> __( 'Header Settings', 'mloc' ),
		'priority'	=> 45,
	) );

	// Move core header image customization under this theme header settings
	$wp_customize->get_section( 'header_image' )->panel = 'mloc_header_settings';

	// Section: Navigation
	$wp_customize->add_section( 'mloc_navigation', array(
		'title'			=> __( 'Navigation', 'mloc' ),
		'panel'			=> 'mloc_header_settings',
		'priority'		=> 20,
	) );

	// Navigation search input
	$wp_customize->add_setting( 'mloc_navigation_search', array(
		'default'			=> false,
		'sanitize_callback'	=> 'mloc_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'mloc_navigation_search', array(
		'type'		=> 'checkbox',
		'label'		=> esc_html__( 'Enable search in primary navigation', 'mloc' ),
		'section'	=> 'mloc_navigation',
		'settings'	=> 'mloc_navigation_search',
		'priority'	=> 20,
	) );

	/**
	 * Page settings
	 */
	$wp_customize->add_section( 'mloc_page_settings', array(
		'title'		=> __( 'Page Settings', 'mloc' ),
		'priority'	=> 55,
	) );

	// Page featured image display
	$wp_customize->add_setting( 'mloc_page_featured_image', array(
		'default' => true,
	) );
	$wp_customize->add_control( 'mloc_page_featured_image', array(
		'type'			=> 'checkbox',
		'label'			=> esc_html__( 'Enable featured image display', 'mloc' ),
		'description'	=> __( 'Display featured image of the page at the beginning of its content', 'mloc' ),
		'section'		=> 'mloc_page_settings',
		'settings'		=> 'mloc_page_featured_image',
		'priority'		=> 20,
	) );

	/**
	 * Single post settings
	 */
	$wp_customize->add_section( 'mloc_single_post_settings', array(
		'title'		=> __( 'Single Post Settings', 'mloc' ),
		'priority'	=> 65,
	) );

	// Page featured image display
	$wp_customize->add_setting( 'mloc_single_post_featured_image', array(
		'default' => true,
	) );
	$wp_customize->add_control( 'mloc_single_post_featured_image', array(
		'type'			=> 'checkbox',
		'label'			=> esc_html__( 'Enable featured image display', 'mloc' ),
		'description'	=> __( 'Display featured image of the post at the beginning of its content', 'mloc' ),
		'section'		=> 'mloc_single_post_settings',
		'settings'		=> 'mloc_single_post_featured_image',
		'priority'		=> 20,
	) );
}
add_action( 'customize_register', 'mloc_customize_register' );

if ( ! function_exists( 'mloc_sanitize_checkbox' ) ) {
	/**
	 * Sanitize checkbox input
	 *
	 * @param $input
	 * @return bool
	 */
	function mloc_sanitize_checkbox( $input ) {
		return ( isset( $input ) && $input === true ? true : false );
	}
}