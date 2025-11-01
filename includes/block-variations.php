<?php
/**
 * Block Variations
 *
 * @link https://developer.wordpress.org/themes/features/block-variations/
 * @link https://developer.wordpress.org/news/2023/08/an-introduction-to-block-variations/
 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-variations/
 * @link https://fullsiteediting.com/lessons/block-variations/
 * @link https://fullsiteediting.com/lessons/block-variation-examples/
 *
 * @package themeslug
 */


/**
 * Enqueue a block editor script.
 *
 * Helper function to reduce duplication when enqueuing block editor scripts.
 *
 * @param string $handle Script handle.
 * @param string $filename Script filename (relative to assets/js/).
 * @param array  $dependencies Script dependencies.
 * @return void
 */
function themeslug_enqueue_block_editor_script( $handle, $filename, $dependencies = [] ) {
	wp_enqueue_script(
		$handle,
		get_theme_file_uri( "assets/js/{$filename}" ),
		$dependencies,
		filemtime( get_theme_file_path( "assets/js/{$filename}" ) ),
		true // Print scripts in the footer. This is required for scripts to work correctly in the Site Editor.
	);
}


/**
 * Unregister Block Variations
 *
 * @link https://developer.wordpress.org/news/2024/07/15-ways-to-curate-the-wordpress-editing-experience/#unregister-block-variations
 */
function themeslug_unregister_block_variations() {
	themeslug_enqueue_block_editor_script(
		'themeslug-unregister-block-variations',
		'unregister-block-variations.js',
		[ 'wp-blocks', 'wp-dom-ready' ]
	);
}
add_action('enqueue_block_editor_assets', 'themeslug_unregister_block_variations');


/**
 * Enqueue Block Variations
 *
 * Enqueues the script for registering block variations.
 *
 * @return void
 */
function themeslug_enqueue_block_variations() {
	themeslug_enqueue_block_editor_script(
		'themeslug-enqueue-block-variations',
		'register-block-variations.js',
		[ 'wp-blocks', 'wp-dom-ready', 'wp-i18n' ]
	);
}
add_action('enqueue_block_editor_assets', 'themeslug_enqueue_block_variations');
