<?php
/**
 * Performance helpers.
 *
 * @package Agramlabs_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'agramlabs_preload_main_assets' ) ) :
	/**
	 * Preload the main compiled stylesheet.
	 */
	function agramlabs_preload_main_assets(): void {
		$main_css = get_theme_file_path( 'assets/css/main.css' );

		if ( file_exists( $main_css ) ) {
			printf(
				'<link rel="preload" href="%s" as="style">' . "\n",
				esc_url( get_theme_file_uri( 'assets/css/main.css' ) )
			);
		}
	}
endif;
add_action( 'wp_head', 'agramlabs_preload_main_assets', 1 );

if ( ! function_exists( 'agramlabs_image_loading_attributes' ) ) :
	/**
	 * Add starter image loading defaults.
	 *
	 * @param array<string,string|bool> $attr Image attributes.
	 * @return array<string,string|bool>
	 */
	function agramlabs_image_loading_attributes( array $attr ): array {
		if ( empty( $attr['loading'] ) ) {
			$attr['loading'] = 'lazy';
		}

		if ( empty( $attr['decoding'] ) ) {
			$attr['decoding'] = 'async';
		}

		return $attr;
	}
endif;
add_filter( 'wp_get_attachment_image_attributes', 'agramlabs_image_loading_attributes' );
