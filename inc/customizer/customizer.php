<?php
/**
 * Theme customizer functionality
 *
 * @package Darko
 */

/**
 * Include custom customizer classes and files
 */
function darko_setup_customizer_files() {
    $objects_array = array(
        'customizer/controls/image-select/class-darko-customize-image-select-control.php',
        'customizer/controls/slider/class-darko-customize-slider-control.php'
    );
    foreach ( $objects_array as $object ) {
        $object_path = DARKO_INC . $object;
        if ( file_exists( $object_path ) ) {
            require_once( $object_path );
        }
    }

    $settings_array = array(
        'customizer/settings/darko-appearance-background-image.php',
        'customizer/settings/darko-appearance-general.php',
        'customizer/settings/darko-appearance-typography.php',
        'customizer/settings/darko-content-blog.php',
        'customizer/settings/darko-content-page.php',
        'customizer/settings/darko-content-single-post.php',
        'customizer/settings/darko-footer.php',
        'customizer/settings/darko-header-image.php',
        'customizer/settings/darko-header-navigation.php'
    );
    foreach ( $settings_array as $setting ) {
        $setting_path = DARKO_INC . $setting;
        if ( file_exists( $setting_path ) ) {
            include_once( $setting_path );
        }
    }
}
add_action( 'customize_register', 'darko_setup_customizer_files', 0 );

/**
 * Register custom customizer objects
 *
 * @param $wp_customize
 */
function darko_register_customizer_objects( $wp_customize ) {
	$wp_customize->register_control_type( 'Darko_Customize_Image_Select_Control' );
    $wp_customize->register_control_type( 'Darko_Customize_Slider_Control' );
}
add_action( 'customize_register', 'darko_register_customizer_objects', 0 );

/**
 * Add theme customization to customizer
 *
 * @param $wp_customize
 */
function darko_customize_register( $wp_customize ) {
    // Panel: Appearance settings
	$wp_customize->add_panel( 'darko_appearance_settings', array(
		'title'		=> __( 'Appearance Settings', 'darko' ),
		'priority'	=> 25,
	) );
    // Move core colors customization under theme appearance settings
    $wp_customize->get_section( 'colors' )->panel = 'darko_appearance_settings';
    // Move core background image customization under theme appearance settings
    $wp_customize->get_section( 'background_image' )->panel = 'darko_appearance_settings';

	// Panel: Header settings
	$wp_customize->add_panel( 'darko_header_settings', array(
		'title'		=> __( 'Header Settings', 'darko' ),
		'priority'	=> 45,
	) );
	// Move core header image customization under theme header settings
	$wp_customize->get_section( 'header_image' )->panel = 'darko_header_settings';

    // Panel: Content settings
    $wp_customize->add_panel( 'darko_content_settings', array(
        'title'     => __( 'Content Settings', 'darko' ),
        'priority'  => 50,
    ) );

    // Add selective refresh
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
    $wp_customize->get_setting( 'custom_logo' )->transport = 'postMessage';

    $wp_customize->selective_refresh->add_partial( 'blogname', array(
        'selector'          => '.navbar-brand p',
        'render_callback'   => function() {
            return get_bloginfo( 'name' );
        },
    ) );
    $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
        'selector'          => '.home.blog .hero .hero-title',
        'render_callback'   => function() {
            return get_bloginfo( 'description' );
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
    $wp_customize->selective_refresh->add_partial( 'darko_copyright', array(
        'selector'          => '.copyright p',
        'render_callback'   => function() {
            $copyright = get_theme_mod( 'darko_copyright', '© Copyright - ' . get_bloginfo( 'name' ) );

            return $copyright;
        },
    ) );
}
add_action( 'customize_register', 'darko_customize_register' );

/**
 * Load customize preview JS file
 */
function darko_customize_preview_init() {
    wp_enqueue_script( 'darko-customize-preview', DARKO_JS_URI . 'customize-preview.js', array( 'customize-preview' ), false, true );
    wp_enqueue_script( 'darko-customize-typography-preview', DARKO_JS_URI . 'customize-typography-preview.js', array( 'customize-preview' ), false, true );
}
add_action( 'customize_preview_init', 'darko_customize_preview_init' );

/**
 * Load customize control context JS file
 */
function darko_customize_controls_context_init() {
    wp_enqueue_style( 'darko-customize-style', DARKO_CSS_URI . 'customize-styles.css' );
    wp_enqueue_script( 'darko-customize-context', DARKO_JS_URI . 'customize-context.js', array( 'customize-controls' ), false, true );
}
add_action( 'customize_controls_enqueue_scripts', 'darko_customize_controls_context_init' );

if ( ! function_exists( 'darko_sanitize_checkbox' ) ) {
	/**
	 * Sanitize checkbox input
	 *
	 * @param $input
	 * @return bool
	 */
	function darko_sanitize_checkbox( $input ) {
		return ( isset( $input ) && $input === true ? true : false );
	}
}

if ( ! function_exists( 'darko_sanitize_float' ) ) {
    /**
     * Sanitize float number
     *
     * @param $input
     * @return float|bool Returns sanitized float or false
     */
    function darko_sanitize_float( $input ) {
        return filter_var( $input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
    }
}