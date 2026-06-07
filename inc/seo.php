<?php
/**
 * Lightweight SEO preparation hooks.
 *
 * @package Agramlabs_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'agramlabs_starter_has_seo_plugin' ) ) :
	/**
	 * Detect common SEO plugins to avoid duplicate theme metadata.
	 */
	function agramlabs_starter_has_seo_plugin(): bool {
		return defined( 'WPSEO_VERSION' )
			|| defined( 'RANK_MATH_VERSION' )
			|| defined( 'AIOSEO_VERSION' )
			|| defined( 'SEOPRESS_VERSION' );
	}
endif;

if ( ! function_exists( 'agramlabs_starter_document_title_separator' ) ) :
	/**
	 * Keep document titles concise.
	 */
	function agramlabs_starter_document_title_separator(): string {
		return '|';
	}
endif;
add_filter( 'document_title_separator', 'agramlabs_starter_document_title_separator' );

if ( ! function_exists( 'agramlabs_starter_meta_description' ) ) :
	/**
	 * Output a conservative meta description when no SEO plugin is active.
	 */
	function agramlabs_starter_meta_description(): void {
		if ( agramlabs_starter_has_seo_plugin() || is_admin() ) {
			return;
		}

		$description = get_bloginfo( 'description' );

		if ( is_singular() ) {
			$description = has_excerpt() ? get_the_excerpt() : wp_strip_all_tags( get_the_content() );
		} elseif ( is_archive() ) {
			$description = wp_strip_all_tags( get_the_archive_description() );
		}

		$description = wp_trim_words( trim( preg_replace( '/\s+/', ' ', $description ) ), 28, '' );

		if ( '' === $description ) {
			return;
		}

		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
	}
endif;
add_action( 'wp_head', 'agramlabs_starter_meta_description', 5 );

if ( ! function_exists( 'agramlabs_starter_robots' ) ) :
	/**
	 * Allow large previews in search results.
	 *
	 * @param array<string,bool|string> $robots Robots directives.
	 * @return array<string,bool|string>
	 */
	function agramlabs_starter_robots( array $robots ): array {
		$robots['max-image-preview'] = 'large';

		return $robots;
	}
endif;
add_filter( 'wp_robots', 'agramlabs_starter_robots' );
