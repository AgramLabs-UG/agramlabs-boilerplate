<?php
/**
 * Classic fallback page template.
 *
 * @package Agramlabs_Starter
 */

get_header();

$sidebar_layout = agramlabs_starter_get_sidebar_layout();
?>
<?php agramlabs_starter_before_main(); ?>
<main id="main" class="site-main" role="main">
	<div class="site-layout site-layout--<?php echo esc_attr( $sidebar_layout ); ?> alignwide">
		<div class="site-content">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'entry' ); ?>>
					<header class="entry__header">
						<h1 class="entry__title"><?php the_title(); ?></h1>
					</header>
					<div class="entry__content"><?php the_content(); ?></div>
				</article>
			<?php endwhile; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</main>
<?php agramlabs_starter_after_main(); ?>
<?php
get_footer();
