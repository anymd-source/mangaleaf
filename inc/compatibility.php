<?php
/**
 * PHP 8.1-8.4 Compatibility Layer
 * 
 * This file provides compatibility functions and utilities for PHP 8.1+ features.
 * 
 * @package MangaLeaf
 * @since 2.1.1
 */

defined( 'ABSPATH' ) || die( '!' );

/**
 * Check if required PHP extensions are loaded
 * 
 * @return array Array of extension status checks
 */
function mangaleaf_check_php_extensions(): array {
	return [
		'ioncube'   => extension_loaded( 'ionCube Loader' ),
		'curl'      => extension_loaded( 'curl' ),
		'fileinfo'  => extension_loaded( 'fileinfo' ),
		'json'      => extension_loaded( 'json' ),
		'mbstring'  => extension_loaded( 'mbstring' ),
	];
}

/**
 * Get the current PHP version details
 * 
 * @return object PHP version information
 */
function mangaleaf_get_php_info(): object {
	return (object) [
		'version'       => PHP_VERSION,
		'version_id'    => PHP_VERSION_ID,
		'sapi'          => PHP_SAPI,
		'os'            => PHP_OS,
		'extensions'    => get_loaded_extensions(),
		'memory_limit'  => ini_get( 'memory_limit' ),
		'max_upload'    => ini_get( 'upload_max_filesize' ),
		'post_max'      => ini_get( 'post_max_size' ),
	];
}

/**
 * Verify that required extensions are loaded
 * 
 * @throws RuntimeException If required extension is not loaded
 * 
 * @return bool True if all required extensions are loaded
 */
function mangaleaf_verify_requirements(): bool {
	$extensions = mangaleaf_check_php_extensions();
	
	$required = [ 'curl', 'fileinfo' ];
	
	foreach ( $required as $ext ) {
		if ( ! $extensions[ $ext ] ) {
			throw new RuntimeException(
				sprintf(
					'Required PHP extension "%s" is not loaded.',
					$ext
				)
			);
		}
	}
	
	return true;
}

/**
 * Type-safe string handling for PHP 8.1+
 * 
 * @param mixed  $value The value to convert to string
 * @param bool   $strict Enable strict type checking
 * 
 * @return string The string value
 */
function mangaleaf_to_string( mixed $value, bool $strict = false ): string {
	if ( is_string( $value ) ) {
		return $value;
	}
	
	if ( $strict && ! is_scalar( $value ) ) {
		throw new TypeError(
			sprintf(
				'Expected string, got %s',
				gettype( $value )
			)
		);
	}
	
	return (string) $value;
}

/**
 * Type-safe integer handling for PHP 8.1+
 * 
 * @param mixed  $value The value to convert to integer
 * @param bool   $strict Enable strict type checking
 * 
 * @return int The integer value
 */
function mangaleaf_to_int( mixed $value, bool $strict = false ): int {
	if ( is_int( $value ) ) {
		return $value;
	}
	
	if ( $strict && ! is_numeric( $value ) ) {
		throw new TypeError(
			sprintf(
				'Expected numeric value, got %s',
				gettype( $value )
			)
		);
	}
	
	return (int) $value;
}

/**
 * Safe array access using match expression (PHP 8.0+ feature)
 * 
 * @param array  $array The array to access
 * @param string $key The key to access
 * @param mixed  $default The default value if key doesn't exist
 * 
 * @return mixed The value or default
 */
function mangaleaf_array_get( array $array, string $key, mixed $default = null ): mixed {
	return $array[ $key ] ?? $default;
}

/**
 * Safe array merge with type safety
 * 
 * @param array ...$arrays Arrays to merge
 * 
 * @return array The merged array
 */
function mangaleaf_array_merge( array ...$arrays ): array {
	$result = [];
	
	foreach ( $arrays as $array ) {
		if ( is_array( $array ) ) {
			$result = array_merge( $result, $array );
		}
	}
	
	return $result;
}

/**
 * Named parameters helper for function calls
 * 
 * Useful for WordPress compatibility with PHP 8.0+ named arguments
 * 
 * @param callable $callback The function/method to call
 * @param array    $args Named arguments
 * 
 * @return mixed The function result
 */
function mangaleaf_call_with_named_args( callable $callback, array $args ): mixed {
	return call_user_func_array( $callback, $args );
}

/**
 * Version check utility
 * 
 * @param string $version Version string to check (e.g., "8.1.0")
 * @param string $operator Comparison operator (>=, >, <=, <, ==, !=)
 * 
 * @return bool True if version check passes
 */
function mangaleaf_php_version_check( string $version, string $operator = '>=' ): bool {
	return version_compare( PHP_VERSION, $version, $operator );
}

/**
 * Get PHP version as comparable integer
 * 
 * Example: PHP 8.1.5 returns 80105
 * 
 * @return int The PHP version as integer
 */
function mangaleaf_get_php_version_id(): int {
	return PHP_VERSION_ID;
}

/**
 * Check if running on specific PHP version range
 * 
 * @param string $min_version Minimum version (inclusive)
 * @param string $max_version Maximum version (inclusive), null for no upper limit
 * 
 * @return bool True if within version range
 */
function mangaleaf_php_version_in_range( string $min_version, ?string $max_version = null ): bool {
	$check = version_compare( PHP_VERSION, $min_version, '>=' );
	
	if ( $check && $max_version !== null ) {
		$check = version_compare( PHP_VERSION, $max_version, '<=' );
	}
	
	return $check;
}

// Initialize compatibility checks on plugin load
add_action(
	'plugins_loaded',
	static function (): void {
		try {
			mangaleaf_verify_requirements();
		} catch ( RuntimeException $e ) {
			wp_die(
				esc_html( $e->getMessage() ),
				'MangaLeaf Theme - Missing Requirements'
			);
		}
	},
	5
);
