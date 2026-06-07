<?php
/**
 * Menu registration and rendering helpers.
 *
 * @package Agramlabs_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'agramlabs_starter_register_menus' ) ) :
	function agramlabs_starter_register_menus(): void {
		register_nav_menus(
			array(
				'primary' => __( 'Primary menu', 'agramlabs-starter' ),
				'footer'  => __( 'Footer menu', 'agramlabs-starter' ),
				'drawer'  => __( 'Drawer menu', 'agramlabs-starter' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'agramlabs_starter_register_menus' );

if ( ! function_exists( 'agramlabs_starter_render_menu' ) ) :
	function agramlabs_starter_render_menu( string $location, array $args = array() ): void {
		$defaults = array(
			'container'      => 'nav',
			'container_class'=> 'menu menu--' . sanitize_html_class( $location ),
			'fallback_cb'    => false,
			'menu_class'     => 'menu__list',
			'theme_location' => $location,
			'depth'          => 2,
		);

		if ( has_nav_menu( $location ) ) {
			wp_nav_menu( wp_parse_args( $args, $defaults ) );
			return;
		}

		if ( current_user_can( 'edit_theme_options' ) ) {
			printf(
				'<nav class="%1$s" aria-label="%2$s"><a class="menu__empty" href="%3$s">%4$s</a></nav>',
				esc_attr( $defaults['container_class'] ),
				esc_attr( $location ),
				esc_url( admin_url( 'nav-menus.php' ) ),
				esc_html__( 'Assign menu', 'agramlabs-starter' )
			);
		}
	}
endif;
