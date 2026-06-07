<?php
/**
 * Classic fallback search template.
 *
 * @package Agramlabs_Starter
 */

get_header();
?>
<?php agramlabs_before_main(); ?>
<main id="main" class="site-main" role="main">
	<div class="site-content alignwide">
		<header class="archive-header">
			<h1 class="archive-header__title">
				<?php
				printf(
					/* translators: %s: search query. */
					esc_html__( 'Search results for: %s', 'agramlabs' ),
					esc_html( get_search_query() )
				);
				?>
			</h1>
			<?php get_search_form(); ?>
		</header>
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'entry' ); ?>>
					<h2 class="entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="entry__summary"><?php the_excerpt(); ?></div>
				</article>
			<?php endwhile; ?>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No results matched your search.', 'agramlabs' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php agramlabs_after_main(); ?>
<?php
get_footer();
