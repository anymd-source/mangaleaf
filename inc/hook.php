<?php
/**
 * MangaLeaf Theme Hooks and Assets
 * 
 * PHP 8.1+ Compatible
 * 
 * @package MangaLeaf
 * @since 2.2.0
 */

defined( 'ABSPATH' ) || exit( 'Direct access denied!' );

// ============================================================================
// THEME ASSETS SECTION
// ============================================================================

/**
 * Enqueue theme scripts and styles
 * 
 * @return void
 */
function themesia_enqueue_assets(): void {
	$theme_version = '2.2.0';

	// Remove WordPress block library styles
	wp_dequeue_style( 'wp-block-library' );

	// Enqueue main theme styles
	wp_enqueue_style( 'style', get_stylesheet_uri(), [], $theme_version );

	// Enqueue RTL stylesheet if enabled
	if ( get_option( 'tsrtl' ) === '1' ) {
		wp_enqueue_style( 
			'rtl', 
			get_template_directory_uri() . '/assets/css/rtl.css', 
			[], 
			$theme_version 
		);
	}

	// Enqueue light mode stylesheet
	wp_enqueue_style( 
		'lightstyle', 
		get_template_directory_uri() . '/assets/css/lightmode.css', 
		[], 
		$theme_version 
	);

	// Enqueue Font Awesome
	wp_enqueue_style( 
		'fontawesome', 
		get_template_directory_uri() . '/assets/css/font-awesome.min.css', 
		[], 
		'5.13.0' 
	);

	// Enqueue theme scripts
	wp_enqueue_script( 
		'history_script', 
		get_template_directory_uri() . '/assets/js/history.js', 
		[ 'jquery' ] 
	);

	wp_enqueue_script( 
		'tsfn_scripts', 
		get_template_directory_uri() . '/assets/js/function.js', 
		[ 'jquery' ] 
	);

	// Enqueue home and manga-specific assets
	if ( is_home() || is_singular( 'manga' ) ) {
		wp_enqueue_style( 
			'owl-carousel', 
			get_template_directory_uri() . '/assets/css/owl.carousel.css', 
			[], 
			'1.0.0' 
		);
	}

	// Manga-specific assets
	if ( is_singular( 'manga' ) ) {
		wp_enqueue_script( 
			'tsmedia', 
			get_template_directory_uri() . '/assets/js/tsmedia.js', 
			[ 'jquery' ], 
			'1.0.0', 
			false 
		);

		// Gallery assets
		if ( get_option( 'gallerymanga' ) === '1' ) {
			wp_enqueue_style( 
				'blueimp', 
				get_template_directory_uri() . '/assets/css/blueimp-gallery.min.css', 
				[], 
				'2.38.0' 
			);
		}
	}

	// Override jQuery with custom version
	wp_deregister_script( 'jquery' );
	wp_register_script( 
		'jquery', 
		get_template_directory_uri() . '/assets/js/jquery.min.js', 
		[], 
		'3.5.1' 
	);
	wp_enqueue_script( 'jquery' );

	// Home page Swiper
	if ( is_home() ) {
		wp_enqueue_style( 
			'swiper', 
			'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/css/swiper.min.css', 
			[], 
			'4.5.1' 
		);
	}

	// Carousel for home and manga pages
	if ( is_home() || is_singular( 'manga' ) ) {
		wp_enqueue_script( 
			'owl-carousel', 
			get_template_directory_uri() . '/assets/js/owl.carousel.min.js', 
			[ 'jquery' ], 
			'2.3.4', 
			false 
		);
	}

	// Post reading options
	if ( is_singular( 'post' ) ) {
		wp_enqueue_script( 
			'reading-options', 
			get_template_directory_uri() . '/assets/js/reading-options.js', 
			[ 'tsfn_scripts' ], 
			'1.0.0', 
			false 
		);

		// Lazy loading
		if ( get_option( 'tslazyload' ) ) {
			wp_enqueue_script( 
				'tslazyloadpf', 
				'https://cdn.jsdelivr.net/npm/intersection-observer@0.7.0/intersection-observer.min.js', 
				[ 'reading-options' ], 
				'7.0', 
				false 
			);

			wp_enqueue_script( 
				'tslazyload', 
				'https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.1.2/dist/lazyload.min.js', 
				[ 'tslazyloadpf' ], 
				'17.1.2', 
				false 
			);
		}
	}

	// NSFW handling
	if ( is_singular( [ 'manga', 'post' ] ) ) {
		wp_enqueue_script( 
			'nsfw_scripts', 
			get_template_directory_uri() . '/assets/js/nsfw.js', 
			[ 'tsfn_scripts' ], 
			'1.0.0', 
			false 
		);
	}

	// Manga-specific scripts
	if ( is_singular( 'manga' ) ) {
		if ( get_option( 'gallerymanga' ) === '1' ) {
			wp_enqueue_script( 
				'blueimp', 
				get_template_directory_uri() . '/assets/js/blueimp-gallery.min.js', 
				[ 'jquery' ], 
				'2.38.0', 
				false 
			);
		}

		wp_enqueue_script( 
			'chapter-search', 
			get_template_directory_uri() . '/assets/js/chapter-search.js', 
			[ 'tsfn_scripts' ], 
			'2.38.0', 
			false 
		);
	}

	// Home page tabs
	if ( is_home() && get_option( 'homerecommend' ) === '1' ) {
		wp_enqueue_script( 
			'tabs', 
			get_template_directory_uri() . '/assets/js/tabs.js', 
			[ 'jquery' ], 
			'1.0.0', 
			false 
		);
	}

	// Global filter script
	wp_enqueue_script( 
		'filter', 
		get_template_directory_uri() . '/assets/js/filter.js', 
		[ 'jquery' ], 
		'1.0.0', 
		true 
	);
}
add_action( 'wp_enqueue_scripts', 'themesia_enqueue_assets' );

