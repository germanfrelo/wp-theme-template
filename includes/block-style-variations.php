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
	// Reuse the helper function from block-variations.php
	if ( function_exists( 'themeslug_enqueue_block_editor_script' ) ) {
		themeslug_enqueue_block_editor_script(
			'themeslug-unregister-block-style-variations',
			'unregister-block-style-variations.js',
			[ 'wp-blocks', 'wp-dom-ready' ]
		);
	}
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
	// Configuration array to reduce duplication
	$block_styles = [
		[
			'blocks' => [ 'core/heading', 'core/post-title' ],
			'name'   => 'eyebrow',
			'label'  => __( 'Antetítulo', 'themeslug' ),
		],
		[
			'blocks' => [ 'core/list' ],
			'name'   => 'unordered-checkmark',
			'label'  => __( 'Sin ordenar con checkmarks', 'themeslug' ),
		],
		[
			'blocks' => [ 'core/list' ],
			'name'   => 'ordered-custom',
			'label'  => __( 'Ordenada personalizada', 'themeslug' ),
		],
		[
			'blocks' => [ 'core/navigation-link' ],
			'name'   => 'external',
			'label'  => __( 'Enlace externo', 'themeslug' ),
		],
		[
			'blocks' => [ 'core/search' ],
			'name'   => 'direction-reversed',
			'label'  => __( 'Dirección inversa', 'themeslug' ),
		],
	];

	// Register each block style
	foreach ( $block_styles as $style ) {
		register_block_style(
			$style['blocks'],
			[
				'name'  => $style['name'],
				'label' => $style['label'],
			]
		);
	}
}
add_action( 'init', 'themeslug_register_block_style_variations' );
