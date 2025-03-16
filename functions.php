<?php

/* =============================================================================================
❗️ IMPORTANT:
Replace all instances of the word 'themeslug' with your actual theme slug. Then remove this message.
============================================================================================= */

/**
 * Theme's functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/core-concepts/custom-functionality/
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */


/**
 * Enqueues custom stylesheets on the front end of the website.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#front-end-stylesheets
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

	// WooCommerce custom stylesheet.
	wp_register_style('themeslug-woocommerce', get_parent_theme_file_uri('assets/css/woocommerce.css'));
	if (class_exists('woocommerce')) {
		wp_enqueue_style('themeslug-woocommerce');
	}

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
 * WooCommerce - Dequeues default stylesheets on the front end.
 * Path of stylesheets: 'wp-content/plugins/woocommerce/assets/css/'
 *
 * @link https://woocommerce.com/document/disable-the-default-stylesheet/
 * @see wp-content/plugins/woocommerce/includes/class-wc-frontend-scripts.php
 */
function themeslug_dequeue_wooocommerce_styles($enqueue_styles) {
	// unset($enqueue_styles['woocommerce-blocktheme']);
	// unset($enqueue_styles['woocommerce-general']);
	// unset($enqueue_styles['woocommerce-layout']);
	// unset($enqueue_styles['woocommerce-smallscreen']);

	return $enqueue_styles;
}
add_filter('woocommerce_enqueue_styles', 'themeslug_dequeue_wooocommerce_styles');


/**
 * WooCommerce - Dequeues default blocks stylesheets on the front end.
 *
 * Inspect your site's source code <head> to find the exact handles of the styles.
 */
function themeslug_dequeue_woocommerce_blocks_styles() {
	// wp_dequeue_style('wc-blocks-style');
}
add_action('wp_enqueue_scripts', 'themeslug_dequeue_woocommerce_blocks_styles', 100);


/**
 * Enqueues custom stylesheets in the Editor.
 *
 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#editor-stylesheets
 *
 * @return void
 */
function themeslug_editor_styles() {
	add_editor_style(array(
		// Additional stylesheets.
		get_parent_theme_file_uri('assets/css/base.css'),
		get_parent_theme_file_uri('assets/css/layouts.css'),
		get_parent_theme_file_uri('assets/css/utility-classes.css'),
		get_parent_theme_file_uri('assets/css/gravity-forms.css'),
		// Active theme's style.css.
		get_stylesheet_uri()
	));
}
add_action('after_setup_theme', 'themeslug_editor_styles');


/**
 * Enqueues a stylesheet for each block (on the front end and in the editor), if it exists in the theme.
 *
 * @link https://developer.wordpress.org/block-editor/how-to-guides/enqueueing-assets-in-the-editor/#theme-scripts-and-styles
 * @link https://developer.wordpress.org/themes/features/block-stylesheets/
 * @link https://developer.wordpress.org/news/2022/12/07/leveraging-theme-json-and-per-block-styles-for-more-performant-themes/
 * @link https://markwilkinson.dev/code-snippets/enqueue-stylesheet-for-any-wordpress-block/
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_block_style/
 *
 * @return void
 */
function themeslug_block_stylesheets() {
	// Gets all of the registered blocks
	$blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();

	// If we have block names
	if (!empty($blocks)) {
		// Loop through each block and enqueue its styles
		foreach ($blocks as $block) {
			// Replaces slash with hyphen for filename
			$block_slug = str_replace('/', '-', $block->name);

			// Relative path of each block stylesheet
			$block_path = "assets/css/blocks/{$block_slug}.css";

			// If we have no file existing for this block, continue
			if (!file_exists(get_theme_file_path($block_path))) {
				continue;
			}

			// Enqueues the block stylesheet
			wp_enqueue_block_style(
				$block->name,
				[
					'handle' => "themeslug-{$block_slug}",
					'src'    => get_theme_file_uri($block_path),
					'path'   => get_theme_file_path($block_path)
				]
			);
		}
	}
}
add_action('init', 'themeslug_block_stylesheets');


/**
 * Registers custom block style variations.
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 * @link https://developer.wordpress.org/themes/features/block-style-variations/
 *
 * @return void
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
 * WooCommerce - Declares theme support.
 *
 * @link https://developer.woocommerce.com/docs/template-structure-overriding-templates-via-a-theme/
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function themeslug_add_woocommerce_support() {
	add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'themeslug_add_woocommerce_support');


/**
 * WooCommerce - Hides the Cart Link's text visually.
 *
 * This function uses the 'render_block' filter to intercept the rendering of all blocks.
 * It specifically targets the 'woocommerce/cart-link' block and adds a 'visually-hidden'
 * class to the span element containing the cart text, making it accessible to screen readers but
 * visually hidden.
 *
 * @param string $block_content The HTML content of the rendered block.
 * @param array  $block         An array containing information about the block (blockName, attributes, etc.).
 *
 * @return string The modified HTML content of the block.
 */
function themeslug_modify_cart_link_block($block_content, $block) {
	if ('woocommerce/cart-link' === $block['blockName']) {
		// Finds the span with class 'wc-block-cart-link__text' and add 'visually-hidden'.
		$block_content = preg_replace(
			'/(<span class="wc-block-cart-link__text">)/',
			'$1<span class="visually-hidden">',
			$block_content
		);
		// Ensures the closing 'span' is also correct.
		$block_content = str_replace('<span class="wc-block-cart-link__text"><span class="visually-hidden">', '<span class="wc-block-cart-link__text visually-hidden">', $block_content);

	}
	return $block_content;
}
add_filter('render_block', 'themeslug_modify_cart_link_block', 10, 2);
