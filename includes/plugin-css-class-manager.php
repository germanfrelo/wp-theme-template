<?php
/**
 * CSS Class Manager plugin customizations.
 *
 * @link https://wordpress.org/plugins/css-class-manager/
 *
 * @package themeslug
 */

/**
 * Generate class names from this theme's main stylesheet.
 *
 * This function hooks into the 'css_class_manager_theme_classes_css' filter to
 * feed the contents of this theme's main stylesheet into the plugin. The plugin
 * then scans this CSS string, extracts all found class names (e.g., '.my-class'),
 * and makes them available in the editor's "Class names" dropdown list.
 *
 * @since 1.0.0
 * @link https://github.com/ediamin/css-class-manager/wiki
 *
 * @param string $css The initial CSS string from the plugin, which may be empty or contain CSS from other sources.
 * @return string The combined CSS string for the plugin to parse.
 */
function themeslug_add_theme_css_for_plugin_css_class_manager($css) {
	// Construct the absolute path to the theme's compiled stylesheet.
	$stylesheet_path = get_theme_file_path(THEMESLUG_THEME_CSS_PATH);

	// Before proceeding, verify the stylesheet file actually exists to prevent errors.
	if (file_exists($stylesheet_path)) {
		// Read the entire contents of the CSS file into a string.
		$css_from_file = file_get_contents($stylesheet_path);

		// Append the theme's CSS to the string. The plugin will parse this entire string to find and list the available class names.
		return "{$css}{$css_from_file}";
	}

	// If the stylesheet isn't found, return the original string to avoid issues.
	return $css;
}
add_filter(
	'css_class_manager_theme_classes_css',
	'themeslug_add_theme_css_for_plugin_css_class_manager',
);
