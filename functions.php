<?php
/**
 * themeslug functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/core-concepts/custom-functionality/
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package themeslug
 */

// Register template part areas
require_once get_theme_file_path( 'inc/template-part-areas.php' );

// Remove WordPress defaults
require_once get_theme_file_path( 'inc/remove-wp-defaults.php' );

// Custom Blocks
require_once get_theme_file_path( 'inc/custom-blocks.php' );

// Block style variations
require_once get_theme_file_path( 'inc/block-style-variations.php' );

// CSS
require_once get_theme_file_path( 'inc/styles.php' );

// Front-end JavaScript
require_once get_theme_file_path( 'inc/js-scripts.php' );
