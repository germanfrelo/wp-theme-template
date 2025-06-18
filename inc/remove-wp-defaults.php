<?php
/**
 * Remove WordPress' defaults.
 */

/**
 * Remove some inline default core styles/settings.
 *
 * @link https://github.com/WordPress/gutenberg/issues/36834#issuecomment-1769802551
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
	wp_dequeue_style( 'wp-block-button' );
	wp_dequeue_style( 'wp-block-categories' );
	wp_dequeue_style( 'wp-block-code' );
	wp_dequeue_style( 'wp-block-details' );
	wp_dequeue_style( 'wp-block-group' );
	wp_dequeue_style( 'wp-block-heading' );
	wp_dequeue_style( 'wp-block-list' );
	wp_dequeue_style( 'wp-block-post-template' );
	wp_dequeue_style( 'wp-block-site-logo' );
}
add_action( 'wp_enqueue_scripts', 'themeslug_remove_core_styles' );
