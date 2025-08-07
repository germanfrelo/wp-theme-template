<?php
/**
 * Enqueue stylesheets.
 *
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#including-css
 */


/**
 * Enqueue stylesheets on the front end of the website.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#front-end-stylesheets
 *
 * @return void
 */
function themeslug_enqueue_styles() {
	$theme_version = wp_get_theme()->get('Version');

	wp_enqueue_style(
		'themeslug-styles',
		get_theme_file_uri('build-css/global.css'),
		[],
		$theme_version
	);
}
add_action('wp_enqueue_scripts', 'themeslug_enqueue_styles');


/**
 * Enqueue stylesheets in the Editor.
 *
 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#editor-stylesheets
 *
 * @return void
 */
function themeslug_add_editor_styles() {
	add_editor_style(
		[
			get_theme_file_uri('build-css/global.css'),
		]
	);
}
add_action('after_setup_theme', 'themeslug_add_editor_styles');
