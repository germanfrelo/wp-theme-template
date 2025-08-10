<?php

/**
 * Enqueue block variations.
 *
 * @link https://developer.wordpress.org/themes/features/block-variations/
 * @link https://developer.wordpress.org/news/2023/08/an-introduction-to-block-variations/
 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-variations/
 * @link https://fullsiteediting.com/lessons/block-variation-examples/
 *
 * @return void
 */
function themeslug_enqueue_block_variations() {
	wp_enqueue_script(
		'themeslug-register-wp-block-variations',
		get_theme_file_uri('assets/js/register-wp-block-variations.js'),
		[
			'wp-blocks',
			'wp-dom-ready',
			'wp-i18n'
		],
		wp_get_theme()->get('Version'),
		false
	);
}
add_action('enqueue_block_editor_assets', 'themeslug_enqueue_block_variations');
