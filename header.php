<?php
/**
 * Classic fallback header.
 *
 * @package Agramlabs_Starter
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'agramlabs-starter' ); ?></a>
<?php agramlabs_starter_before_header(); ?>
<header class="site-header" role="banner">
	<div class="site-header__inner alignwide">
		<div class="site-header__brand">
			<?php
			$header_logo_id = absint( agramlabs_starter_get_theme_option( 'header_logo', 0 ) );

			if ( $header_logo_id ) {
				echo wp_get_attachment_image( $header_logo_id, 'full', false, array( 'class' => 'site-header__logo' ) );
			} elseif ( has_custom_logo() ) {
				the_custom_logo();
			}
			?>
			<p class="site-header__title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></p>
		</div>
		<?php agramlabs_starter_render_menu( 'primary', array( 'container_class' => 'menu menu--primary site-header__nav' ) ); ?>
		<?php agramlabs_starter_drawer_toggle( 'site-header__drawer-toggle' ); ?>
	</div>
</header>
<?php agramlabs_starter_after_header(); ?>
