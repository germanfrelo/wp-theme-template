<?php
/**
 * themeslug functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @link https://developer.wordpress.org/themes/core-concepts/custom-functionality/
 *
 * @package themeslug
 */

// --- Base Theme Paths ---
// Use get_template_directory() for server-side file includes (e.g., require, filemtime)
define('THEMESLUG_THEME_PATH', get_template_directory());
// Use get_template_directory_uri() for browser-side assets (CSS, JS, images)
define('THEMESLUG_THEME_URL', get_template_directory_uri());

// --- Directory Names ---
define('THEMESLUG_ASSETS_DIR_NAME', 'assets');
define('THEMESLUG_DIST_DIR_NAME', 'dist');

// --- Full URLs (for enqueuing scripts and styles) ---
define(
	'THEMESLUG_ASSETS_URL',
	THEMESLUG_THEME_URL . '/' . THEMESLUG_ASSETS_DIR_NAME,
);
define(
	'THEMESLUG_DIST_URL',
	THEMESLUG_THEME_URL . '/' . THEMESLUG_DIST_DIR_NAME,
);

// --- Full Server Paths (for including files) ---
define(
	'THEMESLUG_DIST_PATH',
	THEMESLUG_THEME_PATH . '/' . THEMESLUG_DIST_DIR_NAME,
);

// --- Specific Asset URLs (Built from the constants above) ---
define('THEMESLUG_EDITOR_JS_URL', THEMESLUG_ASSETS_URL . '/js/editor/');
define('THEMESLUG_FRONTEND_JS_URL', THEMESLUG_ASSETS_URL . '/js/frontend/');
define('THEMESLUG_THEME_SVG_URL', THEMESLUG_DIST_URL . '/svg/');
// Theme stylesheet: The URL for enqueuing in the browser
define('THEMESLUG_THEME_STYLESHEET_URL', THEMESLUG_DIST_URL . '/css/theme.css');
define(
	'THEMESLUG_EDITOR_STYLESHEET_URL',
	THEMESLUG_DIST_URL . '/css/editor.css',
);
// Theme stylesheet: The Server Path for cache-busting (filemtime)
define(
	'THEMESLUG_THEME_STYLESHEET_PATH',
	THEMESLUG_DIST_PATH . '/css/theme.css',
);

// --- Handle ---
define('THEMESLUG_THEME_HANDLE', 'themeslug-styles');

// Helper Functions
require_once get_theme_file_path('includes/helpers.php');

// Template Part Areas
require_once get_theme_file_path('includes/template-part-areas.php');

// Styles
require_once get_theme_file_path('includes/dequeue-core-styles.php');
require_once get_theme_file_path('includes/enqueue-theme-styles.php');
// require_once get_theme_file_path( 'includes/styles-cascade-layers.php' ); // TODO: WIP

// Custom Blocks
require_once get_theme_file_path('includes/custom-blocks.php');

// Editor-only Scripts for Unregistering and Registering Block Style Variations and Block Variations
require_once get_theme_file_path('includes/enqueue-editor-scripts.php');

// Block Output Customizations
require_once get_theme_file_path('includes/block-output-customizations.php');

// Front-end Scripts
require_once get_theme_file_path('includes/enqueue-frontend-scripts.php');

// Register Meta Fields
require_once get_theme_file_path('includes/register-meta-fields.php');

// Plugin Customizations
require_once get_theme_file_path('includes/plugin-css-class-manager.php');
require_once get_theme_file_path('includes/plugin-gravityforms.php');
