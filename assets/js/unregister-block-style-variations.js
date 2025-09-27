/**
 * Unregister Block Style Variations (Block Styles, for short)
 */

wp.domReady(() => {
	wp.blocks.unregisterBlockStyle("core/button", ["fill", "outline"]);
	wp.blocks.unregisterBlockStyle("core/image", ["rounded"]);
	wp.blocks.unregisterBlockStyle("core/quote", ["default", "plain"]);
	wp.blocks.unregisterBlockStyle("core/site-logo", ["rounded"]);
	wp.blocks.unregisterBlockStyle("core/separator", ["wide"]);
});
