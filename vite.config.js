import { resolve } from 'node:path';
import { defineConfig } from 'vite';

export default defineConfig({
	build: {
		emptyOutDir: false,
		manifest: false,
		outDir: 'assets',
		rollupOptions: {
			input: {
				main: resolve(__dirname, 'src/js/main.js')
			},
			output: {
				entryFileNames: 'js/[name].js'
			}
		}
	}
});
