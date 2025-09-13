<?php
/**
 * Block Style Variations (aka Block Styles).
 *
 * @package themeslug
 */

/**
 * Register block style variations.
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 * @link https://developer.wordpress.org/themes/features/block-style-variations/
 * @link https://fullsiteediting.com/lessons/custom-block-styles/
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
