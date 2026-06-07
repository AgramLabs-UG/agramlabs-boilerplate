<?php
/**
 * Classic fallback archive template.
 *
 * @package Agramlabs_Starter
 */

get_header();

$sidebar_layout = agramlabs_get_sidebar_layout();
?>
<?php agramlabs_before_main(); ?>
<main id="main" class="site-main" role="main">
	<div class="site-layout site-layout--<?php echo esc_attr( $sidebar_layout ); ?> alignwide">
		<div class="site-content">
			<header class="archive-header">
				<?php the_archive_title( '<h1 class="archive-header__title">', '</h1>' ); ?>
				<?php the_archive_description( '<div class="archive-header__description">', '</div>' ); ?>
			</header>
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'entry' ); ?>>
						<h2 class="entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="entry__summary"><?php the_excerpt(); ?></div>
					</article>
				<?php endwhile; ?>
				<?php the_posts_pagination(); ?>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</main>
<?php agramlabs_after_main(); ?>
<?php
get_footer();
