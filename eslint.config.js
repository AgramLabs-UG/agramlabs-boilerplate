import js from '@eslint/js';

export default [
	js.configs.recommended,
	{
		files: ['src/js/**/*.js'],
		languageOptions: {
			ecmaVersion: 'latest',
			sourceType: 'module',
			globals: {
				document: 'readonly',
				IntersectionObserver: 'readonly',
				window: 'readonly'
			}
		}
	}
];
