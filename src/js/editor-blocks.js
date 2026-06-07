const { __ } = window.wp.i18n;
const { registerBlockType } = window.wp.blocks;
const { InspectorControls, RichText, useBlockProps } = window.wp.blockEditor;
const { Button, PanelBody, TextControl, TextareaControl } = window.wp.components;
const { createElement: el } = window.wp.element;

const setListItem = (items, index, key, value) => items.map((item, itemIndex) => (
	itemIndex === index ? { ...item, [key]: value } : item
));

const removeListItem = (items, index) => items.filter((item, itemIndex) => itemIndex !== index);

const editableList = ({ items, labels, fields, onChange, addItem }) => el(
	'div',
	{ className: 'ags-editor-list' },
	items.map((item, index) => el(
		'div',
		{ className: 'ags-editor-list__item', key: index },
		el('strong', null, `${labels.item} ${index + 1}`),
		fields.map((field) => el(
			field.type === 'textarea' ? TextareaControl : TextControl,
			{
				key: field.key,
				label: field.label,
				value: item[field.key] || '',
				onChange: (value) => onChange(setListItem(items, index, field.key, value))
			}
		)),
		el(
			Button,
			{
				isDestructive: true,
				variant: 'secondary',
				onClick: () => onChange(removeListItem(items, index))
			},
			labels.remove
		)
	)),
	el(
		Button,
		{
			variant: 'primary',
			onClick: () => onChange([...items, addItem])
		},
		labels.add
	)
);

const sectionEdit = ({ attributes, setAttributes, config }) => {
	const blockProps = useBlockProps({ className: `ags-editor-block ags-editor-block--${config.slug}` });
	const items = attributes[config.listKey] || config.defaultItems;

	return el(
		'section',
		blockProps,
		el(InspectorControls, null, el(
			PanelBody,
			{ title: __('Block content', 'agramlabs'), initialOpen: true },
			editableList({
				items,
				labels: config.labels,
				fields: config.fields,
				addItem: config.addItem,
				onChange: (value) => setAttributes({ [config.listKey]: value })
			})
		)),
		el(RichText, {
			tagName: 'h2',
			placeholder: config.headingPlaceholder,
			value: attributes.heading,
			onChange: (heading) => setAttributes({ heading }),
			allowedFormats: []
		}),
		el(
			'div',
			{ className: 'ags-editor-block__preview' },
			items.map((item, index) => el(
				'article',
				{ className: 'ags-editor-card', key: index },
				el('strong', null, item[config.previewTitle] || `${config.labels.item} ${index + 1}`),
				el('p', null, item[config.previewText] || '')
			))
		)
	);
};

registerBlockType('agramlabs/faq', {
	title: __('FAQ Accordion', 'agramlabs'),
	description: __('Structured editable FAQ accordion.', 'agramlabs'),
	category: 'design',
	icon: 'editor-help',
	attributes: {
		heading: { type: 'string', default: 'Frequently asked questions' },
		items: {
			type: 'array',
			default: [
				{ question: 'What can editors change?', answer: 'Editors can update each question and answer from the block sidebar.' },
				{ question: 'Why is this a custom block?', answer: 'FAQ content benefits from a controlled repeatable structure.' }
			]
		}
	},
	edit: (props) => sectionEdit({
		...props,
		config: {
			slug: 'faq',
			listKey: 'items',
			headingPlaceholder: __('FAQ heading', 'agramlabs'),
			labels: { item: __('Question', 'agramlabs'), add: __('Add question', 'agramlabs'), remove: __('Remove question', 'agramlabs') },
			fields: [
				{ key: 'question', label: __('Question', 'agramlabs') },
				{ key: 'answer', label: __('Answer', 'agramlabs'), type: 'textarea' }
			],
			addItem: { question: '', answer: '' },
			defaultItems: [],
			previewTitle: 'question',
			previewText: 'answer'
		}
	}),
	save: () => null
});

registerBlockType('agramlabs/slider', {
	title: __('Swiper Slider', 'agramlabs'),
	description: __('Editable Swiper-powered slide list.', 'agramlabs'),
	category: 'design',
	icon: 'slides',
	attributes: {
		heading: { type: 'string', default: 'Featured slides' },
		slides: {
			type: 'array',
			default: [
				{ title: 'First slide', text: 'Add a concise message for this slide.', imageUrl: '', imageAlt: '' },
				{ title: 'Second slide', text: 'Use this for services, testimonials, or featured content.', imageUrl: '', imageAlt: '' }
			]
		}
	},
	edit: (props) => sectionEdit({
		...props,
		config: {
			slug: 'slider',
			listKey: 'slides',
			headingPlaceholder: __('Slider heading', 'agramlabs'),
			labels: { item: __('Slide', 'agramlabs'), add: __('Add slide', 'agramlabs'), remove: __('Remove slide', 'agramlabs') },
			fields: [
				{ key: 'title', label: __('Title', 'agramlabs') },
				{ key: 'text', label: __('Text', 'agramlabs'), type: 'textarea' },
				{ key: 'imageUrl', label: __('Image URL', 'agramlabs') },
				{ key: 'imageAlt', label: __('Image alt text', 'agramlabs') }
			],
			addItem: { title: '', text: '', imageUrl: '', imageAlt: '' },
			defaultItems: [],
			previewTitle: 'title',
			previewText: 'text'
		}
	}),
	save: () => null
});