// ============================================================================
// THEME VARIABLES SECTION
// ============================================================================

/**
 * Add global JavaScript variables
 * 
 * @return void
 */
function add_theme_global_vars(): void {
	?>
	<script>
		const baseurl = "<?php echo esc_url( home_url( '/' ) ); ?>";
		const ajaxurl = "<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>";
		const max_bookmark = <?php echo (int) get_option( 'bookmark', 50 ); ?>;
		const max_history = <?php echo (int) get_option( 'max_history', 10 ); ?>;
		const defaultTheme = "<?php echo esc_attr( (string) get_option( 'defaulttheme' ) ); ?>";
	</script>
	<?php
}
add_action( 'wp_head', 'add_theme_global_vars', 8 );

// ============================================================================
// THEME HEADER SECTION
// ============================================================================

/**
 * Output header scripts and styles
 * 
 * @return void
 */
function themesia_output_header(): void {
	// Custom header scripts from admin
	echo get_option( 'tsscriptheader' );
	?>
	<script>
		jQuery(document).ready(function($){
			$(".shme").click(function(){
				$(".mm").toggleClass("shwx");
			});
			$(".srcmob").click(function(){
				$(".minmb").toggleClass("minmbx");
			});
		});
	</script>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			// Scroll to top button functionality
			$(window).scroll(function(){
				if ($(this).scrollTop() > 100) {
					$('.scrollToTop').fadeIn();
				} else {
					$('.scrollToTop').fadeOut();
				}
			});
			
			$('.scrollToTop').click(function(){
				$('html, body').animate({scrollTop : 0},800);
				return false;
			});
		});
	</script>
	<?php
	
	// Output theme color styles
	themesia_output_theme_colors();
}
add_action( 'wp_head', 'themesia_output_header' );

/**
 * Output dynamic theme color styles
 * 
 * @return void
 */
function themesia_output_theme_colors(): void {
	$theme_color = (string) get_option( 'themecolor' );
	if ( empty( $theme_color ) ) {
		return;
	}

	// Sanitize color
	$theme_color = sanitize_hex_color( $theme_color );
	if ( ! $theme_color ) {
		return;
	}
	?>
	<style>
		.th, .serieslist.pop ul li.topone .limit .bw .ctr,
		.releases .vl, .scrollToTop,
		#sidebar #bm-history li a:hover,
		.hpage a, #footer .footermenu,
		.footer-az .az-list li a,
		.main-info .info-desc .spe span {
			background-color: <?php echo esc_attr( $theme_color ); ?> !important;
		}
		
		#sidebar .section #searchform #searchsubmit,
		.series-gen .nav-tabs li.active a,
		.lastend .inepcx a,
		.nav_apb a:hover,
		#top-menu li a:hover,
		.readingnav.rnavbot .readingnavbot .readingbar .readingprogress {
			background-color: <?php echo esc_attr( $theme_color ); ?> !important;
		}
		
		.lightmode #sidebar .section h4,
		.lightmode .serieslist ul li .ctr,
		.listupd .utao .uta .luf ul li,
		.lightmode .bs .bsx:hover .tt,
		.soralist ul, a:hover,
		.lightmode .blogbox .btitle h3,
		.lightmode .blogbox .btitle h3 a {
			color: <?php echo esc_attr( $theme_color ); ?> !important;
		}
		
		.bxcl ul li .lchx a:visited,
		.listupd .utao .uta .luf ul li a:visited {
			color: <?php echo esc_attr( $theme_color ); ?> !important;
		}
		
		@media only screen and (max-width: 800px) {
			.lightmode.black .th, .lightmode .th, .th, .surprise {
				background-color: <?php echo esc_attr( $theme_color ); ?>;
			}
		}
	</style>
	<?php
}

