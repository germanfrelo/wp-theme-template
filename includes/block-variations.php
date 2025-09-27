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
 * Unregister Block Variations
 *
 * @link https://developer.wordpress.org/news/2024/07/15-ways-to-curate-the-wordpress-editing-experience/#unregister-block-variations
 */
function themeslug_unregister_block_variations() {
	wp_enqueue_script(
		'themeslug-unregister-block-variations',
		get_theme_file_uri('assets/js/unregister-block-variations.js'),
		['wp-blocks', 'wp-dom-ready'],
		filemtime(get_theme_file_path('assets/js/unregister-block-variations.js')),
		true // Print scripts in the footer. This is required for scripts to work correctly in the Site Editor.
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
	wp_enqueue_script(
		'themeslug-enqueue-block-variations',
		get_theme_file_uri('assets/js/register-block-variations.js'),
		[
			'wp-blocks',
			'wp-dom-ready',
			'wp-i18n',
		],
		filemtime(get_theme_file_path('assets/js/register-block-variations.js')),
		true // Print scripts in the footer. This is required for scripts to work correctly in the Site Editor.
	);
}
add_action('enqueue_block_editor_assets', 'themeslug_enqueue_block_variations');
