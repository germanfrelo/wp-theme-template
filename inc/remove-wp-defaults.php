<?php
/**
 * Remove WordPress defaults.
 *
 * @package themeslug
 */


/**
 * Remove the default global settings and styles that WordPress loads from its core 'theme.json' file.
 *
 * This prevents them from being loaded on the front end of the website, which reduces a substantial amount of opinionated inline styles.
 *
 * @link https://github.com/WordPress/gutenberg/issues/36834#issuecomment-1769802551
 * @link https://github.com/WordPress/wordpress-develop/blob/trunk/src/wp-includes/theme.json
 * @link https://fullsiteediting.com/lessons/how-to-filter-theme-json-with-php/
 * @link https://developer.wordpress.org/reference/hooks/wp_theme_json_data_default/
 *
 * @param \WP_Theme_JSON_Data $theme_json Class to access and update the underlying data.
 * @return \WP_Theme_JSON_Data
 */
function themeslug_remove_wp_theme_json_defaults($theme_json) {
	// Get the theme data
	$new_data = $theme_json->get_data();

	// Override the theme data
	$new_data = [
		"version"  => 3,
		"settings" => [
			"color" => [
				"duotone" => [],
				"gradients" => [],
				"palette" => [],
			],
			"shadow" => [
				"presets" => [],
			],
			"spacing" => [
				"spacingScale" => [
					"steps" => 0
				],
			],
			"typography" => [
				"fontSizes" => [],
			],
		],
		"styles" => [
			"elements" => [
				"button" => [
					"color" => [
						"text" => "",
						"background" => "",
					],
					"spacing" => [
						"padding" => [
							"top" => "",
							"bottom" => "",
							"left" => "",
							"right" => "",
						],
					],
					"typography" => [
						"fontFamily" => "",
						"fontSize" => "",
						"lineHeight" => "",
						"textDecoration" => "",
					],
					"border" => [
						"width" => "",
					],
				],
				"link" => [
					"typography" => [
						"textDecoration" => "",
					],
				],
			],
		],
	];

	// Update the theme data
	$theme_json->update_with($new_data);

	// Return the updated theme data
	return $theme_json;
}
add_filter('wp_theme_json_data_default', 'themeslug_remove_wp_theme_json_defaults');


/**
 * Remove default WordPress's block styles.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_dequeue_style/
 * @link https://fullsiteediting.com/lessons/how-to-remove-default-block-styles/
 *
 * @return void
 */
function themeslug_remove_wp_block_styles() {
	wp_dequeue_style('wp-block-categories');
	wp_dequeue_style('wp-block-code');
	wp_dequeue_style('wp-block-details');
	wp_dequeue_style('wp-block-list');
	wp_dequeue_style('wp-block-post-template');
	wp_dequeue_style('wp-block-post-title');
	wp_dequeue_style('wp-block-quote');
	wp_dequeue_style('wp-block-search');
	wp_dequeue_style('wp-block-site-logo');
	wp_dequeue_style('wp-block-site-title');
}
add_action('wp_enqueue_scripts', 'themeslug_remove_wp_block_styles');


/**
 * Remove default WordPress's emoji functionality.
 *
 * WordPress 4.2 added support for emojis into core for older browsers. This disables this functionality by removing the associated styles and scripts, because:
 * - Modern browsers handle this conversion natively, so emojis will still be visible to most users.
 * - This helps reduce an extra HTTP request on every page load, improving site performance.
 *
 * @link https://fkwdigital.com/removing-all-styles-and-scripts-associated-with-wordpress-core-emojis-in-2024/
 * @link https://docs.wp-rocket.me/article/1509-disable-emoji-optimization
 */

// Remove emojis from the admin
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

// Remove emojis from the front end
remove_action('wp_head', 'print_emoji_detection_script', 7 );
remove_action('wp_print_styles', 'print_emoji_styles');

// Remove emojis from the RSS feed
remove_filter('embed_head', 'print_emoji_detection_script');

// Remove emojis from comments
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');

// Remove emojis from emails
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

// Remove the translation of emojis from someone's mobile device
add_filter('option_use_smilies', '__return_false');

// Remove the injection of the inline CSS in the front end
add_action('wp_enqueue_scripts', function() {
	wp_dequeue_style('wp-emoji-styles');
});

// Remove extra nonsense from emojis
add_action('init', function( $plugins ) {
	if( is_array($plugins) ) {
		$plugins = array_diff( $plugins, array('wpemoji') );
	}
	return $plugins;
} );

// Remove the SVG prefetch URL
add_filter('emoji_svg_url', '__return_false');
add_filter('wp_resource_hints', function($urls, $relation_type) {
	if ('dns-prefetch' === $relation_type ) {
		// Strip out any URLs referencing the emoji script
		$emoji_svg_url_pattern = "/https:\/\/s.w.org\/images\/core\/emoji\//";
		foreach ( $urls as $key => $url ) {
			if ( preg_match( $emoji_svg_url_pattern, $url ) ) {
				unset($urls[$key]);
			}
		}
	}
	return $urls;
}, 20, 2);


/**
 * Remove default WordPress's block style variations.
 *
 * Block styles can be unregistered in PHP ('unregister_block_style') or JavaScript ('unregisterBlockStyle').
 * The PHP method only works for styles registered server-side.
 * Core WordPress block styles are registered client-side using JavaScript.
 * Therefore, to unregister core block styles, the JavaScript 'unregisterBlockStyle' function must be used.
 *
 * @link https://developer.wordpress.org/reference/hooks/enqueue_block_editor_assets/
 * @link https://developer.wordpress.org/news/2024/07/15-ways-to-curate-the-wordpress-editing-experience
 */
function themeslug_unregister_wp_block_style_variations_script() {
	wp_enqueue_script(
		'themeslug-unregister-wp-block-style-variations',
		get_template_directory_uri() . '/assets/js/unregister-wp-block-style-variations.js',
		array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'),
		filemtime(get_template_directory_uri() . '/assets/js/unregister-wp-block-style-variations.js'),
		true // Print scripts in the footer. This is required for scripts to work correctly in the Site Editor.
	);
}
add_action('enqueue_block_editor_assets', 'themeslug_unregister_wp_block_style_variations_script');


// TODO: Check.
/**
 * Remove the inline styles on the front.
 *
 * @link https://fullsiteediting.com/lessons/how-to-remove-default-block-styles/
 */
// remove_filter('render_block', 'wp_render_layout_support_flag', 10, 2);
// remove_filter('render_block', 'gutenberg_render_layout_support_flag', 10, 2);
// remove_filter('render_block', 'wp_render_elements_support', 10, 2);
// remove_filter('render_block', 'gutenberg_render_elements_support', 10, 2);


// TODO: Check.
/**
 * Remove global styles on the front.
 *
 * @link https://fullsiteediting.com/lessons/how-to-remove-default-block-styles/
 */
function themeslug_remove_global_styles() {
	// wp_dequeue_style('global-styles');
}
// add_action('wp_enqueue_scripts', 'themeslug_remove_global_styles', 100);


// TODO: Check.
/**
 * Remove global styles on the front.
 */
// remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
