<?php
/**
 * MangaLeaf Theme Functions
 * 
 * PHP 8.1+ Compatible
 * WordPress 5.9+
 * 
 * @package MangaLeaf
 * @since 2.2.0
 */

// Prevent direct access
defined( 'ABSPATH' ) || exit( 'Direct access denied!' );

// Load compatibility layer
require_once get_template_directory() . '/inc/compatibility.php';

// Load core theme files
require_once get_template_directory() . '/inc/core.php';
require_once get_template_directory() . '/inc/hook.php';

// ============================================================================
// EXCERPT SECTION
// ============================================================================

/**
 * Filter excerpt ending
 * 
 * @param string $more The excerpt ending string
 * @return string Modified excerpt ending
 */
function new_excerpt_more( string $more ): string {
	return '...';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

/**
 * Set custom excerpt length
 * 
 * @param int $length The excerpt length in words
 * @return int Modified excerpt length
 */
function custom_excerpt_length( int $length ): int {
	return 30;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// ============================================================================
// WIDGET SECTION
// ============================================================================

/**
 * Register theme sidebars/widget areas
 * 
 * @return void
 */
function register_theme_sidebars(): void {
	if ( function_exists( 'register_sidebar' ) ) {
		register_sidebar( [
			'name'          => __( 'Sidebar Right', 'mangaleaf' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<div class="section">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="releases"><h3>',
			'after_title'   => '</h3></div>',
		] );
	}
}
add_action( 'widgets_init', 'register_theme_sidebars' );

// ============================================================================
// MENU SECTION
// ============================================================================

/**
 * Register theme menus
 * 
 * @return void
 */
function register_my_menus(): void {
	register_nav_menus( [
		'main'   => __( 'Main Menu', 'mangaleaf' ),
		'footer' => __( 'Footer Menu', 'mangaleaf' ),
	] );
}
add_action( 'init', 'register_my_menus' );

/**
 * Add custom attributes to menu links
 * 
 * @param array  $atts The menu link attributes
 * @param object $item The menu item object
 * @param object $args The menu arguments
 * @return array Modified attributes
 */
function add_menu_atts( array $atts, object $item, object $args ): array {
	$atts['itemprop'] = 'url';
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_menu_atts', 10, 3 );

// ============================================================================
// SEARCH FILTER SECTION
// ============================================================================

/**
 * Filter search results to manga post type
 * 
 * @param WP_Query $query The WordPress query object
 * @return WP_Query Modified query
 */
function search_filter_manga( WP_Query $query ): WP_Query {
	if ( $query->is_search ) {
		$query->set( 'post_type', [ 'manga' ] );
	}
	return $query;
}

if ( ! is_admin() ) {
	add_filter( 'pre_get_posts', 'search_filter_manga' );
}

/**
 * Disable responsive image srcset
 * 
 * @param array|false $sources The image sources or false
 * @return false
 */
function disable_srcset( $sources ) {
	return false;
}
add_filter( 'wp_calculate_image_srcset', 'disable_srcset' );

// ============================================================================
// THUMBNAIL SECTION
// ============================================================================

/**
 * Add theme support for featured images
 * 
 * @return void
 */
function setup_theme_support(): void {
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
	}
}
add_action( 'after_setup_theme', 'setup_theme_support' );

// ============================================================================
// TITLE CONTROL SECTION
// ============================================================================

/**
 * Filter page title
 * 
 * @param string $title The page title
 * @return string Modified page title
 */
function filter_wp_title( string $title ): string {
	global $page, $paged;

	if ( is_feed() ) {
		return $title;
	}

	$site_description = (string) get_bloginfo( 'description' );
	$site_name        = (string) get_bloginfo( 'name' );

	$filtered_title = $title . $site_name;

	if ( ! empty( $site_description ) && ( is_home() || is_front_page() ) ) {
		$filtered_title .= ' – ' . $site_description;
	}

	$current_page = (int) max( $paged ?? 1, $page ?? 1 );
	if ( $current_page >= 2 ) {
		$filtered_title .= ' – ' . sprintf( __( 'Page %s', 'mangaleaf' ), $current_page );
	}

	return $filtered_title;
}
add_filter( 'wp_title', 'filter_wp_title' );

// ============================================================================
// RANDOM REDIRECT SECTION
// ============================================================================

/**
 * Add rewrite rule for random manga redirect
 * 
 * @return void
 */
function random_add_rewrite(): void {
	global $wp;
	$wp->add_query_var( 'random' );
	add_rewrite_rule( 'random/?$', 'index.php?random=1', 'top' );
}
add_action( 'init', 'random_add_rewrite' );

/**
 * Redirect to random manga
 * 
 * @return void
 */
function random_template(): void {
	$random = (int) get_query_var( 'random' );
	
	if ( $random === 1 ) {
		$posts = get_posts( [
			'post_type'      => 'manga',
			'orderby'        => 'rand',
			'numberposts'    => 1,
			'posts_per_page' => 1,
		] );

		if ( ! empty( $posts ) ) {
			$link = get_permalink( $posts[0] );
			if ( $link ) {
				wp_redirect( esc_url_raw( $link ), 307 );
				exit;
			}
		}
	}
}
add_action( 'template_redirect', 'random_template' );

// ============================================================================
// POST VIEWS TRACKING SECTION
// ============================================================================

/**
 * Set post view count
 * 
 * @param int $post_id The post ID
 * @return int|bool The meta update result
 */
function set_post_views( int $post_id ) {
	$count_key = 'wpb_post_views_count';
	$count     = (int) get_post_meta( $post_id, $count_key, true );

	if ( $count === 0 ) {
		delete_post_meta( $post_id, $count_key );
		return add_post_meta( $post_id, $count_key, 1 );
	}

	$count++;
	return update_post_meta( $post_id, $count_key, $count );
}

// Remove prefetching to maintain accurate view counts
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

/**
 * Track post views on singular pages
 * 
 * @param int $post_id The post ID
 * @return int|bool|null The meta update result or null
 */
function track_post_views( int $post_id ) {
	if ( ! is_single() ) {
		return null;
	}

	if ( is_singular( 'manga' ) ) {
		return null;
	}

	if ( empty( $post_id ) ) {
		$post_id = (int) get_the_ID();
	}

	return set_post_views( $post_id );
}
add_action( 'wp_head', function(): void {
	track_post_views( (int) get_the_ID() );
} );

/**
 * Get formatted post view count
 * 
 * @param int $post_id The post ID
 * @return string The formatted view count
 */
function get_post_views( int $post_id ): string {
	$count_key = 'wpb_post_views_count';
	$count     = (int) get_post_meta( $post_id, $count_key, true );

	if ( $count === 0 ) {
		delete_post_meta( $post_id, $count_key );
		add_post_meta( $post_id, $count_key, 0 );
		return '0 Views';
	}

	return sprintf( '%d %s', $count, _n( 'View', 'Views', $count, 'mangaleaf' ) );
}

// ============================================================================
// TAXONOMY ORDERING SECTION
// ============================================================================

/**
 * Reorder genre taxonomy by title
 * 
 * @param WP_Query $query The WordPress query object
 * @return void
 */
function reorder_tax_by_title( WP_Query $query ): void {
	if ( ! is_admin() && $query->is_main_query() && is_tax( 'genres' ) ) {
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );
	}
}
add_action( 'pre_get_posts', 'reorder_tax_by_title' );

/**
 * Reorder blog archives
 * 
 * @param WP_Query $query The WordPress query object
 * @return void
 */
function reorder_blog_archive( WP_Query $query ): void {
	if ( ! is_admin() && is_post_type_archive( 'blog' ) ) {
		$blog_archive = (int) get_option( 'blogarchive', 10 );
		$query->set( 'posts_per_page', $blog_archive );
	}
}
add_action( 'pre_get_posts', 'reorder_blog_archive' );

/**
 * Filter tags to blog post type only
 * 
 * @param WP_Query $query The WordPress query object
 * @return void
 */
function filter_tags_to_blog( WP_Query $query ): void {
	if ( $query->is_tag() && $query->is_main_query() ) {
		$query->set( 'post_type', [ 'blog' ] );
	}
}
add_action( 'pre_get_posts', 'filter_tags_to_blog' );

// ============================================================================
// IMAGE UTILITY SECTION
// ============================================================================

/**
 * Remove Photon CDN from URLs
 * 
 * @param string $url The image URL
 * @return string The cleaned URL
 */
function remove_photon_cdn( string $url ): string {
	$photon_hosts = [
		'i0.wp.com/',
		'i1.wp.com/',
		'i2.wp.com/',
		'i3.wp.com/',
	];

	foreach ( $photon_hosts as $host ) {
		$url = str_ireplace( $host, '', $url );
	}

	return $url;
}

/**
 * Resize Photon image
 * 
 * @param string $url The image URL
 * @param int    $width The desired width
 * @param int    $height The desired height
 * @return string The resized URL
 */
function resize_photon_image( string $url, int $width = 1000, int $height = 1000 ): string {
	if ( strpos( $url, '.wp.com/' ) === false ) {
		return $url;
	}

	$url = explode( '?', $url )[0];
	$width += 20;
	$height += 20;

	return $url . '?resize=' . $width . ',' . $height;
}

/**
 * Get thumbnail image tag
 * 
 * @param int $post_id The post ID
 * @param int $width The image width
 * @param int $height The image height
 * @return string The image HTML
 */
function get_post_thumbnail_tag( int $post_id = 0, int $width = 1000, int $height = 1000 ): string {
	if ( $post_id === 0 ) {
		$post_id = (int) get_the_ID();
	}

	$thumbnail_url = get_the_post_thumbnail_url( $post_id );
	if ( ! $thumbnail_url ) {
		return '';
	}

	$resized_url = resize_photon_image( $thumbnail_url, $width, $height );
	return sprintf( '<img src="%s" alt="%s" loading="lazy" />', 
		esc_url( $resized_url ), 
		esc_attr( get_the_title( $post_id ) ) 
	);
}

// ============================================================================
// POST UTILITY SECTION
// ============================================================================

/**
 * Get post author display name
 * 
 * @param int $post_id The post ID
 * @return string The author name
 */
function get_post_author_name( int $post_id = 0 ): string {
	if ( $post_id === 0 ) {
		$post_id = (int) get_the_ID();
	}

	$author_id = (int) get_post_field( 'post_author', $post_id );
	return (string) get_the_author_meta( 'display_name', $author_id );
}

/**
 * Build chapter URL
 * 
 * @param string $post_name The post slug
 * @return string The chapter URL
 */
function build_chapter_url( string $post_name ): string {
	$post_name = trim( $post_name, '/' );
	return get_site_url() . '/' . $post_name . '/';
}

// ============================================================================
// CONTENT FILTERS
// ============================================================================

// Disable big image size threshold
add_filter( 'big_image_size_threshold', '__return_false' );

/**
 * Fix Blogger image sizes
 * 
 * @param string $content The post content
 * @return string The modified content
 */
function fix_blogger_image_sizes( string $content ): string {
	return (string) preg_replace( '/\/s\d+\//', '/s0/', $content );
}
add_filter( 'the_content', 'fix_blogger_image_sizes' );

// ============================================================================
// BREADCRUMB SECTION
// ============================================================================

/**
 * Display breadcrumb navigation
 * 
 * @return void
 */
function display_breadcrumb_navigation(): void {
	if ( get_option( 'tsbreadcrumb' ) !== '1' ) {
		return;
	}
	?>
	<div class="ts-breadcrumb bixbox">
		<ol itemscope="" itemtype="http://schema.org/BreadcrumbList">
			<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
				<a itemprop="item" href="<?php echo esc_url( site_url() ); ?>/">
					<span itemprop="name"><?php echo esc_html( get_bloginfo( 'name', 'display' ) ); ?></span>
				</a>
				<meta itemprop="position" content="1">
			</li>
			 › 
			<?php if ( is_singular( 'manga' ) ) : ?>
				<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
					<a itemprop="item" href="<?php the_permalink(); ?>">
						<span itemprop="name"><?php the_title(); ?></span>
					</a>
					<meta itemprop="position" content="2">
				</li>
			<?php else : 
				$series_id = (int) get_post_meta( get_the_ID(), 'ero_seri', true );
				if ( $series_id ) : 
			?>
				<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
					<a itemprop="item" href="<?php echo esc_url( get_permalink( $series_id ) ); ?>">
						<span itemprop="name"><?php echo esc_html( get_the_title( $series_id ) ); ?></span>
					</a>
					<meta itemprop="position" content="2">
				</li>
				 › 
				<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
					<a itemprop="item" href="<?php the_permalink(); ?>">
						<span itemprop="name"><?php the_title(); ?></span>
					</a>
					<meta itemprop="position" content="3">
				</li>
			<?php 
				endif;
			endif; 
			?>
		</ol>
	</div>	
	<?php
}

// ============================================================================
// BATCH DOWNLOAD SECTION
// ============================================================================

/**
 * Get batch download link
 * 
 * @param int $post_id The post ID
 * @return string The batch download HTML
 */
function get_batch_download( int $post_id = 0 ): string {
	if ( $post_id === 0 ) {
		$post_id = (int) get_the_ID();
	}

	if ( ! is_numeric( $post_id ) ) {
		return '';
	}

	$meta = (string) get_post_meta( $post_id, 'ero_batch', true );

	if ( empty( trim( strip_tags( $meta ) ) ) ) {
		return '';
	}

	// Check for sora_client function availability
	if ( function_exists( 'sora_client' ) && (int) get_option( 'enable_soralink' ) === 1 ) {
		return (string) sora_client( $meta );
	}

	return $meta;
}
