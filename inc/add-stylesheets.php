<?php
/**
 * Enqueue stylesheets.
 */

/**
 * The theme version.
 */
define( 'THEME_VERSION', wp_get_theme()->get( 'Version' ) );

/**
 * Enqueue stylesheets on the front end of the website.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#front-end-stylesheets
 *
 * @return void
 */
function ifiseducacion_enqueue_styles() {
	// Active theme's main stylesheet (style.css)
	wp_enqueue_style(
		'ifiseducacion-main-stylesheet',
		get_stylesheet_uri(),
		[],
		THEME_VERSION
	);

	// All the styles
	wp_enqueue_style(
		'ifiseducacion-styles',
		get_theme_file_uri('build-css/global.css'),
		[],
		THEME_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'ifiseducacion_enqueue_styles' );

/**
 * Enqueue stylesheets in the Editor.
 *
 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#editor-stylesheets
 *
 * @return void
 */
function ifiseducacion_add_editor_styles() {
	add_editor_style( array(
		// Active theme's main stylesheet (style.css)
		get_stylesheet_uri(),
		// All the styles
		get_theme_file_uri('build-css/global.css'),
	) );
}
add_action( 'after_setup_theme', 'ifiseducacion_add_editor_styles' );
