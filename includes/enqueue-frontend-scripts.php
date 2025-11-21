<?php
/**
 * Enqueue JavaScript files on the front end of the website.
 *
 * @link https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#including-javascript
 *
 * @package themeslug
 */
function themeslug_enqueue_frontend_scripts() {
	$frontend_scripts_dir = THEMESLUG_FRONTEND_JS_DIR;

	// List of the JS files (filenames only, located under $frontend_scripts_dir).
	$files = [
		// Add files here when needed.
	];

	$deps = [];

	themeslug_enqueue_scripts(
		[
			'files_dir' => $frontend_scripts_dir,
			'files'     => $files,
			'deps'      => $deps,
			'in_footer' => false,
			'add_defer' => true, // defer by default for frontend scripts
		]
	);
}
add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_frontend_scripts' );
