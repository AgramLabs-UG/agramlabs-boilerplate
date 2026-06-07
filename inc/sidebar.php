<?php
/**
 * Sidebar registration and layout helpers.
 *
 * @package Agramlabs_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'agramlabs_register_sidebars' ) ) :
	function agramlabs_register_sidebars(): void {
		register_sidebar(
			array(
				'name'          => __( 'Primary Sidebar', 'agramlabs' ),
				'id'            => 'primary-sidebar',
				'description'   => __( 'Optional sidebar for classic fallback templates.', 'agramlabs' ),
				'before_widget' => '<section id="%1$s" class="sidebar__widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="sidebar__title">',
				'after_title'   => '</h2>',
			)
		);
	}
endif;
add_action( 'widgets_init', 'agramlabs_register_sidebars' );

if ( ! function_exists( 'agramlabs_get_sidebar_layout' ) ) :
	function agramlabs_get_sidebar_layout(): string {
		$layout = (string) agramlabs_get_theme_option( 'default_sidebar_layout', 'right' );

		if ( ! is_active_sidebar( 'primary-sidebar' ) ) {
			return 'none';
		}

		return in_array( $layout, array( 'none', 'right', 'left' ), true ) ? $layout : 'right';
	}
endif;
