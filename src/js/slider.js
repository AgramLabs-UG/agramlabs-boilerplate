import Swiper from 'swiper';
import { A11y, Autoplay, Navigation, Pagination } from 'swiper/modules';

const parseOptions = (element) => {
	const raw = element.getAttribute('data-slider-options');

	if (!raw) {
		return {};
	}

	try {
		return JSON.parse(raw);
	} catch {
		return {};
	}
};

export const initSliders = () => {
	const sliders = document.querySelectorAll('[data-slider]');

	sliders.forEach((slider) => {
		if (slider.dataset.sliderReady === 'true') {
			return;
		}

		const root = slider;
		const options = parseOptions(root);
		const nextEl = root.querySelector('[data-slider-next]');
		const prevEl = root.querySelector('[data-slider-prev]');
		const paginationEl = root.querySelector('[data-slider-pagination]');

		root.dataset.sliderReady = 'true';

		new Swiper(root, {
			modules: [A11y, Autoplay, Navigation, Pagination],
			slidesPerView: 1,
			spaceBetween: 24,
			watchOverflow: true,
			navigation: nextEl && prevEl ? { nextEl, prevEl } : false,
			pagination: paginationEl ? { el: paginationEl, clickable: true } : false,
			...options,
		});
	});
};
