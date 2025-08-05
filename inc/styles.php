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
	$theme_version = wp_get_theme()->get( 'Version' );

	// Active theme's style.css file
	wp_enqueue_style(
		'themeslug-theme-stylesheet',
		get_stylesheet_uri(),
		[],
		$theme_version
	);

	// All the styles
	wp_enqueue_style(
		'themeslug-styles',
		get_theme_file_uri('build-css/global.css'),
		[],
		$theme_version
	);
}
add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_styles' );

/**
 * Enqueue stylesheets in the Editor.
 *
 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#editor-stylesheets
 *
 * @return void
 */
function themeslug_add_editor_styles() {
	add_editor_style( array(
		// Active theme's style.css file
		get_stylesheet_uri(),
		// All the styles
		get_theme_file_uri('build-css/global.css'),
	) );
}
add_action( 'after_setup_theme', 'themeslug_add_editor_styles' );


/**
 * Enqueue stylesheets in the Admin.
 *
 * @link https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
 *
 * @return void
 */
function themeslug_admin_styles() {
	$screen = get_current_screen();

	// You can inspect the $screen object to find the 'id' for your specific page.
	// To see the $screen object, you can temporarily add:
	// error_log( print_r( $screen, true ) );
	// and check your server's error logs.

	// Page
	if ( $screen->id === '________' ) {
		wp_enqueue_style(
			'themeslug-admin-styles',
			get_theme_file_uri('assets/admin-styles/admin.css'),
			[],
			false,
			'screen'
		);
	}
}
// add_action( 'admin_enqueue_scripts', 'themeslug_admin_styles' );


/**
 * Enqueue stylesheets for the TinyMCE editor.
 *
 * @link https://developer.wordpress.org/reference/hooks/mce_css/
 */
function themeslug_tinymce_styles( $mce_css ) {
	// Get the current screen object to ensure we're on the ________ edit page
	$screen = get_current_screen();

	// Check if we are on the ________ edit page
	if ( $screen && $screen->id === '________' ) {
		// Append your custom stylesheet URL to the existing TinyMCE CSS string.
		// It's crucial to use get_stylesheet_directory_uri() for child themes
		// or plugins_url() for plugins, and get_template_directory_uri() for parent themes.
		$custom_css_url = get_theme_file_uri('assets/admin-styles/tinymce-editor.css');

		// Concatenate the existing CSS with your new CSS file.
		// If $mce_css is empty, just use your URL. Otherwise, append with a comma.
		$mce_css .= ( empty( $mce_css ) ? '' : ',' ) . esc_url( $custom_css_url );
	}

	return $mce_css;
}
// add_filter( 'mce_css', 'themeslug_tinymce_styles' );
