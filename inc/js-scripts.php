<?php
/**
 * Enqueue JavaScript files.
 *
 * @package themeslug
 */

/**
 * Enqueue JS scripts on the front end of the website.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#including-javascript
 *
 * @return void
 */
if ( ! function_exists( 'themeslug_enqueue_frontend_scripts' ) ) {
	function themeslug_enqueue_frontend_scripts() {
		$theme_version = wp_get_theme()->get( 'Version' );

		wp_enqueue_script(
			'themeslug-<script_name>',
			get_theme_file_uri( 'assets/js/<script_name>.js' ),
			[], // Dependencies
			$theme_version,
			[
				'strategy' => 'defer',
				'in_footer' => true, // (redundant with defer but clear)
			]
		);
	}
	// add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_frontend_scripts' );
}
