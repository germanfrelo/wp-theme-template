<?php
/**
 * Enqueue theme styles for the front-end and editor.
 *
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#including-css
 *
 * @package themeslug
 */


/**
 * Enqueue the theme stylesheet on the front end of the website.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#front-end-stylesheets
 */
function themeslug_enqueue_theme_styles() {
	$handle  = THEMESLUG_THEME_HANDLE;
	$src     = get_theme_file_uri( THEMESLUG_THEME_CSS_PATH );
	$version = themeslug_asset_version( THEMESLUG_THEME_CSS_PATH );
	$deps    = [];

	/**
	 * Make the theme's main stylesheet dependent on the Gravity Forms basic stylesheet.
	 * This ensures the theme's CSS loads *after* the plugin's CSS, which allows
	 * for easy style overrides without increasing specificity or using `!important`.
	 * The `wp_style_is()` check prevents errors if Gravity Forms is not active.
	 */
	if ( function_exists( 'wp_style_is' ) && wp_style_is( 'gform_basic-css', 'registered' ) ) {
		$deps[] = 'gform_basic-css';
	}

	wp_enqueue_style( $handle, $src, $deps, $version );
}
// Priority is 20 to ensure the theme CSS is enqueued after common plugin/core styles (registered at the default priority 10). This lets the theme declare plugin styles as dependencies (e.g. Gravity Forms) and provide overrides without using !important.
add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_theme_styles', 20 );


/**
 * Enqueue the theme stylesheet in the Editor.
 *
 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#editor-stylesheets
 */
function themeslug_add_editor_styles() {
	add_editor_style(
		[
			get_theme_file_uri( THEMESLUG_THEME_CSS_PATH ),
			get_theme_file_uri( THEMESLUG_EDITOR_CSS_PATH ),
		]
	);
}
add_action( 'after_setup_theme', 'themeslug_add_editor_styles' );
