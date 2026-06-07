<?php
/**
 * Title: Three column content grid
 * Slug: agramlabs/content-grid
 * Categories: agramlabs-sections
 *
 * @package Agramlabs_Starter
 */
?>
<!-- wp:group {"tagName":"section","className":"feature-grid is-style-section","align":"wide","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignwide feature-grid is-style-section">
	<!-- wp:heading {"level":2} -->
	<h2 class="wp-block-heading">Starter principles</h2>
	<!-- /wp:heading -->
	<!-- wp:html -->
	<div class="container px-0">
		<div class="row g-4">
			<div class="col-12 col-md-4">
				<article class="feature-card">
					<h3 class="feature-card__title">Gutenberg native</h3>
					<p class="feature-card__text">Templates, parts, patterns, and editor styles are first-class.</p>
				</article>
			</div>
			<div class="col-12 col-md-4">
				<article class="feature-card">
					<h3 class="feature-card__title">Grid without bloat</h3>
					<p class="feature-card__text">Bootstrap layout tools are available without shipping component CSS.</p>
				</article>
			</div>
			<div class="col-12 col-md-4">
				<article class="feature-card">
					<h3 class="feature-card__title">Strict CSS</h3>
					<p class="feature-card__text">The cascade is organized to avoid specificity fights and overrides.</p>
				</article>
			</div>
		</div>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
