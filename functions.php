<?php

/**
 * themeslug functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/core-concepts/custom-functionality/
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

// Remove default WordPress styles
require_once get_theme_file_path( 'inc/remove-wp-defaults.php' );

// Custom Blocks
require_once get_theme_file_path( 'inc/custom-blocks.php' );

// Block style variations
require_once get_theme_file_path( 'inc/block-style-variations.php' );

// Block output customizations
require_once get_theme_file_path( 'inc/block-output-customizations.php' );

// CSS
require_once get_theme_file_path( 'inc/styles.php' );

// Front-end JavaScript
require_once get_theme_file_path( 'inc/js-scripts.php' );

// Plugin: Gravity Forms
require_once get_theme_file_path( 'inc/plugin-gravityforms.php' );