/**
 * Output home page genre color styles
 * 
 * @return void
 */
function themesia_output_home_colors(): void {
	$home_color = (string) get_option( 'homegenrecolor' );
	if ( empty( $home_color ) ) {
		return;
	}

	// Sanitize color
	$home_color = sanitize_hex_color( $home_color );
	if ( ! $home_color ) {
		return;
	}
	?>
	<style>
		.home-genres {
			background-color: <?php echo esc_attr( $home_color ); ?>;
		}
		.home-genres .alman a {
			color: <?php echo esc_attr( $home_color ); ?>;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'themesia_output_home_colors' );

// ============================================================================
// THEME FOOTER SECTION
// ============================================================================

/**
 * Output footer scripts and elements
 * 
 * @return void
 */
function themesia_output_footer(): void {
	?>
	<a href="#" class="scrollToTop"><span class="fas fa-angle-up"></span></a>
	<?php

	// Home page Swiper carousel
	if ( is_home() ) {
		?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/js/swiper.min.js"></script>
		<script>
			const swiper = new Swiper('.swiper-container', {
				centeredSlides: true,
				autoplay: {
					delay: 5000,
					disableOnInteraction: false,
				},
				loop: true,
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
				},
			});
		</script>
		<?php
	}

	// Manga gallery
	if ( get_option( 'gallerymanga' ) === '1' && is_singular( 'manga' ) ) {
		?>
		<script>
			jQuery('.owl-carousel').owlCarousel({
				stagePadding: 50,
				loop: true,
				margin: 10,
				responsive: {
					0: { items: 1 },
					600: { items: 4 },
					1000: { items: 4 }
				}
			});

			let isGalleryDragging = false;
			jQuery("#gallery")
				.on("mousedown touchstart", function() {
					isGalleryDragging = false;
				})
				.on("mousemove touchmove", function() {
					isGalleryDragging = true;
				})
				.on("mouseup touchend", function(event) {
					event.preventDefault();
					const wasDragging = isGalleryDragging;
					isGalleryDragging = false;
					
					if (!wasDragging) {
						event = event || window.event;
						const target = event.target || event.srcElement;
						const link = target.src ? target.parentNode : target;
						const options = { index: link, event: event };
						const links = this.getElementsByTagName('a');
						blueimp.Gallery(links, options);
					}
				});
			
			jQuery("#gallery a").on("click", function() { return false; });
		</script>
		<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
			<div class="slides"></div>
			<h3 class="title"></h3>
			<a class="prev">‹</a>
			<a class="next">›</a>
			<a class="close">×</a>
			<a class="play-pause"></a>
			<ol class="indicator"></ol>
		</div>
		<?php
	}

	// Content warning modal
	themesia_output_content_warning();

	// Floating elements
	if ( function_exists( 'floating' ) ) {
		floating();
	}

	// Dark mode listener
	?>
	<script>ts_darkmode.listen();</script>
	<?php

	// Custom footer scripts
	echo get_option( 'tsscriptfooter' );
}
add_action( 'wp_footer', 'themesia_output_footer' );

/**
 * Output content warning modal if applicable
 * 
 * @return void
 */
