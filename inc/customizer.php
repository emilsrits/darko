<?php
/**
 * Theme customizer functionality
 *
 * @package Mloc
 */

/**
 * Include custom customizer classes and files
 */
function mloc_setup_customizer_files() {
    $objects_array = array(
        'customizer/mloc-control-image-select/mloc-control-image-select.php'
    );
    foreach ( $objects_array as $object ) {
        $object_path = MLOC_INC . $object;
        if ( file_exists( $object_path ) ) {
            require_once( $object_path );
        }
    }

    $settings_array = array(
        'customizer/settings/mloc-layout.php',
        'customizer/settings/mloc-navigation.php',
        'customizer/settings/mloc-page.php',
        'customizer/settings/mloc-single-post.php'
    );
    foreach ( $settings_array as $setting ) {
        $setting_path = MLOC_INC . $setting;
        if ( file_exists( $setting_path ) ) {
            include_once( $setting_path );
        }
    }
}
add_action( 'customize_register', 'mloc_setup_customizer_files', 0 );

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
	// Panel: Appearance settings
	$wp_customize->add_panel( 'mloc_appearance_settings', array(
		'title'		=> __( 'Appearance Settings', 'mloc' ),
		'priority'	=> 25,
	) );
    // Move core colors customization under theme appearance settings
    $wp_customize->get_section( 'colors' )->panel = 'mloc_appearance_settings';
    // Move core background image customization under theme appearance settings
    $wp_customize->get_section( 'background_image' )->panel = 'mloc_appearance_settings';

	// Panel: Header settings
	$wp_customize->add_panel( 'mloc_header_settings', array(
		'title'		=> __( 'Header Settings', 'mloc' ),
		'priority'	=> 45,
	) );
	// Move core header image customization under theme header settings
	$wp_customize->get_section( 'header_image' )->panel = 'mloc_header_settings';

	// Copyright
	$wp_customize->add_setting( 'mloc_copyright', array(
		'default'			=> '© Copyright - ' . get_bloginfo( 'name' ),
		'sanitize_callback'	=> 'wp_filter_nohtml_kses',
	) );
	$wp_customize->add_control( 'mloc_copyright', array(
		'type'			=> 'text',
		'label'			=> esc_html__( 'Copyright', 'mloc' ),
		'description'	=> __( 'Change site copyright in footer.', 'mloc' ),
		'section'		=> 'title_tagline',
		'settings'		=> 'mloc_copyright',
		'priority'		=> 65,
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