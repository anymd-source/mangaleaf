<?php
/**
 * MangaLeaf Theme - Core Functions
 *
 * Core theme initialization and setup
 *
 * @package MangaLeaf
 * @since 2.2.0
 */

// Prevent direct access
defined( 'ABSPATH' ) || exit( 'Direct access denied!' );

/**
 * Setup theme
 *
 * @return void
 */
function mangaleaf_setup_theme(): void {
	// Add support for title tag
	add_theme_support( 'title-tag' );

	// Add support for custom logo
	add_theme_support( 'custom-logo' );

	// Add support for post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add support for HTML5 markup
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	// Load textdomain
	load_theme_textdomain( 'mangaleaf', get_template_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'mangaleaf_setup_theme' );

/**
 * Enqueue theme styles and scripts
 *
 * @return void
 */
function mangaleaf_enqueue_assets(): void {
	$template_dir = get_template_directory_uri();

	// Enqueue main stylesheet
	wp_enqueue_style(
		'mangaleaf-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' ),
		'all'
	);

	// Enqueue font awesome if needed
	wp_enqueue_style(
		'font-awesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
		array(),
		'6.4.0',
		'all'
	);
}

add_action( 'wp_enqueue_scripts', 'mangaleaf_enqueue_assets' );

/**
 * Register sidebars
 *
 * @return void
 */
function mangaleaf_register_sidebars(): void {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Primary Sidebar', 'mangaleaf' ),
			'id'            => 'primary-sidebar',
			'description'   => esc_html__( 'Main sidebar area', 'mangaleaf' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}

add_action( 'widgets_init', 'mangaleaf_register_sidebars' );

/**
 * Safe get option with type casting
 *
 * @param string $option Option name.
 * @param mixed  $default Default value.
 * @param string $type Expected type.
 * @return mixed Option value
 */
function mangaleaf_get_option( string $option, $default = '', string $type = 'string' ) {
	$value = get_option( $option, $default );

	// Type casting for PHP 8.0+ compatibility
	switch ( $type ) {
		case 'int':
			return (int) $value;
		case 'bool':
			return (bool) $value;
		case 'float':
			return (float) $value;
		case 'array':
			return is_array( $value ) ? $value : array();
		default:
			return (string) $value;
	}
}

/**
 * Get theme mod with safety
 *
 * @param string $setting Setting name.
 * @param mixed  $default Default value.
 * @return mixed Setting value
 */
function mangaleaf_get_theme_mod( string $setting, $default = '' ) {
	try {
		return get_theme_mod( $setting, $default );
	} catch ( Exception $e ) {
		error_log( 'MangaLeaf Theme Mod Error: ' . $e->getMessage() );
		return $default;
	}
}

/**
 * Sanitize color value
 *
 * @param string $color Color value.
 * @return string Sanitized color
 */
function mangaleaf_sanitize_color( string $color ): string {
	$color = trim( $color, '#' );

	// Check if valid hex color
	if ( preg_match( '/^[a-f0-9]{6}$/i', $color ) ) {
		return '#' . $color;
	}

	return '#000000';
}

/**
 * Log theme errors for debugging
 *
 * @param string $message Error message.
 * @param string $level Log level (error, warning, info).
 * @return void
 */
function mangaleaf_log_error( string $message, string $level = 'error' ): void {
	if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
		error_log( sprintf( '[MangaLeaf %s] %s', strtoupper( $level ), $message ) );
	}
}

/**
 * Check if all required plugins are active
 *
 * @return bool True if all required extensions are loaded
 */
function mangaleaf_check_requirements(): bool {
	$required_extensions = array(
		'curl'     => 'cURL',
		'fileinfo' => 'fileinfo',
	);

	foreach ( $required_extensions as $ext => $name ) {
		if ( ! extension_loaded( $ext ) ) {
			mangaleaf_log_error(
				sprintf( 'Required extension "%s" is not loaded', $name ),
				'error'
			);
			return false;
		}
	}

	return true;
}

// Check requirements on init
add_action( 'init', function(): void {
	if ( ! mangaleaf_check_requirements() && current_user_can( 'manage_options' ) ) {
		add_action( 'admin_notices', function(): void {
			?>
			<div class="notice notice-error">
				<p><?php esc_html_e( 'MangaLeaf Theme: Required PHP extensions are missing. Please contact your hosting provider.', 'mangaleaf' ); ?></p>
			</div>
			<?php
		} );
	}
} );
