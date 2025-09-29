<?php
/**
 * Enqueue and manage theme styles.
 *
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#including-css
 *
 * @package themeslug
 */


/**
 * Remove the default global settings and styles that WordPress loads from its core 'theme.json' file.
 *
 * This prevents them from being loaded on the front end of the website, which reduces a substantial amount of opinionated inline styles.
 *
 * @link https://github.com/WordPress/wordpress-develop/blob/trunk/src/wp-includes/theme.json
 * @link https://github.com/WordPress/gutenberg/issues/36834#issuecomment-1769802551
 * @link https://developer.wordpress.org/news/2023/07/how-to-modify-theme-json-data-using-server-side-filters/
 * @link https://developer.wordpress.org/reference/hooks/wp_theme_json_data_default/
 * @link https://fullsiteediting.com/lessons/how-to-filter-theme-json-with-php/
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
 * Remove WordPress default block styles.
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
	wp_dequeue_style('wp-block-read-more');
	wp_dequeue_style('wp-block-search');
	wp_dequeue_style('wp-block-site-logo');
	wp_dequeue_style('wp-block-site-title');
}
add_action('wp_enqueue_scripts', 'themeslug_remove_wp_block_styles', 10);


/**
 * Enqueue theme stylesheets on the front end of the website.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#front-end-stylesheets
 *
 * @return void
 */
function themeslug_enqueue_styles() {
	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'themeslug-styles',
		get_theme_file_uri( 'build/styles/global.css' ),
		[],
		$theme_version
	);
}
add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_styles', 20 );


/**
 * Enqueue theme stylesheets in the Editor.
 *
 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#editor-stylesheets
 *
 * @return void
 */
function themeslug_add_editor_styles() {
	add_editor_style(
		[
			get_theme_file_uri( 'build/styles/global.css' ),
		]
	);
}
add_action( 'after_setup_theme', 'themeslug_add_editor_styles' );


// TODO: WIP
/**
 * CSS Cascade Layers
 *
 * The single source of truth for the entire cascade layer setup.
 *
 * @return array The configuration for CSS layers.
 */
function themeslug_get_layer_config() {
	return [
		// Defines the final order of all top-level layers.
		'order' => [
			'wordpress',
			'plugins',
			'theme',
		],
		// Maps specific stylesheet 'handles' to a layer.
		'map' => [
			'themeslug-styles' => 'theme',
			// e.g. 'plugin_handle' => 'plugins',
		],
		// The default layer for any handle not found in the map.
		'default' => 'wordpress',
	];
}

// TODO: WIP
/**
 * Defines the top-level cascade layers a single time.
 *
 * This runs early to ensure the @layer rule appears before any @import rules that use it.
 */
function themeslug_define_cascade_layers() {
	// Dynamically build the @layer rule from the config array.
	$config = themeslug_get_layer_config();
	$layer_css = sprintf( '@layer %s;', implode( ', ', $config['order'] ) );

	// Register a dummy, empty style handle.
	wp_register_style( 'themeslug-layer-definition', false );
	wp_enqueue_style( 'themeslug-layer-definition' );

	// Add the layer definition as an inline style. This will be the first style block.
	wp_add_inline_style( 'themeslug-layer-definition', $layer_css );
}
// add_action( 'wp_enqueue_scripts', 'themeslug_define_cascade_layers', 5 );

// TODO: WIP
/**
 * Re-formats enqueued stylesheets to use CSS Cascade Layers.
 *
 * This runs last to ensure it can process all previously enqueued styles
 * from the theme, plugins, and WordPress core.
 *
 * @link https://www.iptanus.com/how-to-apply-cascade-layers-in-wordpress/
 */
function themeslug_enqueue_layered_scripts() {
	global $wp_styles;
	$config = themeslug_get_layer_config();

	// Only loop through styles actually enqueued on the page.
	$enqueued_handles = $wp_styles->queue;

	foreach ( $enqueued_handles as $handle ) {
		// Skip our own layer definition handle.
		if ( 'themeslug-layer-definition' === $handle ) {
			continue;
		}

		$style = $wp_styles->registered[ $handle ];

		// Skip if the style has no src and no inline code.
		$src_exists = $style->src && is_string( $style->src );
		$after_data = $wp_styles->get_data( $handle, 'after' );
		if ( ! $src_exists && empty( $after_data ) ) {
			continue;
		}

		// The main @layer definition is already handled, so we just build the import/wrapper.
		$code = '';

		// Dynamically determine layer name.
		$layer_name = $config['map'][ $handle ] ?? $config['default'];

		if ( $src_exists ) {
			$code .= sprintf( '@import url("%s") layer(%s);', $style->src, $layer_name );
		}
		$code .= sprintf( '@layer %s {', $layer_name );

		$after = $after_data ?: [];
		array_unshift( $after, $code );
		$wp_styles->add_data( $handle, 'after', $after );

		if ( $src_exists ) {
			$wp_styles->registered[ $handle ]->src = '';
		}
	}
}
// add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_layered_scripts', 9999999999 );
