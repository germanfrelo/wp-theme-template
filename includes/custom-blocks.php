<?php
/**
 * Register custom blocks and block categories
 *
 * @link https://developer.wordpress.org/block-editor/getting-started/fundamentals/registration-of-a-block/
 * @link https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#managing-block-categories
 * @link https://developer.wordpress.org/reference/hooks/block_categories_all/
 *
 * @package themeslug
 */

/**
 * Add custom block categories.
 */
function themeslug_register_block_categories($categories) {
	return array_merge($categories, [
		[
			"slug" => "themeslug-blocks",
			"title" => __("themename", "themeslug"),
		],
	]);
}
add_filter("block_categories_all", "themeslug_register_block_categories");

/**
 * Enqueue custom block types.
 */
function themeslug_enqueue_blocks() {
	// register_block_type(get_template_directory() . '/dist/blocks/______');
}
add_action("init", "themeslug_enqueue_blocks");
