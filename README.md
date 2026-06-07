# Agramlabs Starter

Agramlabs Starter is a Gutenberg-first WordPress starter theme with a Bootstrap-compatible grid, SCSS architecture, ES module JavaScript without jQuery, Swiper slider support, local SVG icons, SEO preparation, WooCommerce preparation, BEM naming, optimized compiled assets, and a strict no-`!important` rule.

The theme is block-first. `theme.json`, block templates, template parts, and patterns are the primary rendering model. Classic PHP templates can be added as fallbacks when needed.

## Requirements

- WordPress 6.5+
- PHP 8.1+
- Node 20+ for asset development
- npm 10+

## Installation

1. Place `agramlabs-starter` in `wp-content/themes`.
2. Activate **Agramlabs Starter** in WordPress admin.
3. Install dependencies when developing assets:

```bash
npm install
```

Compiled files are checked into `assets/css` and `assets/js`, so the theme can activate before npm dependencies are installed.

## Development Commands

```bash
npm run build
npm run lint:css
npm run lint:js
npm run watch
```

Command purpose:

- `npm run build`: Builds CSS and JavaScript assets.
- `npm run build:css`: Compiles `src/scss/main.scss` and `src/scss/editor.scss`.
- `npm run build:js`: Bundles `src/js/main.js` with Vite.
- `npm run watch`: Watches the main SCSS file.
- `npm run lint:css`: Runs Stylelint on SCSS.
- `npm run lint:js`: Runs ESLint on JavaScript.

## Theme Features

- Gutenberg block theme support through `theme.json`, `templates`, `parts`, and `patterns`.
- Bootstrap-compatible grid classes without importing Bootstrap reboot or component CSS.
- SCSS source split into settings, tools, base, layouts, components, blocks, pages, utilities, and vendor-compatible partials.
- JavaScript modules bundled through Vite with no jQuery dependency.
- Swiper support for sliders and carousels.
- Appear-animation hook for elements with `data-animate`.
- Local SVG icon helper through `agramlabs_starter_get_icon()`.
- SEO fallback metadata that avoids common SEO plugin duplication.
- WooCommerce support, gallery support, wrappers, and fallback template.
- Plugin-aware JSON-LD schema foundation.
- Local SVG file injector for `assets/svg`.
- Starter block patterns for CTA, FAQ, testimonials, pricing, and contact.
- Performance helpers for stylesheet preload and image loading attributes.
- Customizer settings for branding, footer, marketing snippets, drawer behavior, animations, sidebar layout, and Gutenberg cleanup.
- Header, footer, and drawer menu locations.
- Accessible drawer menu with vanilla JavaScript behavior.
- Semantic classic PHP fallback templates.
- Optimized compiled CSS and JS assets.
- No jQuery in theme code.
- No `!important` in theme source or compiled theme files.

## Folder Overview

- `inc/`: PHP feature modules.
- `src/scss/`: Source SCSS.
- `src/js/`: Source JavaScript.
- `assets/`: Compiled assets loaded by WordPress.
- `templates/`: Block templates.
- `parts/`: Block template parts.
- `patterns/`: Gutenberg block patterns.
- `docs/`: Rules, architecture, and task tracking.
- `theme.json`: Design tokens and block defaults.
- `woocommerce.php`: WooCommerce fallback template.

See [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md) for extension rules.

## Slider Usage

Use Swiper-compatible markup:

```html
<div class="swiper" data-slider>
	<div class="swiper-wrapper">
		<div class="swiper-slide">Slide 1</div>
		<div class="swiper-slide">Slide 2</div>
	</div>
	<div class="slider-controls">
		<button class="slider-controls__button" data-slider-prev type="button">Previous</button>
		<div class="swiper-pagination" data-slider-pagination></div>
		<button class="slider-controls__button" data-slider-next type="button">Next</button>
	</div>
</div>
```

Optional JSON settings can be added with `data-slider-options`.

## Animation Usage

Add `data-animate` to elements that should reveal on scroll:

```html
<section data-animate>
	<h2>Section title</h2>
</section>
```

Use `data-animate-delay="0.15"` for staggered timing. Appear animations use native `IntersectionObserver` and preserve `prefers-reduced-motion`.

## Icon Usage

Render a registered local SVG icon in PHP:

```php
echo agramlabs_starter_get_icon( 'arrow-right', array( 'label' => 'Continue' ) );
```

Use `agramlabs_starter_icon()` when direct output is appropriate.

## SEO and WooCommerce

SEO preparation is intentionally conservative. The theme outputs fallback metadata only when common SEO plugins are not detected. Future schema work should use JSON-LD and avoid fake or duplicated data.

WooCommerce preparation is active only when WooCommerce is installed. The theme registers WooCommerce support, gallery features, and content wrappers.

## Planned Next Work

The following are planned and tracked in [docs/TASKS.md](docs/TASKS.md):

- Initialize the clean firm GitHub repository.
- Add accessibility audit automation later if browser-level checks are needed.

## Engineering Rules

Project rules live in [docs/RULES.md](docs/RULES.md). The short version:

- Semantic HTML5.
- BEM for project classes.
- DRY SCSS.
- Vanilla JavaScript.
- Swiper for sliders.
- No jQuery.
- No `!important`.
- Escape output and sanitize input in PHP.
- Keep templates thin and helpers modular.
- Build and lint before release.

## Verification Checklist

Run before commit or release:

```bash
npm run build
npm run lint:css
npm run lint:js
```

Also check:

- PHP syntax for changed PHP files.
- No `!important` outside `node_modules`.
- No jQuery usage in theme code.
- Compiled assets exist in `assets/css` and `assets/js`.
- Theme activates in WordPress admin when the local database is available.
