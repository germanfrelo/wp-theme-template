<?php
/**
 * Enqueue stylesheets.
 *
 * @link https://developer.wordpress.org/themes/core-concepts/including-assets/#including-css
 */


// Define layer names as a single source of truth.
define( 'THEMESLUG_WP_LAYER', 'wordpress' );
define( 'THEMESLUG_THEME_LAYER', 'theme' );


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

	wp_enqueue_style(
		'themeslug-styles',
		get_theme_file_uri( 'build-css/global.css' ),
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
	add_editor_style(
		[
			get_theme_file_uri( 'build-css/global.css' ),
		]
	);
}
add_action( 'after_setup_theme', 'themeslug_add_editor_styles' );


/**
 * Defines the top-level cascade layers a single time.
 *
 * This runs early to ensure the @layer rule appears before any @import rules that use it.
 */
function themeslug_define_cascade_layers() {
	// Register a dummy, empty style handle.
	wp_register_style( 'themeslug-layer-definition', false );
	wp_enqueue_style( 'themeslug-layer-definition' );

	// Use the constants to build the layer definition string.
	$layer_css = sprintf( '@layer %s, %s;', THEMESLUG_WP_LAYER, THEMESLUG_THEME_LAYER );

	// Add the layer definition as an inline style. This will be the first style block.
	wp_add_inline_style( 'themeslug-layer-definition', $layer_css );
}
add_action( 'wp_enqueue_scripts', 'themeslug_define_cascade_layers', 5 );


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

	// More efficient: Only loop through styles actually enqueued on the page.
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

		if ( 'themeslug-styles' === $handle ) {
			// This is our theme stylesheet.
			$layer_name = THEMESLUG_THEME_LAYER;
		} else {
			// This is a WordPress core or plugin stylesheet.
			$layer_name = THEMESLUG_WP_LAYER;
		}

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
add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_layered_scripts', 9999999999 );
