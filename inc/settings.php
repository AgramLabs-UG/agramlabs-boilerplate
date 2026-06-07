<?php
/**
 * Theme settings and Customizer controls.
 *
 * @package Agramlabs_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'agramlabs_setting_defaults' ) ) :
	/**
	 * Return theme option defaults.
	 *
	 * @return array<string,mixed>
	 */
	function agramlabs_setting_defaults(): array {
		return array(
			'header_logo'                  => 0,
			'footer_logo'                  => 0,
			'footer_copyright'             => sprintf( '© %s %s', gmdate( 'Y' ), get_bloginfo( 'name' ) ),
			'marketing_head_code'          => '',
			'marketing_footer_code'        => '',
			'drawer_desktop_enabled'       => false,
			'appear_animation'             => 'fade-up',
			'default_sidebar_layout'       => 'right',
			'gutenberg_cleanup_enabled'    => false,
			'cleanup_wp_block_class'       => false,
			'cleanup_has_classes'          => false,
			'cleanup_align_classes'        => false,
		);
	}
endif;

if ( ! function_exists( 'agramlabs_get_theme_option' ) ) :
	/**
	 * Read a theme mod with fallback.
	 *
	 * @param string $key Option key without prefix.
	 * @param mixed  $fallback Fallback value.
	 * @return mixed
	 */
	function agramlabs_get_theme_option( string $key, mixed $fallback = null ): mixed {
		$defaults = agramlabs_setting_defaults();
		$default  = array_key_exists( $key, $defaults ) ? $defaults[ $key ] : $fallback;

		return get_theme_mod( 'agramlabs_' . $key, $default );
	}
endif;

if ( ! function_exists( 'agramlabs_sanitize_checkbox' ) ) :
	/**
	 * Sanitize checkbox value.
	 *
	 * @param mixed $value Raw value.
	 */
	function agramlabs_sanitize_checkbox( mixed $value ): bool {
		return (bool) $value;
	}
endif;

if ( ! function_exists( 'agramlabs_sanitize_select' ) ) :
	/**
	 * Sanitize select values against allowed choices.
	 *
	 * @param mixed              $value Raw value.
	 * @param WP_Customize_Setting $setting Customizer setting.
	 */
	function agramlabs_sanitize_select( mixed $value, WP_Customize_Setting $setting ): string {
		$control = $setting->manager->get_control( $setting->id );
		$choices = $control ? $control->choices : array();

		return array_key_exists( $value, $choices ) ? (string) $value : (string) $setting->default;
	}
endif;

if ( ! function_exists( 'agramlabs_sanitize_code' ) ) :
	/**
	 * Preserve admin-provided marketing snippets.
	 *
	 * @param mixed $value Raw value.
	 */
	function agramlabs_sanitize_code( mixed $value ): string {
		if ( ! current_user_can( 'manage_options' ) ) {
			return '';
		}

		return is_string( $value ) ? $value : '';
	}
endif;

