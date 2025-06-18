<?php

/**
 * Add custom block category.
 */
add_filter('block_categories_all', function ($categories) {
	return array_merge(
		$categories,
		[
			[
				'slug'  => 'themeslug-blocks',
				'title' => __('themename', 'themeslug'),
			],
		]
	);
});


/**
 * Register blocks.
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_type/
 * @link https://developer.wordpress.org/block-editor/getting-started/fundamentals/registration-of-a-block/
 */
function themeslug_register_blocks() {
	// register_block_type(get_template_directory() . '/build/blocks/______');
}
add_action('init', 'themeslug_register_blocks');
