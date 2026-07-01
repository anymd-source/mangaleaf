<?php
/**
 * MangaLeaf Theme - Diagnostic Script
 *
 * Run this to diagnose common theme issues
 *
 * @package MangaLeaf
 * @since 2.2.0
 */

// Prevent direct access via web browser for security
if ( ! function_exists( 'wp_get_environment_type' ) ) {
	exit( 'This file cannot be accessed directly.' );
}

// Only run in admin or development
if ( 'production' === wp_get_environment_type() && ! current_user_can( 'manage_options' ) ) {
	exit( 'Access denied.' );
}

/**
 * MangaLeaf Theme Diagnostics
 */
class MangaLeaf_Diagnostics {

	/**
	 * Run all diagnostics
	 *
	 * @return array Diagnostics results
	 */
	public static function run(): array {
		return array(
			'php_version'     => self::check_php_version(),
			'php_extensions'  => self::check_php_extensions(),
			'wordpress_version' => self::check_wordpress_version(),
			'theme_files'     => self::check_theme_files(),
			'file_permissions' => self::check_file_permissions(),
			'memory_limit'    => self::check_memory_limit(),
			'error_log'       => self::get_recent_errors(),
		);
	}

	/**
	 * Check PHP version
	 *
	 * @return array
	 */
	private static function check_php_version(): array {
		$version      = phpversion();
		$required     = '5.9';
		$recommended  = '8.1';
		$status       = 'ok';
		$message      = '';

		if ( version_compare( $version, $required, '<' ) ) {
			$status  = 'error';
			$message = "PHP version {$version} is below required {$required}";
		} elseif ( version_compare( $version, $recommended, '<' ) ) {
			$status  = 'warning';
			$message = "PHP version {$version} is below recommended {$recommended}";
		} else {
			$message = "PHP version {$version} is compatible";
		}

		return array(
			'version' => $version,
			'status'  => $status,
			'message' => $message,
		);
	}

	/**
	 * Check PHP extensions
	 *
	 * @return array
	 */
	private static function check_php_extensions(): array {
		$required = array(
			'curl'     => 'cURL',
			'fileinfo' => 'fileinfo',
		);

		$optional = array(
			'ioncube' => 'ionCube Loader',
		);

		$results = array(
			'required' => array(),
			'optional' => array(),
		);

		foreach ( $required as $ext => $name ) {
			$loaded = extension_loaded( $ext );
			$results['required'][ $name ] = array(
				'status'  => $loaded ? 'ok' : 'error',
				'message' => $loaded ? "✓ {$name} is loaded" : "✗ {$name} is NOT loaded",
			);
		}

		foreach ( $optional as $ext => $name ) {
			$loaded = extension_loaded( $ext );
			$results['optional'][ $name ] = array(
				'status'  => $loaded ? 'ok' : 'warning',
				'message' => $loaded ? "✓ {$name} is loaded" : "⚠ {$name} is NOT loaded (optional)",
			);
		}

		return $results;
	}

	/**
	 * Check WordPress version
	 *
	 * @return array
	 */
	private static function check_wordpress_version(): array {
		global $wp_version;
		$required = '5.9';
		$status   = version_compare( $wp_version, $required, '>=' ) ? 'ok' : 'error';

		return array(
			'version' => $wp_version,
			'required' => $required,
			'status'  => $status,
			'message' => $status === 'ok'
				? "WordPress {$wp_version} is compatible"
				: "WordPress {$wp_version} is below required {$required}",
		);
	}

	/**
	 * Check theme files
	 *
	 * @return array
	 */
	private static function check_theme_files(): array {
		$template_dir = get_template_directory();
		$required_files = array(
			'style.css',
			'functions.php',
			'index.php',
			'header.php',
			'footer.php',
		);

		$optional_files = array(
			'inc/core.php',
			'inc/hook.php',
			'inc/php81-deprecated-fixes.php',
		);

		$results = array(
			'required' => array(),
			'optional' => array(),
		);

		foreach ( $required_files as $file ) {
			$path = $template_dir . '/' . $file;
			$exists = file_exists( $path );
			$results['required'][ $file ] = array(
				'status'  => $exists ? 'ok' : 'error',
				'message' => $exists ? "✓ {$file} exists" : "✗ {$file} is MISSING",
				'readable' => $exists ? is_readable( $path ) : false,
			);
		}

		foreach ( $optional_files as $file ) {
			$path = $template_dir . '/' . $file;
			$exists = file_exists( $path );
			$results['optional'][ $file ] = array(
				'status'  => $exists ? 'ok' : 'warning',
				'message' => $exists ? "✓ {$file} exists" : "⚠ {$file} not found",
				'readable' => $exists ? is_readable( $path ) : false,
			);
		}

		return $results;
	}

	/**
	 * Check file permissions
	 *
	 * @return array
	 */
	private static function check_file_permissions(): array {
		$template_dir = get_template_directory();

		return array(
			'template_dir'    => $template_dir,
			'is_writable'     => is_writable( $template_dir ),
			'is_readable'     => is_readable( $template_dir ),
			'permissions'     => substr( sprintf( '%o', fileperms( $template_dir ) ), -4 ),
		);
	}

	/**
	 * Check memory limit
	 *
	 * @return array
	 */
	private static function check_memory_limit(): array {
		$limit = WP_MEMORY_LIMIT;
		$usage = memory_get_usage( true );
		$percentage = round( ( $usage / wp_convert_hr_to_bytes( $limit ) ) * 100 );

		return array(
			'limit'      => $limit,
			'usage'      => size_format( $usage ),
			'percentage' => $percentage . '%',
			'status'     => $percentage > 80 ? 'warning' : 'ok',
		);
	}

	/**
	 * Get recent errors from debug.log
	 *
	 * @return array
	 */
	private static function get_recent_errors(): array {
		$debug_log = WP_CONTENT_DIR . '/debug.log';

		if ( ! file_exists( $debug_log ) ) {
			return array(
				'status'  => 'info',
				'message' => 'No debug.log file found. Enable WP_DEBUG_LOG to track errors.',
			);
		}

		if ( ! is_readable( $debug_log ) ) {
			return array(
				'status'  => 'error',
				'message' => 'debug.log exists but is not readable',
			);
		}

		$lines = file( $debug_log );
		$recent = array_slice( $lines, -20 ); // Get last 20 lines

		return array(
			'file'   => $debug_log,
			'total_lines' => count( $lines ),
			'recent_errors' => $recent,
		);
	}
}

// Output diagnostics as JSON if requested
if ( isset( $_GET['mangaleaf_diagnostics'] ) && current_user_can( 'manage_options' ) ) {
	header( 'Content-Type: application/json' );
	echo wp_json_encode( MangaLeaf_Diagnostics::run(), JSON_PRETTY_PRINT );
	exit;
}
