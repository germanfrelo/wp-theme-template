/**
 * Unregister WordPress default block style variations.
 * List: https://developer.wordpress.org/themes/features/block-style-variations/
 */
wp.domReady(() => {
	wp.blocks.unregisterBlockStyle("core/button", ["fill", "outline"]);
	wp.blocks.unregisterBlockStyle("core/image", ["rounded"]);
});
