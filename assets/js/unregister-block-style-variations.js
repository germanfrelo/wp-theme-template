/**
 * Unregister Block Style Variations (Block Styles, for short)
 *
 * @link https://developer.wordpress.org/block-editor/reference-guides/packages/packages-blocks/#unregisterblockstyle
 */

wp.domReady(() => {
	wp.blocks.unregisterBlockStyle("core/button", ["fill", "outline"]);
	wp.blocks.unregisterBlockStyle("core/image", ["rounded"]);
	wp.blocks.unregisterBlockStyle("core/quote", ["default", "plain"]);
	wp.blocks.unregisterBlockStyle("core/site-logo", ["rounded"]);
	wp.blocks.unregisterBlockStyle("core/separator", ["wide"]);
});
