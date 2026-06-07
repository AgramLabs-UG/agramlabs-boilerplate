<?php
/**
 * Theme setup and asset loading.
 *
 * @package Agramlabs_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AGRAMLABS_STARTER_VERSION', wp_get_theme()->get( 'Version' ) );

require_once get_theme_file_path( 'inc/icons.php' );
require_once get_theme_file_path( 'inc/settings.php' );
require_once get_theme_file_path( 'inc/hooks.php' );
require_once get_theme_file_path( 'inc/navigation.php' );
require_once get_theme_file_path( 'inc/sidebar.php' );
require_once get_theme_file_path( 'inc/drawer.php' );
require_once get_theme_file_path( 'inc/gutenberg-cleanup.php' );
require_once get_theme_file_path( 'inc/seo.php' );
require_once get_theme_file_path( 'inc/schema.php' );
require_once get_theme_file_path( 'inc/svg.php' );
require_once get_theme_file_path( 'inc/woocommerce.php' );
require_once get_theme_file_path( 'inc/performance.php' );
require_once get_theme_file_path( 'inc/blocks.php' );

if ( ! function_exists( 'agramlabs_setup' ) ) :
	/**
	 * Register core theme support.
	 */
	function agramlabs_setup(): void {
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );

		add_editor_style( 'assets/css/editor.css' );
	}
endif;
add_action( 'after_setup_theme', 'agramlabs_setup' );

if ( ! function_exists( 'agramlabs_body_classes' ) ) :
	/**
	 * Add theme state classes.
	 *
	 * @param array<int,string> $classes Body classes.
	 * @return array<int,string>
	 */
	function agramlabs_body_classes( array $classes ): array {
		$classes[] = 'theme-agramlabs';
		$classes[] = 'has-appear-' . sanitize_html_class( agramlabs_get_theme_option( 'appear_animation', 'fade-up' ) );

		if ( agramlabs_get_theme_option( 'drawer_desktop_enabled', false ) ) {
			$classes[] = 'has-desktop-drawer';
		}

		return $classes;
	}
endif;
add_filter( 'body_class', 'agramlabs_body_classes' );

if ( ! function_exists( 'agramlabs_asset_version' ) ) :
	/**
	 * Return filemtime-based versions in development and theme version as fallback.
	 */
	function agramlabs_asset_version( string $relative_path ): string {
		$path = get_theme_file_path( $relative_path );

		if ( file_exists( $path ) ) {
			return (string) filemtime( $path );
		}

		return AGRAMLABS_STARTER_VERSION;
	}
endif;

if ( ! function_exists( 'agramlabs_enqueue_assets' ) ) :
	/**
	 * Enqueue frontend assets.
	 */
	function agramlabs_enqueue_assets(): void {
		wp_enqueue_style(
			'agramlabs-main',
			get_theme_file_uri( 'assets/css/main.css' ),
			array(),
			agramlabs_asset_version( 'assets/css/main.css' )
		);

		wp_enqueue_script(
			'agramlabs-main',
			get_theme_file_uri( 'assets/js/main.js' ),
			array(),
			agramlabs_asset_version( 'assets/js/main.js' ),
			array( 'strategy' => 'defer', 'in_footer' => true )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'agramlabs_enqueue_assets' );

if ( ! function_exists( 'agramlabs_enqueue_editor_assets' ) ) :
	/**
	 * Enqueue block editor assets.
	 */
	function agramlabs_enqueue_editor_assets(): void {
		wp_enqueue_style(
			'agramlabs-editor',
			get_theme_file_uri( 'assets/css/editor.css' ),
			array(),
			agramlabs_asset_version( 'assets/css/editor.css' )
		);
	}
endif;
add_action( 'enqueue_block_editor_assets', 'agramlabs_enqueue_editor_assets' );

if ( ! function_exists( 'agramlabs_register_block_styles' ) ) :
	/**
	 * Register starter block style variants.
	 */
	function agramlabs_register_block_styles(): void {
		register_block_style(
			'core/group',
			array(
				'name'  => 'section',
				'label' => __( 'Section', 'agramlabs' ),
			)
		);

		register_block_style(
			'core/buttons',
			array(
				'name'  => 'stacked-mobile',
				'label' => __( 'Stacked on mobile', 'agramlabs' ),
			)
		);

		register_block_style(
			'core/list',
			array(
				'name'  => 'check-list',
				'label' => __( 'Check list', 'agramlabs' ),
			)
		);
	}
endif;
add_action( 'init', 'agramlabs_register_block_styles' );

if ( ! function_exists( 'agramlabs_register_pattern_categories' ) ) :
	/**
	 * Register starter pattern categories.
	 */
	function agramlabs_register_pattern_categories(): void {
		register_block_pattern_category(
			'agramlabs-sections',
			array( 'label' => __( 'Agramlabs Sections', 'agramlabs' ) )
		);
	}
endif;
add_action( 'init', 'agramlabs_register_pattern_categories' );
