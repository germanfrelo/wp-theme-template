<?php
/**
 * Block Style Variations (aka Block Styles).
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
		'core/button',
		array(
			'name'  => 'default-inverted',
			'label' => __( 'Default Inverted', 'themeslug' )
		)
	);
	register_block_style(
		'core/button',
		array(
			'name'  => 'plain-text',
			'label' => __( 'Plain Text', 'themeslug' )
		)
	);
	register_block_style(
		'core/button',
		array(
			'name'  => 'plain-text-underlined',
			'label' => __( 'Plain Text Underlined', 'themeslug' )
		)
	);
	register_block_style(
		'core/cover',
		array(
			'name'  => 'custom',
			'label' => __( 'Custom', 'themeslug' )
		)
	);
	register_block_style(
		'core/details',
		array(
			'name'  => 'custom',
			'label' => __( 'Custom', 'themeslug' )
		)
	);
	register_block_style(
		'core/list',
		array(
			'name'  => 'checkmark',
			'label' => __( 'Checkmark', 'themeslug' )
		)
	);
	register_block_style(
		'core/navigation',
		array(
			'name'  => 'tabs',
			'label' => __( 'Tabs', 'themeslug' )
		)
	);
	register_block_style(
		'core/navigation-link',
		array(
			'name'  => 'external',
			'label' => __( 'External', 'themeslug' )
		)
	);
	register_block_style(
		'core/search',
		array(
			'name'  => 'direction-reversed',
			'label' => __( 'Reversed direction', 'themeslug' )
		)
	);
	register_block_style(
		'core/separator',
		array(
			'name'  => 'thin',
			'label' => __( 'Thin', 'themeslug' )
		)
	);
	register_block_style(
		'core/separator',
		array(
			'name'  => 'thick',
			'label' => __( 'Thick', 'themeslug' )
		)
	);
	register_block_style(
		'core/social-links',
		array(
			'name'  => 'custom',
			'label' => __( 'Custom', 'themeslug' )
		)
	);
}
add_action( 'init', 'themeslug_register_block_style_variations' );
