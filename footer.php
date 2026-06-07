<?php
/**
 * Classic fallback footer.
 *
 * @package Agramlabs_Starter
 */

?>
<?php agramlabs_before_footer(); ?>
<footer class="site-footer" role="contentinfo">
	<div class="site-footer__inner alignwide">
		<div class="site-footer__brand">
			<?php
			$footer_logo_id = absint( agramlabs_get_theme_option( 'footer_logo', 0 ) );

			if ( $footer_logo_id ) {
				echo wp_get_attachment_image( $footer_logo_id, 'full', false, array( 'class' => 'site-footer__logo' ) );
			}
			?>
			<p class="site-footer__credit"><?php echo wp_kses_post( agramlabs_get_theme_option( 'footer_copyright', '' ) ); ?></p>
		</div>
		<?php agramlabs_render_menu( 'footer', array( 'container_class' => 'menu menu--footer site-footer__nav' ) ); ?>
	</div>
</footer>
<?php agramlabs_after_footer(); ?>
<?php wp_footer(); ?>
</body>
</html>
