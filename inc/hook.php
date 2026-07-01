<?php
/**
 * MangaLeaf Theme - Theme Hooks
 *
 * Custom hooks and filters for theme functionality
 *
 * @package MangaLeaf
 * @since 2.2.0
 */

// Prevent direct access
defined( 'ABSPATH' ) || exit( 'Direct access denied!' );

/**
 * Hook: mangaleaf_before_header
 * Fires before the header template part
 *
 * @since 2.2.0
 */
do_action( 'mangaleaf_before_header' );

/**
 * Hook: mangaleaf_after_header
 * Fires after the header template part
 *
 * @since 2.2.0
 */
do_action( 'mangaleaf_after_header' );

/**
 * Hook: mangaleaf_before_content
 * Fires before the main content area
 *
 * @since 2.2.0
 */
do_action( 'mangaleaf_before_content' );

/**
 * Hook: mangaleaf_after_content
 * Fires after the main content area
 *
 * @since 2.2.0
 */
do_action( 'mangaleaf_after_content' );

/**
 * Hook: mangaleaf_before_footer
 * Fires before the footer template part
 *
 * @since 2.2.0
 */
do_action( 'mangaleaf_before_footer' );

/**
 * Hook: mangaleaf_after_footer
 * Fires after the footer template part
 *
 * @since 2.2.0
 */
do_action( 'mangaleaf_after_footer' );

/**
 * Add custom body classes
 *
 * @param array $classes Body classes.
 * @return array Modified classes
 */
function mangaleaf_body_classes( array $classes ): array {
	// Add PHP version class
	$php_version = str_replace( '.', '-', phpversion() );
	$classes[]   = 'php-' . $php_version;

	// Add theme version class
	$theme_version = str_replace( '.', '-', wp_get_theme()->get( 'Version' ) );
	$classes[]     = 'theme-' . $theme_version;

	// Add light/dark mode detection if set
	$light_mode = mangaleaf_get_theme_mod( 'light_mode', false );
	if ( $light_mode ) {
		$classes[] = 'lightmode';
	}

	return $classes;
}

add_filter( 'body_class', 'mangaleaf_body_classes' );

/**
 * Remove WordPress version from head (security)
 *
 * @return void
 */
function mangaleaf_remove_wp_version(): void {
	remove_action( 'wp_head', 'wp_generator' );
}

add_action( 'wp_head', 'mangaleaf_remove_wp_version' );

/**
 * Add custom post class
 *
 * @param array $classes Post classes.
 * @return array Modified classes
 */
function mangaleaf_post_class( array $classes ): array {
	$classes[] = 'mangaleaf-post';

	if ( has_post_thumbnail() ) {
		$classes[] = 'has-thumbnail';
	}

	return $classes;
}

add_filter( 'post_class', 'mangaleaf_post_class' );

/**
 * Custom excerpt more text
 *
 * @param string $more Original more text.
 * @return string Modified more text
 */
function mangaleaf_excerpt_more( string $more ): string {
	return ' <a href="' . esc_url( get_permalink() ) . '" class="read-more">' . esc_html__( 'Read More', 'mangaleaf' ) . '</a>';
}

add_filter( 'excerpt_more', 'mangaleaf_excerpt_more' );

/**
 * Set default excerpt length
 *
 * @param int $length Original length.
 * @return int Modified length
 */
function mangaleaf_excerpt_length( int $length ): int {
	return 30;
}

add_filter( 'excerpt_length', 'mangaleaf_excerpt_length' );

/**
 * Sanitize comment class
 *
 * @param array $classes Comment classes.
 * @return array Sanitized classes
 */
function mangaleaf_comment_class( array $classes ): array {
	return array_map( 'sanitize_html_class', $classes );
}

add_filter( 'comment_class', 'mangaleaf_comment_class' );

/**
 * Add custom gallery shortcode
 *
 * @return void
 */
function mangaleaf_register_gallery_shortcode(): void {
	add_shortcode( 'mangaleaf_gallery', function( $atts ) {
		$atts = shortcode_atts(
			array(
				'ids'      => '',
				'columns'  => 3,
				'orderby'  => 'post__in',
			),
			$atts
		);

		if ( empty( $atts['ids'] ) ) {
			return '';
		}

		$ids = explode( ',', $atts['ids'] );
		$ids = array_map( 'intval', $ids );

		$args = array(
			'post__in'       => $ids,
			'posts_per_page' => -1,
			'orderby'        => $atts['orderby'],
			'post_type'      => 'attachment',
		);

		$query = new WP_Query( $args );

		if ( ! $query->have_posts() ) {
			return '';
		}

		$output = '<div class="mangaleaf-gallery" data-columns="' . absint( $atts['columns'] ) . '">';

		while ( $query->have_posts() ) {
			$query->the_post();
			$image_url = wp_get_attachment_image_src( get_the_ID(), 'medium' )[0];
			$output   .= '<div class="gallery-item"><img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( get_the_title() ) . '"></div>';
		}

		$output .= '</div>';

		wp_reset_postdata();

		return $output;
	} );
}

add_action( 'init', 'mangaleaf_register_gallery_shortcode' );

/**
 * Disable XML-RPC for security (optional)
 *
 * @return void
 */
function mangaleaf_disable_xmlrpc(): void {
	add_filter( 'xmlrpc_enabled', '__return_false' );
}

add_action( 'init', 'mangaleaf_disable_xmlrpc' );
