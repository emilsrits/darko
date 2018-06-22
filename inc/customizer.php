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

		$wp_customize->add_section( 'mloc_layout', array(
			'title'			=> __( 'Layout', 'mloc' ),
			'description'	=> __( 'Layout for posts and pages', 'mloc' ),
			'panel'			=> 'mloc_appearance_settings',
			'priority'		=> 20,
		) );

		/**
		 * Blog sidebar layout
		 */
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

		/**
		 * Page sidebar layout
		 */
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
}
add_action( 'customize_register', 'mloc_customize_register' );