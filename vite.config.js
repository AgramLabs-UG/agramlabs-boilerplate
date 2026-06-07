import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
import { defineConfig } from 'vite';

const themeDir = dirname(fileURLToPath(import.meta.url));

export default defineConfig({
	build: {
		emptyOutDir: false,
		manifest: false,
		outDir: 'assets',
		rollupOptions: {
			input: {
				main: resolve(themeDir, 'src/js/main.js'),
				'editor-blocks': resolve(themeDir, 'src/js/editor-blocks.js')
			},
			output: {
				entryFileNames: 'js/[name].js'
			}
		}
	}
});
