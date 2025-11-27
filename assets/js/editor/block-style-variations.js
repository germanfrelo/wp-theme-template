/**
 * Block Style Variations (Block Styles, for short)
 *
 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-styles/
 * @link https://developer.wordpress.org/block-editor/reference-guides/packages/packages-blocks/#registerblockstyle
 * @link https://developer.wordpress.org/block-editor/reference-guides/packages/packages-blocks/#unregisterblockstyle
 * @link https://developer.wordpress.org/news/2024/07/15-ways-to-curate-the-wordpress-editing-experience/#unregister-block-styles
 * @link https://developer.wordpress.org/themes/features/block-style-variations/
 */

wp.domReady(() => {
	const { __ } = wp.i18n;

	/**
	 * Unregister Core Block Style Variations
	 *
	 * Block styles can be unregistered in both PHP and JavaScript.
	 * The PHP method only works for styles registered server-side with 'register_block_style'.
	 *
	 * To disable styles registered with client-side code, which includes those provided by WordPress, you must use JavaScript with 'unregisterBlockStyle'.
	 */
	wp.blocks.unregisterBlockStyle("core/button", "default");
	wp.blocks.unregisterBlockStyle("core/button", "fill");
	wp.blocks.unregisterBlockStyle("core/button", "outline");
	wp.blocks.unregisterBlockStyle("core/image", "default");
	wp.blocks.unregisterBlockStyle("core/image", "rounded");
	wp.blocks.unregisterBlockStyle("core/quote", "default");
	wp.blocks.unregisterBlockStyle("core/quote", "plain");
	wp.blocks.unregisterBlockStyle("core/site-logo", "default");
	wp.blocks.unregisterBlockStyle("core/site-logo", "rounded");
	wp.blocks.unregisterBlockStyle("core/separator", "default");
	wp.blocks.unregisterBlockStyle("core/separator", "dots");
	wp.blocks.unregisterBlockStyle("core/separator", "wide");
	wp.blocks.unregisterBlockStyle("core/social-links", "default");
	wp.blocks.unregisterBlockStyle("core/social-links", "logos-only");
	wp.blocks.unregisterBlockStyle("core/social-links", "pill-shape");
	/*
	 * The following are the remaining core block style variations.
	 * They are intentionally left registered. To unregister them, just uncomment them.
	 */
	// wp.blocks.unregisterBlockStyle("core/table", "default");
	// wp.blocks.unregisterBlockStyle("core/table", "stripes");
	// wp.blocks.unregisterBlockStyle("core/tag-cloud", "default");
	// wp.blocks.unregisterBlockStyle("core/tag-cloud", "outline");

	/**
	 * Register New Block Style Variations
	 */

	wp.blocks.registerBlockStyle("core/button", {
		name: "button-default",
		label: __("Relleno", "themeslug"),
		isDefault: true,
	});

	wp.blocks.registerBlockStyle("core/button", {
		name: "button-inverse",
		label: __("Inverso", "themeslug"),
	});

	wp.blocks.registerBlockStyle("core/button", {
		name: "button-outlined",
		label: __("Contorno", "themeslug"),
	});

	wp.blocks.registerBlockStyle("core/button", {
		name: "button-ghost",
		label: __("Sin relleno", "themeslug"),
	});

	wp.blocks.registerBlockStyle("core/details", {
		name: "browser-default",
		label: __("Sin estilos", "themeslug"),
	});

	wp.blocks.registerBlockStyle("core/heading", {
		name: "heading-eyebrow",
		label: __("Antetítulo", "themeslug"),
	});

	wp.blocks.registerBlockStyle("core/list", {
		name: "list-custom-marker",
		label: __("Marcador personalizado", "themeslug"),
	});

	wp.blocks.registerBlockStyle("core/navigation-link", {
		name: "navigation-link-external",
		label: __("Link externo", "themeslug"),
	});

	wp.blocks.registerBlockStyle("core/navigation", {
		name: "navigation-tabs",
		label: __("Subcategorías", "themeslug"),
	});

	wp.blocks.registerBlockStyle("core/page-list", {
		name: "navigation-tabs",
		label: __("Subcategorías", "themeslug"),
	});

	wp.blocks.registerBlockStyle("core/search", {
		name: "search-reversed-direction",
		label: __("Dir. inversa", "themeslug"),
	});
});
