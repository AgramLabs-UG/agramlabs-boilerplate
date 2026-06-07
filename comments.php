<?php
/**
 * Classic fallback comments template.
 *
 * @package Agramlabs_Starter
 */

if ( post_password_required() ) {
	return;
}
?>
<section class="comments" id="comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments__title"><?php esc_html_e( 'Comments', 'agramlabs-starter' ); ?></h2>
		<ol class="comments__list">
			<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true ) ); ?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>
	<?php comment_form(); ?>
</section>
