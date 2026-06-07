<?php
/**
 * Plugin-aware JSON-LD schema helpers.
 *
 * @package Agramlabs_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'agramlabs_schema_image' ) ) :
	/**
	 * Return an image URL for schema.
	 */
	function agramlabs_schema_image(): string {
		if ( is_singular() && has_post_thumbnail() ) {
			return (string) get_the_post_thumbnail_url( null, 'full' );
		}

		$custom_logo_id = get_theme_mod( 'custom_logo' );

		if ( $custom_logo_id ) {
			return (string) wp_get_attachment_image_url( $custom_logo_id, 'full' );
		}

		return '';
	}
endif;

if ( ! function_exists( 'agramlabs_schema_graph' ) ) :
	/**
	 * Build a minimal schema graph.
	 *
	 * @return array<string,mixed>
	 */
	function agramlabs_schema_graph(): array {
		$site_url = home_url( '/' );
		$graph    = array(
			array(
				'@type' => 'Organization',
				'@id'   => $site_url . '#organization',
				'name'  => get_bloginfo( 'name' ),
				'url'   => $site_url,
			),
			array(
				'@type'     => 'WebSite',
				'@id'       => $site_url . '#website',
				'url'       => $site_url,
				'name'      => get_bloginfo( 'name' ),
				'publisher' => array( '@id' => $site_url . '#organization' ),
			),
		);

		$image = agramlabs_schema_image();

		if ( $image ) {
			$graph[0]['logo'] = array(
				'@type' => 'ImageObject',
				'url'   => $image,
			);
		}

		if ( is_singular() ) {
			$post_id = get_queried_object_id();
			$type    = is_singular( 'post' ) ? 'Article' : 'WebPage';

			$item = array(
				'@type'      => $type,
				'@id'        => get_permalink( $post_id ) . '#webpage',
				'url'        => get_permalink( $post_id ),
				'name'       => get_the_title( $post_id ),
				'isPartOf'   => array( '@id' => $site_url . '#website' ),
				'inLanguage' => get_bloginfo( 'language' ),
			);

			if ( 'Article' === $type ) {
				$item['headline']      = get_the_title( $post_id );
				$item['datePublished'] = get_the_date( DATE_W3C, $post_id );
				$item['dateModified']  = get_the_modified_date( DATE_W3C, $post_id );
				$item['author']        = array(
					'@type' => 'Person',
					'name'  => get_the_author_meta( 'display_name', (int) get_post_field( 'post_author', $post_id ) ),
				);
			}

			if ( $image ) {
				$item['image'] = $image;
			}

			$graph[] = $item;
		}

		return array(
			'@context' => 'https://schema.org',
			'@graph'   => $graph,
		);
	}
endif;

if ( ! function_exists( 'agramlabs_output_schema' ) ) :
	/**
	 * Output schema if no SEO plugin owns it.
	 */
	function agramlabs_output_schema(): void {
		if ( is_admin() || agramlabs_has_seo_plugin() ) {
			return;
		}

		printf(
			'<script type="application/ld+json">%s</script>' . "\n",
			wp_json_encode( agramlabs_schema_graph(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
		);
	}
endif;
add_action( 'wp_head', 'agramlabs_output_schema', 20 );
