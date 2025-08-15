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


// We use 'wp_enqueue_scripts' action with a very high priority so that it runs
// last. This way we make sure that all plugins and the theme have enqueued
// their styles and they are available in global $wp_styles object.
// add_action( 'wp_enqueue_scripts', 'enqueue_layered_scripts', 9999999999 );

function enqueue_layered_scripts() {
	global $wp_styles;
	// Get all styles that will be enqueued by WordPress
	$styles = $wp_styles->registered;
	// Define the layers and their order.
	// We assign all styles loaded by WordPress to 'normal-styles' layer.
	// We also define another layer, 'stronger-styles', which has a higher precendence.
	// We can put any styles we want in there.
	$layers = '@layer normal-styles, stronger-styles;';
	// Iterate through the styles in order to change the way they are enqueued
	foreach ( $styles as $key => $style ) {
		// Check if the style loads a css file
		$src_exists = is_string($styles[$key]->src);
		// Prepare the CSS code that will be loaded in place of the <link> tag.
		// First, we define the layers and their order. Unfortunately we cannot
		// be sure which style in the list will be loaded first. So we need to
		// put the definition of the layers in every CSS code.
		$code = $layers.' ';
		// Then we add an @import rule to load the CSS file, if exists. We set
		// the layer of the imported file to be 'normal-styles'.
		if ( $src_exists ) $code .= '@import url("'.$style->src.'") layer(normal-styles); ';
		// The style may contain extra CSS code that has been added through
		// add_inline_style() function. We also need to put this code inside
		// 'normal-styles' layer. We do this by enclosing the code inside a
		// @layer rule. We prepend '@layer normal-styles {' inside the extra CSS
		// code.
		// Notice that we do not close the opening @layer block. We do this on
		// purpose because themes or plugins may add more CSS code after this
		// function and we want to have that too inside the layer. It is ok that
		// we do not close the @layer block, the browser will do it
		// automatically.
		$code .= '@layer normal-styles { ';
		$after = $wp_styles->get_data( $style->handle, 'after' );
		if ( ! $after ) $after = array();
		// We prepend the prepared CSS code to the extra CSS code of the style.
		array_unshift($after , $code);
		$wp_styles->add_data( $style->handle, 'after', $after );
		// We empty the styles 'src' property so that the style is not loaded
		// with a <link> tag.
		if ( $src_exists ) $styles[$key]->src = "";
	}
	// We can put more CSS code here that is loaded in 'stronger-styles' and has
	// higher precendence over any other styles loaded above.
}
