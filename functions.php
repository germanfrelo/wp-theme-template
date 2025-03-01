<?php

/* =============================================================================================
❗️ IMPORTANT:
Replace all instances of the word 'themeslug' with your theme name. Then remove this message.
============================================================================================= */

/**
 * Theme's functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @link https://developer.wordpress.org/themes/core-concepts/custom-functionality/
 */


/**
 * Enqueues custom stylesheets on the front end.
 *
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#front-end-stylesheets
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 *
 * @return void
 */
function themeslug_enqueue_styles() {
	// Additional stylesheets.
	wp_enqueue_style(
		'themeslug-base',
		get_parent_theme_file_uri('assets/css/base.css'),
		array(),
		wp_get_theme()->get('Version')
	);
	wp_enqueue_style(
		'themeslug-layouts',
		get_parent_theme_file_uri('assets/css/layouts.css'),
		array(),
		wp_get_theme()->get('Version')
	);
	wp_enqueue_style(
		'themeslug-utility-classes',
		get_parent_theme_file_uri('assets/css/utility-classes.css'),
		array(),
		wp_get_theme()->get('Version')
	);
	wp_enqueue_style(
		'themeslug-gravity-forms',
		get_parent_theme_file_uri('assets/css/gravity-forms.css'),
		array(),
		wp_get_theme()->get('Version')
	);

	// Active theme's style.css.
	wp_enqueue_style(
		'themeslug-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get('Version')
	);
}
add_action('wp_enqueue_scripts', 'themeslug_enqueue_styles');


/**
 * Enqueues custom stylesheets in the editor.
 *
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#editor-stylesheets
 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
 *
 * @return void
 */
function themeslug_editor_styles() {
	add_editor_style(array(
		// Additional stylesheets.
		get_parent_theme_file_uri('assets/css/base.css'),
		get_parent_theme_file_uri('assets/css/layouts.css'),
		get_parent_theme_file_uri('assets/css/utilit-classes.css'),
		get_parent_theme_file_uri('assets/css/gravity-forms.css'),
		// Active theme's style.css.
		get_stylesheet_uri()
	));
}
add_action('after_setup_theme', 'themeslug_editor_styles');


/**
 * Registers custom block style variations.
 *
 * @link https://developer.wordpress.org/themes/features/block-style-variations/
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 */
function themeslug_block_style_variations() {
	// register_block_style(
	// 	'core/_____',
	// 	array(
	// 		'name'         => '__________',
	// 		'label'        => __('__________', 'themeslug'),
	// 	)
	// );
}
add_action('init', 'themeslug_block_style_variations');


/**
 * Enqueues custom block stylesheets (on the front end and in the editor).
 *
 * @link https://developer.wordpress.org/block-editor/how-to-guides/enqueueing-assets-in-the-editor/#theme-scripts-and-styles
 * @link https://developer.wordpress.org/themes/features/block-stylesheets/
 * @link https://developer.wordpress.org/news/2022/12/07/leveraging-theme-json-and-per-block-styles-for-more-performant-themes/
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_block_style/
 *
 * @return void
 */
function themeslug_block_stylesheets() {
	// Adds the block name (with namespace prefix) for each style.
	$blocks = [
		'core/button',
		'core/navigation',
		'core/query-pagination',
		'core/site-logo',
	];

	// Loops through each block and enqueues its styles.
	foreach ($blocks as $block) {
		// Replaces slash with hyphen for filename.
		$block_slug = str_replace('/', '-', $block);

		// Relative path of block stylesheets.
		$blocks_path = "assets/css/blocks/{$block_slug}.css";

		wp_enqueue_block_style($block, array(
			'handle' => "themeslug-{$block_slug}",
			'src'    => get_theme_file_uri($blocks_path),
			'path'   => get_theme_file_path($blocks_path)
		));
	}
}
add_action('init', 'themeslug_block_stylesheets');
