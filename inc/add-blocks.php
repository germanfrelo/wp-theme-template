<?php
/**
 * Register blocks.
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_type/
 * @link https://developer.wordpress.org/block-editor/getting-started/fundamentals/registration-of-a-block/
 */

/**
 * Product category filter.
 */
function ifiseducacion_register_blocks() {
	$block_path = get_template_directory() . '/src/blocks/product-filter';

	register_block_type( "$block_path/block.json" );
}
add_action( 'init', 'ifiseducacion_register_blocks' );
