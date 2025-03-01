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
 * Gets the paths of some stylesheets.
 *
 * @return array An array of stylesheets URIs.
 */
function themeslug_get_stylesheets_paths() {
	return array(
		// Additional stylesheets.
		get_parent_theme_file_uri('assets/css/base.css'),
		get_parent_theme_file_uri('assets/css/layouts.css'),
		get_parent_theme_file_uri('assets/css/utility-classes.css'),
		get_parent_theme_file_uri('assets/css/gravity-forms.css'),
		// Active theme's style.css.
		get_stylesheet_uri()
	);
}


/**
 * Enqueues custom stylesheets on the front end of the website.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#front-end-stylesheets
 *
 * @return void
 */
function themeslug_enqueue_styles() {
	$css_paths = themeslug_get_stylesheets_paths();

	foreach ($css_paths as $path) {
		wp_enqueue_style(
			md5($path),
			$path,
			array(),
			wp_get_theme()->get('Version')
		);
	}
}
add_action('wp_enqueue_scripts', 'themeslug_enqueue_styles');


/**
 * Enqueues custom stylesheets in the Editor.
 *
 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#editor-stylesheets
 *
 * @return void
 */
function themeslug_editor_styles() {
	add_editor_style(themeslug_get_stylesheets_paths());
}
add_action('after_setup_theme', 'themeslug_editor_styles');


/**
 * Enqueues custom block stylesheets (on the front end and in the Editor).
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_block_style/
 * @link https://developer.wordpress.org/themes/features/block-stylesheets/
 *
 * @return void
 */
function themeslug_block_stylesheets() {
	// Adds the block name (with namespace prefix) for each style.
	$blocks = [
		"core/archives",
		"core/audio",
		"core/avatar",
		"core/button",
		"core/buttons",
		"core/calendar",
		"core/categories",
		"core/code",
		"core/column",
		"core/columns",
		"core/comment-author-name",
		"core/comment-content",
		"core/comment-date",
		"core/comment-edit-link",
		"core/comment-reply-link",
		"core/comment-template",
		"core/comments",
		"core/comments-pagination",
		"core/comments-pagination-next",
		"core/comments-pagination-numbers",
		"core/comments-pagination-previous",
		"core/comments-title",
		"core/cover",
		"core/details",
		"core/embed",
		"core/file",
		"core/gallery",
		"core/group",
		"core/heading",
		"core/home-link",
		"core/html",
		"core/image",
		"core/latest-comments",
		"core/latest-posts",
		"core/list",
		"core/list-item",
		"core/loginout",
		"core/media-text",
		"core/more",
		"core/navigation",
		"core/navigation-link",
		"core/navigation-submenu",
		"core/nextpage",
		"core/page-list",
		"core/page-list-item",
		"core/paragraph",
		"core/post-author",
		"core/post-author-biography",
		"core/post-author-name",
		"core/post-comments-count",
		"core/post-comments-form",
		"core/post-comments-link",
		"core/post-content",
		"core/post-date",
		"core/post-excerpt",
		"core/post-featured-image",
		"core/post-navigation-link",
		"core/post-template",
		"core/post-terms",
		"core/post-time-to-read",
		"core/post-title",
		"core/preformatted",
		"core/pullquote",
		"core/query",
		"core/query-no-results",
		"core/query-pagination",
		"core/query-pagination-next",
		"core/query-pagination-numbers",
		"core/query-pagination-previous",
		"core/query-title",
		"core/query-total",
		"core/quote",
		"core/read-more",
		"core/rss",
		"core/search",
		"core/separator",
		"core/shortcode",
		"core/site-logo",
		"core/site-tagline",
		"core/site-title",
		"core/social-link",
		"core/social-links",
		"core/spacer",
		"core/table",
		"core/table-of-contents",
		"core/tag-cloud",
		"core/template-part",
		"core/term-description",
		"core/verse",
		"core/video"
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
