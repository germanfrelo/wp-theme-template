<?php
/**
 * Block Style Variations (Block Styles, for short)
 *
 * @link https://developer.wordpress.org/themes/features/block-style-variations/
 *
 * @package themeslug
 */


/**
 * Unregister block style variations.
 *
 * Block styles can be unregistered in PHP ('unregister_block_style') or JavaScript ('unregisterBlockStyle').
 * The PHP method only works for styles registered server-side.
 * Core WordPress block styles are registered client-side using JavaScript.
 * Therefore, to unregister core block styles, the JavaScript 'unregisterBlockStyle' function must be used.
 *
 * @link https://developer.wordpress.org/reference/hooks/enqueue_block_editor_assets/
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 */
function themeslug_enqueue_unregister_block_style_variations_script() {
	wp_enqueue_script(
		'themeslug-unregister-block-style-variations',
		get_template_directory_uri() . '/assets/js/unregister-block-style-variations.js',
		['wp-blocks', 'wp-dom-ready'],
		filemtime(get_template_directory() . '/assets/js/unregister-block-style-variations.js'),
		true // Print scripts in the footer. This is required for scripts to work correctly in the Site Editor.
	);
}
add_action('enqueue_block_editor_assets', 'themeslug_enqueue_unregister_block_style_variations_script');


/**
 * Register block style variations.
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 *
 * @return void
 */
function themeslug_register_block_style_variations() {
	register_block_style(
		[
			'core/button',
			'core/read-more'
		],
		[
			'name'  => 'outlined',
			'label' => __( 'Outlined', 'themeslug' )
		]
	);

	register_block_style(
		[
			'core/button',
			'core/read-more'
		],
		[
			'name'  => 'plain',
			'label' => __( 'Plain', 'themeslug' )
		]
	);

	register_block_style(
		[
			'core/details'
		],
		[
			'name'  => 'custom',
			'label' => __( 'Custom', 'themeslug' )
		]
	);

	register_block_style(
		[
			'core/list'
		],
		[
			'name'  => 'unordered-checkmark',
			'label' => __( 'Unordered Checkmark', 'themeslug' )
		]
	);

	register_block_style(
		[
			'core/list'
		],
		[
			'name'  => 'ordered-custom',
			'label' => __( 'Ordered Custom', 'themeslug' )
		]
	);

	register_block_style(
		[
			'core/navigation-link'
		],
		[
			'name'  => 'external',
			'label' => __( 'External', 'themeslug' )
		]
	);

	register_block_style(
		[
			'core/search'
		],
		[
			'name'  => 'direction-reversed',
			'label' => __( 'Reversed direction', 'themeslug' )
		]
	);
}
add_action( 'init', 'themeslug_register_block_style_variations' );
