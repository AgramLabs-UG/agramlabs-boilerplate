<?php
/**
 * Local SVG icon registry.
 *
 * @package Agramlabs_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'agramlabs_icons' ) ) :
	/**
	 * Return available theme icons.
	 *
	 * @return array<string,string>
	 */
	function agramlabs_icons(): array {
		return array(
			'arrow-right' => '<path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>',
			'check'       => '<path d="m5 12 5 5L20 7"/>',
			'chevron-left' => '<path d="m15 18-6-6 6-6"/>',
			'chevron-right' => '<path d="m9 18 6-6-6-6"/>',
			'close'       => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
			'menu'        => '<path d="M4 6h16"/><path d="M4 12h16"/><path d="M4 18h16"/>',
			'play'        => '<path d="m8 5 12 7-12 7V5z"/>',
			'search'      => '<path d="m21 21-4.3-4.3"/><circle cx="11" cy="11" r="7"/>',
			'shopping-bag' => '<path d="M6 8h16l-2 14H8L6 8z"/><path d="M10 8a4 4 0 0 1 8 0"/>',
			'user'        => '<path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/>',
		);
	}
endif;

if ( ! function_exists( 'agramlabs_get_icon' ) ) :
	/**
	 * Return a local SVG icon.
	 *
	 * @param string $name Icon name.
	 * @param array  $args Icon args.
	 */
	function agramlabs_get_icon( string $name, array $args = array() ): string {
		$icons = agramlabs_icons();

		if ( ! isset( $icons[ $name ] ) ) {
			return '';
		}

		$defaults = array(
			'class'       => '',
			'aria_hidden' => true,
			'label'       => '',
			'size'        => 24,
		);
		$args     = wp_parse_args( $args, $defaults );
		$classes  = trim( 'icon icon--' . sanitize_html_class( $name ) . ' ' . $args['class'] );
		$label    = trim( (string) $args['label'] );
		$hidden   = (bool) $args['aria_hidden'] && '' === $label;
		$attrs    = array(
			'class'   => esc_attr( $classes ),
			'width'   => absint( $args['size'] ),
			'height'  => absint( $args['size'] ),
			'viewBox' => '0 0 24 24',
			'fill'    => 'none',
			'stroke'  => 'currentColor',
			'stroke-width' => '2',
			'stroke-linecap' => 'round',
			'stroke-linejoin' => 'round',
		);

		if ( $hidden ) {
			$attrs['aria-hidden'] = 'true';
			$attrs['focusable']   = 'false';
		} else {
			$attrs['role']       = 'img';
			$attrs['aria-label'] = $label;
		}

		$attr_html = '';

		foreach ( $attrs as $attr => $value ) {
			$attr_html .= sprintf( ' %s="%s"', esc_attr( $attr ), esc_attr( (string) $value ) );
		}

		return sprintf( '<svg%s>%s</svg>', $attr_html, $icons[ $name ] );
	}
endif;

if ( ! function_exists( 'agramlabs_icon' ) ) :
	/**
	 * Print a local SVG icon.
	 *
	 * @param string $name Icon name.
	 * @param array  $args Icon args.
	 */
	function agramlabs_icon( string $name, array $args = array() ): void {
		echo agramlabs_get_icon( $name, $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;
