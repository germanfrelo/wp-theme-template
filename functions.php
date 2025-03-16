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
 * Enqueue custom stylesheets on the front end of the website.
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
 * Enqueue custom stylesheets in the Editor.
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
 * Enqueue custom block stylesheets (on the front end and in the Editor).
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_block_style/
 * @link https://developer.wordpress.org/themes/features/block-stylesheets/
 *
 * @return void
 */
function themeslug_block_stylesheets() {
	// Add the block name (with namespace prefix) for each style.
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

	// Loop through each block and enqueue its styles.
	foreach ($blocks as $block) {
		// Replace slash with hyphen for filename.
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
 * Register custom block style variations.
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 * @link https://developer.wordpress.org/themes/features/block-style-variations/
 *
 * @return void
 */
function themeslug_block_style_variations() {
	register_block_style(
		'core/button', array(
			'name'         => 'primary', // .wp-block-button.is-style-primary
			'label'        => __('Primary', 'themeslug'),
			// Styles are in the block's stylesheet 'core-button.css' file
		)
	);
	register_block_style(
		'core/button', array(
			'name'         => 'danger', // .wp-block-button.is-style-danger
			'label'        => __('Danger', 'themeslug'),
			// Styles are in the block's stylesheet 'core-button.css' file
		)
	);
	register_block_style(
		'core/columns', array(
			'name'         => 'columns-wrap-reverse',
			'label'        => __('Apilación invertida', 'themeslug'),
			'inline_style' => '
				.wp-block-columns:not(.is-not-stacked-on-mobile).is-style-columns-wrap-reverse {
					--columns-flex-wrap-when-stacked-on-mobile: wrap-reverse;
				}
			'
			// The rest of the styles are in the block's stylesheet 'core-columns.css' file
		)
	);
	register_block_style(
		'core/group', array(
			'name'         => 'card',
			'label'        => __('Tarjeta', 'themeslug'),
			'inline_style' => '
				.wp-block-group.is-style-card {
					padding: var(--wp--preset--spacing--l, var(--wp--style--block-gap, 1.5em));
					background-color: var(--wp--preset--color--background-1, transparent);
					border: var(--wp--custom--border--width--thin, 1px) solid var(--wp--preset--color--border-1, currentcolor);
					border-radius: var(--wp--custom--border--radius--small, 1rem);
				}
			'
			// The rest of the styles are in the block's stylesheet 'core-group.css' file
		)
	);
	register_block_style(
		'core/media-text', array(
			'name'         => 'stacked-on-mobile-text-before',
			'label'        => __('Móvil: Texto antes', 'themeslug'),
			'inline_style' => '
				.wp-block-media-text.is-style-stacked-on-mobile-text-before {
					--media-text-stacked-content-row: 1;
					--media-text-stacked-media-row: 2;
				}
			'
			// The rest of the styles are in the block's stylesheet 'core-media-text.css' file
		)
	);
	register_block_style(
		'core/search', array(
			'name'         => 'direction-reversed', // .wp-block-search.is-style-direction-reversed
			'label'        => __('Reversed direction', 'themeslug'),
			// Styles are in the block's stylesheet 'core-search.css' file
		)
	);
	register_block_style(
		'core/separator', array(
			'name'         => 'thick', // .wp-block-separator.is-style-thick-line
			'label'        => __('Thick Line', 'themeslug')
		)
	);
}
add_action('init', 'themeslug_block_style_variations');


/**
 * Remove some unnecessary inline core styles.
 *
 * @link https://github.com/WordPress/gutenberg/issues/36834#issuecomment-1769802551
 *
 * @param \WP_Theme_JSON_Data $theme_json Class to access and update the underlying data.
 *
 * @return \WP_Theme_JSON_Data
 */
// add_filter(
// 	'wp_theme_json_data_default', function($theme_json) {
// 		$data = $theme_json->get_data();
// 		$data['settings']['color']['duotone']['default'] = []; // Remove default color duotone
// 		$data['settings']['color']['gradients']['default'] = []; // Remove default color gradients
// 		$data['settings']['color']['palette']['default'] = []; // Remove default color palette
// 		$data['settings']['spacing']['spacingSizes']['default'] = []; // Remove default spacing sizes
// 		$data['settings']['typography']['fontSizes']['default'] = []; // Remove default font sizes
// 		$theme_json->update_with($data); // Update the theme data
// 		return $theme_json;
// 	}
// );


/**
 * Plugin Gravity Forms:
 * Filter the next, previous and submit buttons.
 *
 * Replace the form's input buttons with button elements, while maintaining attributes from original input.
 * Reason: "button elements are much easier to style than input elements" (see
 * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/button#notes).
 *
 * @since WordPress 6.6
 *
 * @link https://docs.gravityforms.com/gform_submit_button/#h-1-change-input-to-button
 *
 * @param string $button Contains the input tag to be filtered.
 * @param array  $form   Contains all the properties of the current form.
 * @return string The filtered button.
 */
function themeslug_input_to_button($button, $form) {
	$fragment = WP_HTML_Processor::create_fragment($button);
	$fragment->next_token();

	$attributes = array('id', 'type', 'class', 'onclick');
	$new_attributes = array();
	foreach ($attributes as $attribute) {
		$value = $fragment->get_attribute($attribute);
		if (! empty($value)) {
			$new_attributes[] = sprintf('%s="%s"', $attribute, esc_attr($value));
		}
	}

	return sprintf('<button %s>%s</button>', implode(' ', $new_attributes), esc_html($fragment->get_attribute('value')));
}
add_filter('gform_next_button', 'themeslug_input_to_button', 10, 2);
add_filter('gform_previous_button', 'themeslug_input_to_button', 10, 2);
add_filter('gform_submit_button', 'themeslug_input_to_button', 10, 2);


/**
 * Plugin Gravity Forms:
 * Add custom CSS classes to the submit button.
 *
 * @since WordPress 6.6
 *
 * @link https://docs.gravityforms.com/gform_submit_button/#h-5-append-custom-css-classes-to-the-button
 *
 * @return void
 */
function themeslug_add_custom_css_classes($button, $form) {
	$fragment = WP_HTML_Processor::create_fragment($button);
	$fragment->next_token();
	$fragment->add_class('wp-block-button');
	$fragment->add_class('wp-block-button__link');

	return $fragment->get_updated_html();
}
add_filter('gform_submit_button', 'themeslug_add_custom_css_classes', 10, 2);
