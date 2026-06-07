<?php
/**
 * Classic fallback front page.
 *
 * @package Agramlabs_Starter
 */

get_header();
?>
<?php agramlabs_before_main(); ?>
<main id="main" class="site-main" role="main">
	<div class="site-content alignwide">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</div>
</main>
<?php agramlabs_after_main(); ?>
<?php
get_footer();
