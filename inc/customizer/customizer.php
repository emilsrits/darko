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
        'customizer/controls/image-select/class-mloc-customize-image-select-control.php',
        'customizer/controls/slider/class-mloc-customize-slider-control.php'
    );
    foreach ( $objects_array as $object ) {
        $object_path = MLOC_INC . $object;
        if ( file_exists( $object_path ) ) {
            require_once( $object_path );
        }
    }

    $settings_array = array(
        'customizer/settings/mloc-appearance-general.php',
        'customizer/settings/mloc-appearance-typography.php',
        'customizer/settings/mloc-content-blog.php',
        'customizer/settings/mloc-content-page.php',
        'customizer/settings/mloc-content-single-post.php',
        'customizer/settings/mloc-header-navigation.php'
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
	$wp_customize->register_control_type( 'Mloc_Customize_Image_Select_Control' );
    $wp_customize->register_control_type( 'Mloc_Customize_Slider_Control' );
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

	// Panel: Content settings
    $wp_customize->add_panel( 'mloc_content_settings', array(
        'title'     => __( 'Content Settings', 'mloc' ),
        'priority'  => 65,
    ) );

	// Copyright
	$wp_customize->add_setting( 'mloc_copyright', array(
		'default'			=> '© Copyright - ' . get_bloginfo( 'name' ),
		'sanitize_callback'	=> 'wp_filter_nohtml_kses',
        'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'mloc_copyright', array(
		'type'			=> 'text',
		'label'			=> esc_html__( 'Copyright', 'mloc' ),
		'description'	=> __( 'Change site copyright in footer.', 'mloc' ),
		'section'		=> 'title_tagline',
		'settings'		=> 'mloc_copyright',
		'priority'		=> 65,
	) );

	// Add selective refresh
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'custom_logo' )->transport = 'postMessage';

    $wp_customize->selective_refresh->add_partial( 'blogname', array(
        'selector'          => '.navbar-brand p',
        'render_callback'   => function() {
            return get_bloginfo( 'name' );
        },
    ) );

    $wp_customize->selective_refresh->add_partial( 'custom_logo', array(
        'selector'          => '.navbar-brand',
        'render_callback'   => function() {
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );

            if ( $custom_logo_id ) {
                $logo_callback = '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '">';
            } else {
                $logo_callback = '<p>' . get_bloginfo( 'name' ) . '</p>';
            }

            return $logo_callback;
        },
    ) );

    $wp_customize->selective_refresh->add_partial( 'mloc_copyright', array(
        'selector'          => '.copyright p',
        'render_callback'   => function() {
            $copyright = get_theme_mod( 'mloc_copyright', '© Copyright - ' . get_bloginfo( 'name' ) );

            return $copyright;
        },
    ) );
}
add_action( 'customize_register', 'mloc_customize_register' );

/**
 * Load customize preview JS file
 */
function mloc_customize_preview_init() {
    wp_enqueue_script( 'mloc-customize-preview', get_template_directory_uri() . '/assets/js/typography-customize-preview.js', array( 'customize-preview' ), false, true );
}
add_action( 'customize_preview_init', 'mloc_customize_preview_init' );

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