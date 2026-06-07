<?php
/**
 * Classic fallback 404 template.
 *
 * @package Agramlabs_Starter
 */

get_header();
?>
<?php agramlabs_starter_before_main(); ?>
<main id="main" class="site-main" role="main">
	<div class="site-content alignwide">
		<h1><?php esc_html_e( 'Page not found', 'agramlabs-starter' ); ?></h1>
		<p><?php esc_html_e( 'The page you requested does not exist or has moved.', 'agramlabs-starter' ); ?></p>
		<?php get_search_form(); ?>
	</div>
</main>
<?php agramlabs_starter_after_main(); ?>
<?php
get_footer();
