/**
 * Unregister WordPress default block style variations.
 */
wp.domReady(() => {
	wp.blocks.unregisterBlockStyle("core/button", ["fill"]);
	wp.blocks.unregisterBlockStyle("core/image", ["rounded"]);
	wp.blocks.unregisterBlockStyle("core/quote", ["default", "plain"]);
	wp.blocks.unregisterBlockStyle("core/site-logo", ["rounded"]);
});