registerBlockType('agramlabs/testimonials', {
	title: __('Testimonials', 'agramlabs'),
	description: __('Structured testimonial grid.', 'agramlabs'),
	category: 'design',
	icon: 'format-quote',
	attributes: {
		heading: { type: 'string', default: 'What clients say' },
		items: {
			type: 'array',
			default: [
				{ quote: 'A practical foundation that keeps projects moving.', name: 'Client Name', meta: 'Company / Role' },
				{ quote: 'Clean structure and simple editing controls.', name: 'Client Name', meta: 'Company / Role' }
			]
		}
	},
	edit: (props) => sectionEdit({
		...props,
		config: {
			slug: 'testimonials',
			listKey: 'items',
			headingPlaceholder: __('Testimonials heading', 'agramlabs'),
			labels: { item: __('Testimonial', 'agramlabs'), add: __('Add testimonial', 'agramlabs'), remove: __('Remove testimonial', 'agramlabs') },
			fields: [
				{ key: 'quote', label: __('Quote', 'agramlabs'), type: 'textarea' },
				{ key: 'name', label: __('Name', 'agramlabs') },
				{ key: 'meta', label: __('Role / company', 'agramlabs') }
			],
			addItem: { quote: '', name: '', meta: '' },
			defaultItems: [],
			previewTitle: 'name',
			previewText: 'quote'
		}
	}),
	save: () => null
});

registerBlockType('agramlabs/card-grid', {
	title: __('Card Grid', 'agramlabs'),
	description: __('Controlled reusable card grid.', 'agramlabs'),
	category: 'design',
	icon: 'grid-view',
	attributes: {
		heading: { type: 'string', default: 'Reusable card grid' },
		cards: {
			type: 'array',
			default: [
				{ icon: '01', title: 'Card title', text: 'Short supporting copy for this card.', url: '' },
				{ icon: '02', title: 'Card title', text: 'Short supporting copy for this card.', url: '' }
			]
		}
	},
	edit: (props) => sectionEdit({
		...props,
		config: {
			slug: 'card-grid',
			listKey: 'cards',
			headingPlaceholder: __('Card grid heading', 'agramlabs'),
			labels: { item: __('Card', 'agramlabs'), add: __('Add card', 'agramlabs'), remove: __('Remove card', 'agramlabs') },
			fields: [
				{ key: 'icon', label: __('Icon / label', 'agramlabs') },
				{ key: 'title', label: __('Title', 'agramlabs') },
				{ key: 'text', label: __('Text', 'agramlabs'), type: 'textarea' },
				{ key: 'url', label: __('URL', 'agramlabs') }
			],
			addItem: { icon: '', title: '', text: '', url: '' },
			defaultItems: [],
			previewTitle: 'title',
			previewText: 'text'
		}
	}),
	save: () => null
});

registerBlockType('agramlabs/contact-section', {
	title: __('Contact Section', 'agramlabs'),
	description: __('Editable contact details with a form shortcode slot.', 'agramlabs'),
	category: 'design',
	icon: 'email',
	attributes: {
		heading: { type: 'string', default: 'Start a conversation' },
		text: { type: 'string', default: 'Add contact copy and connect this section to the preferred form plugin.' },
		email: { type: 'string', default: 'hello@example.com' },
		phone: { type: 'string', default: '+1 555 0100' },
		formShortcode: { type: 'string', default: '' }
	},
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps({ className: 'ags-editor-block ags-editor-block--contact' });

		return el(
			'section',
			blockProps,
			el(InspectorControls, null, el(
				PanelBody,
				{ title: __('Contact settings', 'agramlabs'), initialOpen: true },
				el(TextareaControl, {
					label: __('Text', 'agramlabs'),
					value: attributes.text,
					onChange: (text) => setAttributes({ text })
				}),
				el(TextControl, {
					label: __('Email', 'agramlabs'),
					value: attributes.email,
					onChange: (email) => setAttributes({ email })
				}),
				el(TextControl, {
					label: __('Phone', 'agramlabs'),
					value: attributes.phone,
					onChange: (phone) => setAttributes({ phone })
				}),
				el(TextControl, {
					label: __('Form shortcode', 'agramlabs'),
					value: attributes.formShortcode,
					onChange: (formShortcode) => setAttributes({ formShortcode })
				})
			)),
			el(RichText, {
				tagName: 'h2',
				placeholder: __('Contact heading', 'agramlabs'),
				value: attributes.heading,
				onChange: (heading) => setAttributes({ heading }),
				allowedFormats: []
			}),
			el('p', null, attributes.text),
			el('p', null, attributes.email),
			el('p', null, attributes.phone)
		);
	},
	save: () => null
});
