<?php
/**
 * themeslug functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @link https://developer.wordpress.org/themes/core-concepts/custom-functionality/
 *
 * @package themeslug
 */

// Theme Constants
define('THEMESLUG_ASSETS_DIR', 'assets');
define('THEMESLUG_DIST_DIR', 'dist'); // Distribution directory (build output)
define('THEMESLUG_EDITOR_CSS_PATH', THEMESLUG_DIST_DIR . '/css/editor.css');
define('THEMESLUG_EDITOR_JS_DIR', THEMESLUG_ASSETS_DIR . '/js/editor/');
define('THEMESLUG_FRONTEND_JS_DIR', THEMESLUG_ASSETS_DIR . '/js/frontend/');
define('THEMESLUG_THEME_CSS_PATH', THEMESLUG_DIST_DIR . '/css/theme.css');
define('THEMESLUG_THEME_HANDLE', 'themeslug-styles');

// Helper Functions
require_once get_theme_file_path('includes/helpers.php');

// Template Part Areas
require_once get_theme_file_path('includes/template-part-areas.php');

// Styles
require_once get_theme_file_path('includes/dequeue-core-styles.php');
require_once get_theme_file_path('includes/enqueue-theme-styles.php');
require_once get_theme_file_path('includes/styles-cascade-layers.php');

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
