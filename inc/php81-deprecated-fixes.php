<?php
/**
 * MangaLeaf Theme - PHP 8.1+ Compatibility Fixes
 *
 * Handles deprecated function calls and syntax for PHP 8.1+
 *
 * @package MangaLeaf
 * @since 2.2.0
 */

// Prevent direct access
defined( 'ABSPATH' ) || exit( 'Direct access denied!' );

/**
 * Polyfill for deprecated PHP functions
 *
 * @return void
 */
function mangaleaf_php81_compatibility(): void {
	// Check PHP version
	if ( version_compare( phpversion(), '8.1', '<' ) ) {
		return; // No compatibility fixes needed for older PHP
	}

	// Handle any deprecated function calls here
	if ( ! function_exists( 'mysql_real_escape_string' ) ) {
		function mysql_real_escape_string( $unescaped_string ) {
			return addslashes( $unescaped_string );
		}
	}

	if ( ! function_exists( 'split' ) ) {
		function split( $pattern, $string, $limit = -1 ) {
			return preg_split( '/' . preg_quote( $pattern, '/' ) . '/', $string, $limit );
		}
	}
}

// Run compatibility checks
mangaleaf_php81_compatibility();

/**
 * Ensure ioncube loader is available
 *
 * @return bool
 */
function mangaleaf_check_ioncube(): bool {
	if ( extension_loaded( 'ionCube Loader' ) ) {
		return true;
	}

	// Log if ioncube is missing (non-critical warning)
	if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
		error_log( '[MangaLeaf] ioncube Loader extension not found (optional)' );
	}

	return false;
}

/**
 * Check all required PHP extensions at startup
 *
 * @return array Array of missing extensions
 */
function mangaleaf_get_missing_extensions(): array {
	$required = array(
		'curl'     => 'cURL',
		'fileinfo' => 'fileinfo',
	);

	$optional = array(
		'ioncube' => 'ionCube Loader',
	);

	$missing = array();

	// Check required extensions
	foreach ( $required as $ext => $name ) {
		if ( ! extension_loaded( $ext ) ) {
			$missing['required'][] = $name;
		}
	}

	// Check optional extensions
	foreach ( $optional as $ext => $name ) {
		if ( ! extension_loaded( $ext ) ) {
			$missing['optional'][] = $name;
		}
	}

	return $missing;
}

/**
 * Render admin notice for missing extensions
 *
 * @return void
 */
function mangaleaf_show_extension_notice(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$missing = mangaleaf_get_missing_extensions();

	if ( empty( $missing['required'] ) && empty( $missing['optional'] ) ) {
		return;
	}

	$message = '<strong>' . esc_html__( 'MangaLeaf Theme Requirements:', 'mangaleaf' ) . '</strong><br>';

	if ( ! empty( $missing['required'] ) ) {
		$message .= '<span style="color: #d63638;">' . esc_html__( 'REQUIRED - Missing extensions:', 'mangaleaf' ) . ' ' . esc_html( implode( ', ', $missing['required'] ) ) . '</span><br>';
	}

	if ( ! empty( $missing['optional'] ) ) {
		$message .= '<span style="color: #7c3726;">' . esc_html__( 'OPTIONAL - Missing extensions:', 'mangaleaf' ) . ' ' . esc_html( implode( ', ', $missing['optional'] ) ) . '</span>';
	}

	?>
	<div class="notice notice-warning is-dismissible">
		<p><?php echo wp_kses_post( $message ); ?></p>
	</div>
	<?php
}

add_action( 'admin_notices', 'mangaleaf_show_extension_notice' );

/**
 * Display PHP version compatibility notice
 *
 * @return void
 */
function mangaleaf_show_php_version_notice(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$php_version = phpversion();
	$required_version = '5.9';
	$recommended_version = '8.1';

	if ( version_compare( $php_version, $required_version, '<' ) ) {
		?>
		<div class="notice notice-error is-dismissible">
			<p>
				<strong><?php esc_html_e( 'MangaLeaf Theme Warning:', 'mangaleaf' ); ?></strong><br>
				<?php
				each_html(
					sprintf(
						'Your PHP version (%s) is below the minimum required version (%s). Please upgrade your PHP version immediately.',
						$php_version,
						$required_version
					)
				);
				?>
			</p>
		</div>
		<?php
	} elseif ( version_compare( $php_version, $recommended_version, '<' ) ) {
		?>
		<div class="notice notice-warning is-dismissible">
			<p>
				<strong><?php esc_html_e( 'MangaLeaf Theme Notice:', 'mangaleaf' ); ?></strong><br>
				<?php
				each_html(
					sprintf(
						'Your PHP version (%s) works but is not optimal. Recommended version is %s or higher for best performance and security.',
						$php_version,
						$recommended_version
					)
				);
				?>
			</p>
		</div>
		<?php
	}
}

add_action( 'admin_notices', 'mangaleaf_show_php_version_notice' );

/**
 * Helper to safely use typed properties (PHP 7.4+)
 *
 * @param object $object Object instance.
 * @param string $property Property name.
 * @param mixed  $default Default value if not set.
 * @return mixed Property value or default
 */
function mangaleaf_get_object_property( object $object, string $property, $default = null ) {
	try {
		return $object->$property ?? $default;
	} catch ( Exception $e ) {
		return $default;
	}
}

/**
 * Safe array key access with type coercion
 *
 * @param array  $array Array to access.
 * @param string $key Key to retrieve.
 * @param mixed  $default Default value.
 * @param string $type Expected type (string, int, bool, array).
 * @return mixed
 */
function mangaleaf_array_get( array $array, string $key, $default = null, string $type = 'string' ) {
	if ( ! isset( $array[ $key ] ) ) {
		return $default;
	}

	$value = $array[ $key ];

	switch ( $type ) {
		case 'int':
			return (int) $value;
		case 'bool':
			return (bool) $value;
		case 'array':
			return (array) $value;
		default:
			return (string) $value;
	}
}
