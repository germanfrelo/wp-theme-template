<?php
/**
 * Enqueue editor scripts.
 *
 * @link https://developer.wordpress.org/block-editor/how-to-guides/enqueueing-assets-in-the-editor/#editor-scripts-and-styles
 * @link https://developer.wordpress.org/reference/hooks/enqueue_block_editor_assets/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#editor-javascript
 *
 * @package themeslug
 */
function themeslug_enqueue_editor_scripts() {
	$editor_scripts_dir = THEMESLUG_EDITOR_JS_DIR;

	// List of the JS files (filenames only, located under $editor_scripts_dir).
	$files = [
		'block-variations.js',
		'block-style-variations.js',
	];

	// Editor script dependencies:
	// 'wp-blocks'     - Block registration and block-related JS APIs used by block variations.
	// 'wp-dom-ready'  - Ensures editor DOM is ready before running DOM-dependent initialization.
	// 'wp-edit-post'  - Exposes editor UI APIs (plugins, panels) that some editor scripts may use.
	// 'wp-i18n'       - Provides JS translation functions (wp.i18n.__) used in scripts.
	$deps = [
		'wp-blocks',
		'wp-dom-ready',
		'wp-edit-post',
		'wp-i18n',
	];

	themeslug_enqueue_scripts(
		[
			'files_dir' => $editor_scripts_dir,
			'files'     => $files,
			'deps'      => $deps,
			'in_footer' => true,
		]
	);
}
add_action( 'enqueue_block_editor_assets', 'themeslug_enqueue_editor_scripts' );
