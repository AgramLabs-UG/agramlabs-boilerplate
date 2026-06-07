<?php
/**
 * Drawer menu helpers.
 *
 * @package Agramlabs_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'agramlabs_starter_drawer_toggle' ) ) :
	function agramlabs_starter_drawer_toggle( string $class = '' ): void {
		printf(
			'<button class="drawer-toggle %1$s" type="button" data-drawer-toggle aria-controls="site-drawer" aria-expanded="false"><span class="drawer-toggle__label">%2$s</span>%3$s</button>',
			esc_attr( $class ),
			esc_html__( 'Menu', 'agramlabs-starter' ),
			agramlabs_starter_get_icon( 'menu', array( 'class' => 'drawer-toggle__icon' ) ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}
endif;

if ( ! function_exists( 'agramlabs_starter_render_drawer' ) ) :
	function agramlabs_starter_render_drawer(): void {
		?>
		<div class="site-drawer" id="site-drawer" data-drawer aria-hidden="true">
			<div class="site-drawer__overlay" data-drawer-close></div>
			<aside class="site-drawer__panel" aria-label="<?php esc_attr_e( 'Site menu', 'agramlabs-starter' ); ?>" tabindex="-1">
				<button class="site-drawer__close" type="button" data-drawer-close aria-label="<?php esc_attr_e( 'Close menu', 'agramlabs-starter' ); ?>">
					<?php agramlabs_starter_icon( 'close' ); ?>
				</button>
				<?php agramlabs_starter_render_menu( has_nav_menu( 'drawer' ) ? 'drawer' : 'primary', array( 'container_class' => 'menu menu--drawer' ) ); ?>
			</aside>
		</div>
		<?php
	}
endif;
add_action( 'wp_footer', 'agramlabs_starter_render_drawer', 20 );
