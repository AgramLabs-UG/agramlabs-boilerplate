<?php
/**
 * Classic fallback index.
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
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'entry' ); ?>>
						<header class="entry__header">
							<h1 class="entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
						</header>
						<div class="entry__summary"><?php the_excerpt(); ?></div>
					</article>
				<?php endwhile; ?>
				<?php the_posts_pagination(); ?>
			<?php else : ?>
				<p><?php esc_html_e( 'No posts found.', 'agramlabs-starter' ); ?></p>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</main>
<?php agramlabs_starter_after_main(); ?>
<?php
get_footer();
