import { initAnimations } from './animation.js';
import { initDrawer } from './drawer.js';
import { initSliders } from './slider.js';

const ready = (callback) => {
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', callback, { once: true });
		return;
	}

	callback();
};

ready(() => {
	document.documentElement.classList.add('has-js');
	initDrawer();
	initSliders();
	initAnimations();
});
