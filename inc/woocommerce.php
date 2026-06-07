<?php
/**
 * WooCommerce preparation.
 *
 * @package Agramlabs_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'agramlabs_starter_woocommerce_setup' ) ) :
	/**
	 * Register WooCommerce theme support.
	 */
	function agramlabs_starter_woocommerce_setup(): void {
		add_theme_support(
			'woocommerce',
			array(
				'gallery_thumbnail_image_width' => 180,
				'product_grid'                  => array(
					'default_rows'    => 3,
					'min_rows'        => 1,
					'max_rows'        => 6,
					'default_columns' => 3,
					'min_columns'     => 1,
					'max_columns'     => 4,
				),
			)
		);
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
endif;
add_action( 'after_setup_theme', 'agramlabs_starter_woocommerce_setup' );

if ( ! function_exists( 'agramlabs_starter_is_woocommerce_active' ) ) :
	/**
	 * Check WooCommerce availability.
	 */
	function agramlabs_starter_is_woocommerce_active(): bool {
		return class_exists( 'WooCommerce' );
	}
endif;

if ( ! function_exists( 'agramlabs_starter_woocommerce_wrapper_before' ) ) :
	/**
	 * Open WooCommerce content wrapper.
	 */
	function agramlabs_starter_woocommerce_wrapper_before(): void {
		echo '<main class="site-main site-main--commerce wp-block-group"><div class="woocommerce-layout alignwide">';
	}
endif;

if ( ! function_exists( 'agramlabs_starter_woocommerce_wrapper_after' ) ) :
	/**
	 * Close WooCommerce content wrapper.
	 */
	function agramlabs_starter_woocommerce_wrapper_after(): void {
		echo '</div></main>';
	}
endif;

if ( agramlabs_starter_is_woocommerce_active() ) {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	add_action( 'woocommerce_before_main_content', 'agramlabs_starter_woocommerce_wrapper_before', 10 );
	add_action( 'woocommerce_after_main_content', 'agramlabs_starter_woocommerce_wrapper_after', 10 );
}
