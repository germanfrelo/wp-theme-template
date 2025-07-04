/**
 * Unregister core block styles.
 */
wp.domReady(() => {
	wp.blocks.unregisterBlockStyle("core/button", ["outline"]);
});
