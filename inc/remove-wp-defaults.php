<?php
/**
 * Remove WordPress defaults.
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
	wp_dequeue_style('wp-block-button');
	wp_dequeue_style('wp-block-categories');
	wp_dequeue_style('wp-block-code');
	wp_dequeue_style('wp-block-details');
	wp_dequeue_style('wp-block-group');
	wp_dequeue_style('wp-block-heading');
	wp_dequeue_style('wp-block-list');
	wp_dequeue_style('wp-block-post-template');
	wp_dequeue_style('wp-block-quote');
	wp_dequeue_style('wp-block-site-logo');
	wp_dequeue_style('wp-block-site-title');
}
add_action('wp_enqueue_scripts', 'themeslug_remove_wp_block_styles');


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
 * Remove all default block styles from the front.
 *
 * @link https://fullsiteediting.com/lessons/how-to-remove-default-block-styles/
 */
function themeslug_remove_core_block_styles() {
	global $wp_styles;

	foreach ( $wp_styles->queue as $key => $handle ) {
		if ( strpos( $handle, 'wp-block-' ) === 0 ) {
			wp_dequeue_style( $handle );
		}
	}
}
// add_action( 'wp_enqueue_scripts', 'themeslug_remove_core_block_styles' );


// TODO: Check.
/**
 * Remove default block styles from the Block Editor and Site Editor.
 *
 * @link https://fullsiteediting.com/lessons/how-to-remove-default-block-styles/
 */
// add_action(
// 	'wp_default_styles',
// 	function( $styles ) {

// 		/* Create an array with the two handles wp-block-library and
// 		 * wp-block-library-theme.
// 		 */
// 		$handles = [ 'wp-block-library', 'wp-block-library-theme' ];

// 		foreach ( $handles as $handle ) {
// 			// Search and compare with the list of registered style handles:
// 			$style = $styles->query( $handle, 'registered' );
// 			if ( ! $style ) {
// 				continue;
// 			}
// 			// Remove the style
// 			$styles->remove( $handle );
// 			// Remove path and dependencies
// 			$styles->add( $handle, false, [] );
// 		}
// 	},
// 	PHP_INT_MAX
// );


// TODO: Check.
/**
 * Remove the inline styles on the front.
 *
 * @link https://fullsiteediting.com/lessons/how-to-remove-default-block-styles/
 */
// remove_filter( 'render_block', 'wp_render_layout_support_flag', 10, 2 );
// remove_filter( 'render_block', 'gutenberg_render_layout_support_flag', 10, 2 );
// remove_filter( 'render_block', 'wp_render_elements_support', 10, 2 );
// remove_filter( 'render_block', 'gutenberg_render_elements_support', 10, 2 );


// TODO: Check.
/**
 * Remove global styles on the front.
 *
 * @link https://fullsiteediting.com/lessons/how-to-remove-default-block-styles/
 */
function themeslug_remove_global_styles() {
	// wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'wp-emoji-styles' );
}
// add_action( 'wp_enqueue_scripts', 'themeslug_remove_global_styles', 100 );


// TODO: Check.
/**
 * Remove global styles on the front.
 */
// remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
