/**
 * Block Variations
 *
 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-variations/
 * @link https://developer.wordpress.org/block-editor/reference-guides/packages/packages-blocks/#registerblockvariation
 * @link https://developer.wordpress.org/block-editor/reference-guides/packages/packages-blocks/#unregisterblockvariation
 * @link https://developer.wordpress.org/news/2023/08/an-introduction-to-block-variations/
 * @link https://developer.wordpress.org/news/2024/07/15-ways-to-curate-the-wordpress-editing-experience/#unregister-block-variations
 * @link https://developer.wordpress.org/themes/features/block-variations/
 * @link https://fullsiteediting.com/lessons/block-variation-examples/
 * @link https://fullsiteediting.com/lessons/block-variations/
 */

wp.domReady(() => {
	const { __ } = wp.i18n;

	/**
	 * Unregister Core Block Variations
	 *
	 * Block styles can be unregistered in both PHP and JavaScript.
	 * The PHP method only works for styles registered server-side with 'register_block_style'.
	 *
	 * To disable styles registered with client-side code, which includes those provided by WordPress, you must use JavaScript with 'unregisterBlockStyle'.
	 */

	// wp.blocks.unregisterBlockVariation("blockName", "blockVariationName");

	/**
	 * Register New Block Variations
	 */

	// wp.blocks.registerBlockVariation("originalblockName", {
	// 	name: "blockVariationSlug",
	// 	title: __("blockVariationTitle", "themeslug"),
	// 	description: __("blockVariationDescription", "themeslug"),
	// 	category: "",
	// 	keywords: [],
	// 	icon: "",
	// 	attributes: {},
	// 	supports: {
	// 		html: false,
	// 	},
	// });
});
