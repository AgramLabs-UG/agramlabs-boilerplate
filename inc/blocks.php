<?php
/**
 * Starter custom block registration and render callbacks.
 *
 * @package Agramlabs_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'agramlabs_blocks_asset_version' ) ) :
	/**
	 * Return a block asset version.
	 */
	function agramlabs_blocks_asset_version( string $relative_path ): string {
		$path = get_theme_file_path( $relative_path );

		if ( file_exists( $path ) ) {
			return (string) filemtime( $path );
		}

		return AGRAMLABS_STARTER_VERSION;
	}
endif;

if ( ! function_exists( 'agramlabs_register_blocks' ) ) :
	/**
	 * Register boilerplate editable blocks.
	 */
	function agramlabs_register_blocks(): void {
		wp_register_script(
			'agramlabs-editor-blocks',
			get_theme_file_uri( 'assets/js/editor-blocks.js' ),
			array( 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-element', 'wp-i18n' ),
			agramlabs_blocks_asset_version( 'assets/js/editor-blocks.js' ),
			true
		);

		$blocks = array(
			'faq'             => 'agramlabs_render_faq_block',
			'slider'          => 'agramlabs_render_slider_block',
			'testimonials'    => 'agramlabs_render_testimonials_block',
			'card-grid'       => 'agramlabs_render_card_grid_block',
			'contact-section' => 'agramlabs_render_contact_section_block',
		);

		foreach ( $blocks as $name => $render_callback ) {
			register_block_type(
				"agramlabs/{$name}",
				array(
					'api_version'     => 3,
					'editor_script'   => 'agramlabs-editor-blocks',
					'render_callback' => $render_callback,
					'supports'        => array(
						'align' => array( 'wide', 'full' ),
					),
				)
			);
		}
	}
endif;
add_action( 'init', 'agramlabs_register_blocks' );

if ( ! function_exists( 'agramlabs_block_items' ) ) :
	/**
	 * Return a normalized block item list.
	 *
	 * @param mixed $items Raw attribute value.
	 * @return array<int,array<string,mixed>>
	 */
	function agramlabs_block_items( mixed $items ): array {
		if ( ! is_array( $items ) ) {
			return array();
		}

		return array_values(
			array_filter(
				$items,
				static fn( $item ): bool => is_array( $item )
			)
		);
	}
endif;

if ( ! function_exists( 'agramlabs_render_faq_block' ) ) :
	/**
	 * Render FAQ accordion block.
	 */
	function agramlabs_render_faq_block( array $attributes ): string {
		$heading = isset( $attributes['heading'] ) ? sanitize_text_field( $attributes['heading'] ) : '';
		$items   = agramlabs_block_items( $attributes['items'] ?? array() );

		ob_start();
		?>
		<section class="ags-block ags-faq" data-animate>
			<?php if ( $heading ) : ?>
				<h2 class="ags-block__title"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			<div class="ags-faq__items">
				<?php foreach ( $items as $item ) : ?>
					<details class="ags-faq__item">
						<summary class="ags-faq__question"><?php echo esc_html( $item['question'] ?? '' ); ?></summary>
						<div class="ags-faq__answer"><?php echo wp_kses_post( wpautop( $item['answer'] ?? '' ) ); ?></div>
					</details>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
		return (string) ob_get_clean();
	}
endif;

if ( ! function_exists( 'agramlabs_render_slider_block' ) ) :
	/**
	 * Render Swiper slider block.
	 */
	function agramlabs_render_slider_block( array $attributes ): string {
		$heading = isset( $attributes['heading'] ) ? sanitize_text_field( $attributes['heading'] ) : '';
		$slides  = agramlabs_block_items( $attributes['slides'] ?? array() );

		ob_start();
		?>
		<section class="ags-block ags-slider-block" data-animate>
			<?php if ( $heading ) : ?>
				<h2 class="ags-block__title"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			<div class="swiper" data-slider>
				<div class="swiper-wrapper">
					<?php foreach ( $slides as $slide ) : ?>
						<article class="swiper-slide ags-slider-card">
							<?php if ( ! empty( $slide['imageUrl'] ) ) : ?>
								<img class="ags-slider-card__image" src="<?php echo esc_url( $slide['imageUrl'] ); ?>" alt="<?php echo esc_attr( $slide['imageAlt'] ?? '' ); ?>">
							<?php endif; ?>
							<div class="ags-slider-card__body">
								<h3><?php echo esc_html( $slide['title'] ?? '' ); ?></h3>
								<p><?php echo esc_html( $slide['text'] ?? '' ); ?></p>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
				<div class="slider-controls">
					<button class="slider-controls__button" data-slider-prev type="button" aria-label="<?php esc_attr_e( 'Previous slide', 'agramlabs' ); ?>">‹</button>
					<div class="swiper-pagination" data-slider-pagination></div>
					<button class="slider-controls__button" data-slider-next type="button" aria-label="<?php esc_attr_e( 'Next slide', 'agramlabs' ); ?>">›</button>
				</div>
			</div>
		</section>
		<?php
		return (string) ob_get_clean();
	}
endif;

if ( ! function_exists( 'agramlabs_render_testimonials_block' ) ) :
	/**
	 * Render testimonials block.
	 */
	function agramlabs_render_testimonials_block( array $attributes ): string {
		$heading = isset( $attributes['heading'] ) ? sanitize_text_field( $attributes['heading'] ) : '';
		$items   = agramlabs_block_items( $attributes['items'] ?? array() );

		ob_start();
		?>
		<section class="ags-block ags-testimonials" data-animate>
			<?php if ( $heading ) : ?>
				<h2 class="ags-block__title"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			<div class="ags-testimonials__grid">
				<?php foreach ( $items as $item ) : ?>
					<figure class="ags-testimonial">
						<blockquote><?php echo esc_html( $item['quote'] ?? '' ); ?></blockquote>
						<figcaption>
							<strong><?php echo esc_html( $item['name'] ?? '' ); ?></strong>
							<span><?php echo esc_html( $item['meta'] ?? '' ); ?></span>
						</figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
		return (string) ob_get_clean();
	}
endif;

if ( ! function_exists( 'agramlabs_render_card_grid_block' ) ) :
	/**
	 * Render controlled card grid block.
	 */
	function agramlabs_render_card_grid_block( array $attributes ): string {
		$heading = isset( $attributes['heading'] ) ? sanitize_text_field( $attributes['heading'] ) : '';
		$cards   = agramlabs_block_items( $attributes['cards'] ?? array() );

		ob_start();
		?>
		<section class="ags-block ags-card-grid" data-animate>
			<?php if ( $heading ) : ?>
				<h2 class="ags-block__title"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			<div class="ags-card-grid__items">
				<?php foreach ( $cards as $card ) : ?>
					<article class="ags-card">
						<?php if ( ! empty( $card['icon'] ) ) : ?>
							<span class="ags-card__icon"><?php echo esc_html( $card['icon'] ); ?></span>
						<?php endif; ?>
						<h3><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
						<p><?php echo esc_html( $card['text'] ?? '' ); ?></p>
						<?php if ( ! empty( $card['url'] ) ) : ?>
							<a href="<?php echo esc_url( $card['url'] ); ?>"><?php esc_html_e( 'Learn more', 'agramlabs' ); ?></a>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
		return (string) ob_get_clean();
	}
endif;

if ( ! function_exists( 'agramlabs_render_contact_section_block' ) ) :
	/**
	 * Render contact/form section block.
	 */
	function agramlabs_render_contact_section_block( array $attributes ): string {
		$heading = isset( $attributes['heading'] ) ? sanitize_text_field( $attributes['heading'] ) : '';
		$text    = isset( $attributes['text'] ) ? sanitize_textarea_field( $attributes['text'] ) : '';
		$email   = isset( $attributes['email'] ) ? sanitize_email( $attributes['email'] ) : '';
		$phone   = isset( $attributes['phone'] ) ? sanitize_text_field( $attributes['phone'] ) : '';
		$form    = isset( $attributes['formShortcode'] ) ? $attributes['formShortcode'] : '';

		ob_start();
		?>
		<section class="ags-block ags-contact-section" data-animate>
			<div class="ags-contact-section__content">
				<?php if ( $heading ) : ?>
					<h2 class="ags-block__title"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $text ) : ?>
					<p><?php echo esc_html( $text ); ?></p>
				<?php endif; ?>
				<ul class="ags-contact-section__list">
					<?php if ( $email ) : ?>
						<li><a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a></li>
					<?php endif; ?>
					<?php if ( $phone ) : ?>
						<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
					<?php endif; ?>
				</ul>
			</div>
			<?php if ( $form ) : ?>
				<div class="ags-contact-section__form"><?php echo do_shortcode( wp_kses_post( $form ) ); ?></div>
			<?php endif; ?>
		</section>
		<?php
		return (string) ob_get_clean();
	}
endif;
