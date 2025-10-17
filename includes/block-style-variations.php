<?php
/**
 * Block Style Variations (Block Styles, for short)
 *
 * @link https://developer.wordpress.org/themes/features/block-style-variations/
 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-styles/
 *
 * @package themeslug
 */


/**
 * Unregister Block Style Variations
 *
 * Block styles can be unregistered in both PHP and JavaScript.
 * The PHP method only works for styles registered server-side with 'register_block_style'.
 * To disable styles registered with client-side code, which includes those provided by WordPress, you must use JavaScript with 'unregisterBlockStyle'.
 *
 * @link https://developer.wordpress.org/news/2024/07/15-ways-to-curate-the-wordpress-editing-experience/#unregister-block-styles
 * @link https://developer.wordpress.org/reference/hooks/enqueue_block_editor_assets/
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 */
function themeslug_unregister_block_style_variations() {
	wp_enqueue_script(
		'themeslug-unregister-block-style-variations',
		get_theme_file_uri('assets/js/unregister-block-style-variations.js'),
		['wp-blocks', 'wp-dom-ready'],
		filemtime(get_theme_file_path('assets/js/unregister-block-style-variations.js')),
		true // Print scripts in the footer. This is required for scripts to work correctly in the Site Editor.
	);
}
add_action('enqueue_block_editor_assets', 'themeslug_unregister_block_style_variations');


/**
 * Register Block Style Variations
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 *
 * @return void
 */
function themeslug_register_block_style_variations() {
	register_block_style(
		[
			'core/details'
		],
		[
			'name'  => 'custom',
			'label' => __( 'Personalizado', 'themeslug' )
		]
	);

	register_block_style(
		[
			'core/heading',
			'core/post-title'
		],
		[
			'name'  => 'eyebrow',
			'label' => __( 'Antetítulo', 'themeslug' )
		]
	);

	register_block_style(
		[
			'core/list'
		],
		[
			'name'  => 'unordered-checkmark',
			'label' => __( 'Sin ordenar con checkmarks', 'themeslug' )
		]
	);

	register_block_style(
		[
			'core/list'
		],
		[
			'name'  => 'ordered-custom',
			'label' => __( 'Ordenada personalizada', 'themeslug' )
		]
	);

	register_block_style(
		[
			'core/navigation-link'
		],
		[
			'name'  => 'external',
			'label' => __( 'Enlace externo', 'themeslug' )
		]
	);

	register_block_style(
		[
			'core/search'
		],
		[
			'name'  => 'direction-reversed',
			'label' => __( 'Dirección inversa', 'themeslug' )
		]
	);
}
add_action( 'init', 'themeslug_register_block_style_variations' );
