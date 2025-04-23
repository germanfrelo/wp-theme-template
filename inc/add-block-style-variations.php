<?php
/**
 * Block Style Variations (aka Block Styles).
 */

/**
 * Register block style variations.
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 * @link https://developer.wordpress.org/themes/features/block-style-variations/
 *
 * @return void
 */
function ifiseducacion_register_block_style_variations() {
	register_block_style(
		array( 'core/button', 'core/read-more' ),
		array(
			'name'         => 'default-inverted',
			'label'        => __( 'Invertido', 'ifiseducacion' )
			// Styles are in the style.css file
		)
	);
	register_block_style(
		array( 'core/button', 'core/read-more' ),
		array(
			'name'         => 'plain-text',
			'label'        => __( 'Simple', 'ifiseducacion' )
			// Styles are in the style.css file
		)
	);
	register_block_style(
		array( 'core/button', 'core/read-more' ),
		array(
			'name'         => 'plain-text-underlined',
			'label'        => __( 'Simple subrayado', 'ifiseducacion' )
			// Styles are in the style.css file
		)
	);
	register_block_style(
		'core/cover',
		array(
			'name'         => 'custom',
			'label'        => __( 'Custom', 'ifiseducacion' )
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/details',
		array(
			'name'         => 'icon-chevron',
			'label'        => __( 'Icons Chevron', 'ifiseducacion' )
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/details',
		array(
			'name'         => 'icon-plus-minus',
			'label'        => __( 'Icons Plus Minus', 'ifiseducacion' )
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'         => 'card',
			'label'        => __( 'Card', 'ifiseducacion' )
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'         => 'switcher-2',
			'label'        => __( 'Columns: from 2 to 1', 'ifiseducacion' )
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'         => 'switcher-3',
			'label'        => __( 'Columns: from 3 to 1', 'ifiseducacion' )
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'         => 'switcher-4',
			'label'        => __( 'Columns: from 4 to 1', 'ifiseducacion' )
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'         => 'grid-2',
			'label'        => __( 'Grid: 2 items', 'ifiseducacion' )
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'         => 'grid-3',
			'label'        => __( 'Grid: 3 items', 'ifiseducacion' )
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/list',
		array(
			'name'         => 'checkmark',
			'label'        => __( 'Checkmark', 'ifiseducacion' )
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/media-text',
		array(
			'name'         => 'stacked-on-mobile-text-before',
			'label'        => __( 'Mobile: Text before', 'ifiseducacion' )
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/navigation',
		array(
			'name'         => 'tabs',
			'label'        => __( 'Tabs', 'ifiseducacion' )
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/navigation-link',
		array(
			'name'         => 'external',
			'label'        => __( 'External', 'ifiseducacion' )
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/read-more',
		array(
			'name'         => 'outline',
			'label'        => __( 'Contorno', 'ifiseducacion' )
			// Styles are in the style.css file
		)
	);
	register_block_style(
		'core/search',
		array(
			'name'         => 'direction-reversed',
			'label'        => __( 'Reversed direction', 'ifiseducacion' )
			// Styles are in the block's stylesheet file
		)
	);
	register_block_style(
		'core/separator',
		array(
			'name'         => 'custom',
			'label'        => __( 'Personalizado', 'ifiseducacion' )
			// Styles are in the block's stylesheet file
		)
	);
}
add_action( 'init', 'ifiseducacion_register_block_style_variations' );
