<?php
/**
 * Local SVG file injector.
 *
 * @package Agramlabs_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'agramlabs_starter_get_svg' ) ) :
	/**
	 * Return sanitized inline SVG from the theme assets/svg directory.
	 *
	 * @param string $name SVG filename without extension.
	 * @param string $class Optional class.
	 */
	function agramlabs_starter_get_svg( string $name, string $class = '' ): string {
		$name = sanitize_file_name( $name );
		$path = get_theme_file_path( 'assets/svg/' . $name . '.svg' );

		if ( ! file_exists( $path ) ) {
			return '';
		}

		$svg = file_get_contents( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

		if ( ! is_string( $svg ) || '' === trim( $svg ) ) {
			return '';
		}

		$allowed = array(
			'svg'     => array(
				'aria-hidden' => true,
				'class'       => true,
				'fill'        => true,
				'focusable'   => true,
				'height'      => true,
				'role'        => true,
				'stroke'      => true,
				'viewbox'     => true,
				'viewBox'     => true,
				'width'       => true,
				'xmlns'       => true,
			),
			'g'       => array( 'fill' => true, 'stroke' => true, 'transform' => true ),
			'path'    => array( 'd' => true, 'fill' => true, 'stroke' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'stroke-width' => true ),
			'circle'  => array( 'cx' => true, 'cy' => true, 'fill' => true, 'r' => true, 'stroke' => true ),
			'rect'    => array( 'fill' => true, 'height' => true, 'rx' => true, 'stroke' => true, 'width' => true, 'x' => true, 'y' => true ),
			'line'    => array( 'stroke' => true, 'stroke-linecap' => true, 'stroke-width' => true, 'x1' => true, 'x2' => true, 'y1' => true, 'y2' => true ),
			'polyline'=> array( 'fill' => true, 'points' => true, 'stroke' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'stroke-width' => true ),
			'polygon' => array( 'fill' => true, 'points' => true, 'stroke' => true ),
			'title'   => array(),
		);

		$svg = wp_kses( $svg, $allowed );

		if ( '' !== $class ) {
			$svg = preg_replace( '/<svg\b(?![^>]*\bclass=)/', '<svg class="' . esc_attr( $class ) . '"', $svg, 1 ) ?? $svg;
		}

		return $svg;
	}
endif;

if ( ! function_exists( 'agramlabs_starter_svg' ) ) :
	/**
	 * Print a local SVG file.
	 *
	 * @param string $name SVG filename without extension.
	 * @param string $class Optional class.
	 */
	function agramlabs_starter_svg( string $name, string $class = '' ): void {
		echo agramlabs_starter_get_svg( $name, $class ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;
