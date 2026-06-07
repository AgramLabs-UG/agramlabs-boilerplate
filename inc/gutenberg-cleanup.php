<?php
/**
 * Reversible Gutenberg class cleanup filters.
 *
 * @package Agramlabs_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'agramlabs_starter_gutenberg_cleanup_rules' ) ) :
	function agramlabs_starter_gutenberg_cleanup_rules(): array {
		return array(
			'cleanup_wp_block_class' => '/\swp-block-[a-z0-9_-]+/',
			'cleanup_has_classes'    => '/\shas-[a-z0-9_-]+/',
			'cleanup_align_classes'  => '/\salign(?:wide|full|left|right|center)/',
		);
	}
endif;

if ( ! function_exists( 'agramlabs_starter_cleanup_class_attribute' ) ) :
	function agramlabs_starter_cleanup_class_attribute( string $class_attribute ): string {
		if ( ! agramlabs_starter_get_theme_option( 'gutenberg_cleanup_enabled', false ) ) {
			return $class_attribute;
		}

		foreach ( agramlabs_starter_gutenberg_cleanup_rules() as $setting => $pattern ) {
			if ( agramlabs_starter_get_theme_option( $setting, false ) ) {
				$class_attribute = preg_replace( $pattern, '', $class_attribute ) ?? $class_attribute;
			}
		}

		return trim( preg_replace( '/\s+/', ' ', $class_attribute ) ?? $class_attribute );
	}
endif;

if ( ! function_exists( 'agramlabs_starter_cleanup_rendered_block' ) ) :
	function agramlabs_starter_cleanup_rendered_block( string $block_content ): string {
		if ( ! agramlabs_starter_get_theme_option( 'gutenberg_cleanup_enabled', false ) ) {
			return $block_content;
		}

		return preg_replace_callback(
			'/class="([^"]+)"/',
			static function ( array $matches ): string {
				return 'class="' . esc_attr( agramlabs_starter_cleanup_class_attribute( $matches[1] ) ) . '"';
			},
			$block_content
		) ?? $block_content;
	}
endif;
add_filter( 'render_block', 'agramlabs_starter_cleanup_rendered_block', 20 );
