const FOCUSABLE = [
	'a[href]',
	'button:not([disabled])',
	'input:not([disabled])',
	'select:not([disabled])',
	'textarea:not([disabled])',
	'[tabindex]:not([tabindex="-1"])',
].join(',');

export const initDrawer = () => {
	const drawer = document.querySelector('[data-drawer]');
	const toggles = document.querySelectorAll('[data-drawer-toggle]');
	const closeButtons = document.querySelectorAll('[data-drawer-close]');

	if (!drawer || toggles.length === 0) {
		return;
	}

	const panel = drawer.querySelector('.site-drawer__panel');
	let activeToggle = null;

	const setOpen = (isOpen) => {
		drawer.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
		document.body.classList.toggle('has-open-drawer', isOpen);

		toggles.forEach((toggle) => {
			toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
		});

		if (isOpen) {
			panel?.focus();
			return;
		}

		activeToggle?.focus();
	};

	const closeDrawer = () => setOpen(false);

	toggles.forEach((toggle) => {
		toggle.addEventListener('click', () => {
			activeToggle = toggle;
			setOpen(drawer.getAttribute('aria-hidden') !== 'false');
		});
	});

	closeButtons.forEach((button) => {
		button.addEventListener('click', closeDrawer);
	});

	document.addEventListener('keydown', (event) => {
		if (drawer.getAttribute('aria-hidden') === 'true') {
			return;
		}

		if (event.key === 'Escape') {
			closeDrawer();
			return;
		}

		if (event.key !== 'Tab' || !panel) {
			return;
		}

		const focusable = [...panel.querySelectorAll(FOCUSABLE)];

		if (focusable.length === 0) {
			event.preventDefault();
			panel.focus();
			return;
		}

		const first = focusable[0];
		const last = focusable.at(-1);

		if (event.shiftKey && document.activeElement === first) {
			event.preventDefault();
			last.focus();
		} else if (!event.shiftKey && document.activeElement === last) {
			event.preventDefault();
			first.focus();
		}
	});
};
