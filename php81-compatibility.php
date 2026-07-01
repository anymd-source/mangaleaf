<?php
/**
 * MangaLeaf Theme - PHP 8.1+ Compatibility Fixes
 *
 * Handles deprecated features and ensures compatibility with PHP 8.1 through 8.4
 *
 * @package MangaLeaf
 * @since 2.2.0
 */

/**
 * Suppress deprecation warnings for deprecated features in PHP 8.1+
 * This is a temporary measure while the theme is updated
 */
if ( PHP_VERSION_ID >= 80100 ) {
	error_reporting( E_ALL & ~E_DEPRECATED & ~E_STRICT );
}

/**
 * Polyfill for str_contains (PHP 8.0+)
 */
if ( ! function_exists( 'str_contains' ) ) {
	/**
	 * Determine if a string contains a given substring
	 *
	 * @param string $haystack The string to search in.
	 * @param string $needle The string to search for.
	 * @return bool
	 */
	function str_contains( $haystack, $needle ) {
		return '' === $needle || false !== strpos( $haystack, $needle );
	}
}

/**
 * Polyfill for str_starts_with (PHP 8.0+)
 */
if ( ! function_exists( 'str_starts_with' ) ) {
	/**
	 * Determine if a string starts with a given substring
	 *
	 * @param string $haystack The string to search in.
	 * @param string $needle The string to search for.
	 * @return bool
	 */
	function str_starts_with( $haystack, $needle ) {
		return 0 === strpos( $haystack, $needle );
	}
}

/**
 * Polyfill for str_ends_with (PHP 8.0+)
 */
if ( ! function_exists( 'str_ends_with' ) ) {
	/**
	 * Determine if a string ends with a given substring
	 *
	 * @param string $haystack The string to search in.
	 * @param string $needle The string to search for.
	 * @return bool
	 */
	function str_ends_with( $haystack, $needle ) {
		return '' === $needle || $needle === substr( $haystack, -strlen( $needle ) );
	}
}

/**
 * Replace deprecated split() function (removed in PHP 8.0)
 * with explode() which is the modern equivalent
 */
if ( ! function_exists( 'mangaleaf_split' ) ) {
	/**
	 * Split a string using a regular expression pattern
	 * Replacement for the deprecated split() function
	 *
	 * @param string $pattern The regex pattern to split on.
	 * @param string $string The string to split.
	 * @param int    $limit Optional. Maximum number of elements.
	 * @return array
	 */
	function mangaleaf_split( $pattern, $string, $limit = -1 ) {
		return preg_split( $pattern, $string, $limit );
	}
}

/**
 * Handle create_function deprecation (removed in PHP 8.0)
 * This should be replaced with anonymous functions
 */
if ( ! function_exists( 'mangaleaf_create_function' ) ) {
	/**
	 * Creates anonymous function replacement for deprecated create_function()
	 * Note: This is a polyfill. Prefer actual anonymous functions.
	 *
	 * @param string $args Function arguments.
	 * @param string $code Function body code.
	 * @return callable
	 * @deprecated Use anonymous functions instead
	 */
	function mangaleaf_create_function( $args, $code ) {
		return function( ...$argv ) use ( $args, $code ) {
			// Simple replacement - should be refactored to use actual closures
			return eval( "return function( $args ) { $code };" );
		};
	}
}

/**
 * Fix for implode() parameter order (weak in PHP 8.0+)
 * PHP 8.0 deprecated implode($array, $glue) in favor of implode($glue, $array)
 */
if ( ! function_exists( 'mangaleaf_implode' ) ) {
	/**
	 * Backward-compatible implode function
	 *
	 * @param string|array $glue The glue string or array to implode.
	 * @param array        $pieces Optional. The pieces to join. Default null.
	 * @return string
	 */
	function mangaleaf_implode( $glue, $pieces = null ) {
		if ( is_array( $glue ) && is_null( $pieces ) ) {
			// Old style: implode( $array )
			return implode( $glue );
		} elseif ( is_array( $pieces ) ) {
			// New style: implode( $glue, $array )
			return implode( $glue, $pieces );
		}
		return '';
	}
}

/**
 * Deprecated functions that should be replaced
 *
 * @see https://www.php.net/manual/en/migration80.deprecated.php
 * @see https://www.php.net/manual/en/migration81.deprecated.php
 */

/**
 * Log when deprecated functions are being used
 */
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
	/**
	 * Monitor for use of ereg (removed in PHP 5.3.0, alternatives in preg_match)
	 * This is already removed but check for calls anyway
	 */
	if ( function_exists( 'ereg' ) ) {
		// ereg was already removed, but theme might have compatibility code
		trigger_error(
			'ereg() function found - use preg_match() instead',
			E_USER_DEPRECATED
		);
	}
}

// PHP 8.1+ Specific Compatibility
if ( PHP_VERSION_ID >= 80100 ) {
	/**
	 * Handle readonly properties (new in PHP 8.1)
	 * Ensure proper type juggling in older code
	 */
	if ( ! function_exists( 'mangaleaf_get_readonly_property' ) ) {
		/**
		 * Safely access readonly properties
		 *
		 * @param object $obj The object.
		 * @param string $prop The property name.
		 * @return mixed
		 */
		function mangaleaf_get_readonly_property( $obj, $prop ) {
			if ( property_exists( $obj, $prop ) ) {
				return $obj->$prop;
			}
			return null;
		}
	}
}

// PHP 8.2+ Specific Compatibility
if ( PHP_VERSION_ID >= 80200 ) {
	/**
	 * Handle Disjunctive Normal Form (DNF) types
	 * Ensure compatibility with strict typing
	 */
	if ( ! function_exists( 'mangaleaf_validate_type' ) ) {
		/**
		 * Validate value against expected types
		 *
		 * @param mixed  $value The value to check.
		 * @param array  $types Allowed types.
		 * @return bool
		 */
		function mangaleaf_validate_type( $value, $types ) {
			foreach ( $types as $type ) {
				$type = strtolower( $type );
				switch ( $type ) {
					case 'string':
						if ( is_string( $value ) ) {
							return true;
						}
						break;
					case 'int':
					case 'integer':
						if ( is_int( $value ) ) {
							return true;
						}
						break;
					case 'float':
						if ( is_float( $value ) ) {
							return true;
						}
						break;
					case 'bool':
					case 'boolean':
						if ( is_bool( $value ) ) {
							return true;
						}
						break;
					case 'array':
						if ( is_array( $value ) ) {
							return true;
						}
						break;
					case 'object':
						if ( is_object( $value ) ) {
							return true;
						}
						break;
					case 'null':
						if ( is_null( $value ) ) {
							return true;
						}
						break;
				}
			}
			return false;
		}
	}
}

// PHP 8.3+ Specific Compatibility
if ( PHP_VERSION_ID >= 80300 ) {
	/**
	 * json_encode now accepts flags as second parameter (was third in earlier versions)
	 * Handle both old and new calling conventions
	 */
	if ( ! function_exists( 'mangaleaf_json_encode' ) ) {
		/**
		 * Backward-compatible JSON encoding
		 *
		 * @param mixed $value The value to encode.
		 * @param int   $flags Optional. Flags for json_encode.
		 * @param int   $depth Optional. Max depth.
		 * @return string|false
		 */
		function mangaleaf_json_encode( $value, $flags = JSON_UNESCAPED_SLASHES, $depth = 512 ) {
			return json_encode( $value, $flags, $depth );
		}
	}
}

/**
 * Log successful loading of compatibility layer
 */
if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
	error_log( 'MangaLeaf PHP 8.1+ Compatibility Layer loaded' );
}