function themesia_output_content_warning(): void {
	if ( get_option( 'contentwarning' ) !== '1' ) {
		return;
	}

	if ( ! is_singular( [ 'manga', 'post' ] ) ) {
		return;
	}

	wp_reset_postdata();

	if ( is_singular( 'manga' ) ) {
		$series_id = (int) get_the_ID();
	} else {
		$series_id = (int) get_post_meta( get_the_ID(), 'ero_seri', true );
	}

	if ( ! $series_id ) {
		return;
	}

	// Check if series has NSFW tags
	$nsfw_terms = [ 'adult', 'mature', 'smut' ];
	if ( ! is_object_in_term( $series_id, 'genres', $nsfw_terms ) ) {
		return;
	}
	?>
	<div class="restrictcontainer" data-id="<?php echo (int) $series_id; ?>">
		<script>ts_restricted_warning.quickHide();</script>
		<div class="restrictcheck">
			<div class="restrictmess">
				<div class="restitle">
					<?php esc_html_e( 'Content Warning', 'mangaleaf' ); ?>
				</div>
				<div class="resdescp">
					<?php 
					if ( function_exists( 'GOV_lang' ) && method_exists( 'GOV_lang', 'get' ) ) {
						echo GOV_lang::get( 'series_nsfw', [ 'manga_title' => get_the_title() ] );
					} else {
						esc_html_e( 'This content contains mature themes.', 'mangaleaf' );
					}
					?>
				</div>
				<div class="resconfirm">
					<div class="rescb enterx">
						<?php 
						if ( function_exists( 'GOV_lang' ) && method_exists( 'GOV_lang', 'get' ) ) {
							echo GOV_lang::get( 'warning_enter_label' );
						} else {
							esc_html_e( 'Enter', 'mangaleaf' );
						}
						?>
					</div>
					<div class="rescb exitx">
						<?php 
						if ( function_exists( 'GOV_lang' ) && method_exists( 'GOV_lang', 'get' ) ) {
							echo GOV_lang::get( 'warning_exit_label' );
						} else {
							esc_html_e( 'Exit', 'mangaleaf' );
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

// ============================================================================
// LIST MODE REWRITE RULES
// ============================================================================

/**
 * Add rewrite rules for list mode
 * 
 * @return void
 */
function add_list_mode_rewrite_rules(): void {
	$slug = (string) get_option( 'changeslug', 'manga' );
	add_rewrite_rule( "^{$slug}/list-mode/?$", 'index.php?themesia-mangalist=true', 'top' );
}
add_action( 'init', 'add_list_mode_rewrite_rules' );

/**
 * Add themesia-mangalist query variable
 * 
 * @param array $query_vars The query variables
 * @return array Modified query variables
 */
function add_list_mode_query_var( array $query_vars ): array {
	$query_vars[] = 'themesia-mangalist';
	return $query_vars;
}
add_filter( 'query_vars', 'add_list_mode_query_var' );

/**
 * Redirect to list mode template
 * 
 * @param string $original The original template
 * @return string The template path
 */
function catch_list_mode_page( string $original ): string {
	if ( get_query_var( 'themesia-mangalist' ) ) {
		remove_filter( 'wp_title', 'filter_wp_title' );
		add_filter( 'wp_title', function( string $title ): string {
			return 'List Mode - ' . get_bloginfo( 'name' );
		}, 99999 );

		add_filter( 'pre_get_document_title', function( string $title ): string {
			return 'List Mode - ' . get_bloginfo( 'name' );
		}, 99999 );

		$_GET['list'] = 'list';
		return get_template_directory() . '/archive-manga.php';
	}

	return $original;
}
add_action( 'template_include', 'catch_list_mode_page' );

// ============================================================================
// AFTER BODY HOOK
// ============================================================================

/**
 * Fire after body hook
 * 
 * @return void
 */
function tsia_after_body(): void {
	do_action( 'tsia_after_body' );
}
add_action( 'tsia_after_body', function(): void {
	?>
	<script>ts_darkmode.init();</script>
	<?php
} );

// ============================================================================
// PROJECT EXCLUSION
// ============================================================================

/**
 * Exclude project posts from homepage
 * 
 * @param WP_Query $query The query object
 * @return void
 */
function exclude_projects_from_home( WP_Query $query ): void {
	if ( get_option( 'excludeproject' ) !== '1' ) {
		return;
	}

	if ( $query->is_home() && $query->is_main_query() ) {
		$query->query_vars['meta_key']   = 'ero_project';
		$query->query_vars['meta_value'] = 0;
	}
}
add_action( 'pre_get_posts', 'exclude_projects_from_home' );

// ============================================================================
// ADMIN COLUMNS
// ============================================================================

/**
 * Add views column to post list
 * 
 * @param array $columns The column array
 * @return array Modified columns
 */
function add_views_column_header( array $columns ): array {
	$columns['ts-views'] = __( 'Views', 'mangaleaf' );
	return $columns;
}
add_filter( 'manage_post_posts_columns', 'add_views_column_header' );
add_filter( 'manage_manga_posts_columns', 'add_views_column_header' );

/**
 * Display views column content
 * 
 * @param string $column_name The column name
 * @return void
 */
function display_views_column_content( string $column_name ): void {
	if ( $column_name === 'ts-views' ) {
		echo (int) get_post_meta( get_the_ID(), 'wpb_post_views_count', true );
	}
}
add_action( 'manage_post_posts_custom_column', 'display_views_column_content' );
add_action( 'manage_manga_posts_custom_column', 'display_views_column_content' );

/**
 * Make views column sortable
 * 
 * @param array $sortable_columns The sortable columns
 * @return array Modified sortable columns
 */
function make_views_column_sortable( array $sortable_columns ): array {
	$sortable_columns['ts-views'] = 'views';
	return $sortable_columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'make_views_column_sortable' );
add_filter( 'manage_edit-manga_sortable_columns', 'make_views_column_sortable' );

/**
 * Handle views column sorting
 * 
 * @param WP_Query $query The query object
 * @return void
 */
function handle_views_column_sorting( WP_Query $query ): void {
	if ( ! is_admin() ) {
		return;
	}

	$orderby = (string) $query->get( 'orderby' );

	if ( $orderby === 'views' ) {
		$query->set( 'meta_key', 'wpb_post_views_count' );
		$query->set( 'orderby', 'meta_value_num' );
	}
}
add_action( 'pre_get_posts', 'handle_views_column_sorting' );