if ( ! function_exists( 'agramlabs_customize_register' ) ) :
	/**
	 * Register Customizer settings.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager.
	 */
	function agramlabs_customize_register( WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_panel(
			'agramlabs_theme',
			array(
				'title'       => __( 'Agramlabs Theme', 'agramlabs' ),
				'description' => __( 'Starter theme settings.', 'agramlabs' ),
				'priority'    => 160,
			)
		);

		$sections = array(
			'brand'     => __( 'Branding', 'agramlabs' ),
			'footer'    => __( 'Footer', 'agramlabs' ),
			'scripts'   => __( 'Marketing Codes', 'agramlabs' ),
			'layout'    => __( 'Layout and Drawer', 'agramlabs' ),
			'cleanup'   => __( 'Gutenberg Cleanup', 'agramlabs' ),
		);

		foreach ( $sections as $key => $title ) {
			$wp_customize->add_section(
				'agramlabs_' . $key,
				array(
					'title' => $title,
					'panel' => 'agramlabs_theme',
				)
			);
		}

		$wp_customize->add_setting( 'agramlabs_header_logo', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'agramlabs_header_logo',
				array(
					'label'     => __( 'Header logo', 'agramlabs' ),
					'section'   => 'agramlabs_brand',
					'mime_type' => 'image',
				)
			)
		);

		$site_icon_control = $wp_customize->get_control( 'site_icon' );

		if ( $site_icon_control ) {
			$site_icon_control->section     = 'agramlabs_brand';
			$site_icon_control->description = __( 'Used as the browser favicon and app icon.', 'agramlabs' );
		}

		$wp_customize->add_setting( 'agramlabs_footer_logo', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'agramlabs_footer_logo',
				array(
					'label'     => __( 'Footer logo', 'agramlabs' ),
					'section'   => 'agramlabs_footer',
					'mime_type' => 'image',
				)
			)
		);

		$wp_customize->add_setting( 'agramlabs_footer_copyright', array( 'default' => agramlabs_setting_defaults()['footer_copyright'], 'sanitize_callback' => 'wp_kses_post' ) );
		$wp_customize->add_control( 'agramlabs_footer_copyright', array( 'label' => __( 'Footer copyright', 'agramlabs' ), 'section' => 'agramlabs_footer', 'type' => 'textarea' ) );

		$wp_customize->add_setting( 'agramlabs_marketing_head_code', array( 'default' => '', 'sanitize_callback' => 'agramlabs_sanitize_code' ) );
		$wp_customize->add_control( 'agramlabs_marketing_head_code', array( 'label' => __( 'Head marketing code', 'agramlabs' ), 'section' => 'agramlabs_scripts', 'type' => 'textarea' ) );

		$wp_customize->add_setting( 'agramlabs_marketing_footer_code', array( 'default' => '', 'sanitize_callback' => 'agramlabs_sanitize_code' ) );
		$wp_customize->add_control( 'agramlabs_marketing_footer_code', array( 'label' => __( 'Footer marketing code', 'agramlabs' ), 'section' => 'agramlabs_scripts', 'type' => 'textarea' ) );

		$wp_customize->add_setting( 'agramlabs_drawer_desktop_enabled', array( 'default' => false, 'sanitize_callback' => 'agramlabs_sanitize_checkbox' ) );
		$wp_customize->add_control( 'agramlabs_drawer_desktop_enabled', array( 'label' => __( 'Enable drawer toggle on desktop', 'agramlabs' ), 'section' => 'agramlabs_layout', 'type' => 'checkbox' ) );

		$wp_customize->add_setting( 'agramlabs_appear_animation', array( 'default' => 'fade-up', 'sanitize_callback' => 'agramlabs_sanitize_select' ) );
		$wp_customize->add_control(
			'agramlabs_appear_animation',
			array(
				'label'   => __( 'Appear animation', 'agramlabs' ),
				'section' => 'agramlabs_layout',
				'type'    => 'select',
				'choices' => array(
					'none'    => __( 'None', 'agramlabs' ),
					'fade'    => __( 'Fade', 'agramlabs' ),
					'fade-up' => __( 'Fade up', 'agramlabs' ),
					'scale'   => __( 'Scale', 'agramlabs' ),
				),
			)
		);

		$wp_customize->add_setting( 'agramlabs_default_sidebar_layout', array( 'default' => 'right', 'sanitize_callback' => 'agramlabs_sanitize_select' ) );
		$wp_customize->add_control(
			'agramlabs_default_sidebar_layout',
			array(
				'label'   => __( 'Default sidebar layout', 'agramlabs' ),
				'section' => 'agramlabs_layout',
				'type'    => 'select',
				'choices' => array(
					'none'  => __( 'No sidebar', 'agramlabs' ),
					'right' => __( 'Right sidebar', 'agramlabs' ),
					'left'  => __( 'Left sidebar', 'agramlabs' ),
				),
			)
		);

		$cleanup_controls = array(
			'gutenberg_cleanup_enabled' => __( 'Enable Gutenberg cleanup', 'agramlabs' ),
			'cleanup_wp_block_class'    => __( 'Remove wp-block-* classes', 'agramlabs' ),
			'cleanup_has_classes'       => __( 'Remove has-* utility classes', 'agramlabs' ),
			'cleanup_align_classes'     => __( 'Remove align* classes', 'agramlabs' ),
		);

		foreach ( $cleanup_controls as $key => $label ) {
			$wp_customize->add_setting( 'agramlabs_' . $key, array( 'default' => false, 'sanitize_callback' => 'agramlabs_sanitize_checkbox' ) );
			$wp_customize->add_control( 'agramlabs_' . $key, array( 'label' => $label, 'section' => 'agramlabs_cleanup', 'type' => 'checkbox' ) );
		}
	}
endif;
add_action( 'customize_register', 'agramlabs_customize_register' );

if ( ! function_exists( 'agramlabs_output_marketing_head_code' ) ) :
	/**
	 * Output trusted admin-saved head snippets.
	 */
	function agramlabs_output_marketing_head_code(): void {
		$code = trim( (string) agramlabs_get_theme_option( 'marketing_head_code', '' ) );

		if ( '' !== $code ) {
			echo "\n" . $code . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
endif;
add_action( 'wp_head', 'agramlabs_output_marketing_head_code', 99 );

if ( ! function_exists( 'agramlabs_output_marketing_footer_code' ) ) :
	/**
	 * Output trusted admin-saved footer snippets.
	 */
	function agramlabs_output_marketing_footer_code(): void {
		$code = trim( (string) agramlabs_get_theme_option( 'marketing_footer_code', '' ) );

		if ( '' !== $code ) {
			echo "\n" . $code . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
endif;
add_action( 'wp_footer', 'agramlabs_output_marketing_footer_code', 99 );
