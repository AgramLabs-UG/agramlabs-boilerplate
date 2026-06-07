module.exports = {
	extends: ['stylelint-config-standard-scss'],
	rules: {
		'declaration-no-important': true,
		'custom-property-pattern': [
			'^(ags|bs|wp)-[a-z0-9-]+$',
			{
				message: 'Use project, Bootstrap, or WordPress custom property names.'
			}
		],
		'selector-class-pattern': [
			'^(wp-|has-|is-|align|align-items-|container|row|col|offset|g-|gx-|gy-|px-|ags-|boiler-|site-|entry-|post-|feature-|hero-|button|skip-link|icon|swiper|slider-|drawer-|menu|sidebar|archive-|comments|comment-form|form-|required|woocommerce|products|product)[a-zA-Z0-9_-]*$',
			{
				message: 'Use BEM-style project classes or approved WordPress/Bootstrap utility classes.'
			}
		]
	}
};
