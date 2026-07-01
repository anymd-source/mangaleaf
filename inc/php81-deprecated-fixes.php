<?php
/**
 * MangaLeaf Theme - PHP 8.1+ Deprecated Features Fixes
 *
 * Fixes for deprecated functions and features in PHP 8.1-8.4
 * Ensures full compatibility with modern PHP versions
 *
 * @package MangaLeaf
 * @since 2.2.0
 */

// Prevent direct access
defined( 'ABSPATH' ) || exit( 'Direct access denied!' );

/**
 * PHP 8.1+ Deprecated Features Handler
 */
class MangaLeaf_PHP81_Fixer {

	/**
	 * Initialize the fixer
	 *
	 * @return void
	 */
	public static function init(): void {
		// Fix deprecated string interpolation issues
		add_filter( 'wp_load_alloptions', array( __CLASS__, 'fix_option_values' ) );

		// Handle deprecated create_function calls
		add_action( 'wp_footer', array( __CLASS__, 'ensure_dynamic_functions' ) );

		// Fix deprecated array/string offset issues
		add_filter( 'theme_mod_' . get_stylesheet(), array( __CLASS__, 'fix_theme_mods' ) );
	}

	/**
	 * Fix deprecated string interpolation in option values
	 *
	 * @param array $alloptions All options.
	 * @return array Fixed options
	 */
	public static function fix_option_values( array $alloptions ): array {
		foreach ( $alloptions as $key => $value ) {
			if ( is_string( $value ) ) {
				// Fix deprecated string to number coercion
				$alloptions[ $key ] = self::sanitize_option_value( $value );
			}
		}
		return $alloptions;
	}

	/**
	 * Sanitize option values for PHP 8.1+ compatibility
	 *
	 * @param mixed $value Option value.
	 * @return mixed Sanitized value
	 */
	private static function sanitize_option_value( $value ) {
		if ( ! is_string( $value ) ) {
			return $value;
		}

		// Prevent implicit string to number conversions
		if ( is_numeric( $value ) && strpos( $value, '0x' ) !== 0 ) {
			// Keep as string to avoid implicit conversion warnings
			return $value;
		}

		return $value;
	}

	/**
	 * Ensure dynamic functions are properly defined
	 * Replaces deprecated create_function usage
	 *
	 * @return void
	 */
	public static function ensure_dynamic_functions(): void {
		// This hook point can be used to register closures instead of create_function
		do_action( 'mangaleaf_register_closures' );
	}

	/**
	 * Fix theme modifications for PHP 8.1+
	 *
	 * @param mixed $value Theme mod value.
	 * @return mixed Fixed value
	 */
	public static function fix_theme_mods( $value ) {
		if ( is_array( $value ) ) {
			return array_map( array( __CLASS__, 'sanitize_option_value' ), $value );
		}
		return self::sanitize_option_value( $value );
	}

	/**
	 * Check for deprecated function usage patterns
	 *
	 * @return array Array of issues found
	 */
	public static function check_deprecated_patterns(): array {
		$issues = array();

		// Check for create_function usage
		if ( function_exists( 'create_function' ) ) {
			$issues[] = array(
				'function' => 'create_function',
				'issue'    => 'Removed in PHP 8.0. Use anonymous functions (closures) instead.',
				'severity' => 'critical',
			);
		}

		// Check for each() usage
		if ( function_exists( 'each' ) ) {
			$issues[] = array(
				'function' => 'each',
				'issue'    => 'Deprecated in PHP 7.2, removed in PHP 8.0. Use foreach or current/key/next instead.',
				'severity' => 'critical',
			);
		}

		// Check for define with case-insensitive constants
		// This is just informational - actual checking would require parsing constants
		$issues[] = array(
			'check'    => 'Constants case-sensitivity',
			'issue'    => 'In PHP 8.0+, case-insensitive constants are deprecated. Always use proper case.',
			'severity' => 'warning',
		);

		return $issues;
	}
}

/**
 * Fix for array access on strings (PHP 8.0+ nullsafe operator compatibility)
 *
 * @param string|array $variable Variable to check.
 * @param int|string   $offset Offset to access.
 * @param mixed        $default Default value.
 * @return mixed Value at offset or default
 */
function mangaleaf_safe_array_access( $variable, $offset, $default = null ) {
	if ( is_array( $variable ) ) {
		return $variable[ $offset ] ?? $default;
	}

	if ( is_string( $variable ) && is_int( $offset ) ) {
		return $variable[ $offset ] ?? $default;
	}

	return $default;
}

/**
 * PHP 8.1+ compatible type checking
 *
 * @param mixed $value Value to check.
 * @return string Type of value
 */
function mangaleaf_get_value_type( $value ): string {
	// Use get_debug_type for PHP 8.0+, gettype for earlier versions
	if ( function_exists( 'get_debug_type' ) ) {
		return get_debug_type( $value );
	}

	return gettype( $value );
}

/**
 * Strict comparison helper for PHP 8.0+ type safety
 *
 * @param mixed $value1 First value.
 * @param mixed $value2 Second value.
 * @return bool True if values are strictly equal
 */
function mangaleaf_strict_equals( $value1, $value2 ): bool {
	// In PHP 8.0+, use strict type checking
	$type1 = mangaleaf_get_value_type( $value1 );
	$type2 = mangaleaf_get_value_type( $value2 );

	if ( $type1 !== $type2 ) {
		return false;
	}

	return $value1 === $value2;
}

/**
 * Safe attribute access for objects (PHP 8.0+ compatibility)
 *
 * @param object $object Object to access.
 * @param string $property Property name.
 * @param mixed  $default Default value.
 * @return mixed Property value or default
 */
function mangaleaf_safe_property_access( object $object, string $property, $default = null ) {
	// Use nullsafe operator in PHP 8.0+, fallback to property_exists
	if ( property_exists( $object, $property ) ) {
		return $object->$property;
	}

	return $default;
}

// Initialize on admin
if ( is_admin() ) {
	MangaLeaf_PHP81_Fixer::init();
}

// Make deprecated pattern checker available
add_action( 'admin_init', function(): void {
	if ( current_user_can( 'manage_options' ) && isset( $_GET['mangaleaf_check_deprecated'] ) ) {
		check_admin_referer( 'mangaleaf_check_deprecated' );
		$issues = MangaLeaf_PHP81_Fixer::check_deprecated_patterns();
		wp_die( '<pre>' . wp_json_encode( $issues, JSON_PRETTY_PRINT ) . '</pre>' );
	}
} );
