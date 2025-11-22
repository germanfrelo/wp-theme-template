<?php
/**
 * Remove default WP theme.json defaults and dequeue core block styles.
 *
 * Combines theme.json server-side overrides with the dequeue logic that removes core block styles.
 *
 * @package themeslug
 */

/**
 * Remove the default global settings and styles that WordPress loads from its core 'theme.json' file.
 *
 * This prevents them from being loaded on the front end of the website, which reduces a substantial amount of opinionated inline styles.
 *
 * @link https://developer.wordpress.org/news/2023/07/how-to-modify-theme-json-data-using-server-side-filters/
 * @link https://developer.wordpress.org/reference/hooks/wp_theme_json_data_default/
 * @link https://fullsiteediting.com/lessons/how-to-filter-theme-json-with-php/
 * @link https://github.com/WordPress/gutenberg/issues/36834#issuecomment-1769802551
 * @link https://github.com/WordPress/wordpress-develop/blob/trunk/src/wp-includes/theme.json
 *
 * @param \WP_Theme_JSON_Data $theme_json Class to access and update the underlying data.
 * @return \WP_Theme_JSON_Data
 */
function themeslug_remove_wp_theme_json_defaults($theme_json) {
	// Get the theme data
	$new_data = $theme_json->get_data();

	// Override the theme data
	$new_data = [
		"version" => 3,
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
					"steps" => 0,
				],
			],
			"typography" => [
				"fontSizes" => [],
			],
		],
		"styles" => [
			"blocks" => [
				"core/button" => [
					"variations" => [
						"outline" => [
							"border" => [
								"width" => "",
								"style" => "",
								"color" => "",
							],
							"color" => [
								"text" => "",
								"gradient" => "",
							],
							"spacing" => [
								"padding" => [
									"top" => "",
									"right" => "",
									"bottom" => "",
									"left" => "",
								],
							],
						],
					],
				],
			],
			"elements" => [
				"button" => [
					"color" => [
						"text" => "",
						"background" => "",
					],
					"spacing" => [
						"padding" => [
							"top" => "",
							"right" => "",
							"bottom" => "",
							"left" => "",
						],
					],
					"typography" => [
						"fontSize" => "",
						"fontFamily" => "",
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
			"spacing" => [
				"blockGap" => "",
				"padding" => [
					"top" => "",
					"right" => "",
					"bottom" => "",
					"left" => "",
				],
			],
		],
	];

	// Update the theme data
	$theme_json->update_with($new_data);

	// Return the updated theme data
	return $theme_json;
}
add_filter(
	"wp_theme_json_data_default",
	"themeslug_remove_wp_theme_json_defaults",
);

/**
 * Remove core block styles from the front end of the website.
 *
 * These stylesheets contain opinionated rules that conflict with or
 * override the theme's more consistent design system. Removing them
 * allows the theme's global and block-specific styles to apply cleanly,
 * without the need for high-specificity CSS overrides.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_dequeue_style/
 * @link https://fullsiteediting.com/lessons/how-to-remove-default-block-styles/
 * @link https://github.com/WordPress/gutenberg/tree/trunk/packages/block-library/src
 *
 * @return void
 */
function themeslug_remove_wp_block_styles() {
	// Central list of core block styles we intentionally remove to avoid
	// WordPress opinionated defaults interfering with the theme's design system.
	$handles = [
		"wp-block-archives",
		"wp-block-audio",
		"wp-block-avatar",
		"wp-block-button",
		"wp-block-buttons",
		"wp-block-calendar",
		"wp-block-categories",
		"wp-block-code",
		"wp-block-column",
		"wp-block-columns",
		// 'wp-block-comment-author-name',
		// 'wp-block-comment-content',
		// 'wp-block-comment-date',
		// 'wp-block-comment-edit-link',
		// 'wp-block-comment-reply-link',
		// 'wp-block-comment-template',
		// 'wp-block-comments-pagination-next',
		// 'wp-block-comments-pagination-numbers',
		// 'wp-block-comments-pagination-previous',
		// 'wp-block-comments-pagination',
		// 'wp-block-comments-title',
		// 'wp-block-comments',
		"wp-block-cover",
		"wp-block-details",
		// 'wp-block-embed',
		// 'wp-block-file',
		// 'wp-block-footnotes',
		// 'wp-block-gallery',
		"wp-block-group",
		"wp-block-heading",
		// 'wp-block-image',
		// 'wp-block-latest-comments',
		// 'wp-block-latest-posts',
		"wp-block-list-item",
		"wp-block-list",
		"wp-block-loginout",
		// 'wp-block-media-text',
		"wp-block-navigation-link",
		"wp-block-navigation",
		"wp-block-page-list-item",
		"wp-block-page-list",
		"wp-block-paragraph",
		"wp-block-post-author-biography",
		"wp-block-post-author-name",
		"wp-block-post-author",
		// 'wp-block-post-comments-form',
		"wp-block-post-date",
		"wp-block-post-excerpt",
		"wp-block-post-featured-image",
		"wp-block-post-navigation-link",
		"wp-block-post-template",
		"wp-block-post-terms",
		"wp-block-post-title",
		"wp-block-preformatted",
		"wp-block-pullquote",
		"wp-block-query-no-results",
		"wp-block-query-pagination-next",
		"wp-block-query-pagination-numbers",
		"wp-block-query-pagination-previous",
		"wp-block-query-pagination",
		"wp-block-query-title",
		"wp-block-query-total",
		"wp-block-query",
		"wp-block-quote",
		"wp-block-read-more",
		// 'wp-block-rss',
		"wp-block-search",
		"wp-block-separator",
		"wp-block-site-logo",
		"wp-block-site-tagline",
		"wp-block-site-title",
		"wp-block-social-link",
		"wp-block-social-links",
		"wp-block-spacer",
		"wp-block-table",
		// 'wp-block-tag-cloud',
		"wp-block-term-description",
		// 'wp-block-text-columns',
		"wp-block-verse",
		// 'wp-block-video',
	];

	foreach ($handles as $handle) {
		// Only attempt to dequeue if the handle was registered/enqueued by core/plugins.
		if (
			wp_style_is($handle, "enqueued") ||
			wp_style_is($handle, "registered")
		) {
			wp_dequeue_style($handle);
		}
	}
}
add_action("wp_enqueue_scripts", "themeslug_remove_wp_block_styles");
