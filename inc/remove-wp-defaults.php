<?php
/**
 * Remove WordPress' defaults.
 */

/**
 * Override some global settings from the WordPress default theme.json file, which are loaded as inline styles.
 *
 * @link https://github.com/WordPress/gutenberg/issues/36834#issuecomment-1769802551
 * @link https://fullsiteediting.com/lessons/how-to-filter-theme-json-with-php/
 * @link https://developer.wordpress.org/reference/hooks/wp_theme_json_data_default/
 *
 * @param \WP_Theme_JSON_Data $theme_json Class to access and update the underlying data.
 *
 * @return \WP_Theme_JSON_Data
 */
function themeslug_filter_theme_json_default($theme_json) {
	$data = $theme_json->get_data();
	$data['settings']['color']['duotone']['default'] = []; // Remove default color duotone
	$data['settings']['color']['gradients']['default'] = []; // Remove default color gradients
	$data['settings']['color']['palette']['default'] = []; // Remove default color palette
	$data['settings']['shadow']['presets']['default'] = []; // Remove default shadow presets
	$data['settings']['spacing']['spacingSizes']['default'] = []; // Remove default spacing sizes
	$data['settings']['typography']['fontSizes']['default'] = []; // Remove default font sizes
	$theme_json->update_with($data); // Updates the theme data
	return $theme_json;
}
add_filter('wp_theme_json_data_default', 'themeslug_filter_theme_json_default');


/**
 * Remove some default core block styles.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_dequeue_style/
 * @link https://fullsiteediting.com/lessons/how-to-remove-default-block-styles/
 *
 * @return void
 */
function themeslug_remove_core_styles() {
	wp_dequeue_style( 'wp-block-categories' );
	wp_dequeue_style( 'wp-block-code' );
	wp_dequeue_style( 'wp-block-details' );
	wp_dequeue_style( 'wp-block-heading' );
	wp_dequeue_style( 'wp-block-list' );
	wp_dequeue_style( 'wp-block-post-template' );
	wp_dequeue_style( 'wp-block-post-title' );
	wp_dequeue_style( 'wp-block-quote' );
	wp_dequeue_style( 'wp-block-search' );
	wp_dequeue_style( 'wp-block-site-logo' );
	wp_dequeue_style( 'wp-block-site-title' );
}
add_action( 'wp_enqueue_scripts', 'themeslug_remove_core_styles' );


/**
 * Unregister WordPress default block style variations.
 *
 * Block styles can be unregistered in PHP ('unregister_block_style') or JavaScript ('unregisterBlockStyle').
 * The PHP method only works for styles registered server-side.
 * Core WordPress block styles are registered client-side using JavaScript.
 * Therefore, to unregister core block styles, the JavaScript 'unregisterBlockStyle' function must be used.
 *
 * @link https://developer.wordpress.org/reference/hooks/enqueue_block_editor_assets/
 * @link https://developer.wordpress.org/news/2024/07/15-ways-to-curate-the-wordpress-editing-experience
 */
add_action('enqueue_block_editor_assets', function() {
	wp_enqueue_script(
		'themeslug-unregister-core-block-style-variations',
		get_template_directory_uri() . '/assets/js/unregister-core-block-style-variations.js',
		array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'),
		filemtime(get_template_directory_uri() . '/assets/js/unregister-core-block-style-variations.js'),
		true // Print scripts in the footer. This is required for scripts to work correctly in the Site Editor.
	);
});
