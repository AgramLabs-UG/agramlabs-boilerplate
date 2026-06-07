export const initAnimations = () => {
	const animatedElements = document.querySelectorAll('[data-animate]');

	if (animatedElements.length === 0) {
		return;
	}

	if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
		animatedElements.forEach((element) => {
			element.dataset.animateReady = 'true';
		});
		return;
	}

	const observer = new IntersectionObserver(
		(entries) => {
			entries.forEach((entry) => {
				if (!entry.isIntersecting) {
					return;
				}

				const element = entry.target;
				const delay = element.getAttribute('data-animate-delay') || '0';

				element.style.setProperty('--ags-appear-delay', `${delay}s`);
				element.dataset.animateReady = 'true';
				observer.unobserve(element);
			});
		},
		{ rootMargin: '0px 0px -10% 0px', threshold: 0.1 }
	);

	animatedElements.forEach((element) => observer.observe(element));
};
